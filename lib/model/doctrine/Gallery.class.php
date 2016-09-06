<?php

/**
 * Gallery
 *
 * @package    garage
 * @subpackage model
 * @author     Garin Studio <eugeniy.b@garin-studio.ru>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Gallery extends BaseGallery
{

  private $_preview_file, $_images_delete;


  /**
   * @return FileStorage
   */
  protected function getStorage($prefix)
  {
    if (!$this->id) {
      throw new Exception('Unable to get storage for unsaved instance');
    }

    return new FileStorage(array(
      'level'       => 2,
      'prefix'      => 'gallery_' . $prefix,
    ));
  }


  public function toArray($deep = true, $prefixKey = false)
  {
    $images = array();
    foreach ($this->Images as $image) {
      $images[$image->id] = self::cleanPath($image->file);
    }
    return array_merge(parent::toArray($deep, $prefixKey), array('images' => $images));
  }

  public function getImages()
  {
    if (is_null($this->_get('Images', false))) {
      $this->_set('Images', Doctrine::getTable('GalleryImage')->getRelatedImages($this->id));
    }

    return $this->_get('Images');
  }

  public function getPreviewImage()
  {
    return $this->id ? self::cleanPath($this->getStorage('preview')->getFilename($this->id)) : false;
  }

  public function getPreviewThumb()
  {
    return self::cleanPath($this->getStorage('preview')->getThumb(
      $this->id, 'gallery_preview_thumb', array('width' => 430, 'crop' => '430x340'), 'gallery_preview'
    ));
  }


  public function setPreviewImage($value)
  {
    if ($value instanceOf sfValidatedFile) {
      $this->_preview_file = $value;
    }
  }

  public function setImagesDelete($value)
  {
    if (is_array($value)) {
      $this->_images_delete = $value;
    }
  }


  public function postSave($event)
  {
    parent::postSave($event);

    if ($this->_preview_file instanceOf sfValidatedFile) {
      $storage = $this->getStorage('preview');
      $storage->delete($this->id);
      $this->cleanupThumbs();

      $storage->buildPath($this->id);
      $target = $storage->generateFilename($this->id, null, $this->_preview_file->getOriginalName());
      $this->_preview_file->save($target);

      $this->_preview_file = null;
    }

    if ($this->_images_delete) {
      $this->unlink('Images', $this->_images_delete);
      $this->_images_delete = null;
    }

    $this->updateSearchIndex();
  }

  public function postDelete($event)
  {
    parent::postDelete($event);
    Search::delete($this);

    $this->cleanupThumbs();
  }


  public function updateSearchIndex()
  {
    foreach (sfConfig::get('sf_languages') as $lang) {
      if (!$this->Translation[$lang]->title) {
        continue;
      }

      $contents = array();
      foreach ($this->Images as $image) {
        $contents[] = Search::cleanText(
          $image->Translation[$lang]->title,
          $image->Translation[$lang]->description
        );
      }

      $doc = Search::createDocument($this);
      $doc->addField(Zend_Search_Lucene_Field::text('title', $this->Translation[$lang]->title));
      $doc->addField(Zend_Search_Lucene_Field::text('contents', implode("\n", $contents)));

      $doc->getField('title')->boost = 5;
      $doc->getField('contents')->boost = 1;

      Search::getInstance($lang)->addDocument($doc);
    }
  }


  private function cleanupThumbs()
  {
    foreach (array('gallery_preview', 'gallery_preview_thumb') as $name) {
      $this->getStorage()->delete($this->id, $name);
    }
  }


  public static function cleanPath($path)
  {
    return str_replace(sfConfig::get('sf_web_dir'), '', $path);
  }
}

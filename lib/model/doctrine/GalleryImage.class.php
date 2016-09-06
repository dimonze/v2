<?php

/**
 * GalleryImage
 *
 * @package    garage
 * @subpackage model
 * @author     Garin Studio <eugeniy.b@garin-studio.ru>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class GalleryImage extends BaseGalleryImage
{
  private $_file;
  private static $_storage;


  /**
   * @return FileStorage
   */
  protected function getStorage()
  {
    if (!$this->id) {
      throw new Exception('Unable to get storage for unsaved instance');
    }

    if (is_null(self::$_storage)) {
      self::$_storage = new FileStorage(array(
        'level'       => 2,
        'prefix'      => 'gallery_image',
      ));
    }

    return self::$_storage;
  }


  public function getFile()
  {
    return $this->id ? $this->getStorage()->getFilename($this->id) : false;
  }

  public function setFile($value)
  {
    if (!$value) return;

    if ($value instanceOf sfValidatedFile) {
      $tmpfile = sprintf('%s/tmp/%s', sfConfig::get('sf_web_dir'), $value->generateFilename());
      $this->_file = $value->save($tmpfile);
    }
    else {
      throw new Exception('Only instance of sfValidatedFile can be set as file');
    }
  }

  public function getSource()
  {
    return Gallery::cleanPath($this->file);
  }

  public function getThumb()
  {
    return Gallery::cleanPath($this->getStorage()->getThumb(
      $this->id, 'gallery_image_thumb', array('height' => 260, 'crop' => '260x260'), 'gallery_image'
    ));
  }

  public function getMedium()
  {
    return Gallery::cleanPath($this->getStorage()->getThumb(
      $this->id, 'gallery_image_medium', array('width' => 895), 'gallery_image'
    ));
  }

  public function postSave($event)
  {
    parent::postSave($event);

    if ($this->_file) {
      $this->cleanupThumbs();
      $this->getStorage()->store($this->_file, $this->id, true);
      $this->_file = null;
    }
  }

  public function postDelete($event)
  {
    parent::postDelete($event);

    $this->getStorage()->delete($this->id);
    $this->cleanupThumbs();
  }


  private function cleanupThumbs()
  {
    foreach (array('gallery_image_thumb', 'gallery_image_medium') as $name) {
      $this->getStorage()->delete($this->id, $name);
    }
  }
}

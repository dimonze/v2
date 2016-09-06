<?php

/**
 * Page
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    garage
 * @subpackage model
 * @author     Garin Studio <eugeniy.b@garin-studio.ru>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Page extends BasePage
{
  const
    RESEARCH_PAGE = 31,
    PERFORMANCE_PAGE = 42,
    ADDRESS_PAGE  = 16,
    JOBS_PAGE     = 30;

  private $_images_delete;

  public function getIndent()
  {
    return str_repeat('· ', $this->level);
  }

  public function getIndentedTitle()
  {
    return $this->indent . $this->title;
  }

  public function getParentId()
  {
    if ($this->getNode()->getParent()) {
      return $this->getNode()->getParent()->id;
    }
  }

  public function isDescendantOf(Page $page)
  {
    return $this->lft > $page->lft && $this->rgt < $page->rgt;
  }

  public function save(Doctrine_Connection $conn = null)
  {
    parent::save($conn);
    
    if ($this->_images_delete) {
      foreach ($this->_images_delete as $image_id) {
        foreach ($this->Images as $image) {
          if ($image->id == $image_id) {
            $image->delete();
            break;
          }
        }
      }
      $this->_images_delete = null;
    }
    
    $this->updateSearchIndex();
  }

  public function delete(Doctrine_Connection $conn = null)
  {
    parent::delete($conn);
    Search::delete($this);
  }


  public function updateSearchIndex()
  {
    if ($this->is_for_press) {
      Search::delete($this);
      return true;
    }

    foreach (sfConfig::get('sf_languages') as $lang) {
      if (!$this->Translation[$lang]->title) {
        continue;
      }

      $doc = Search::createDocument($this);
      $doc->addField(Zend_Search_Lucene_Field::text('title', $this->Translation[$lang]->title));
      $doc->addField(Zend_Search_Lucene_Field::text(
        'contents', Search::cleanText($this->Translation[$lang]->body)
      ));

      $doc->getField('title')->boost = 5;
      $doc->getField('contents')->boost = 1;

      Search::getInstance($lang)->addDocument($doc);
    }
  }

  public function getIsForPress()
  {
    return in_array($this->id, array(12,19,20,25));
  }

  public function getIsForResearch()
  {
    return in_array($this->id, array(34,35,36));
  }
  
  public function setImagesUpload($value)
  {
    if (!is_array($value)) {
      return;
    }
    foreach ($value as $file) {
      $image = new PageImage();
      $image->file = $file;
      $this->Images[] = $image;
    }
  }
  
  public function setImagesDelete($value)
  {
    if (is_array($value)) {
      $this->_images_delete = $value;
    }
  }
  
  public function toArray($deep = true, $prefixKey = false)
  {
    $images = array();
    foreach ($this->Images as $image) {
      $images[$image->id] = $this->cleanPath($image->file);
    }
    return array_merge(parent::toArray($deep, $prefixKey), array('images' => $images));
  }
  
  public function cleanPath($path)
  {
    return str_replace(sfConfig::get('sf_web_dir'), '', $path);
  }
}
<?php

/**
 * PageImage
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    garage
 * @subpackage model
 * @author     Garin Studio <eugeniy.b@garin-studio.ru>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class PageImage extends BasePageImage
{
  private $_file;

  /**
   * @return FileStorage
   */
  protected function getStorage()
  {
    if (!$this->id) {
      throw new Exception('Unable to get storage for unsaved instance');
    }

    return new FileStorage(array(
      'level'       => 2,
      'prefix'      => 'page_image',
    ));
  }


  public function getFile()
  {
    return $this->id ? $this->getStorage()->getFilename($this->id) : false;
  }

  public function setFile($value)
  {
    if ($value) {
      $this->_file = sfConfig::get('sf_web_dir') . '/tmp/' . str_replace('/', '_', $value);
    }
  }

  public function getMedium()
  {
    return $this->Page->cleanPath($this->getStorage()->getThumb(
      $this->id, 'page_image_medium', array('height' => 470), 'page_image'
    ));
  }


  public function save(Doctrine_Connection $conn = null)
  {
    parent::save($conn);

    if ($this->_file) {
      $this->getStorage()->store($this->_file, $this->id, true);
      $this->_file = null;
    }
  }

  public function delete(Doctrine_Connection $conn = null)
  {
    parent::delete($conn);
    $this->getStorage()->delete($this->id);
    $this->getStorage()->delete($this->id, 'page_image_medium');
  }
}

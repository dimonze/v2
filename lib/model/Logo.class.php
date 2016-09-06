<?php

class Logo implements ArrayAccess
{
  protected
    $isNew,
    $tmpfile,

    $_culture,
    $_key,
    $_link,
    $_status,
    $_image;


  public function __construct($culture, $key = null)
  {
    $this->_culture = $culture;

    if (is_null($key)) {
      $this->isNew = true;
      $this->_key = $this->generateNewKey();
    }
    else {
      $logos = $this->getLogos();
      if (empty($logos[$key])) return null;

      $this->isNew  = false;
      $this->_key   = $key;
      $this->_link  = $logos[$key]['link'];
      $this->_status  = $logos[$key]['status'];
      $this->_image = $logos[$key]['image'];
    }
  }

  public function __get($field)
  {
    $getter = 'get' . sfInflector::camelize($field);
    if (method_exists($this, $getter)) {
      return $this->$getter();
    }
    elseif ($this->offsetExists($field)) {
      return $this->offsetGet($field);
    }

    throw new Exception(sprintf('Field %s not exists in %s', $field, __CLASS__));
  }

  public function __set($field, $value)
  {
    $setter = 'set' . sfInflector::camelize($field);
    if (method_exists($this, $setter)) {
      return $this->$setter($value);
    }
    elseif ($this->offsetExists($field)) {
      return $this->offsetSet($field, $value);
    }

    throw new Exception(sprintf('Field %s not exists in %s', $field, __CLASS__));
  }

  public function offsetExists($offset)
  {
    $offset = sprintf('_%s', $offset);
    return is_null($this->$offset) || isset($this->$offset);
  }

	public function offsetGet($offset)
  {
    $offset = sprintf('_%s', $offset);
    return $this->$offset;
  }

	public function offsetSet($offset, $value)
  {
    $offset = sprintf('_%s', $offset);
    $this->$offset = $value;
  }

	public function offsetUnset($offset)
  {
    $offset = sprintf('_%s', $offset);
    $this->$offset = null;
  }

  public function toArray()
  {
    $data = array();
    foreach ($this as $k => $v) {
      $data[ltrim($k, '_')] = $v;
    }

    return $data;
  }

  public function fromArray(array $values)
  {
    foreach ($values as $k => $v) {
      $this->__set($k, $v);
    }
  }

  public function isNew()
  {
    return $this->isNew;
  }

  public function getImage()
  {
    $path = $this->getImagePath();
    $path = str_replace(sfConfig::get('sf_web_dir'), '', $path);

    return $path;
  }

  public function isImageStored()
  {
    return is_file($this->getImagePath());
  }

  public function getImagePath()
  {
    return sprintf('%s/logos/%s', sfConfig::get('sf_upload_dir'), $this->_image);
  }

  public function setImage($value)
  {
    if (!$value) return;

    if ($value instanceOf sfValidatedFile) {
      if ($this->isImageStored()) {
        $this->setImageDelete(true);
      }

      $this->_image  = $value->generateFilename();
      $this->tmpfile = sprintf('%s/tmp/%s', sfConfig::get('sf_web_dir'), $this->_image);
      $value->save($this->tmpfile);
    }
    else {
      throw new Exception('Only instance of sfValidatedFile can be set as file');
    }
  }

  public function setImageDelete($value)
  {
    if ($value) @unlink($this->getImagePath());
  }

  public function promote()
  {
    $new_pos = $this->_key-1;
    if ($new_pos < 0) return;

    $this->move($new_pos);
  }

  public function demote()
  {
    $logos = $this->getLogos();
    $new_pos = $this->_key+1;
    if ($new_pos >= count($logos)) return;

    $this->move($new_pos);
  }

  public function save()
  {
    if ($this->tmpfile) {
      $target = $this->getImagePath();
      $thumb = new sfThumbnail(null, 65, true, true, 90);
      $thumb->loadFile($this->tmpfile);
      $thumb->save($target);
      $thumb->freeAll();
    }

    $app_config = sfYaml::load($this->getConfigFilePath());
    $app_config['all']['.array'][$this->_culture][$this->_key] = array(
      'link'    => $this->_link,
      'status'    => $this->_status,
      'image'   => $this->_image,
    );

    file_put_contents($this->getConfigFilePath(), sfYaml::dump($app_config, 4));
    self::removeCacheFile();
  }

  public function delete()
  {
    $this->setImageDelete(true);
    $app_config = sfYaml::load($this->getConfigFilePath());

    $data = array();
    foreach ($app_config['all']['.array'][$this->_culture] as $k => $b) {
      if ($k != $this->_key) $data[] = $b;
    }

    $app_config['all']['.array'][$this->_culture] = $data;
    file_put_contents($this->getConfigFilePath(), sfYaml::dump($app_config, 4));
    self::removeCacheFile();
  }


  private function move($new_pos)
  {
    $logos = $this->getlogos();
    $sorted  = array();

    $c = 0;
    foreach ($logos as $k => $b) {
      if ($k == $this->_key && $c != $new_pos) { }
      elseif ($c == $new_pos) {
        if ($c > count($sorted)) {
          $sorted[] = $b;
          $sorted[] = $logos[$this->_key];
        }
        else {
          $sorted[] = $logos[$this->_key];
          $sorted[] = $b;
        }
      }
      else {
        $sorted[] = $b;
      }

      $c++;
    }

    $app_config = sfYaml::load($this->getConfigFilePath());
    $app_config['all']['.array'][$this->_culture] = $sorted;
    file_put_contents($this->getConfigFilePath(), sfYaml::dump($app_config, 4));

    self::removeCacheFile();
  }

  private function generateNewKey()
  {
    return count($this->getLogos());
  }

  private function getLogos()
  {
    return sfConfig::get(sprintf('logo_%s', $this->_culture));
  }

  private function getConfigFilePath()
  {
    return sfConfig::get('sf_config_dir').'/logos.yml';
  }


  public static function removeCacheFile()
  {
    $fs = new sfFilesystem();
    $fs->remove(sfFinder::type('file')->name('config_logos.yml.php')->in(sfConfig::get('sf_cache_dir')));
  }
}
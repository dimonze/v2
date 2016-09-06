<?php

class Banner implements ArrayAccess
{
  protected
    $isNew,
    $tmpfile,

    $_culture,
    $_key,
    $_title,
    $_text,
    $_link,
    $_file,
    $_code;


  public function __construct($culture, $key = null)
  {
    $this->_culture = $culture;

    if (is_null($key)) {
      $this->isNew = true;
      $this->_key = $this->generateNewKey();
    }
    else {
      $banners = $this->getBanners();
      if (empty($banners[$key])) return null;

      $this->isNew  = false;
      $this->_key   = $key;
      $this->_title = $banners[$key]['title'];
      $this->_text  = $banners[$key]['text'];
      $this->_link  = $banners[$key]['link'];
      $this->_file  = $banners[$key]['file'];
      $this->_code  = $banners[$key]['code'];
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

  public function getFile()
  {
    $path = $this->getFilePath();
    $path = str_replace(sfConfig::get('sf_web_dir'), '', $path);

    return $path;
  }

  public function isFileStored()
  {
    return is_file($this->getFilePath());
  }

  public function getFilePath()
  {
    return sprintf('%s/promos/%s', sfConfig::get('sf_upload_dir'), $this->_file);
  }

  public function setFile($value)
  {
    if (!$value) return;

    if ($value instanceOf sfValidatedFile) {
      if ($this->isFileStored()) {
        $this->setFileDelete(true);
      }

      $this->_file = $value->generateFilename();
      $this->tmpfile = sprintf('%s/tmp/%s', sfConfig::get('sf_web_dir'), $this->_file);
      $value->save($this->tmpfile);
    }
    else {
      throw new Exception('Only instance of sfValidatedFile can be set as file');
    }
  }

  public function setFileDelete($value)
  {
    if ($value) @unlink($this->getFilePath());
  }

  public function promote()
  {
    $new_pos = $this->_key-1;
    if ($new_pos < 0) return;

    $this->move($new_pos);
  }

  public function demote()
  {
    $banners = $this->getBanners();
    $new_pos = $this->_key+1;
    if ($new_pos >= count($banners)) return;

    $this->move($new_pos);
  }

  public function save()
  {
    if ($this->tmpfile) {
      switch (pathinfo($this->tmpfile, PATHINFO_EXTENSION)) {
        case 'swf':
          rename($this->tmpfile, $this->getFilePath());
          $this->buildCodeFlash();
          break;

        case 'gif':
          rename($this->tmpfile, $this->getFilePath());
          $this->buildCodeImage();
          break;

        default:
          $target = $this->getFilePath();
          $thumb = new sfThumbnail(400, 264, true, true, 96);
          $thumb->loadFile($this->tmpfile);
          $thumb->save($target);

          $this->buildCodeImage();
      }
    }

    $app_config = sfYaml::load($this->getConfigFilePath());
    $app_config['all']['.array'][$this->_culture][$this->_key] = array(
      'title'   => $this->_title,
      'text'    => $this->_text,
      'link'    => $this->_link,
      'file'    => $this->_file,
      'code'    => $this->_code,
    );

    file_put_contents($this->getConfigFilePath(), sfYaml::dump($app_config, 4));
    self::removeCacheFile();
  }

  public function delete()
  {
    $this->setFileDelete(true);
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
    $banners = $this->getBanners();
    $sorted  = array();

    $c = 0;
    foreach ($banners as $k => $b) {
      if ($k == $this->_key && $c != $new_pos) { }
      elseif ($c == $new_pos) {
        if ($c > count($sorted)) {
          $sorted[] = $b;
          $sorted[] = $banners[$this->_key];
        }
        else {
          $sorted[] = $banners[$this->_key];
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

  private function buildCodeImage()
  {
    $this->_code = sprintf('<a href="%s"><img src="%s" alt="%s"/></a>',
      $this->_link,
      $this->getFile(),
      $this->_title
    );
  }

  private function buildCodeFlash()
  {
    $this->_code = sprintf('<embed width="220" height="150" wmode="opaque" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" src="%s" FlashVars="link=%s"></embed>',
      $this->getFile(),
      $this->_link
    );
  }

  private function generateNewKey()
  {
    return count($this->getBanners());
  }

  private function getBanners()
  {
    return sfConfig::get(sprintf('banner_%s', $this->_culture));
  }

  private function getConfigFilePath()
  {
    return sfConfig::get('sf_config_dir').'/banners.yml';
  }


  public static function removeCacheFile()
  {
    $fs = new sfFilesystem();
    $fs->remove(sfFinder::type('file')->name('config_banners.yml.php')->in(sfConfig::get('sf_cache_dir')));
  }
}
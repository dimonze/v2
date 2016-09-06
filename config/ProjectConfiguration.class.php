<?php

require_once dirname(__FILE__).'/../lib/vendor/symfony/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
  static protected $zendLoaded = false;

  public function setup()
  {
    mb_internal_encoding('utf-8');
    mb_regex_encoding('utf-8');
    $this->registerErrbit();
    date_default_timezone_set('Europe/Moscow');
    sfConfig::set('sf_languages', array('ru','en'));

    $this->enablePlugins('sfDoctrinePlugin', 'sfThumbnailPlugin');
    
    $this->enablePlugins('csDoctrineActAsSortablePlugin');

    if('backend' == sfConfig::get('sf_app') || 'cli' == PHP_SAPI) {
      $this->enablePlugins('sfFormExtraPlugin');
    }
    elseif ('frontend' == sfConfig::get('sf_app')) {
      $this->enablePlugins('sfKCaptchaPlugin');
    }
  }

  static public function registerZend()
  {
    if (self::$zendLoaded) {
      return;
    }

    set_include_path(sfConfig::get('sf_lib_dir') . '/vendor/zend/library' . PATH_SEPARATOR . get_include_path());
    require_once sfConfig::get('sf_lib_dir') . '/vendor/zend/library/Zend/Loader/Autoloader.php';
    Zend_Loader_Autoloader::getInstance();
    self::$zendLoaded = true;
  }
  
  protected function registerErrbit()
  {
    // Production only
    if (strpos(__DIR__, 'garageccc.com')) {
      require_once sfConfig::get('sf_lib_dir') . '/vendor/errbit-php/lib/Errbit.php';
      Errbit::instance()
        ->configure(array(
          'api_key'           => '290a62137c1bd6be6ac3324c731f9bb4',
          'host'              => 'errbit.garin.su',
          'port'              => 80,
          'secure'            => false,
          'project_root'      => sfConfig::get('sf_root_dir'),
          'environment_name'  => 'production',
        ))
        ->start(array('error', 'fatal'));

      $this->getEventDispatcher()->connect('application.throw_exception', function(sfEvent $e) {
        Errbit::instance()->notify($e->getSubject());
      });
    }
  }
}

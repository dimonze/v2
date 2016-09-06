<?php


class SysMsgForm extends BaseForm
{
  public function configure()
  {
    $this->setWidgets(array(
      'content_ru'  => new sfWidgetFormTextareaTinyMCE($this->_tinymce_mini_options),
      'content_en'  => new sfWidgetFormTextareaTinyMCE($this->_tinymce_mini_options),
      'enabled'     => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'content_ru'  => new sfValidatorPass(array('required' => true)),
      'content_en'  => new sfValidatorPass(array('required' => true)),
      'enabled'     => new sfValidatorBoolean(),
    ));

    $this->setDefaults(array(
      'content_ru'  => sfConfig::get('app_msg_content_ru'),
      'content_en'  => sfConfig::get('app_msg_content_en'),
      'enabled'     => sfConfig::get('app_msg_enabled'),
    ));

    $this->getWidgetSchema()->setLabels(array(
      'content_ru'  => 'RU Текст',
      'content_en'  => 'EN Текст',
      'enabled'     => 'Показывать?',
    ));

    $this->getWidgetSchema()->setNameFormat('msg[%s]');
    $this->getWidgetSchema()->setFormFormatterName('table');
  }

  public function save()
  {
    $app_config = sfYaml::load(sfConfig::get('sf_config_dir').'/app.yml');
    $app_config['all']['msg']['content_ru'] = $this->getValue('content_ru');
    $app_config['all']['msg']['content_en'] = $this->getValue('content_en');
    $app_config['all']['msg']['enabled']    = $this->getValue('enabled');

    file_put_contents(sfConfig::get('sf_config_dir').'/app.yml', sfYaml::dump($app_config, 4));
    self::removeCacheFile();
  }

  public function getStylesheets()
  {
    return array_merge(
            parent::getStylesheets(),
            array('/sfDoctrinePlugin/css/default.css' => 'screen', '/sfDoctrinePlugin/css/global.css' => 'screen')
    );
  }


  public static function removeCacheFile()
  {
    $fs = new sfFilesystem();
    $fs->remove(sfFinder::type('file')->name('config_app.yml.php')->in(sfConfig::get('sf_cache_dir')));
  }
}
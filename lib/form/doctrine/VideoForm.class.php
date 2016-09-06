<?php

/**
 * Video form.
 *
 * @package    garage
 * @subpackage form
 * @author     Garin Studio <eugeniy.b@garin-studio.ru>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class VideoForm extends BaseVideoForm
{
  public function configure()
  {
    $this->embedI18n(sfConfig::get('sf_languages'));
  }
  
  protected function doUpdateObject($values)
  {
    foreach (sfConfig::get('sf_languages') as $lang) {
      if (empty($values[$lang])) {
        unset($this->getObject()->Translation[$lang]);
      }
    }

    parent::doUpdateObject($values);
  }

  public function saveEmbeddedForms($con = null, $forms = null)
  { }
  
}

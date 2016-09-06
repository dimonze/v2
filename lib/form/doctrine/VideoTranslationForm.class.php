<?php

/**
 * VideoTranslation form.
 *
 * @package    garage
 * @subpackage form
 * @author     Garin Studio <eugeniy.b@garin-studio.ru>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class VideoTranslationForm extends BaseVideoTranslationForm
{
  public function configure()
  {
    $this->widgetSchema['title'] = new sfWidgetFormInputText();
    
      $this->widgetSchema->setLabels(array(
      'title'             => 'Название',
    ));
  }
}

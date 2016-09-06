<?php

/**
 * News form.
 *
 * @package    garage
 * @subpackage form
 * @author     Garin Studio <eugeniy.b@garin-studio.ru>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class NewsForm extends BaseNewsForm
{
  public function configure()
  {
    $this->embedI18n(sfConfig::get('sf_languages'));

    $this->widgetSchema['date'] = new sfWidgetFormI18nDate(array('culture' => 'ru'));
    $this->widgetSchema['preview_image'] = new sfWidgetFormInputFileEditable(array(
      'file_src'    => $this->getObject()->preview_image . '?' . filemtime(sfConfig::get('sf_web_dir') . $this->getObject()->preview_image),
      'is_image'    => true,
      'with_delete' => false,
      'edit_mode'   => $this->getObject()->preview_image,
    ));

    $this->validatorSchema['preview_image'] = new sfValidatorFile(array(
      'required' => !$this->getObject()->preview_image,
    ));


    $this->getWidget('gallery_id')->setOption('table_method', 'getGalleryChoices');
  }
}

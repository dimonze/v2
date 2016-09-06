<?php

/**
 * Book form.
 *
 * @package    garage
 * @subpackage form
 * @author     Garin Studio <dimonze@garin-studio.ru>
 * @version    SVN: $Id$
 */
class BookForm extends BaseBookForm
{
 public function configure()
  {
   $this->embedI18n(sfConfig::get('sf_languages'));
   
   $this->widgetSchema['publication_date'] = new sfWidgetFormI18nDate(array('culture' => 'ru'));
    
    $this->widgetSchema['preview_image'] = new sfWidgetFormInputFileEditable(array(
      'file_src'    => $this->getObject()->preview_image . '?' . filemtime(sfConfig::get('sf_web_dir') . $this->getObject()->preview_image),
      'is_image'    => true,
      'with_delete' => false,
      'edit_mode'   => $this->getObject()->preview_image,
    ));

    $this->validatorSchema['preview_image'] = new sfValidatorFile(array(
      'required' => !$this->getObject()->preview_image,
    ));
    
    $this->widgetSchema['images'] = new WidgetFormInputAjaxUpload();
    
    $this->validatorSchema['images_delete'] = new sfValidatorPass();
    $this->validatorSchema['images_upload'] = new sfValidatorPass();
    $this->widgetSchema['banner_image_ru'] = new sfWidgetFormInputFileEditable(array(
      'file_src'  => $this->getObject()->banner_image_ru . '?' . filemtime(sfConfig::get('sf_web_dir') . $this->getObject()->banner_image_ru),
      'is_image'  => true,
      'edit_mode' => $this->getObject()->banner_image_ru,
      'delete_label'  => 'удалить',
    ));
    $this->widgetSchema['banner_image_en'] = new sfWidgetFormInputFileEditable(array(
      'file_src'  => $this->getObject()->banner_image_en . '?' . filemtime(sfConfig::get('sf_web_dir') . $this->getObject()->banner_image_en),
      'is_image'  => true,
      'edit_mode' => $this->getObject()->banner_image_en,
      'delete_label'  => 'удалить',
    ));
    
    $this->validatorSchema['banner_image_ru'] = new sfValidatorFile(array(
      'required' => false,
    ));
    $this->validatorSchema['banner_image_en'] = new sfValidatorFile(array(
      'required' => false,
    ));
    
    $this->validatorSchema['banner_image_ru_delete'] = new sfValidatorPass();
    $this->validatorSchema['banner_image_en_delete'] = new sfValidatorPass();


    $this->getWidget('gallery_id')->setOption('table_method', 'getGalleryChoices');
  
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

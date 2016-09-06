<?php

/**
 * Event form.
 *
 * @package    garage
 * @subpackage form
 * @author     Garin Studio <eugeniy.b@garin-studio.ru>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class EventForm extends BaseEventForm
{
  public function configure()
  {
    $this->embedI18n(sfConfig::get('sf_languages'));


    $this->widgetSchema['date_start'] = new sfWidgetFormI18nDate(array('culture' => 'ru'));
    $this->widgetSchema['date_end'] = new sfWidgetFormI18nDate(array('culture' => 'ru'));
    $this->widgetSchema['type'] = new sfWidgetFormSelect(array(
      'choices' => Event::$types,
    ));
    $this->widgetSchema['published_at'] = new sfWidgetFormInputCheckbox(array(
      'value_attribute_value' => $this->getObject()->published_at,
    ));

    $this->widgetSchema['preview_image'] = new sfWidgetFormInputFileEditable(array(
      'file_src'    => $this->getObject()->preview_image . '?' . filemtime(sfConfig::get('sf_web_dir') . $this->getObject()->preview_image),
      'is_image'    => true,
      'with_delete' => false,
      'edit_mode'   => $this->getObject()->preview_image,
    ));
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
    $this->widgetSchema['additional_image'] = new sfWidgetFormInputFileEditable(array(
      'file_src'  => $this->getObject()->additional_image . '?' . filemtime(sfConfig::get('sf_web_dir') . $this->getObject()->additional_image),
      'is_image'  => true,
      'edit_mode' => $this->getObject()->additional_image,
    ));
    $this->widgetSchema['images'] = new WidgetFormInputAjaxUpload();


    $this->validatorSchema['date_start'] = new sfValidatorDate(array('required' => true));
    $this->validatorSchema['type'] = new sfValidatorChoice(array(
      'choices' => array_keys(Event::$types),
    ));

    $this->validatorSchema['preview_image'] = new sfValidatorFile(array(
      'required' => !$this->getObject()->preview_image,
      'max_size'      => 5242880,  
    ), array(
      'max_size'      => 'Макс. размер 5Мб',   
    ));
    $this->validatorSchema['banner_image_ru'] = new sfValidatorFile(array(
      'required' => false,
    ));
    $this->validatorSchema['banner_image_en'] = new sfValidatorFile(array(
      'required' => false,
    ));
    $this->validatorSchema['additional_image'] = new sfValidatorFile(array(
      'required' => false,
    ));
    $this->validatorSchema['banner_image_ru_delete'] = new sfValidatorPass();
    $this->validatorSchema['banner_image_en_delete'] = new sfValidatorPass();
    $this->validatorSchema['additional_image_delete'] = new sfValidatorPass();
    $this->validatorSchema['images_delete'] = new sfValidatorPass();
    $this->validatorSchema['images_upload'] = new sfValidatorPass();


    $this->getValidatorSchema()->setPreValidator(new sfValidatorCallback(array(
      'callback'  => array($this, 'validatorFieldsForPublishing'),
    )));


    $this->getWidget('gallery_id')->setOption('table_method', 'getGalleryChoices');
  }

  public function validatorFieldsForPublishing(sfValidatorCallback $validator, $values)
  {
    if (empty($values['published_at'])) {
      $this->getValidator('preview_image')->setOption('required', false);
      $this->getValidator('date_start')->setOption('required', false);

      if (empty($values['ru']['title']) && empty($values['en']['title'])) {
        throw new sfValidatorError($validator, 'Должно быть заполнено название хотя бы на одном языке.');
      }

      foreach (sfConfig::get('sf_languages') as $lang) {
        if (empty($values[$lang]['title'])) {
          $this->getValidator($lang)->offsetGet('title')->setOption('required', false);
        }
      }
    }

    return $values;
  }

  public function bind(array $taintedValues = null, array $taintedFiles = null)
  {
    if (!empty($taintedValues['published_at']) && empty($this->getObject()->published_at)) {
      $taintedValues['published_at'] = time();
    }

    parent::bind($taintedValues, $taintedFiles);
  }

  public function processValues($values)
  {
    foreach (sfConfig::get('sf_languages') as $lang) {
      $values[$lang]['title'] = preg_replace('/^ЧЕРНОВИК\s+/', '', $values[$lang]['title']);
    }

    if (!empty($values['ru']['title']) || !empty($values['en']['title'])) {
      if (empty($values['date_start']) || (empty($values['preview_image']) && !$this->getObject()->preview_image)) {
        foreach (sfConfig::get('sf_languages') as $lang) {
          if (!empty($values[$lang]['title'])) {
            $values[$lang]['title'] = 'ЧЕРНОВИК '.$values[$lang]['title'];
          }
        }
      }
    }

    return parent::processValues($values);
  }

  
  protected function doUpdateObject($values)
  {
    foreach (sfConfig::get('sf_languages') as $lang) {
      if (empty($values[$lang]) || empty($values[$lang]['title'])) {
        unset($this->getObject()->Translation[$lang], $values[$lang]);
      }
    }

    parent::doUpdateObject($values);
  }

  public function saveEmbeddedForms($con = null, $forms = null)
  { }
}

<?php

/**
 * Letter form.
 *
 * @package    garage
 * @subpackage form
 * @author     Garin Studio <eugeniy.b@garin-studio.ru>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class LetterForm extends BaseLetterForm
{
  public function configure()
  {
    $this->setWidget('lang', new sfWidgetFormChoice(array(
      'choices'       => array_combine(sfConfig::get('sf_languages'), array('Русский', 'Английский')),
    )));
    $this->setWidget('body', new sfWidgetFormTextareaTinyMCE($this->_tinymce_mini_options));
    $this->setWidget('image', new sfWidgetFormInputFileEditable(array(
      'file_src'      => $this->getObject()->image,
      'edit_mode'     => (bool) $this->getObject()->image,
      'is_image'      => true,
      'with_delete'   => true,
      'template'      => '%file%<br />%input%<br />%delete% удалить',
    )));

    $this->setValidator('lang', new sfValidatorChoice(array(
      'choices'       => sfConfig::get('sf_languages'),
      'required'      => true,
    )));
    $this->setValidator('subject', new sfValidatorString(array(
      'required'      => false,
      'max_length' => 255,
    )));
    $this->setValidator('image', new sfValidatorFile(array(
      'required'      => false,
      'mime_types'    => 'web_images',
    )));
    $this->setValidator('image_delete', new sfValidatorBoolean(array(
      'required'      => false,
    )));

    $this->embedEventsForm();

    $this->getWidget('image')->setAttribute('class', 'unlimited');

    unset($this['created_at'], $this['updated_at']);
  }

  public function bind(array $taintedValues = null, array $taintedFiles = null)
  {
    if (!empty($taintedValues['events'])) {
      foreach (array_keys($taintedValues['events']) as $index) {
        $this->addEventsWidget($index);
        $this->getValidator('events')->offsetGet($index)->offsetSet('items', new sfValidatorCallback(array(
          'callback'  => array($this, 'validatorEvents'),
        )));

        if (!empty($taintedValues['events'][$index]['items'])) {
          $this->getValidator('events')->offsetGet($index)->offsetGet('category')->setOption('required', true);
        }
      }
    }

    parent::bind($taintedValues, $taintedFiles);
  }

  public function validatorEvents(sfValidatorCallback $validator, $values)
  {
    $image_validator = new sfValidatorFile(array('required' => false, 'mime_types' => 'web_images'));

    for ($i=0; true; $i++) {
      if (!isset($values['id'][$i])) break;
      if ($i > 10) throw new sfValidatorErrorSchema($validator, new sfValidatorError($validator, 'Максимум 10 позиций.'));

      $event_id = $values['id'][$i];
      $values[$event_id] = array(
        'text'      => trim($values['text'][$i]),
        'template'  => $values['template'][$i],
        'button'    => $values['button'][$i],
        'dates'     => trim($values['dates'][$i]),
        'link'      => trim($values['link'][$i]),
      );

      if (empty($values[$event_id]['dates'])) {
        $values[$event_id]['dates'] = null;
      }
      if (empty($values[$event_id]['link'])) {
        $values[$event_id]['link'] = sprintf('http://%s/%s/event/%d', sfContext::getInstance()->getRequest()->getHost(), $this->taintedValues['lang'], $event_id);
      }
      elseif (!preg_match('/^\w*:\/{2}/i', $values[$event_id]['link'])) {
        $values[$event_id]['link'] = 'http://'.$values[$event_id]['link'];
      }

      if (!empty($values['image_delete'][$i])) {
        $this->getObject()->setEventImageDelete($event_id);
      }
      $this->getObject()->setEventImage($event_id, $image_validator->clean($values['image'][$i]));
    }

    foreach (array_keys($values) as $k) {
      if (!is_numeric($k)) unset($values[$k]);
    }

    return $values;
  }

  public function processValues($values)
  {
    if (empty($values['subject']) && $values['lang'] == 'ru') {
      $values['subject'] = 'Безымянное письмо';
    }
    elseif (empty($values['subject']) && $values['lang'] == 'en'){
      $values['subject'] = 'No subject';
    }

    foreach ($values['events'] as $i => $data) {
      if (!empty($data['items'])) {
        $values['events'][$data['category']] = $data['items'];
      }
      unset($values['events'][$i]);
    }

    return parent::processValues($values);
  }

  public function addEventsWidget($index)
  {
    if (!isset($this->widgetSchema['events'][$index])) {
      $form = new LetterCategoryForm();
      $this->getEmbeddedForm('events')->embedForm($index, $form);

      //unable to embed form to already embedded form without line below :(
      $this->widgetSchema['events'][$index] = new sfWidgetFormSchemaDecorator($form->getWidgetSchema(), $form->getWidgetSchema()->getFormFormatter()->getDecoratorFormat());
      $this->validatorSchema['events'][$index] = $form->getValidatorSchema();
      $this->widgetSchema['events']->setLabel($index, false);
    }
  }


  private function embedEventsForm()
  {
    $form = new BaseForm();

    $categories = $this->isNew() || !is_array($this->getObject()->events) ? array() : array_keys($this->getObject()->events);
    foreach ($categories as $i => $category) {
      $category_form = new LetterCategoryForm(array('category' => $category));

      if (is_numeric($category)) { //backward compatibility
        $category_title = $this->getObject()->lang == 'ru' ? sfContext::getInstance()->getI18N()->__(Event::$titles[$category]['title']) : Event::$titles[$category]['title'];
        $category_form->getWidget('category')->setAttribute('value', $category_title);
      }

      $form->embedForm($i, $category_form);
      $form->getWidgetSchema()->setLabel($i, false);
    }

    $this->embedForm('events', $form);

    if (!$this->getEmbeddedForm('events')->getEmbeddedForms()) {
      $this->addEventsWidget(0);
    }
  }
}


class LetterCategoryForm extends sfForm
{
  public function configure()
  {
    $this->setWidget('category', new sfWidgetFormInputText(array('default' => $this->getDefault('category')), array('value' => $this->getDefault('category'))));
    $this->setValidator('category', new sfValidatorString(array('required' => false, 'trim' => true, 'max_length' => 30)));

    $this->setWidget('items', new WidgetFormLetterItemAutocomplete(array(
      'url'       => sfContext::getInstance()->getController()->genUrl('@default?module=letter&action=match'),
      'url_add'   => sfContext::getInstance()->getController()->genUrl('@default?module=letter&action=addItem'),
    )));
    $this->setValidator('items', new sfValidatorPass(array(
      'required'  => false,
    )));

    $this->getWidgetSchema()->setLabel('category', 'Категория');
    $this->getWidgetSchema()->setLabel('items', 'События');

    $this->getWidgetSchema()->setHelp('items', 'начните вводить название (минимум 3 символа), чтобы увидеть список совпадений');

    $this->disableLocalCSRFProtection();
  }
}
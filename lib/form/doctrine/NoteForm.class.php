<?php

/**
 * Note form.
 *
 * @package    garage
 * @subpackage form
 * @author     Garin Studio <eugeniy.b@garin-studio.ru>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class NoteForm extends BaseNoteForm
{

  public function configure()
  {
    $this->widgetSchema['event_name'] = new sfWidgetFormInput();
    $this->validatorSchema['event_name'] = new sfValidatorString(array('required' => true));
    
    $this->widgetSchema['event_id'] = new sfWidgetFormInputHidden();
    $this->validatorSchema['event_id'] = new sfValidatorString(array('required' => true));
    
    $this->widgetSchema['event_type'] = new sfWidgetFormInputHidden();
    $this->validatorSchema['event_type'] = new sfValidatorChoice(array('choices' => array('book', 'event')));    
    
    $this->widgetSchema['position'] = new sfWidgetFormInputHidden();
    $this->validatorSchema['position'] = new sfValidatorString(array('required' => false));
    
    
    $this->widgetSchema->setLabels(array(
      'name'          => 'Заметка',
      'event_name'    => 'Событие',
      'event_id'      => 'id События',
      'event_type'    => 'Тип',  
      'position'      => 'Позиция',     
    ));
  } 

}

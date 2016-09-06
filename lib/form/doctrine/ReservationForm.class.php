<?php

/**
 * Reservation form.
 *
 * @package    garage
 * @subpackage form
 * @author     Garin Studio <eugeniy.b@garin-studio.ru>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ReservationForm extends BaseReservationForm
{
  public function configure()
  {
    $this->widgetSchema['event_id'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['date'] = new sfWidgetFormInput();
    $this->widgetSchema['kcaptcha'] = new sfWidgetFormInputKCaptcha(
      array(
        'template' => '%img% %input%',
        'image_attributes' => array('class' => 'fl captcha'),
        'form_name' => $this->getName(),
      ),
      array('class' => 'fl')
    );

    $this->validatorSchema['date'] = new sfValidatorDate(array(
      'date_format' => '/^\d{4}-\d{2}-\d{2}$/'
    ));
    $this->validatorSchema['kcaptcha'] = new sfValidatorKCaptcha(array(
      'form_name' => $this->getName(),
    ));

    $this->disableCSRFProtection();

    unset($this['created_at'], $this['updated_at']);
  }
}

<?php

/**
 * Feedback form.
 *
 * @package    garage
 * @subpackage form
 * @author     Garin Studio <eugeniy.b@garin-studio.ru>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class FeedbackForm extends BaseFeedbackForm
{
  public function configure()
  {
    $this->widgetSchema['kcaptcha'] = new sfWidgetFormInputKCaptcha(
      array(
        'template' => '%img% %input%',
        'image_attributes' => array('class' => 'fl captcha'),
        'form_name' => $this->getName(),
      ),
      array('class' => 'fl')
    );

    $this->validatorSchema['kcaptcha'] = new sfValidatorKCaptcha(array(
      'form_name' => $this->getName(),
    ));
    $this->validatorSchema['message'] = new sfValidatorString();

    $this->disableCSRFProtection();

    unset($this['created_at'], $this['updated_at']);
  }
}

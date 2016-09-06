<?php

/**
 * UserResetForm
 *
 * @package    domus
 * @subpackage forms
 * @author     Garin Studio
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class UserResetForm extends BaseForm
{
  public function configure() {
    $this->setWidgets(array(
      'email'    => new sfWidgetFormInput()
    ));

    $this->setValidators(array(
      'email'    => new sfValidatorAnd(array(
          new sfValidatorEmail(array('required' => true)),
          new sfValidatorDoctrineChoice(array('model' => 'User', 'column' => array('email')))
      ), array('halt_on_error' => true))
    ));

    $this->widgetSchema->setNameFormat('user[%s]');
    $this->disableLocalCSRFProtection();
  }
}
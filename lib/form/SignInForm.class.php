<?php

class SignInForm extends BaseForm
{
  public function configure()
  {
    $this->setWidgets(array(
      'email' => new sfWidgetFormInputText(),
      'pass'  => new sfWidgetFormInputPassword(),
    ));

    $this->setValidators(array(
      'email' => new sfValidatorCallback(array('callback' => array($this, 'validateLogin'), 'required' => true)),
      'pass'  => new sfValidatorString(array('max_length' => 20, 'required' => true)),
    ));

    $this->getWidgetSchema()->setNameFormat('user[%s]');

    $this->disableLocalCSRFProtection();
  }

  public function validateLogin(sfValidatorCallback $validator, $value)
  {
    if (!in_array($value, array_keys(sfConfig::get('app_accounts')))) {
      $validator = new sfValidatorEmail(array('max_length' => 50, 'required' => true));
      try {
        $validator->clean($value);
      } catch (sfValidatorError $e) {
        throw new sfValidatorError($validator, 'invalid file');
      }
    }

    return $value;
  }

}
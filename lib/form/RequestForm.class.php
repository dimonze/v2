<?php

class RequestForm extends sfForm
{
  public function setup()
  {
    sfValidatorBase::setDefaultMessage('required', 'required');
    sfValidatorBase::setDefaultMessage('invalid', 'invalid');
    sfValidatorBase::setDefaultMessage('max_length', 'too long');
    sfValidatorBase::setDefaultMessage('min_length', 'too short');

    parent::setup();
  }


  public function configure()
  {
    $i18n = sfContext::getInstance()->getI18N();

    foreach (array('fio','address','email','phone','profession','company','theme','aim') as $name) {
      $this->setWidget($name, new sfWidgetFormInputText());
      $this->setValidator($name, new sfValidatorString(array(
        'max_length'  => 200,
        'required'    => true,
      )));

      if (in_array($name, array('fio','address','email'))) {
        $this->getWidget($name)->setAttribute('class', 'input long_input');
      }
      elseif (in_array($name, array('phone','profession','company','theme','aim'))) {
        $this->getWidget($name)->setAttribute('class', 'input short_input');
      }
    }

    $this->setWidget('captcha', new sfWidgetFormInputKCaptcha(array(
      'template'    => '%img%',
      'form_name'   => 'request',
    )));
    $this->setValidator('captcha', new sfValidatorKCaptcha(array(
      'form_name'   => 'request',
    )));

    $this->setValidator('email', new sfValidatorEmail(array(
      'required'    => true,
    )));
    $this->setValidator('phone', new sfValidatorRegex(array(
      'pattern'     => '/^(?:\+7|8)[\d\- ()]+$/',
      'max_length'  => 18,
      'min_length'  => 10,
      'trim'        => true,
    )));

    $this->getWidget('phone')->setAttribute('placeholder', $i18n->__('number in international format', null, 'request-form'));
    $this->getWidget('aim')->setAttribute('placeholder', $i18n->__('dissertation, diploma, article, work on the exhibition, etc.', null, 'request-form'));

    $this->getWidgetSchema()->setLabels(array(
      'fio'         => 'Full Name',
      'address'     => 'Address',
      'email'       => 'E-mail',
      'phone'       => 'Phone',
      'profession'  => 'Profession',
      'company'     => 'Company',
      'theme'       => 'Theme of research',
      'aim'         => 'Purpose of research',
      'captcha'     => 'Captcha',
    ));

    $this->getWidgetSchema()->getFormFormatter()->setTranslationCatalogue('request-form');

    $this->getWidgetSchema()->setNameFormat('request[%s]');
  }
}

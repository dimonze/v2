<?php

class sfValidatorKCaptcha extends sfValidatorBase
{
  protected function configure($options = array(), $messages = array())
  {
    parent::configure($options, $messages);
    $this->addRequiredOption('form_name');
  }

  /**
   * @param string $value
   *
   * @return string
   *
   * @throws sfValidatorError
   */
  protected function doClean($value)
  {
    $clean = (string) $value;

    $kcaptchaKey = sfContext::getInstance()->getUser()->getAttributeHolder()->remove($this->getOption('form_name'));
    if ($clean !== $kcaptchaKey)
    {
      throw new sfValidatorError($this, 'invalid');
    }

    return $clean;
  }
}
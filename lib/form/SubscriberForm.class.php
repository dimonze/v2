<?php

/**
 * Subscriber form.
 *
 * @package    garage
 * @subpackage form
 * @author     Garin Studio <eugeniy.b@garin-studio.ru>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class SubscriberForm extends sfForm
{
  public function configure()
  {
    $this->setWidget('email', new sfWidgetFormInputText());
    $this->setWidget('captcha', new sfWidgetFormInputKCaptcha(array(
      'image_attributes' => array('class' => 'fr'),
      'form_name' => 'subscriber',
    )));

    $this->setValidator('captcha', new sfValidatorKCaptcha(array(
      'form_name' => 'subscriber',
    )));
    $this->setValidator('email', new sfValidatorEmail(array('max_length' => 50)));

    $this->disableCSRFProtection();

    $this->getWidgetSchema()->setNameFormat('subscriber[%s]');
  }

  public function save($lang)
  {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_URL, 'http://ymlp.com/subscribe.php?id='.($lang != 'ru' ? 'gbjmeybgmgh' : 'gbjmeybgmgb'));
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query(array('YMP0' => $this->getValue('email'))));

    if (!$res = curl_exec($curl)) {
      return curl_error($curl);
    }
    else {
      return $res;
    }
  }
}

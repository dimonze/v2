<?php

/**
 * User form.
 *
 * @package    garage
 * @subpackage form
 * @author     Garin Studio <eugeniy.b@garin-studio.ru>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class UserForm extends BaseUserForm
{
  public function configure()
  {
    $this->setWidget('password', new sfWidgetFormInputHidden());
    $this->setWidget('token', new sfWidgetFormInputHidden());
    $this->setWidget('created_at', new sfWidgetFormI18nDateTime(array('culture' => 'ru')));

    $this->getWidget('group')->setOption('choices', array('' => '') + User::$_groups);
    $this->getWidget('created_at')->setDefault(time());

    $this->getValidator('password')->setOption('required', false);
  }

  protected function updatePasswordColumn()
  {
    return $this->isNew() ? User::generatePassword() : $this->getObject()->getPassword();
  }
}

<?php

/**
 * default actions.
 *
 * @package    garage
 * @subpackage default
 * @author     Garin Studio <eugeniy.b@garin-studio.ru>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class defaultActions extends sfActions
{
  public function executeMsg(sfWebRequest $request)
  {
    $this->form = new SysMsgForm();

    if ($request->isMethod(sfWebRequest::POST) && $request->hasParameter($this->form->getName())) {
      $this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));
      if ($this->form->isValid()) {
        $this->form->save();
        $this->getUser()->setFlash('notice', 'Изменения успешно сохранены.');

        $this->redirect('@default?module=default&action=msg');
      }

      $this->getUser()->setFlash('error', 'Ошибка. Данные не сохранены. Проверьте правильность заполнения формы.', false);
    }
  }
}
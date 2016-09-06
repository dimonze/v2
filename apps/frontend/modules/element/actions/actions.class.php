<?php

/**
 * element actions.
 *
 * @package    garage
 * @subpackage element
 * @author     Garin Studio <eugeniy.b@garin-studio.ru>
 */
class elementActions extends sfActions
{
  public function executeSignIn(sfWebRequest $request)
  {
    $form = new SignInForm();
    if ($request->isMethod(sfWebRequest::POST) && $request->hasParameter($form->getName())) {
      $form->bind($request->getParameter($form->getName()));

      if ($form->isValid()) {
        if (in_array($form->getValue('email'), array_keys(sfConfig::get('app_accounts')))) {
          $accounts = sfConfig::get('app_accounts');
          $user = null;

          if ($accounts[$form->getValue('email')]['pass'] == $form->getValue('pass')) {
            $user = new User();
            $user->fromArray($accounts[$form->getValue('email')]);
          }
        }
        else {
          $user = Doctrine::getTable('user')->findOneByEmailAndPassword($form->getValue('email'), User::handlePassword($form->getValue('pass')));
        }

        if (!$user) {
          return $this->renderText(json_encode(array('success' => false, 'errors' => array('global' => 'Неверный email или пароль'))));
        }

        $this->getUser()->authenticate($user);
        return $this->renderText(json_encode(array('success' => true)));
      }
      else {
        $errors = array();
        foreach ($form->getErrorSchema()->getNamedErrors() as $field => $data) {
          $errors[$field] = $data->getMessage();
        }

        return $this->renderText(json_encode(array('success' => false, 'errors' => $errors)));
      }
    }

    return $this->renderText(json_encode(array('success' => false)));
  }

  public function executeSignOut(sfWebRequest $request)
  {
    $this->getUser()->logout();
    $this->redirect('@homepage');
  }

  public function executePasswordReset(sfWebRequest $request)
  {
    $form = new UserResetForm();

    if ($request->isMethod(sfWebRequest::POST) && $request->hasParameter($form->getName())) {
      $form->bind($request->getParameter($form->getName()));

      if ($form->isValid()) {
        $user = Doctrine::getTable('user')->findOneByEmail($form->getValue('email'));
        $i18n = $this->getContext()->getI18N();
        $url = $this->generateUrl('default', array(
          'module' => 'element',
          'action' => 'passwordSet',
          'id'     => $user->id,
          'token'  => $user->recovery_token,
        ), true);

        $this->getMailer()->composeAndSend(
          sfConfig::get('app_email_from'),
          $user->email,
          $i18n->__('garageccc.com password recovery'),
          sprintf($i18n->__('To recover your password, click here %s'), $url)
        );
        return $this->renderText(json_encode(array(
          'success' => true,
          'message' => $i18n->__('Instructions has been emailed')
        )));
      }

      else {
        $errors = array();
        foreach ($form->getErrorSchema()->getNamedErrors() as $field => $data) {
          $errors[$field] = $data->getMessage();
        }

        return $this->renderText(json_encode(array('success' => false, 'errors' => $errors)));
      }
    }

    return $this->renderText(json_encode(array('success' => false)));
  }

  public function executePasswordSet(sfWebRequest $request)
  {
    $user = Doctrine::getTable('User')->findByRecoveryToken(
      $request->getParameter('id'), $request->getParameter('token')
    );

    if (!$user) {
      return sfView::ERROR;
    }

    $this->form = new UserSetPasswordForm();

    if ($request->isMethod('post')) {
      $this->form->bind($request->getParameter($this->form->getName()));
      if ($this->form->isValid()) {
        $user->password = $this->form->getValue('password');
        $user->save();
        $this->getUser()->authenticate($user);
        $this->redirect('@homepage');
      }
    }
  }
}
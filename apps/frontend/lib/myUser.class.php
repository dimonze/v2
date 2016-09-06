<?php

class myUser extends sfBasicSecurityUser
{
  public function __get($attr)
  {
    if ($this->isAuthenticated()) {
      return $this->getObject()->$attr;
    }

    return null;
  }

  public function __set($attr, $val)
  {
    if ($this->isAuthenticated()) {
      $this->getObject()->$attr = $val;
    }
  }

  public function __call($method, $args)
  {
    if ($this->isAuthenticated()) {
      return call_user_func_array(array($this->getObject(), $method), $args);
    }
    return null;
  }
  /**
   * @return User
   */
  public function getObject()
  {
    return $this->getAttribute('object', null);
  }

  public function setObject(User $user)
  {
    $this->setAttribute('object', $user);
  }

  /**
   * @param  User $user
   * @param  boolean $remember
   * @return void
   */
  public function authenticate(User $user)
  {
    $this->setAttribute('object', $user);
    $this->setAuthenticated(true);
    $this->setAuthToken($user);
  }

  public function logout()
  {
    $this->setAuthenticated(false);
    $this->setAttribute('object', null);
    $this->clearCredentials();
    $this->setAuthToken(null);
  }

  public function setAuthToken(User $user = null)
  {
    $response = sfContext::getInstance()->getResponse();
    if ($user) {
      $response->setCookie('remember', $user->email.':'.$user->auth_token, time()+31536000, '/');
    }
    else {
      $response->setCookie('remember', null);
    }
  }
}

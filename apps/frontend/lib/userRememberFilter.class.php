<?php
/**
 * @package    garage
 * @subpackage filter
 * @author     Garin Studio
 */
class userRememberFilter extends sfFilter
{
  /**
   * @param  sfFilterChain $filterChain
   * @return void
   */
  public function execute($filterChain)
  {
    $sf_user = $this->getContext()->getUser();
    if ($this->isFirstCall() && !$sf_user->isAuthenticated()) {
      if ($remember = $this->getContext()->getRequest()->getCookie('remember')) {
        list($email, $auth_token) = explode(':', $remember);
        $user = Doctrine::getTable('User')->findOneBy('email', $email);

        if ($user && $user->auth_token == $auth_token) {
          $sf_user->authenticate($user, true);
        }
        else {
          $sf_user->setAuthToken(null);
        }
      }
    }

    $filterChain->execute();
  }
}
<?php

require_once dirname(__FILE__).'/../lib/feedbackGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/feedbackGeneratorHelper.class.php';

/**
 * feedback actions.
 *
 * @package    garage
 * @subpackage feedback
 * @author     Garin Studio <eugeniy.b@garin-studio.ru>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class feedbackActions extends autoFeedbackActions
{
  public function executeAnswered()
  {
    $feedback = $this->getRoute()->getObject();
    $feedback->is_answered = true;
    $feedback->save();

    $this->redirect('@feedback');
  }
}

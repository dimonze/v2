<?php

/**
 * feedback cimponents.
 *
 * @package    garage
 * @subpackage feedback
 * @author     Garin Studio <eugeniy.b@garin-studio.ru>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class feedbackComponents extends sfActions
{
  public function executeForm()
  {
    $this->form = new FeedbackForm();
  }

  public function executeSubscribe()
  {
    $this->form = new SubscriberForm();
  }

  public function executeReserve()
  {
    $this->form = new ReservationForm();
    $this->form->setDefault('event_id', $this->event->id);
  }

  public function executeRequest()
  {
    $this->form = new RequestForm();
  }
}

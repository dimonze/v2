<?php

/**
 * feedback actions.
 *
 * @package    garage
 * @subpackage feedback
 * @author     Garin Studio <eugeniy.b@garin-studio.ru>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class feedbackActions extends sfActions
{
  public function executeCreate(sfWebRequest $request)
  {
    $form = new FeedbackForm();
    $form->bind($request->getParameter($form->getName()));

    if ($form->isValid()) {
      $form->save();
      $this->sendEmailFeedback($form->getObject());
    }
    else {
      return $this->renderPartial('form', array('form' => $form));
    }
  }

  public function executeSubscribe(sfWebRequest $request)
  {
    $form = new SubscriberForm();
    $form->bind($request->getParameter($form->getName()));

    if ($form->isValid()) {
      return $this->renderText($form->save($this->getUser()->getCulture()));
    }
    else {
      return $this->renderPartial('subscribe', array('form' => $form));
    }
  }

  public function executeReserve(sfWebRequest $request)
  {
    $form = new ReservationForm();
    $form->bind($values = $request->getParameter($form->getName()));

    if ($form->isValid()) {
      $form->save();
      $this->sendEmailReservation($form->getObject());
    }
    else {
      $event = Doctrine::getTable('Event')->find($values['event_id']);
      return $this->renderPartial('reserve', array('form' => $form, 'event' => $event));
    }
  }

  public function executeRequest(sfWebRequest $request)
  {
    $form = new RequestForm();
    $form->bind($request->getParameter($form->getName()));

    $i18n = $this->getContext()->getI18N();

    if ($form->isValid()) {
      $this->sendEmailRequest($form->getValues());
      return $this->renderText(json_encode(array('success' => true, 'message' => 'OK')));
    }
    else {
      $errors = array();
      foreach ($form->getErrorSchema()->getNamedErrors() as $field => $error) {
        $errors[$error->getMessage()][] = $i18n->__($form->getWidgetSchema()->getLabel($field), null, 'request-form');
      }

      $text = '';
      foreach ($errors as $message => $fields) {
        $message = $i18n->__($message, null, 'request-form');
        if ($message == 'required' || $message == 'обязательны для заполнения') {
          $text .= $i18n->__('All fields are %error%.', array('%error%' => $message), 'request-form');
        }
        elseif (count($fields) == 1) {
          $text .= $i18n->__('Field %field% is %error%.', array('%field%' => $fields[0], '%error%' => $message), 'request-form');
        }
        else {
          $text .= $i18n->__('Fields %fields% are %error%.', array('%fields%' => implode(', ', $fields), '%error%' => $message), 'request-form');
        }

        $text .= ' ';
      }

      return $this->renderText(json_encode(array('success' => false, 'errors' => $text)));
    }
  }

  private function sendEmailFeedback(Feedback $feedback)
  {
    $this->getMailer()->composeAndSend(
      sfConfig::get('app_email_from'),
      sfConfig::get('app_feedback_to'),
      'Обратная связь от пользователя сайта',
      $this->getPartial('mail/feedback', array('feedback' => $feedback))
    );
  }

  private function sendEmailReservation(Reservation $reservation)
  {
    $this->getMailer()->composeAndSend(
      sfConfig::get('app_email_from'),
      sfConfig::get('app_feedback_to'),
      'Заявка на бронирование от пользователя сайта',
      $this->getPartial('mail/reservation', array('reservation' => $reservation))
    );
  }

  private function sendEmailRequest($data)
  {
    $this->getMailer()->composeAndSend(
      sfConfig::get('app_email_from'),
      sfConfig::get('app_job_request_to'),
      'Заявка с сайта garageccc.com',
      $this->getPartial('mail/request', array('data' => $data))
    );
  }
}

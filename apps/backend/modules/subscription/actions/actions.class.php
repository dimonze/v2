<?php

/**
 * subscription actions.
 *
 * @package    garage
 * @subpackage subscription
 * @author     Garin Studio <eugeniy.b@garin-studio.ru>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class subscriptionActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  { }

  public function executeSend(sfWebRequest $request)
  {
    $from = $request->getParameter('email');
    $title = $request->getParameter('title');
    $text = $request->getParameter('text');

    if ($text && $title && $from) {
      $query = Doctrine::getTable('Subscriber')->createQuery()->select('email');
      $emails = $query->execute(array(), Doctrine::HYDRATE_SINGLE_SCALAR);

      $message = $this->getMailer()
        ->compose($from)
        ->setSubject($title)
        ->setBody($text, 'text/html', 'utf-8');

      foreach ($emails as $email) {
        $this->getMailer()->send($message->setTo($email));
      }

      $this->getUser()->setFlash('notice', sprintf('Рассылка была отправлена. Адресатов: ' . count($emails)));
      $this->redirect('subscription/index');
    }
    else {
      $this->setTemplate('index');
    }
  }

  public function executeExport()
  {
    ini_set('max_execution_time', 120);

    $response = $this->getResponse();
    $response->setContentType('application/vnd.ms-excel');
    $response->setHttpHeader('Content-Disposition', 'attachment; filename="subscribers_'.date('Ymd').'.xls"');
    $response->setHttpHeader('Content-Transfer-Encoding', 'binary');
    $response->sendHttpHeaders();

    $fp = fopen('php://output', 'w');
    fputs($fp, '<table width="100%" border="0">');

    foreach (Doctrine::getTable('Subscriber')->findAll(Doctrine::HYDRATE_ARRAY) as $s) {
      fputs($fp, '<tr><td>'.$s['email'].'</td></tr>');
    }

    fputs($fp, '</table>');
    fclose($fp);

    return sfView::NONE;
  }
}

<?php

require_once dirname(__FILE__).'/../lib/pageGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/pageGeneratorHelper.class.php';

/**
 * page actions.
 *
 * @package    garage
 * @subpackage page
 * @author     Garin Studio <eugeniy.b@garin-studio.ru>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class pageActions extends autoPageActions
{
  public function executeShow(sfWebRequest $request)
  {
    $this->forward('page', 'edit');
  }

  public function executePromote(sfWebRequest $request)
  {
    $object = Doctrine::getTable('Page')->find($request->getParameter('id'));
    $node = $object->getNode();
    if ($node->hasPrevSibling()) {
      $prev = $node->getPrevSibling();
      $node->moveAsPrevSiblingOf($prev);
    }

    $this->redirect('@page');
  }

  public function executeDemote(sfWebRequest $request)
  {
    $object = Doctrine::getTable('Page')->find($request->getParameter('id'));
    $node = $object->getNode();
    if ($node->hasNextSibling()) {
      $next = $node->getNextSibling();
      $node->moveAsNextSiblingOf($next);
    }

    $this->redirect('@page');
  }

  public function executeDelete(sfWebRequest $request)
  {
    if (in_array($request->getParameter('id'), array(Page::RESEARCH_PAGE, Page::ADDRESS_PAGE, Page::JOBS_PAGE, Page::PERFORMANCE,))) {
      $this->getUser()->setFlash('error', 'Нельзя удалить эту страницу', true);
      $this->redirect($request->getReferer());
    }

    $request->checkCSRFProtection();

    $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->getRoute()->getObject())));

    if ($this->getRoute()->getObject()->getNode()->delete()) {
      $this->getUser()->setFlash('notice', 'Запись успешно удалена');
    }

    $this->redirect('@page');
  }
}

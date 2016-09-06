<?php

/**
 * gallery actions.
 *
 * @package    garage
 * @subpackage gallery
 * @author     Garin Studio <eugeniy.b@garin-studio.ru>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class galleryActions extends sfActions
{
  public function preExecute()
  {
    $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Garage Center for Contemporary Culture'));
  }

  public function executeIndex(sfWebRequest $request)
  {
    $query = Doctrine::getTable('Gallery')
            ->createQueryI18N('g', $this->getUser()->getCulture())
            ->orderBy('g.date DESC');

    $this->pager = new sfDoctrinePager('Gallery', 6);
    $this->pager->setQuery($query);
    $this->pager->setPage($request->getParameter('page'));
    $this->pager->init();
  }

  public function executeShow()
  {
    $this->gallery = $this->getRoute()->getObject();
  }
}

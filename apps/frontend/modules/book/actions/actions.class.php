<?php

/**
 * event actions.
 *
 * @package    garage
 * @subpackage event
 * @author     Garin Studio <eugeniy.b@garin-studio.ru>
 */
class bookActions extends sfActions
{
  public function preExecute()
  {
    $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Garage Center for Contemporary Culture'));
  }

  public function executeIndex(sfWebRequest $request)
  {
    $query = Doctrine::getTable('Book')
            ->createQueryI18N('g', $this->getUser()->getCulture())
            ->orderBy('g.id DESC');

    $this->author = $request->getParameter('author', null);
    $this->publishing_house = $request->getParameter('publisher', null);
    $this->publication_date = $request->getParameter('year', null);

    if ($this->author) {
      $query->andWhere('author = ?', $this->author);
    }
    if ($this->publishing_house) {
      $query->andWhere('publishing_house = ?', $this->publishing_house);
    }
    if ($this->publication_date) {
      $query->andWhere('publication_date = ?', $this->publication_date);
    }

    $this->pager = new sfDoctrinePager('Book', 6);
    $this->pager->setQuery($query);
    $this->pager->setPage($request->getParameter('page'));
    $this->pager->init();
  }

  public function executeShow()
  {
    $this->book = $this->getRoute()->getObject();
    $this->other_books = Doctrine::getTable('Book')
      ->createQueryI18N()
      ->andWhere('id <> ?', $this->book->id)
      ->limit(2)
      ->execute();
  }
}
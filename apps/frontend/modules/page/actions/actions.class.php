<?php

/**
 * page actions.
 *
 * @package    garage
 * @subpackage page
 * @author     Garin Studio <eugeniy.b@garin-studio.ru>
 */
class pageActions extends sfActions
{
  public function executeIndex()
  {
    $this->checkUserCulture();
    
    $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Garage Museum of Contemporary Art'));
    $this->_counter = 0;

    $this->events = Doctrine::getTable('Event')
      ->createQueryI18N()
      ->andWhere('date_end >= CURDATE() OR (date_start >= CURDATE() AND date_end IS NULL)')
      ->andWhere('on_homepage = ?', true)
      ->andWhere('type >= 10 AND type <= 29')
      ->andWhere('published_at IS NOT NULL')
      ->limit(5)
      ->orderBy('
        IF (CURDATE() BETWEEN date_start AND date_end, date_start, CURDATE()) ASC,
        date_start ASC
      ')
      ->execute();

    $this->note = Doctrine::getTable('Note')
      ->createQuery('n')
      ->select('event_id, position, event_type')
      ->orderBy('position ASC')
      ->limit(5)
      ->execute();

    $this->noteArray = array();
    foreach ($this->note as $value) {
      $this->noteArray[] = (int)$value->event_id;
    }

    if (empty($this->noteArray)) {
      $this->recommended = array();
    }
    else {
      $this->recommended = $this->getBooksAndEvents($this->note);
    }
  }

  public function getBooksAndEvents($notes)
  {
    $recommended = array();

    foreach ($notes as $note) {
      if ($note->event_type == 'book') {
         $obj = Doctrine::getTable('Book')
          ->createQueryI18N()
          ->andWhere('id = ?', $note->event_id)
          ->fetchOne();
      }
      else {
        $obj = Doctrine::getTable('Event')
          ->createQueryI18N()
          ->andWhere('id = ?', $note->event_id)
          ->andWhere('published_at IS NOT NULL')
          ->fetchOne();
      }

      if ($obj) $recommended[] = $obj;
      unset($obj);
    }

    return $recommended;
  }

  public function executeShow()
  {
    $this->page = $this->getRoute()->getObject();
    $this->forward404Unless($this->page);
    $this->forward404If($this->page->is_for_press && !$this->getUser()->is_press);
  }

  public function executeError404()
  { }

  public function executeSearch(sfWebRequest $request)
  {
    $this->types = $request->getParameter('type', array_keys(Search::$types));

    $this->pager = new SearchPager(5);
    $this->pager->setSearch($search = Search::getInstance());
    $this->pager->setQuery($search->buildQuery(
      $request->getParameter('query'), $this->types
    ));
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();
  }
  
  /**
   * Проверка предпочитаемого языка пользователя
   */
  public function checkUserCulture()
  {
    $path_info = $this->getRequest()->getPathInfo();
    $last_culture = $this->getRequest()->getCookie('last_culture');
    //Если заход без указания языка
    if(!preg_match("#\/(ru|en)(\/|$)#", $path_info, $culture_info)){
      //Определяем и записываем язык
      if( empty($last_culture) ){
        $last_culture = $this->getRequest()->getPreferredCulture(array('ru','en'));
      }
      $url = $this->generateUrl('homepage', array( 'sf_culture' => $last_culture ));
      if( $last_culture == 'ru' ) $url .= $last_culture;
      //Делаем редирект на языковую версию в любом случае
      return $this->redirect($url);
    } else { //Продлеваем cookie еще на сутки
      $this->getResponse()->setCookie('last_culture', $culture_info[1], (time() + (24 * 60 * 60)));
    }
  }
}

<?php

/**
 * event actions.
 *
 * @package    garage
 * @subpackage event
 * @author     Garin Studio <eugeniy.b@garin-studio.ru>
 */
class eventActions extends sfActions
{
  public function preExecute()
  {
    $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Garage Museum of Contemporary Art'));
  }

  public function executeCategory(sfWebRequest $request)
  {
    /* @var $query Doctrine_Query */
    $query = Doctrine::getTable('Event')
      ->createQueryI18N()
      ->andWhere('published_at IS NOT NULL');

    $is_archive = 'archive' == $request->getParameter('date');
    $this->type = null;
    //Если раздел
    if ($atype = $request->getParameter('atype')) {
      $query->andWhere('type BETWEEN ? AND ?', array($atype, $atype + 8));
      $this->atype = $atype;
    }
    //Если категория
    if ($type = $request->getParameter('type')) {
      switch ($type) {
        case 41:  $query->andWhere('on_prehistory = 1');  break;
        case 42:  $query->andWhere('on_education_prog = 1');  break;
        default:  $query->andWhere('type = ?', $type);
      }
      $this->type = $type;
      $this->atype = max(1, floor($type / 10) * 10);
    }

    if (!$is_archive && $type == Event::TYPE_EDUCATION_BOOKS) {
      $this->events = $this->prepareBooks($request, $query);
      $this->date = $request->getParameter('date');
      $this->setTemplate('categoryBooks');
    }
    else {

      $this->date = $request->getParameter('date');

      $this->from = $request->getParameter('from', null);
      $this->to = $request->getParameter('to', null);

      //Значения по умолчанию для границ. С введением архива они появились
      if ($is_archive) {
        $query->andWhere('type != ?', Event::TYPE_EDUCATION_BOOKS);
        $this->to = $request->getParameter('to', date('d.m.Y', strtotime('-1 day', strtotime(date('d.m.Y'))) ));
        $this->from = $request->getParameter('from', date('d.m.Y', mktime(0, 0, 0, 1, 1, date("Y")) ));
      }
      else {
        $this->from = $request->getParameter('from', date('d.m.Y'));
      }

      $this->fromDateTime = null;
      if ($this->from) {
        $this->fromDateTime = DateTime::createFromFormat('d.m.Y', $this->from);
      }

      $this->toDateTime = null;
      if ($this->to) {
        $this->toDateTime = DateTime::createFromFormat('d.m.Y', $this->to);
      }
      if ($this->type != 41 && $this->type != 42) {
        if ($this->to && $this->from) {
          $params = array(
            date('Y-m-d', strtotime($this->from)),
            date('Y-m-d', strtotime($this->from)),
            date('Y-m-d', strtotime($this->to)),
          );
          $query->andWhere('NOT IF(date_start < ?, date_end < ?, ? < date_start)', $params);
        }
        else {
          if (!$this->to) {
            $params = array(
                date('Y-m-d', strtotime($this->from)),
                date('Y-m-d', strtotime($this->from)),
            );
            $query->andWhere('NOT IF(date_start < ?, date_end < ?, 0)', $params);
          }
          if (!$this->from) {
            $params = array(
              date('Y-m-d', strtotime($this->to)),
              date('Y-m-d', strtotime($this->to)),
            );
            $query->andWhere('IF(date_end IS NULL, date_start < ?, date_end < ?)', $params);
          }
        }
      }

      if ($is_archive || $this->type == 41 || $this->type == 42) {
        $events = $this->prepareEventsForView($query->execute(), true);
        $per_page = 16;
      }
      else {
        $events = $this->prepareEventsForView($query->execute(), false);
        $per_page =  7;
      }

      $this->pager = new arrayPager('Event', $per_page);
      $this->pager->setResultArray($events);
      $this->pager->setPage($request->getParameter('page'));
      $this->pager->init();

      $this->events = $this->pager->getResults();


      if ($is_archive) {
        $this->setTemplate('categoryArchive');

        if ($this->getUser()->getCulture() != 'ru') {
          $this->months = sfDateTimeFormatInfo::getInstance($this->getUser()->getCulture())->getMonthNames();
        }
        else {
          $i18n_data = sfDateTimeFormatInfo::getInstance('ru')->__get('Data');
          $this->months = $i18n_data['monthNames']['stand-alone']['wide'];
        }
      }
      elseif (Event::TYPE_EXHIBITION_OUTER == $request->getParameter('type')) {
        $this->setTemplate('categoryOuter');
      }
    }
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->event = $this->getRoute()->getObject();

    $request->setAttribute('menu_route_action', 'category');
    $request->setParameter('type', $this->event->type);

    $this->events = Doctrine::getTable('Event')
      ->createQueryI18N()
      ->andWhere('id <> ?', $this->event->id)
      ->andWhere('on_homepage = ?', 1)
      ->andWhere('published_at IS NOT NULL')
      ->limit(2)
      ->execute();

    $this->getResponse()->setTitle($this->event->getTitle());
  }

  public function executeToday(sfWebRequest $request)
  {
    $this->events = Doctrine::getTable('Event')
      ->createQuery()
      ->andWhere('type IN (?, ?, ?, ?)', array(Event::TYPE_EXHIBITION, Event::TYPE_CHILDREN, Event::TYPE_EDUCATION, Event::TYPE_RESEARCH_PROJECTS))
      ->andWhere('? BETWEEN date_start AND date_end', date('Y-m-d'))
      ->andWhere('own_schedule = ? OR schedule_' . strtolower(date('l')) . ' != ?', array(1, '--'))
      ->andWhere('published_at IS NOT NULL')
      ->limit(6)
      ->orderBy('date_start DESC, date_end DESC')
      ->execute();

    $this->setTemplate('today');
    $this->setLayout('simple');
  }

  public function executeTodaybook(sfWebRequest $request)
  {
    $this->events = Doctrine::getTable('Event')
      ->createQuery()
      ->andWhere('type IN (?, ?, ?, ?)', array(Event::TYPE_EXHIBITION, Event::TYPE_CHILDREN, Event::TYPE_EDUCATION, Event::TYPE_RESEARCH_PROJECTS))
      ->andWhere('? BETWEEN date_start AND date_end', date('Y-m-d'))
      ->andWhere('own_schedule = ? OR schedule_' . strtolower(date('l')) . ' != ?', array(1, '--'))
      ->andWhere('published_at IS NOT NULL')
      ->limit(6)
      ->orderBy('date_start DESC, date_end DESC')
      ->execute();

    $this->setTemplate('todayBook');
    $this->setLayout(simple);
  }
  

  private function prepareBooks(sfWebRequest $request, Doctrine_Query $query)
  {
    $query->orderBy('`date_start` DESC, `date_end` DESC');

    if ('past' == $request->getParameter('date')) {
      $query->andWhere('date_end < ?', date('Y-m-d'));
    }
    elseif ('now' == $request->getParameter('date')) {
      $query->andWhere('? BETWEEN date_start AND date_end', date('Y-m-d'));
    }

    //Если есть фильтр
    $this->from = $request->getParameter('from');
    $this->to = $request->getParameter('to');
    if ($this->from && $this->to) {
      $params = array(
        date('Y-m-d', strtotime($this->from)),
        date('Y-m-d', strtotime($this->from)),
        date('Y-m-d', strtotime($this->to)),
      );
      $query->andWhere('NOT IF(date_start < ?, date_end < ?, ? < date_start)', $params);
    }

    $this->pager = new sfDoctrinePager('Event', 7);
    $this->pager->setQuery($query);
    $this->pager->setPage($request->getParameter('page'));
    $this->pager->init();

    return $this->pager->getResults();
  }

  /**
   * @param array $originalEvents
   *
   * @return array
   */
  private function prepareEventsForView($originalEvents, $is_archive = true)
  {
    $events = array();

    foreach ($originalEvents as $event) {

      if($is_archive && $event->own_schedule == 1 && $event->date_end >= date("Y-m-d") && $this->type != 41 && $this->type != 42){
        continue;
      }
      if ($event->own_schedule) {
        $events[] = array(
          $event,
          date('Y-m-d', strtotime($event->date_start))
        );
      }
      else {
        $period = $this->getEventPeriod($event);

        if ($period) {
          foreach ($period as $day) {
            if ('--' != $event->{'schedule_'.strtolower($day->format('l'))}) {
              $dayEvent = clone $event;
              $dayEvent->date_start = $day->format('Y-m-d');
              $dayEvent->date_end   = null;

              $events[] = array(
                $dayEvent,
                $day->format('Y-m-d')
              );
            }
          }
        }
        else { //Если мы так и не смогли определить границы для периодического события, то просто выводим его
          $events[] = array(
            $event,
            date('Y-m-d', strtotime($event->date_start))
          );
        }
      }
    }

    usort($events, function($event1, $event2) {
      if ($event1[1] < $event2[1]) {
        return -1;
      }
      else {
        if ($event1[1] > $event2[1]) return 1;
        else return 0;
      }
    });

    if ($is_archive) {
      //DESC
      $events = array_reverse($events);
    }

    $events = array_map(function($data) {
      return $data[0];
    }, $events);

    return $events;
  }

  /**
   * @param Event $event
   *
   * @return DatePeriod|null
   */
  private function getEventPeriod($event)
  {
    $dateStart = null;
    $dateEnd = null;

    if ($event->date_start) {
      if ($this->from && ($this->fromDateTime->format('Y-m-d') > $event->date_start)) {
        $dateStart = $this->fromDateTime->format('Y-m-d');
      }
      else {
        $dateStart = $event->date_start;
      }
    }

    if ($event->date_end) {
      if ($this->to && ($this->toDateTime->format('Y-m-d') < $event->date_end)) {
        $dateEnd = $this->toDateTime->format('Y-m-d');
      }
      else {
        $dateEnd = $event->date_end;
      }

      $dateEnd = new DateTime($dateEnd);
      $dateEnd = $dateEnd->modify('+1 day');
    }

    $period = null;
    if ($dateStart && $dateEnd) {
      $period = new DatePeriod(
        new DateTime($dateStart),
        new DateInterval('P1D'),
        $dateEnd
      );
    }

    return $period;
  }
}

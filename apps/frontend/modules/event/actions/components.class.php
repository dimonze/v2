<?php

/**
 * event components.
 *
 * @package    garage
 * @subpackage event
 * @author     Garin Studio <eugeniy.b@garin-studio.ru>
 */
class eventComponents extends sfActions
{
  public function executeSlider(sfWebRequest $request)
  {
    $this->culture = $this->getUser()->getCulture();

    $this->events = Doctrine::getTable('Event')
      ->createQueryI18N()
      ->andWhere('on_banner = ?', true)
      ->andWhere('published_at IS NOT NULL')
      ->orderBy('date_start, date_end')
      ->execute();
    $this->books = Doctrine::getTable('Book')
      ->createQueryI18N()
      ->andWhere('on_banner = ?', true)
      ->execute();

    foreach ($this->events as $i => $event) {
      if (!$event->isBannerImageStored('ru') && !$event->isBannerImageStored('en')) {
        $this->events->remove($i);
      }
    }
    foreach ($this->books as $i => $book) {
      if (!$book->isBannerImageStored('ru') && !$book->isBannerImageStored('en')) {
        $this->books->remove($i);
      }
    }

    $this->baners = array();
    $this->_count = 0;

    foreach($this->events as $event) {
      $this->baners[$this->_count] =  array('events', $event);
      $this->_count++;
    }
    foreach($this->books as $book) {
      $this->baners[$this->_count] = array('books', $book);
      $this->_count++;
    }
  }
}

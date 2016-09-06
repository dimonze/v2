<?php

/**
 * Book filter form.
 *
 * @package    garage
 * @subpackage filter
 * @author     Garin Studio <dimonze@garin-studio.ru>
 * @version    SVN: $Id$
 */
class BookFormFilter extends BaseBookFormFilter
{
  public function configure()
  {
    $this->setWidget('book_name', new sfWidgetFormFilterInput(array('with_empty' => false)));
    $this->setValidator('book_name', new sfValidatorPass(array('required' => false)));
    $this->setWidget('author', new sfWidgetFormFilterInput(array('with_empty' => false)));
    $this->setValidator('author', new sfValidatorPass(array('required' => false)));
    $this->setWidget('publishing_house', new sfWidgetFormFilterInput(array('with_empty' => false)));
    $this->setValidator('publishing_house', new sfValidatorPass(array('required' => false)));   
  }
  
  protected function addBookNameColumnQuery($q, $element, $value)
  {
    if (!empty($value['text'])) {
      $q->andWhere('t.book_name LIKE ?', '%'.str_replace(' ', '%', $value['text']).'%');
    }
  }
  
  protected function addAuthorColumnQuery($q, $element, $value)
  {
    if (!empty($value['text'])) {
      $q->andWhere('t.author LIKE ?', '%'.str_replace(' ', '%', $value['text']).'%');
    }
  }
  
  protected function addPublishingHouseColumnQuery($q, $element, $value)
  {
    if (!empty($value['text'])) {
      $q->andWhere('t.publishing_house LIKE ?', '%'.str_replace(' ', '%', $value['text']).'%');
    }
  }
}

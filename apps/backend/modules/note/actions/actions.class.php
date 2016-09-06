<?php

require_once dirname(__FILE__) . '/../lib/noteGeneratorConfiguration.class.php';
require_once dirname(__FILE__) . '/../lib/noteGeneratorHelper.class.php';

/**
 * note actions.
 *
 * @package    garage
 * @subpackage note
 * @author     Garin Studio <eugeniy.b@garin-studio.ru>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class noteActions extends autoNoteActions 
{
    
  public function executePromote() 
  {
    $object = Doctrine::getTable('Note')->findOneById($this->getRequestParameter('id'));

    $object->promote();
    $this->redirect("@note");
  }

  public function executeDemote()
  {
    $object = Doctrine::getTable('Note')->findOneById($this->getRequestParameter('id'));

    $object->demote();
    $this->redirect("@note");
  }
  
  public function executeMoveToPosition()
  {
    $object = Doctrine::getTable('Note')->findOneById($this->getRequestParameter('id'));

    $object->moveToPosition($this->getRequestParameter('pos')+1);
    $this->redirect("@note");
  }
  public function executeGetEvents()
  {     
    $this->events = Doctrine::getTable('Event')->createQuery('e')
            ->innerJoin('e.Translation t with t.title <> "" and t.lang = ?', 'ru')
            ->andWhere('t.title LIKE ?', $this->getRequestParameter('term').'%')
            ->execute();    
    
    $this->books = Doctrine::getTable('Book')->createQuery('b')
            ->innerJoin('b.Translation t with t.book_name <> "" and t.lang = ?', 'ru')
            ->andWhere('t.book_name LIKE ?', $this->getRequestParameter('term').'%')
            ->execute();
    
    
    return $this->renderPartial('GetEvents', array(
          'events'   => $this->events,
          'books'   => $this->books,
    ));
  }

}
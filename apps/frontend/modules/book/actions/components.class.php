<?php

/**
 * book components.
 *
 * @package    garage
 * @subpackage book
 * @author     Garin Studio
 */
class bookComponents extends sfActions
{
  public function executeAuthors()
  {
    $this->author_list = Doctrine::getTable('Book')->getAuthors();
  }

  public function executePublishers()
  {
    $this->publisher_list = Doctrine::getTable('Book')->getPublisher();
  }
}
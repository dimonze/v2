<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of moveBooksTask
 *
 * @author Garin-Studio
 */
class moveBooksTask extends sfBaseTask 
{
  private $conn;


  protected function configure()
  {
    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'frontend'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
    ));    
    
    $this->addArgument('tables', sfCommandArgument::OPTIONAL | sfCommandArgument::IS_ARRAY, 'tables to dump. eg: {event,page,user}');
    $this->namespace        = '';
    $this->name             = 'moveBooks';
    $this->briefDescription = '';
    $this->detailedDescription = '';
  }
  
  protected function execute($arguments = array(), $options = array())
  {
    $databaseManager = new sfDatabaseManager($this->configuration);
    sfContext::createInstance(sfProjectConfiguration::getApplicationConfiguration('frontend', 'prod', true));
    $this->conn = $databaseManager->getDatabase($options['connection'])->getConnection();
    $this->moveBooks();
  }
  
  private function moveBooks()
  {  
    $events = Doctrine::getTable('Event')->createQuery('e')
      ->innerJoin('e.Translation t')
      ->andWhere('e.type = 24')
      ->execute();
      
    $book_storage_preview = new FileStorage(array(
      'level'       => 2,
      'prefix'      => 'book_preview',
    ));//сторадж для Book.class
    $book_storage_baner_en = new FileStorage(array(
      'level'       => 2,
      'prefix'      => 'book_banner_en',
    ));//сторадж для Book.class
    $book_storage_baner_ru = new FileStorage(array(
      'level'       => 2,
      'prefix'      => 'book_banner_ru',
    ));//сторадж для Book.class
    $book_image_storage = new FileStorage(array(
      'level'       => 2,
      'prefix'      => 'book_image',
    ));//сторадж для BookImage.class
      
    foreach ($events as $e) {
      $book = new Book();
      $book->id = $e->id;
      $book->Translation['ru']->book_name =  $e->Translation['ru']->title; 
      $book->Translation['ru']->description = $e->Translation['ru']->description;
      $book->Translation['en']->book_name =  $e->Translation['en']->title;      
      $book->Translation['en']->description = $e->Translation['en']->description;
      $book->Translation['ru']->lang = $e->Translation['ru']->lang;
      $book->Translation['en']->lang = $e->Translation['en']->lang;
      $book->save();
      
      $book_storage_preview->store(sfConfig::get('sf_web_dir').$e->getPreviewImage(), $book->id, false);
      $book_storage_baner_en->store(sfConfig::get('sf_web_dir').$e->getBannerImageEn(), $book->id, false);
      $book_storage_baner_ru->store(sfConfig::get('sf_web_dir').$e->getBannerImageRu(), $book->id, false);
      
      foreach ($e->Images  as $i) {
       $book_image = new BookImage(); 
       $book_image->Book = $book;
       $book_image->save();//сохраняем чтобы знать id БукИмаджа
       
       $book_image_storage->store($i->getFile(), $book_image->id, false);
      }
      $e->delete();
    }
  }
}

?>

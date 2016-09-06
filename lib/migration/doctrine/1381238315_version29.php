<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version29 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createTable('book', array(
             'id' => 
             array(
              'type' => 'integer',
              'unsigned' => '1',
              'primary' => '1',
              'autoincrement' => '1',
              'length' => '4',
             ),
             'on_banner' => 
             array(
              'type' => 'boolean',
              'notnull' => '1',
              'default' => '0',
              'length' => '25',
             ),
             'text_on_banner' => 
             array(
              'type' => 'boolean',
              'notnull' => '1',
              'default' => '1',
              'length' => '25',
             ),
             'gallery_id' => 
             array(
              'type' => 'integer',
              'unsigned' => '1',
              'length' => '4',
             ),
             'on_homepage' => 
             array(
              'type' => 'boolean',
              'default' => '0',
              'notnull' => '1',
              'length' => '25',
             ),
             ), array(
             'type' => 'InnoDB',
             'primary' => 
             array(
              0 => 'id',
             ),
             'collate' => 'utf8_general_ci',
             'charset' => 'utf8',
             ));  
		$this->createForeignKey('book', 'book_gallery_id_gallery_id', array(
             'name' => 'book_gallery_id_gallery_id',
             'local' => 'gallery_id',
             'foreign' => 'id',
             'foreignTable' => 'gallery',
             'onUpdate' => '',
             'onDelete' => 'set null',
             ));	
		$this->addIndex('book', 'book_gallery_id', array(
             'fields' => 
             array(
              0 => 'gallery_id',
             ),
             ));
    }

    public function down()
    {
        $this->dropTable('book');   
		$this->dropForeignKey('book', 'book_gallery_id_gallery_id');
		$this->removeIndex('book', 'book_gallery_id', array(
             'fields' => 
             array(
              0 => 'gallery_id',
             ),
             ));
    }
}
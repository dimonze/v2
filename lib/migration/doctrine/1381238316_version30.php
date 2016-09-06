<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version30 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createTable('book_image', array(
             'id' => 
             array(
              'type' => 'integer',
              'unsigned' => '1',
              'primary' => '1',
              'autoincrement' => '1',
              'length' => '4',
             ),
             'book_id' => 
             array(
              'type' => 'integer',
              'unsigned' => '1',
              'notnull' => '1',
              'length' => '4',
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
		$this->createForeignKey('book_image', 'book_image_book_id_book_id', array(
             'name' => 'book_image_book_id_book_id',
             'local' => 'book_id',
             'foreign' => 'id',
             'foreignTable' => 'book',
             'onUpdate' => '',
             'onDelete' => 'cascade',
             ));
		$this->addIndex('book_image', 'book_image_book_id', array(
             'fields' => 
             array(
              0 => 'book_id',
             ),
             ));
    }

    public function down()
    {        
        $this->dropTable('book_image');
		$this->dropForeignKey('book_image', 'book_image_book_id_book_id');
		$this->removeIndex('book_image', 'book_image_book_id', array(
             'fields' => 
             array(
              0 => 'book_id',
             ),
             ));
    }
}
<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version6 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createForeignKey('event', 'event_gallery_id_gallery_id', array(
             'name' => 'event_gallery_id_gallery_id',
             'local' => 'gallery_id',
             'foreign' => 'id',
             'foreignTable' => 'gallery',
             'onUpdate' => '',
             'onDelete' => 'set null',
             ));
        $this->createForeignKey('gallery_image', 'gallery_image_gallery_id_gallery_id', array(
             'name' => 'gallery_image_gallery_id_gallery_id',
             'local' => 'gallery_id',
             'foreign' => 'id',
             'foreignTable' => 'gallery',
             'onUpdate' => '',
             'onDelete' => 'cascade',
             ));
        $this->createForeignKey('news', 'news_gallery_id_gallery_id', array(
             'name' => 'news_gallery_id_gallery_id',
             'local' => 'gallery_id',
             'foreign' => 'id',
             'foreignTable' => 'gallery',
             'onUpdate' => '',
             'onDelete' => 'set null',
             ));
        $this->createForeignKey('gallery_translation', 'gallery_translation_id_gallery_id', array(
             'name' => 'gallery_translation_id_gallery_id',
             'local' => 'id',
             'foreign' => 'id',
             'foreignTable' => 'gallery',
             'onUpdate' => 'CASCADE',
             'onDelete' => 'CASCADE',
             ));
        $this->createForeignKey('gallery_image_translation', 'gallery_image_translation_id_gallery_image_id', array(
             'name' => 'gallery_image_translation_id_gallery_image_id',
             'local' => 'id',
             'foreign' => 'id',
             'foreignTable' => 'gallery_image',
             'onUpdate' => 'CASCADE',
             'onDelete' => 'CASCADE',
             ));
        $this->addIndex('event', 'event_gallery_id', array(
             'fields' => 
             array(
              0 => 'gallery_id',
             ),
             ));
        $this->addIndex('gallery_image', 'gallery_image_gallery_id', array(
             'fields' => 
             array(
              0 => 'gallery_id',
             ),
             ));
        $this->addIndex('news', 'news_gallery_id', array(
             'fields' => 
             array(
              0 => 'gallery_id',
             ),
             ));
        $this->addIndex('gallery_translation', 'gallery_translation_id', array(
             'fields' => 
             array(
              0 => 'id',
             ),
             ));
        $this->addIndex('gallery_image_translation', 'gallery_image_translation_id', array(
             'fields' => 
             array(
              0 => 'id',
             ),
             ));
    }

    public function down()
    {
        $this->dropForeignKey('event', 'event_gallery_id_gallery_id');
        $this->dropForeignKey('gallery_image', 'gallery_image_gallery_id_gallery_id');
        $this->dropForeignKey('news', 'news_gallery_id_gallery_id');
        $this->dropForeignKey('gallery_translation', 'gallery_translation_id_gallery_id');
        $this->dropForeignKey('gallery_image_translation', 'gallery_image_translation_id_gallery_image_id');
        $this->removeIndex('event', 'event_gallery_id', array(
             'fields' => 
             array(
              0 => 'gallery_id',
             ),
             ));
        $this->removeIndex('gallery_image', 'gallery_image_gallery_id', array(
             'fields' => 
             array(
              0 => 'gallery_id',
             ),
             ));
        $this->removeIndex('news', 'news_gallery_id', array(
             'fields' => 
             array(
              0 => 'gallery_id',
             ),
             ));
        $this->removeIndex('gallery_translation', 'gallery_translation_id', array(
             'fields' => 
             array(
              0 => 'id',
             ),
             ));
        $this->removeIndex('gallery_image_translation', 'gallery_image_translation_id', array(
             'fields' => 
             array(
              0 => 'id',
             ),
             ));
    }
}
<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version7 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('gallery_image_translation', 'title', 'string', '255', array(
             ));
        $this->addColumn('gallery_image_translation', 'description', 'string', '', array(
             ));
    }

    public function down()
    {
        $this->removeColumn('gallery_image_translation', 'title');
        $this->removeColumn('gallery_image_translation', 'description');
    }
}
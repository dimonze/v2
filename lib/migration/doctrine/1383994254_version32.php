<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version32 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('gallery_translation', 'author', 'string', '255', array(
             ));
    }

    public function down()
    {
        $this->removeColumn('gallery_translation', 'author');
    }
}
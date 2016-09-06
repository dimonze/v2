<?php

/**
 * @author Alexey Shockov <alexey@shockov.com>
 */
class Version25 extends Doctrine_Migration_Base
{
  public function up()
  {
    $this->addColumn('event', 'own_schedule', 'boolean', 25, array(
      'notnull' => true,
      'default' => '0',
    ));
    $this->addColumn('event', 'schedule_monday', 'string', 255, array(
      'notnull' => true,
      'default' => '--',
     ));
    $this->addColumn('event', 'schedule_tuesday', 'string', 255, array(
      'notnull' => true,
      'default' => '--',
     ));
    $this->addColumn('event', 'schedule_wednesday', 'string', 255, array(
      'notnull' => true,
      'default' => '--',
     ));
    $this->addColumn('event', 'schedule_thursday', 'string', 255, array(
      'notnull' => true,
      'default' => '--',
     ));
    $this->addColumn('event', 'schedule_friday', 'string', 255, array(
      'notnull' => true,
      'default' => '--',
     ));
    $this->addColumn('event', 'schedule_saturday', 'string', 255, array(
      'notnull' => true,
      'default' => '--',
     ));
    $this->addColumn('event', 'schedule_sunday', 'string', 255, array(
      'notnull' => true,
      'default' => '--',
     ));
  }

  public function postUp()
  {
    Doctrine_Manager::connection()->query('UPDATE Event SET own_schedule = true');
  }

  public function down()
  {
    $this->removeColumn('event', 'own_schedule');
    $this->removeColumn('event', 'schedule_monday');
    $this->removeColumn('event', 'schedule_tuesday');
    $this->removeColumn('event', 'schedule_wednesday');
    $this->removeColumn('event', 'schedule_thursday');
    $this->removeColumn('event', 'schedule_friday');
    $this->removeColumn('event', 'schedule_saturday');
    $this->removeColumn('event', 'schedule_sunday');
  }
}

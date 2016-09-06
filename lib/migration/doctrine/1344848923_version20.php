<?php

class Version20 extends Doctrine_Migration_Base
{
  public function up()
  {
    $this->addColumn('event_translation', 'price', 'string', 255);
  }

  public function postUp()
  {
    $conn = Doctrine_Manager::connection();
    $stmt_select = $conn->execute('SELECT `id`, `price` FROM `event` WHERE `price` IS NOT NULL');
    $stmt_update = $conn->prepare('UPDATE `event_translation` SET `price` = ? WHERE `id` = ?');

    foreach ($stmt_select->fetchAll(PDO::FETCH_ASSOC) as $item) {
      $stmt_update->execute(array($item['price'], $item['id']));
    }
  }

  public function down()
  {
    $this->removeColumn('event_translation', 'price');
  }
}
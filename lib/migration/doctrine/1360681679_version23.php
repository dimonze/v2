<?php

class Version23 extends Doctrine_Migration_Base
{
  public function up()
  {
    $this->addColumn('event_translation', 'html_code', 'clob', 1024);
  }

  public function postUp()
  {
    $data = array(
      200 =>
        '<p>Купить билеты на курс по воскресеньям</p>
        <rb:session key="a47b60b8-dbca-4d42-84a1-ca13676e77be" sessionID="4853633" xmlns:rb="http://kassa.rambler.ru"></rb:session>
        <p>Купить билет на курс по средам</p>
        <rb:session key="bea2adab-bc68-45f1-9a2b-f674c3347fb6" sessionID="4853635" xmlns:rb="http://kassa.rambler.ru"></rb:session>
        <script type="text/javascript" src="http://s2.kassa.rl0.ru/widget/js/ticketmanager.js"></script>',

      201 =>
        '<rb:session key="075bd549-d6e8-499c-b8d8-4d1e2224f974" sessionID="4804225" xmlns:rb="http://kassa.rambler.ru"></rb:session>
        <script type="text/javascript" src="http://s2.kassa.rl0.ru/widget/js/ticketmanager.js"></script>',

      202 =>
        '<rb:session key="e7f42967-0d5c-46b8-9af0-bee6316ce4a8" sessionID="4804217" xmlns:rb="http://kassa.rambler.ru"></rb:session>
        <script type="text/javascript" src="http://s2.kassa.rl0.ru/widget/js/ticketmanager.js"></script>',

      203 =>
          '<rb:session key="27760bf0-159c-423a-8ee8-b07059a27331" sessionID="4804222" xmlns:rb="http://kassa.rambler.ru"></rb:session>
          <script type="text/javascript" src="http://s2.kassa.rl0.ru/widget/js/ticketmanager.js"></script>',
    );

    $conn = Doctrine_Manager::connection();
    $stmt_update = $conn->prepare('UPDATE `event_translation` SET `html_code` = ? WHERE `id` = ?');
    foreach ($data as $id => $html_code) {
      $stmt_update->execute(array($html_code, $id));
    }
  }

  public function down()
  {
    $this->removeColumn('event_translation', 'html_code');
  }
}
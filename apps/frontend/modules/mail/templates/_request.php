От: <?= $data['fio'] ?> <<?= $data['email'] ?>><?= PHP_EOL.PHP_EOL ?>
Адрес: <?= html_entity_decode($data['address'], ENT_QUOTES).PHP_EOL ?>
Телефон: <?= $data['phone'].PHP_EOL ?>
Профессия: <?= html_entity_decode($data['profession'], ENT_QUOTES).PHP_EOL ?>
Организация: <?= html_entity_decode($data['company'], ENT_QUOTES).PHP_EOL ?>
Тема исследования: <?= html_entity_decode($data['theme'], ENT_QUOTES).PHP_EOL ?>
Цель исследования: <?= html_entity_decode($data['aim'], ENT_QUOTES) ?>
<?php use_stylesheet('today')?>
<header class="section-header">
  <h1 class="section-header__h1">Сейчас в Гараже / <time datetime="<?= date('Y-m-d')?>"><?= format_date(date('Y-m-d'), 'F MMMM')?></time></h1>
</header>
<div class="releases group">
  <?php foreach ($events as $event): ?>
    <?= render_event_for_today($event) ?>
  <?php endforeach ?>
</div>
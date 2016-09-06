<?php use_stylesheet('today')?>
<div class="wrapper wrapper-simple">
  <section class="section section-simple" class="margin-top: -20px;">
    <header class="section-header section-header-simple">
      <h1 class="section-header__h1">Сейчас в Гараже / <time datetime="<?= date('Y-m-d')?>"><?= format_date(date('Y-m-d'), 'F MMMM')?></time></h1>
    </header>
    <div class="releases group">
      <?php foreach ($events as $event): ?>
        <?= render_event_for_today($event) ?>
      <?php endforeach ?>
    </div>
  </section>
</div>
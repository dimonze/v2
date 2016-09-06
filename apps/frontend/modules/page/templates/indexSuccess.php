<?php include_component('event', 'slider') ?>

<section class="row-fluid mainPageEvents">

  <div class="span4">
    <h2 class="col__h2"><?= __('VISIT') ?></h2>

    <?php include_component('element', 'contacts') ?>  

    <?php include_component('element', 'hoursAndTickets') ?>
    
    <?php include_component('element', 'about') ?>
    
    <?php include_component('video', 'video') ?>
    
    <?php include_component('news', 'slider') ?>
  </div>

  <div class="span4">

    <h2 class="col__h2"><?= __('ON VIEW') ?></h2>

    <ul class="eventsList">
      <li><?= isset($events[0]) ? render_event2($events[0]) : '' ?></li>
      <li><?= isset($events[1]) ? render_event1($events[1]) : '' ?></li>

      <li><?= isset($events[2]) ? render_event2($events[2]) : '' ?></li>
      <li><?= isset($events[3]) ? render_event2($events[3]) : '' ?></li>

      <li><?= isset($events[4]) ? render_event2($events[4]) : '' ?></li>    

    </ul> 
    <div class="more-box more-box">
      <?= link_to(__('ALL EVENTS'), 'event/category?atype=' . Event::TYPE_EDUCATION) ?>
    </div>
  </div>

  <div class="span4">

    <h2 class="col__h2"><?= __('GARAGE RECOMMENDS') ?></h2> 
    <ul class="eventsList">     
      <?php foreach ($recommended as $event):?>
        <?php if ($note[$_counter]->event_type == 'event'): ?>     
          <?php if ($_counter == '2'): ?>     
          <li><?= isset($event) ?  render_event1($event) : '' ?></li>
          <?php else: ?>      
          <li><?= isset($event) ?  render_event2($event) : '' ?></li>
          <?php endif; ?>
        <?php else: ?>      
          <?php if ($_counter == '2'): ?>     
            <li><?= isset($event) ?  render_book1($event) : '' ?></li>
            <?php else: ?>      
            <li><?= isset($event) ? render_book2($event) : '' ?></li>
            <?php endif; ?>
        <?php endif; ?>
      <?php $_counter++; ?>
      <?php endforeach; ?>

    </ul> 
  </div>
</section>


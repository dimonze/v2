<?php if (count($news)): ?>  
  <div class="ni__box">
    <h2 class="col__h2"><?= __('News') ?></h2>
    
      <?php foreach ($news as $item): ?>
      <div class="ni">
        <div class="ni__date"><?= format_date($item->date) ?></div>
        <h3 class="ni__h"><?= link_to($item->title, 'news_show', $item) ?></h3>
        <div class="ni__text"><?= $item->short ?></div>
      </div> 
      <?php endforeach ?>
    
    <div class="more-box more-box_news">      
      <?= link_to(__('MORE NEWS'), 'news/index', 'class=uppercase') ?>       
    </div>
  </div>  
  <?php endif ?>
<div class="clearfix">
<ul class="menu titleMenu">
  <li>
    <h1>
      <?= __('News') ?>
    </h1>
  </li>
</ul>
</div>

<?php $items = $pager->getResults() ?>

<?php if (isset($items[0])): $item = $items[0] ?>
  <ul class="unstyled allNewsList mainNews">
    <li class="row-fluid">
      <div class="span6">
        <a class="imgEvent" href="<?= url_for('news_show', $item) ?>">
          <?= image_tag_mtime($item->preview_image_medium) ?>
          <div class="triangle triangle-right"></div>
        </a>
      </div>
      <div class="span6">
        <div class="evntTxtWrp">
          <time class="uppercase fs12"><?= format_date($item->date) ?></time>
          <h3><?= link_to($item->title, 'news_show', $item) ?></h3>
          <p>
            <?= $item->short ?>
            <?= link_to('&gt;', 'news_show', $item) ?>
          </p>
        </div>
      </div>
    </li>
  </ul>
<?php endif ?>

<ul class="allNewsList unstyled">
  <?php for ($i = 1; $i <= count($items) - 1; $i++): $item = $items[$i] ?>
    <li class="row-fluid">
      <div class="span3">
        <a href="<?= url_for('news_show', $item) ?>">
          <?= image_tag_mtime($item->preview_image_thumb) ?>
        </a>
      </div>
      <div class="span9">
        <time><?= format_date($item->date) ?></time>
        <h4><?= link_to($item->title, 'news_show', $item) ?></h4>
        <p>
          <?= $item->short ?>
          <?= link_to('&gt;', 'news_show', $item) ?>
        </p>
      </div>
    </li>
  <?php endfor ?>
</ul>

<?php include_partial('global/pager', array('pager' => $pager)) ?>
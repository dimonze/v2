<h3 class="marginNo" style="text-transform: uppercase">
  <?= isset($atype) ? __(Event::$titles[$atype]['title']) : ''; ?>
</h3>

<ul class="menu">
  <li>
    <h1>
      <?php if ('past' == $sf_params->get('date')): ?>
        <?= __('Past') ?>
      <?php elseif ('now' == $sf_params->get('date')): ?>
        <?= __('Current') ?>
      <?php elseif (isset($type)): ?>
        <?=  __(Event::$titles[$atype]['items'][$type]) ?>
      <?php endif ?>
    </h1>
  </li>

  <li>
    <span class="ico icoCall"></span>
    <?php if (!$from && !$to): ?>
      <a href="javascript:void(0)" class="selectDate"><?= __('Select date') ?></a>
    <?php endif ?>
  </li>
  
  <li class="selectDateHolder <?= $from || $to ? '' : 'hidden' ?>" id="selectDateHolder">
    <?php
      $url = 'event/category?';
      if ($sf_params->has('atype') || Event::TYPE_EXHIBITION == $type) {
        $url .= 'atype=' . $atype;
      }
      elseif ($sf_params->has('type')) {
        $url .= 'type=' . $type;
      }
    ?>   
      
    <form action="<?= url_for($url) ?>" method="get">
      <div class="dblInp" id="selectDate">
        <?= __('from') ?>
        <input type="text" id="from" autocomplete="off" name="from" value="<?= $from ?>" />
        <?= __('to') ?>
        <input type="text" id="to" autocomplete="off" name="to" value="<?= $to ?>" />
      </div>
      <span class="hidden">
          <a class="btn" href="#"><?= __('Select') ?></a>
      </span>
      <input type="hidden" id="book_category" value="book" />
    </form>
  </li>
</ul>
<?php include_partial('global/pagertop', array('pager' => $pager)) ?>
<div style="clear:both"></div>
<section class="row-fluid mainPageEvents">
  <?php for ($i = 0; $i <= count($events) - 1; $i += 4): ?>

    <div class="eventsRow">
      <?php for ($j = 0; $j < 3; $j++): ?>
        <?php if (isset($events[$i + $j])): ?>
          <div class="span4">
            <ul class="eventsList ">
              <li>
                <?= render_event1($events[$i + $j]) ?>
              </li>
            </ul>
          </div>
        <?php endif ?>
      <?php endfor ?>
    </div>

    <?php if (isset($events[$i + 3])): ?>
      <ul class="eventsList ">
        <li>
          <?= render_event4($events[$i + 3]) ?>
        </li>
      </ul>
    <?php endif ?>

  <?php endfor ?>
</section>
<?php include_partial('global/pager', array('pager' => $pager)) ?>
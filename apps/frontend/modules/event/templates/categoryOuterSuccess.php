<h3 class="marginNo" style="text-transform: uppercase">
  <?= isset($atype) ? __(Event::$titles[$atype]['title']) : ''; ?>
</h3>
<div class="clearfix">
<ul class="menu">
  <li>
    <h1>
      <?php if ('archive' == $sf_params->get('date')): ?>
        <?= __('Archive') ?>
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
    </form>
  </li>
</ul>
</div>

<div class="worldMapWrp">
  <div class="leftFade"></div>
  <div class="rightFade"></div>
  <div id="worldMap">

    <div id="worldMapInner">
      <img src="/images/world_map.jpg" alt=""/>

      <?php foreach ($events as $event): if (!($coords = event_coords($event))) continue ?>
        <div class="markerItem" style="<?= $coords ?>">
          <div class="hidden">
            <div class="evntTxtWrp">
              <?= event_type($event) ?>
              <h4><?= link_to($event->title, 'event_show', $event) ?></h4>
              <time class="uppercase"><?= event_dates($event) ?></time>
            </div>
          </div>
          <a class="marker" href="javascript:void(0)"><?= $event->city ?></a>
        </div>
      <?php endforeach ?>
    </div>
  </div>
</div>

<?php include_partial('global/share') ?>

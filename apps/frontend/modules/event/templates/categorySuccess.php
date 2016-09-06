<?php if ($sf_user->getCulture() != 'en') use_javascript('jquery.ui.datepicker-ru.js') ?>

<h3 class="marginNo" style="text-transform: uppercase">
  <?= isset($atype) ? __(Event::$titles[$atype]['title']) : ''; ?>
</h3>

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
    <?php if($type != 41 && $type != 42): ?>
    <span class="ico icoCall"></span>
    <?php endif; ?>
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
      
    <form action="<?= url_for($url) ?>" method="get" id="date_filter">
      <?php if($type != 41 && $type != 42): ?>
      <div class="dblInp" id="selectDate">
        <?= __('from') ?>
        <input type="text" id="from" autocomplete="off" name="from" value="<?= $from ?>" />
        <?= __('to') ?>
        <input type="text" id="to" autocomplete="off" name="to" value="<?= $to ?>" />
        <input type="hidden" id="date" name="date" value="<?= (isset($date) ? $date : ''); ?>" />
      </div>         
      <?php endif; ?>
        <?php if ('archive' == $date): ?>
        <script type="text/javascript">
          $(document).ready(function() {
            $('#eventTypeSelector').change(function() {
              $('#selectDateHolder .hidden').fadeIn();
              /*
              if (0 == $(this).val()) {
                window.location.href = '<?= url_for('event/category?atype='.$atype.'&date=archive') ?>';
              } else {
                window.location.href = '<?= url_for('event/category?atype='.$atype.'&type=TYPE_ID&date=archive') ?>'.replace('TYPE_ID', $(this).val());
              }
              */
            });
          });
        </script>
        
        <select name="type" id="eventTypeSelector">
          <option value="0"<?= (isset($type) ? '' : ' selected="selected"') ?>>Все</option>
          <?php foreach(Event::$titles[$atype]['items'] as $type_id => $type_name): ?>
            <?php if ($type_id === Event::TYPE_EDUCATION_BOOKS) continue; ?>
            <option
              <?= ((isset($type) && $type == $type_id) ? ' selected="selected"' : '') ?>
              value="<?= $type_id ?>"><?= __($type_name) ?></option>
          <?php endforeach ?>
        </select>
        <?php endif ?>        
        <span class="hidden">
            <a class="btn" href="#"><?= __('Select') ?></a>
        </span>
    </form>
  </li>
</ul>
<?php include_partial('global/pagertop', array('pager' => $pager)) ?>
<div style="clear:both"></div>
<section class="row-fluid mainPageEvents">
  <?php for ($i = 0; $i <= count($events) - 1; $i += 4): ?>

  <?php if($type != 41 && $type != 42): ?>
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
  <?php else: ?>
    <ul class="eventsList archiveItemList">
    <?php for ($i = 0; $i <= count($events) - 1; $i++): ?>
      <?php
        $c = '';
        if (($i+1) % 2 == 0) $c = "archiveItemSecond";
        if (($i+1) % 4 == 0) $c = "archiveItemForth archiveItemSecond";
      ?>
      <li class="archiveItem <?= $c ?>">
        <?= render_event1_red($events[$i]) ?>
      </li>
    <?php endfor ?>
  </ul>
  <?php endif; ?>
  
    <?php if (isset($events[$i + 3])): ?>
      <ul class="eventsList ">
        <li>
          <?= render_event4_red($events[$i + 3]) ?>
        </li>
      </ul>
    <?php endif ?>

  <?php endfor ?>
</section>
<?php include_partial('global/pager', array('pager' => $pager)) ?>

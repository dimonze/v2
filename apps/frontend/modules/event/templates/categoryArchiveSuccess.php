<?php if ($sf_user->getCulture() != 'en') use_javascript('jquery.ui.datepicker-ru.js') ?>

<h3 class="marginNo" style="text-transform: uppercase">
  <?= isset($atype) ? __(Event::$titles[$atype]['title']) : ''; ?>
</h3>

<ul class="menu">
  <li>
    <h1>
      <?php if ('archive' == $sf_params->get('date')): ?>
        <?= __('Past') ?>
      <?php elseif (isset($type)): ?>
        <?=  __(Event::$titles[$atype]['items'][$type]) ?>
      <?php endif ?>
    </h1>
  </li>

  <li class="selectDateHolder archiveSelectDateBox <?= $from || $to ? '' : 'hidden' ?>" id="selectDateHolder">
    <?php
      $url = 'event/category?';
      if ($sf_params->has('atype') || Event::TYPE_EXHIBITION == $type) {
        $url .= 'atype=' . $atype;
      }
      elseif ($sf_params->has('type')) {
        $url .= 'type=' . $type;
      }
      $_resFrom = preg_split("/[\s,.]+/", $from, 3); 
      $_resTo = preg_split("/[\s,.]+/", $to, 3);
      $_differences = $_resTo[1] - $_resFrom[1];
    ?>
  
    <form action="<?= url_for($url) ?>" method="get" id="date_filter">
        <?php if ('archive' == $sf_params->get('date')): ?>
          <select class="archiveSelectYear" type="hidden" id="year" autocomplete="off" name="" value="">
            <?php for($i = 0; $i < (date('Y') - 2008)+1; $i++):?>
              <?= $year = date("Y") ?>
              <?php if(!$from):?>
                <option value="<?= $year - $i ?>">
                  <?= $year - $i ?>
                </option>
              <?php else: ?>
                <?php
                  $res = preg_split("/[\s,.]+/", $from, 3);
                ?>
                <?php if($res[2] == $year - $i):?>
                  <option value="<?= $year - $i ?>" SELECTED>
                    <?= $year - $i ?>
                  </option>
                <?php else: ?>
                  <option value="<?= $year - $i ?>">
                    <?= $year - $i ?>
                  </option>
                <?php endif ?>
              <?php endif ?>
            <?php endfor ?>
          </select>
          <select class="archiveSelectMonth" type="hidden" id="month" autocomplete="off" name="" value="">
            <?php for($i = 0; $i < 12; $i++):?>
              <?php if ($_differences > 1): ?>
                <?php if ($i == 0) : ?>
                  <option value="-1">
                      <?= __('All') ?>
                  </option>
                <?php endif ?>
                <?php if ($i + 1 == date("m")): ?>
                  <option value="<?= $i + 1 ?>">
                    <?= $months[$i] ?>
                  </option>
                <?php else: ?>
                  <option value="<?= $i + 1 ?>">
                    <?= $months[$i] ?>
                  </option>
                <?php endif ?>
              <?php else: ?>
                <?php
                $res = preg_split("/[\s,.]+/", $from, 3);
                ?>
                <?php if ($res[1] == $i + 1): ?>
                  <?php if ($i == 0) : ?>
                   <option value="-1">
                      <?= __('All') ?>
                   </option>
                  <?php endif ?>
                  <option value="<?= $i + 1 ?>" SELECTED>
                    <?= $months[$i] ?>
                  </option>
                <?php else: ?>
                  <?php if ($i == 0) : ?>
                    <option value="-1">
                      <?= __('All') ?>
                    </option>
                  <?php endif ?>
                  <option value="<?= $i + 1 ?>">
                    <?= $months[$i] ?>
                  </option>
                <?php endif ?>
              <?php endif ?>                   
            <?php endfor ?>
            </select>
          <input type="hidden" id="from" autocomplete="off" name="from" value="<?= $from ?>" />
          <input type="hidden" id="to" autocomplete="off" name="to" value="<?= $to ?>" />
        <?php else: ?>
          <?= __('from') ?>
          <input type="text" id="from" autocomplete="off" name="from" value="<?= $from ?>" />
          <?= __('to') ?>
          <input type="text" id="to" autocomplete="off" name="to" value="<?= $to ?>" />
        <?php endif ?>
        <input type="hidden" id="date" name="date" value="<?= (isset($date) ? $date : ''); ?>" />
        <?php if ('archive' == $date): ?>
        <script type="text/javascript">
          var _global_date = <?= time() ?>;
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

        <select class="archiveSelectType" name="type" id="eventTypeSelector">
          <option value="0"<?= (isset($type) ? '' : ' selected="selected"') ?>><?= __('All') ?></option>
          <?php foreach(Event::$titles[$atype]['items'] as $type_id => $type_name): ?>
            <?php if ($type_id === Event::TYPE_EDUCATION_BOOKS) continue; ?>
            <option
              <?= ((isset($type) && $type == $type_id) ? ' selected="selected"' : '') ?>
              value="<?= $type_id ?>"><?= __($type_name) ?></option>
          <?php endforeach ?>
        </select>
        <?php endif ?>
        <?php if ('archive' == $sf_params->get('date')): ?>
          <span class="nothidden archiveSelectDateBtnBox">
            <a class="btn archiveSelectDateBtn" href="#"><?= __('Select') ?></a>
          </span>
        <?php endif ?>
        <script>
        $('.nothidden .btn').click(function(){         
           var year = document.getElementById("year").value - 0;
           var month = document.getElementById("month").value - 0; 
           var day;
           var date;          
           var d = new Date();
           if (month === -1){             
             date = '01' + '.' + '01' + '.' + year;            
           }
           else{
             date = '01' + '.' + month + '.' + year;
           }
           document.getElementById("from").value = date;
           
           if (month < 12 && month !== -1){
             month = month + 1;
             date = '00' + '.' + month + '.' + year;
           }else if ( month === -1 && year !== d.getFullYear()){
             month = 12;
             day = 31;
             date = day + '.' + month + '.' + year;
           }else if ( month === -1 && year === d.getFullYear()){
             month = d.getMonth() + 1;
             day = d.getDate() - 1;
             date = day + '.' + month + '.' + year;
           }else{
             month = 1;
             year = year + 1; 
             date = '00' + '.' + month + '.' + year;
           }
           if (year === d.getFullYear() && month - 1 === (d.getMonth() + 1))
             {
               day = d.getDate() - 1;
               month = d.getMonth() + 1;
               date = day + '.' + month + '.' + year;
             }
             
           document.getElementById("to").value = date;
        });      
      </script>
    </form>
  </li>
</ul>
<?php include_partial('global/pagertop', array('pager' => $pager)) ?>
<div style="clear:both"></div>
<section class="row-fluid mainPageEvents">
  <ul class="eventsList archiveItemList">
    <?php for ($i = 0; $i <= count($events) - 1; $i++): ?>
      <?php
        $c = '';
        if (($i+1) % 2 == 0) $c = "archiveItemSecond";
        if (($i+1) % 4 == 0) $c = "archiveItemForth archiveItemSecond";
      ?>
      <li class="archiveItem <?= $c ?>">
        <?= render_event1($events[$i]) ?>
      </li>
    <?php endfor ?>
  </ul>
</section>
<?php include_partial('global/pager', array('pager' => $pager)) ?>

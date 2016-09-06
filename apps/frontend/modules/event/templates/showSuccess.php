<div class="row-fluid">
  <div class="span10">
    <h3 class="marginNo"><?= __('GARAGE MUSEUM OF CONTEMPORARY ART PRESENTS') ?></h3>
    <h1><?= $event->title ?></h1>
    <time class="fs18"><?= event_dates($event) ?></time>

    <?php if (count($event->Images)): ?>
      <div class="sliderWide eventItemGallery">
        <a class="arr arrL" href="javascript:void(0)"></a>
        <a class="arr arrR" href="javascript:void(0)"></a>
        <div class="sliderWideWrp">
          <div class="sliderListWrp">
            <ul class="sliderList menu">
              <?php foreach ($event->Images as $image): ?>
                <li><?= image_tag_mtime($image->medium, false) ?></li>
              <?php endforeach ?>
            </ul>
          </div>
        </div>
      </div>
      <?php if (!empty($event->Gallery->id)): ?>
        <p class="overflowH paddindTop">
          <?=
            link_to(
              __('Gallery') . ' <span class="ico icoPhoto"></span>',
              '@gallery_show?id=' . $event->Gallery->id,
              array('class' => 'flangeBtn fr')
            )
          ?>
        </p>
      <?php endif ?>
    <?php endif ?>
    <section class="marginNo">
      <div class="textZone">
        <?= $event->getRaw('description') ?>
      </div>

      <?php if ($event->special && $sf_user->is_member): ?>
        <div class="textZone"><?= $event->getRaw('special') ?></div>
      <?php endif ?>

      <?php if ($event->additional): ?>
        <div class="markBlock row-fluid">
          <div class="span2">
            <?php if ($image = $event->additional_image): ?>
              <?= image_tag_mtime($image) ?>
            <?php endif ?>
          </div>
          <div class="span10">
            <div class="row-fluid">
              <?= $event->getRaw('additional') ?>
            </div>
          </div>
        </div>
      <?php endif ?>

      <?php include_partial('global/share') ?>
    </section>
  </div>

  <div class="span2">
    <ul class="sidebarItems">
      <li>
        <h5 class="uppercase"><?= __('Date') ?></h5>
        <?= event_dates($event) ?>
      </li>

      <?php if (($html_code = $event->getHtmlCode(ESC_RAW)) || $event->price): ?>
        <li>
          <?php if ($html_code): ?>
            <h5 class="uppercase buy__botMrgn"><?= __('Buy online') ?></h5>
          <?php else: ?>
            <h5 class="uppercase"><?= __('Admission fee') ?></h5>
          <?php endif ?>

          <?php if ($event->price): ?>
            <p><?= $event->price ?></p>
          <?php endif ?>

          <?php if ($html_code): ?>
            <?= $html_code ?>
            <script type="text/javascript">
              $(document).ready(function(){
                var matched = location.search.match(/(?:\?|\&)button\=(\d+)/);
                if (matched && typeof matched[1] != 'undefined') {
                  var $rb = $('rb\\:schedule').eq(parseInt(matched[1]-1));
                  if ($rb.length) {
                    ticketManager.placeSchedule($rb.attr('key'), $rb.attr('objectid'), $rb.attr('filter').replace(/\'/g, '"'));
                  }
                }
              });
            </script>
          <!--?php else: ?>
            <p>
              <span class="ico icoMobile"></span>
              <a href="#" class="openPopUp linkWiolet" rel="reserve">< ?= __('Buy tickets') ?></a>
            </p-->
          <?php endif ?>

        </li>
      <?php endif ?>

      <?php if ($event->place_address || $event->place_phone || $event->place_open_hours): ?>
        <li>
          <?php if ($event->place_address): ?>
            <h5 class="uppercase"><?= __('Venue') ?></h5>
            <?= $event->getRaw('place_address') ?>
          <?php endif ?>

          <?php if ($event->place_phone): ?>
            <h5 class="uppercase"><?= __('Phone') ?></h5>
            <p><?= $event->getRaw('place_phone') ?></p>
          <?php endif ?>

          <?php if ($event->place_open_hours): ?>
            <h5 class="uppercase"><?= __('Hours') ?></h5>
            <p><?= $event->getRaw('place_open_hours') ?></p>
            <p>
              <em>
                <?= __('Opening hours are subject to change due to special events.') ?>
              </em>
            </p>
          <?php endif ?>
        </li>
      <?php endif ?>

      <li>
        <h5 class="uppercase"><?= __('Schedule') ?></h5>
        <?php if ($event->own_schedule): ?>
          <div><?= __('According to the Garage schedule') ?></div>
        <?php else: ?>
          <?php foreach (array('monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday') as $day): ?>
            <div><?= __(ucfirst($day)) ?>: <?= $event->{'schedule_'.$day} ?></div>
          <?php endforeach ?>
        <?php endif ?>
      </li>

      <li>
        <h4><?= __('on view') ?></h4>
        <ul class="eventsList">
          <?php foreach ($events as $_event): ?>
            <li>
              <?= render_event3($_event) ?>
            </li>
          <?php endforeach ?>
        </ul>
      </li>
    </ul>
  </div>
</div>

<?php include_component('feedback', 'reserve', array('event' => $event)) ?>

<?php slot('widgetmeta') ?>
  <meta content="website" property="og:type" />
  <meta content="<?= url_for('event_show', $event, true) ?>" property="og:url" />
  <meta content="<?= $event->title ?>" property="og:title" />
  <meta content="<?= $event->short_description ?>" property="og:description" />
  <meta content="http://<?= $sf_request->getHost() ?><?= $event->preview2 ?>" property="og:image" />
<?php end_slot() ?>

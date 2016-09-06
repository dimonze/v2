<section class="eventGallery slider sliderCircle timed">
  <a class="arr arrL" href="javascript:void(0)"></a>
  <a class="arr arrR" href="javascript:void(0)"></a>
  <div class="pagination">
    <ul>
      <?php for ($i=1, $c=$_count; $i<=$c; $i++): ?>
        <li><?= $i ?></li>
      <?php endfor ?>
    </ul>
  </div>
  <ul class="center sliderList">
    <?php $i=0; foreach ($baners as $baner): ?>
      <li data-item="<?= ++$i ?>">        
        <?php if($baner[0] == 'events'): ?>
        <?= link_to(' ', 'event_show', $baner[1], 'class=linkToEvnt') ?>
        <?php else: ?>
        <?= link_to(' ', 'book_show', $baner[1], 'class=linkToEvnt') ?>
       <?php endif ?> 
        <?php if ($baner[1]->isBannerImageStored($culture)) $image_src = $baner[1]->getBannerImage($culture);
        else $image_src = $baner[1]->getBannerImage($culture == 'ru' ? 'en' : 'ru') ?>
        <?= image_tag_mtime($image_src) ?>
        <?php if ($baner[1]->text_on_banner): ?>
          <div class="eventGalleryText white">
            <div class="eventGalleryTextBox">
              <?php if ($baner[0] == 'events'): ?>
              <div class="fs66 uppercase"><?= $baner[1]->title ?></div>
              <div class="fs28 uppercase"><?= event_dates($baner[1]) ?></div>
              <?php else: ?>
              <div class="fs66 uppercase"><?= $baner[1]->book_name ?></div>
              <div class="fs28 uppercase"><?= $baner[1]->publication_date ?></div>
              <?php endif ?>
            </div>
            <div class="textValign"></div>
          </div>
        <?php endif ?>
      </li>
    <?php endforeach ?>
  </ul>
</section>
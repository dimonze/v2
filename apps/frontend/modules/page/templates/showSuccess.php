<div class="<?= !in_array($page->id, array(11,26,5,34)) ? 'textZone' : '' ?>">
  <?php if ($h1 = $page->h1): ?><h1 class="marginNo"><small><?= $h1 ?></small></h1><?php endif ?>
</div>

<?php if (count($page->Images)): ?>
<div class="row-fluid">
  <div class="sliderWide eventItemGallery">
    <a class="arr arrL" href="javascript:void(0)"></a>
    <a class="arr arrR" href="javascript:void(0)"></a>
    <div class="sliderWideWrp">
      <div class="sliderListWrp">
        <ul class="sliderList menu">
          <?php foreach ($page->Images as $image): ?>
            <li><?= image_tag_mtime($image->medium, false) ?></li>
          <?php endforeach ?>
        </ul>
      </div>
    </div>
  </div>
</div>
<?php endif ?>

<section class="<?= !in_array($page->id, array(11,26,5,34)) ? 'textZone' : '' ?>">
  <?= $page->getBody(ESC_RAW) ?>
</section>
<?php set_metas($page) ?>
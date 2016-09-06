<h3 class="marginNo"><?= __('Galleries') ?></h3>

<?php $data = $pager->getResults()->getData()->getRawValue() ?>
<?php while ($rs = array_splice($data, 0, 3)):  ?>
  <section class="row-fluid mainPageEvents galleryList">
    <?php foreach ($rs as $gallery): ?>
      <div class="span4">
        <ul class="eventsList ">
          <li>
            <div class="row-fluid <?= gallery_class($gallery) ?>">
              <div class="evntTxtWrp">
                <?= gallery_type($gallery) ?>
                <h4><?= link_to($gallery->title, 'gallery_show', $gallery) ?></h4>
                <time class="uppercase"><?= format_date($gallery->date) ?></time>
              </div>
              <a class="imgEvent" href="<?= url_for('gallery_show', $gallery) ?>">
                <?= image_tag_mtime($gallery->preview_thumb) ?>
                <div class="triangle triangle-down"></div>
              </a>
            </div>
          </li>
        </ul>
      </div>
    <?php endforeach ?>
  </section>
<?php endwhile ?>

<?php include_partial('global/pager', array('pager' => $pager)) ?>
<?php if (count($banners)): ?>
  <section class="newsBlockImage borderTopLight">
    <div class="row-fluid">
      <?php for ($i=0, $c=count($banners); $i<$c && $i<4; $i++): ?>
        <div class="span3">
          <?= $banners[$i]->getRaw('code') ?>
          <h4><?= $banners[$i]['title'] ?></h4>
          <?php if ($banners[$i]['text']): ?>
            <p>
              <?php if ($banners[$i]['link']): ?><a href="<?= $banners[$i]['link'] ?>"><?= $banners[$i]['text'] ?></a>
              <?php else: ?><?= $banners[$i]['text'] ?><?php endif ?>
            </p>
          <?php endif ?>
        </div>
      <?php endfor ?>
    </div>
  </section>
<?php endif ?>
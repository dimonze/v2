<h3 class="marginNo" style="text-transform:uppercase"><?= __('education') ?></h3>
<?php $_data = $pager->getResults()->getData()->getRawValue() ?>
<ul class="menu">
  <li>
    <h1><?= __('Books') ?></h1>
  </li>
  <li id="selectDateHolder" class="selectDateHolder archiveSelectDateBox ">
    <?php $lists = $_data ?>
    <form id="common_filter" method="get" action="">
      <?= include_component('book', 'authors') ?>
      <?= include_component('book', 'publishers') ?>
      <span class="btn submitBtn">Выбрать</span>
    </form>
  </li>
</ul>
<?php include_partial('global/pagertop', array('pager' => $pager)) ?>
<div style="clear:both"></div>

<?php $data = $pager->getResults()->getData()->getRawValue() ?>
<?php while ($books = array_splice($data, 0, 3)): ?>
  <section class="row-fluid mainPageEvents galleryList">
    <?php foreach ($books as $book): ?>
      <div class="span4">
        <ul class="eventsList ">
          <li>
            <div class="row-fluid blueBox">
              <div class="evntTxtWrp evntTxtWrp_books">
                <h6><?= __('Books') ?></h6>
                <h4><?= link_to($book->book_name, 'book_show', $book) ?></h4>
                <?php if ($book->publishing_house): ?><h5><?= $book->publishing_house ?></h5><?php endif ?>
              </div>
              <a class="imgEvent" href="<?= url_for('book_show', $book) ?>">
                <?= image_tag_mtime($book->preview_thumb) ?>
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
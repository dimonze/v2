<div class="row-fluid">
  <div class="span10">
    <h3 class="marginNo"><?= __('GARAGE MUSEUM OF CONTEMPORARY ART PRESENTS') ?></h3>
    <h1><?= $book->author ? $book->author.' ' : '' ?><?= $book->book_name ?></h1>
    <?php if ($book->publishing_house): ?>
      <h4 class="book__publisher-h4"><?= $book->publishing_house ?></h4>
    <?php endif ?>

    <?php if (count($book->Images)): ?>
      <div class="sliderWide eventItemGallery">
        <a class="arr arrL" href="javascript:void(0)"></a>
        <a class="arr arrR" href="javascript:void(0)"></a>
        <div class="sliderWideWrp">
          <div class="sliderListWrp">
            <ul class="sliderList menu">
              <?php foreach ($book->Images as $image): ?>
                <li><?= image_tag_mtime($image->medium, false) ?></li>
              <?php endforeach ?>
            </ul>
          </div>
        </div>
      </div>

    <?php if (!empty($book->Gallery->id)): ?>
        <p class="overflowH paddindTop">
          <?=
            link_to(
              __('Gallery') . ' <span class="ico icoPhoto"></span>',
              '@gallery_show?id=' . $book->Gallery->id,
              array('class' => 'flangeBtn fr')
            )
          ?>
        </p>
      <?php endif ?>
    <?php endif ?>

    <section class="marginNo">
      <div class="book__description">
        <?= $book->getRaw('description') ?>
      </div>
      <div class="textZone">
        <?php if (($book->about_book) != ''): ?>
          <h5 class="text_header"><?= __('About the book') ?></h5>
          <?= $book->getRaw('about_book') ?>
        <?php endif?>

        <?php if (($book->about_author) != ''): ?>
          <h5 class="text_header"><?= __('About the author') ?></h5>
          <?= $book->getRaw('about_author') ?>
        <?php endif?>

        <?php if (($book->about_publishing) != ''): ?>
          <h5 class="text_header"><?= __('About the publisher') ?></h5>
          <?= $book->getRaw('about_publishing') ?> <br>
        <?php endif?>
      </div>
      <?php include_partial('global/share') ?>
    </section>
  </div>


  <div class="span2">
    <ul class="sidebarItems">

      <?php if (($book->publication_date) != ''): ?>
        <li>
          <h5 class="uppercase"><?= __('Publication date') ?></h5>
          <p><?= $book->getRaw('publication_date'); ?></p>
        </li>
      <?php endif ?>

      <?php if (($book->price) != ''): ?>
        <li>
          <h5 class="uppercase"><?= __('Price') ?></h5>
          <p class="book__price"><?= $book->price ?></p>
        </li>
      <?php endif ?>

      <li>
        <h5 class="uppercase"><?= __('Bookstore contacts') ?></h5>
        <p>e-mail: shop@garageccc.com</p>
        <p><?= __('tel') ?>.: +7 (495) 645-05-21</p>
        <p><?= __('Gorky Park, Pioneer pond, Moscow') ?></p>
      </li>
      <li>
        <h5 class="uppercase"><?= __('Bookstore working time') ?></h5>
        <p><?= __('Monday') ?> – <?= __('Thursday') ?>: <span class="nobr">11:00 – 21:00</span></p>
        <p><?= __('Friday') ?> - <?= __('Sunday') ?>: <span class="nobr">11:00 – 22:00</span></p>
      </li>

      <li>
        <h5 class="uppercase"><?= __('Other Books')?></h5>
        <ul class="eventsList ">
          <?php foreach($other_books as $oBook): ?>
            <li>
              <?= render_book3($oBook) ?>
            </li>
          <?php endforeach ?>
        </ul>
      </li>

    </ul>
  </div>
</div>

<?php slot('widgetmeta') ?>
<meta content="website" property="og:type" />
<meta content="<?= url_for('book_show', $book, true) ?>" property="og:url" />
<meta content="<?= $book->book_name ?>" property="og:title" />
<meta content="<?= $book->about_book ?>" property="og:description" />
<meta content="http://<?= $sf_request->getHost() ?><?= $book->preview2 ?>" property="og:image" />
<?php end_slot() ?>

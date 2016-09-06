<div class="row-fluid">
  <div class="span10">
    <h1><?= $news->title ?></h1>
    <time class="fs18"><?= format_date($news->date) ?></time>
    <?php if (!empty($news->Gallery->id)): ?>
      <p class="overflowH paddindTop">
        <?=
          link_to(
            __('Gallery') . ' <span class="ico icoPhoto"></span>',
            '@gallery_show?id=' . $news->Gallery->id,
            array('class' => 'flangeBtn fr')
          )
        ?>
      </p>
    <?php endif ?>
    <section class="textZone clear paddingNo">
      <?= $news->getRaw('full') ?>
    </section>

    <?php include_partial('global/share') ?>
  </div>

  <div class="span2">
    <?php include_component('news', 'latest') ?>
  </div>
</div>

<?php slot('widgetmeta') ?>
  <meta content="website" property="og:type" />
  <meta content="<?= url_for('news_show', $news, true) ?>" property="og:url" />
  <meta content="<?= $news->title ?>" property="og:title" />
  <meta content="<?= $news->short ?>" property="og:description" />
  <meta content="http://<?= $sf_request->getHost() ?><?= $news->preview_image_medium ?>" property="og:image" />
<?php end_slot() ?>

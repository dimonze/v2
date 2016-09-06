<ul class="menu titleMenu">
  <li>
      <h1><?= __('News') ?> Артгида</h1>
  </li>
</ul>
<div class="clearfix"></div>

<ul class="allNewsList unstyled">
  <?php foreach ($news as $item): $item = $item->getRawValue() ?>
    <li class="row-fluid">
      <div class="span-a">
        <a href="<?= $item['link'] ?>">
          <?= image_tag($item['image']) ?>
        </a>
      </div>
      <div class="span9">
        <time><?= format_date(strtotime($item['date'])) ?></time>
        <h4><a href="<?= $item['link'] ?>"><?= $item['title'] ?></a></h4>
        <p>
          <?= $item['anons'] ?>
          <a href="<?= $item['link'] ?>">&gt;</a>
        </p>
      </div>
    </li>
  <?php endforeach ?>
</ul>
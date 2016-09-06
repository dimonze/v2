<h4><?= link_to(__('News'), 'news/index') ?></h4>
<ul class="newsList unstyled">
  <?php foreach ($news as $item): ?>
    <li>
      <p><time class="uppercase"><?= format_date($item->date) ?></time></p>
      <h5><?= link_to($item->title, 'news_show', $item) ?></h5>
      <p>
        <?= $item->short ?>
        <?= link_to('&gt;', 'news_show', $item) ?>
      </p>
    </li>
  <?php endforeach ?>
</ul>
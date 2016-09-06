<ul class="menu linksBlack uppercase">
  <li><?= link_to(__('Exhibitions'), 'event/category?atype=' . Event::TYPE_EXHIBITION) ?> &frasl;</li>
  <li><?= link_to(__('Kids'), 'event/category?atype=' . Event::TYPE_CHILDREN) ?> &frasl;</li>
  <li><?= link_to(__('Education'), 'event/category?atype=' . Event::TYPE_EDUCATION) ?> &frasl;</li>

  <?php foreach ($pages as $page): ?>
    <li><?= link_to($page->title, 'page_show', $page) ?> &frasl;</li>
  <?php endforeach ?>
</ul>

<ul class="menu listMargR">
  <li><?= link_to(__('Contact us'), 'page_show', $footer_pages[Page::ADDRESS_PAGE])?></li>
  <li><a href="#" class="openPopUp" rel="feedback"><?= __('Feedback') ?></a></li>
  <li><?= link_to($footer_pages[Page::JOBS_PAGE]->title, 'page_show', $footer_pages[Page::JOBS_PAGE])?></li>
  <li><a href="mailto:welcome@garageccc.com">welcome@garageccc.com</a></li>
</ul>

<p>
  <a href="http://park-gorkogo.com/" target="_blank"><?= __('GORKY PARK') ?></a>
  <span class="grey developed">
    <?= __('%link% production', array(
      '%link%' => '<a href="http://www.garin-studio.ru/" onclick="window.open(this.href);return false;">Garin-Studio</a>'
    )) ?>
  </span>
</p>

<?php foreach (array('left' => 'fl', 'right' => 'fr') as $menu => $class): ?>
  <nav class="<?= $class ?>">
    <ul class="menu">
      <?php if ('fr' == $class): ?>
        <li class="no_active"><div class="menu hidden unstyled"></div></li>
      <?php endif ?>

      <?php foreach ($$menu as $group): ?>
        <li class="<?= $group['class'] ?>">
          <a href="<?= url_for(!empty($group['route']) ? $group->getRaw('route') : $group['items'][0]->getRaw('route')) ?>">
            <?php if ('left' == $menu): ?>
              <strong><?= $group['title'] ?></strong>
            <?php else: ?>
              <?= $group['title'] ?>
            <?php endif ?>
          </a>
          <?php if (!empty($group['items'])): ?>
            <ul class="hidden menu unstyled">
              <?php foreach ($group['items'] as $i => $item): ?>
                <li>
                  <?= link_to($item['title'], $item->getRaw('route'), 'class=' . $item['class']) ?>
                  <?= $i + 1 == count($group['items']) ? '' : '/' ?>
                </li>
              <?php endforeach ?>
              <li class="triangle triangle-up"></li>
            </ul>
          <?php endif ?>
        </li>
      <?php endforeach ?>
    </ul>
  </nav>
<?php endforeach ?>
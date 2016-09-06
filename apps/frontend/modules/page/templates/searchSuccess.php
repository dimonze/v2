<h1><small><?= __('Search results') ?></small></h1>
<h4 class="uppercase"><?= __('Found results') ?>: <?= $pager->getNbResults() ?>.</h4>

<form class="searchform bgGrayBox" action="<?= url_for('@search') ?>">
  <div class="row-fluid">
    <div class="span9 relative"><input type="text" name="query" id="searchInp" value="<?= $sf_params->get('query') ?>" /><a class="clearBtn" href="#"></a></div>
    <div class="span3"><input type="submit" value="<?= __('Find') ?>" /></div>
  </div>
  <ul class="menu">
    <?php foreach (Search::$types as $id => $name): ?>
      <li>
        <input type="checkbox" name="type[]" id="chk<?= $id ?>" value="<?= $id ?>"
               <?= in_array($id, $types->getRawValue()) ? 'checked="checked"' : '' ?> />
        <label for="chk<?= $id ?>"><?= $name ?></label>
      </li>
    <?php endforeach ?>
  </ul>
</form>

<?php if ($pager->getNbResults()): ?>
  <ul class="unstyled searchResult">
    <?php foreach ($pager->getResults() as $i => $result): $result = $result->getRawValue() ?>
      <?php if (!$result->record) continue; ?>
      <?php $url = get_record_url($result->record) ?>
      <?php $thumb = get_record_thumb($result->record) ?>

      <li class="row-fluid">
        <div class="span2">
          <strong class="resultN"><?= $pager->getOffset() + $i + 1 ?></strong>
          <?php if ($thumb): ?>
            <a class="imgResult" href="<?= $url ?>">
                <?= image_tag($thumb) ?>
                <div class="triangle triangle-right"></div>
            </a>
          <?php endif ?>
        </div>
        <div class="span10">
          <h4><?= link_to($result->title, $url) ?></h4>
          <p>
            <?= $result->contents ?><br>
            <?= link_to($sf_request->getHost() . $url, $url) ?>
          </p>
        </div>
      </li>
    <?php endforeach ?>
  </ul>

  <?php include_partial('global/pager', array(
    'pager' => $pager,
    'params' => array('query' => $sf_params->get('query'), 'type' => $sf_params->get('type'))
  )) ?>

<?php else: ?>
  <p><?= __('Nothing found') ?></p>
<?php endif ?>

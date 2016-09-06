<select name="publisher" id="publisher">
  <option value=""><?= __('Publishing') ?></option>
  <?php foreach ($publisher_list as $publishing): ?>
    <?php $_publishing = null ?>
    <?php if ($publishing['publishing_house'] == '') continue ?>

    <?php if (strlen($publishing['publishing_house']) > 20): ?>
      <?php $_publishing = (mb_substr($publishing['publishing_house'], 0, 20)) . '...'; ?>
    <?php endif ?>
    <?php if ($sf_params->get('publisher') == $publishing['publishing_house']): ?>
      <option value="<?= $publishing['publishing_house'] ?>" SELECTED>
        <?php if (isset($_publishing)): ?><?= $_publishing ?><?php else: ?><?= $publishing['publishing_house'] ?><?php endif ?>
      </option>
    <?php else: ?>
      <option value="<?= $publishing['publishing_house'] ?>">
        <?php if (isset($_publishing)): ?><?= $_publishing ?><?php else: ?><?= $publishing['publishing_house'] ?><?php endif ?>
      </option>
    <?php endif ?>
  <?php endforeach ?>
</select>
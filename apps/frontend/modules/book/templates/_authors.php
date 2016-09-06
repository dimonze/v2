<select name="author" id="author">
  <option value=""><?= __('Author') ?></option>
  <?php foreach ($author_list as $author): ?>
    <?php $_author = null ?>
    <?php if ($author['author'] == '') continue ?>

    <?php if (strlen($author['author']) > 20): ?>
      <?php $_author = (mb_substr($author['author'], 0, 20)) . '...'; ?>
    <?php endif ?>
    <?php if ($sf_params->get('author') == $author['author']): ?>
      <option value="<?= $author['author'] ?>" SELECTED>
        <?php if (isset($_author)): ?><?= $_author ?><?php else: ?><?= $author['author'] ?><?php endif ?>
      </option>
    <?php else: ?>
      <option value="<?= $author['author'] ?>">
        <?php if (isset($_author)): ?><?= $_author ?><?php else: ?><?= $author['author'] ?><?php endif ?>
      </option>
    <?php endif ?>
  <?php endforeach ?>
</select>
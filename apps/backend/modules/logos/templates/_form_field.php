<div class="<?= $class ?><?php $form[$name]->hasError() and print ' errors' ?>">
  <?php echo $form[$name]->renderError() ?>
  <div>
    <?php echo $form[$name]->renderLabel() ?>
    <?php echo $form[$name]->render() ?>

    <?php if ($help = $form[$name]->renderHelp()): ?>
      <div class="help"><?php echo __($help) ?></div>
    <?php endif ?>
  </div>
</div>

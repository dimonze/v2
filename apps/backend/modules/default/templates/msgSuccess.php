<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>

<div id="sf_admin_container">

  <h1>Системное сообщение</h1>
  <?php include_partial('default/flashes') ?>

  <div id="sf_admin_header"></div>

  <div id="sf_admin_content">

    <div class="sf_admin_form">
      <form action="<?= url_for('@default?module=default&action=msg') ?>" method="post" enctype="multipart/form-data">
        <?= $form->renderHiddenFields() ?>

        <fieldset id="sf_fieldset_none">
          <div class="sf_admin_form_row sf_admin_text sf_admin_form_field_text<?php $form['content_ru']->hasError() and print ' errors' ?>">
            <?php echo $form['content_ru']->renderError() ?>
            <div>
              <?php echo $form['content_ru']->renderLabel() ?>
              <div class="content"><?= $form['content_ru']->render() ?></div>

              <?php if ($help = $form['content_ru']->renderHelp()): ?>
                <div class="help"><?= $help ?></div>
              <?php endif ?>
            </div>
          </div>

          <div class="sf_admin_form_row sf_admin_text sf_admin_form_field_text<?php $form['content_en']->hasError() and print ' errors' ?>">
            <?php echo $form['content_en']->renderError() ?>
            <div>
              <?php echo $form['content_en']->renderLabel() ?>
              <div class="content"><?= $form['content_en']->render() ?></div>

              <?php if ($help = $form['content_en']->renderHelp()): ?>
                <div class="help"><?= $help ?></div>
              <?php endif ?>
            </div>
          </div>

          <div class="sf_admin_form_row sf_admin_text sf_admin_form_field_file<?php $form['enabled']->hasError() and print ' errors' ?>">
            <?php echo $form['enabled']->renderError() ?>
            <div>
              <?php echo $form['enabled']->renderLabel() ?>
              <div class="content"><?= $form['enabled']->render() ?></div>

              <?php if ($help = $form['enabled']->renderHelp()): ?>
                <div class="help"><?= $help ?></div>
              <?php endif ?>
            </div>
          </div>
        </fieldset>

        <ul class="sf_admin_actions">
          <li class="sf_admin_action_save"><input type="submit" value="Сохранить"></li>
        </ul>
      </form>
    </div>
  </div>

  <div id="sf_admin_footer"></div>
</div>
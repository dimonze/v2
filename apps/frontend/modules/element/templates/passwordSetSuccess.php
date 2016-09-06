<section class="textZone">
  <h1><small><?= __('Password recovery') ?></small></h1>
  <form class="greyForm" action="<?= url_for('element/passwordSet') ?>" method="post">
    <?= $form->renderHiddenFields()  ?>
    <input type="hidden" name="id" value="<?= $sf_params->get('id') ?>" />
    <input type="hidden" name="token" value="<?= $sf_params->get('token') ?>" />

    <?= $form['password']->renderError() ?>
    <?= $form['password']->render(array('placeholder' => __('Password'))) ?>
    <br/>

    <?= $form['password_again']->renderError() ?>
    <?= $form['password_again']->render(array('placeholder' => __('Password again'))) ?>
    <br/>

    <input type="submit" class="" value="<?= __('Set password') ?>" />
  </form>
</section>
<div>
  <h5 class="uppercase"><?= __('Newsletter subscription', '', 'feedback') ?></h5>
  <form class="greyForm feedbackForm" action="<?= url_for('feedback/subscribe') ?>" method="post">
    <div class="triangle-up"></div>
    <?= $form['email']->renderError() ?>
    <?= $form['email']->render(array('placeholder' => __('Email', '', 'feedback'))) ?>

    <div class="captcha">
      <?= $form['captcha']->renderError() ?>
      <?= $form['captcha']->render(array('placeholder' => __('Verification code', '', 'feedback'))) ?>
    </div>

    <input type="submit" class="submitMail" value="<?= __('Subscribe', '', 'feedback') ?>" />
  </form>
</div>
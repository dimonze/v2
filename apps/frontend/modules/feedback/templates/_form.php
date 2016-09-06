<div class="popUp" id="feedback">
  <a class="close" href="javascript:void(0)"><img src="/images/close.png" alt=""></a>
  <h1><small><?= __('Feedback', '', 'feedback') ?></small></h1>
  <p class="grey">
    <?= __('Please read FAQ before asking your questions', '', 'feedback') ?>.
  </p>
  <p class="grey">
    <span class="wiolet">*</span> – <?= __('required fields', '', 'feedback') ?>.
  </p>

  <form action="<?= url_for('feedback/create') ?>" method="post" class="ajax-send">
    <table>
      <tbody><tr>
          <td colspan="2"><label for="name"><?= __('Name', '', 'feedback') ?></label></td>
        </tr>
        <tr class="<?= $form['name']->hasError() ? 'error' : '' ?>">
          <td colspan="2">
            <?= $form['name'] ?>
          </td>
        </tr>
        <tr>
         <td colspan="2"><label for="mail"><?= __('Email', '', 'feedback') ?> <span class="wiolet">*</span></label></td>
        </tr>
        <tr class="<?= $form['email']->hasError() ? 'error' : '' ?>">
          <td>
            <?= $form['email'] ?>
          </td>
          <td>
          </td>
        </tr>
        <tr>
          <td colspan="2"><label for="text"><?= __('Message', '', 'feedback') ?>:</label></td>
        </tr>
        <tr class="<?= $form['message']->hasError() ? 'error' : '' ?>">
          <td colspan="2">
            <?= $form['message'] ?>
          </td>
        </tr>
        <tr class="<?= $form['kcaptcha']->hasError() ? 'error' : '' ?>">
          <td colspan="2" class="inlineInput">
            <p class="clearfix"><?= __('Enter verification code', '', 'feedback') ?>:</p>
            <?= $form['kcaptcha'] ?>
          </td>
        </tr>
        <tr class="lastRow">
          <td colspan="2"><input type="submit" value="<?= __('submit', '', 'feedback') ?>"></td>
        </tr>
      </tbody>
    </table>
  </form>
</div>
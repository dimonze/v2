<div>
  <h4 class="requestTitle"><?= __('The application for a job at the library and archives of Garage culture centre', null, 'request-form') ?>:</h4>
  <form class="requestForm" action="<?= url_for('feedback/request') ?>" method="post">
    <table class="formRequest">
      <?= $form->renderHiddenFields() ?>
      <?php foreach (array('fio','address','email','phone','profession','company','theme','aim') as $name): ?>
        <tr>
          <td><?= __($form[$name]->getWidget()->getLabel(), null, 'request-form') ?>:</td>
          <td><?= $form[$name]->render() ?></td>
        </tr>
      <?php endforeach ?>
      <tr>
        <td><?= __($form['captcha']->getWidget()->getLabel(), null, 'request-form') ?>:</td>
        <td><input type="text" name="<?php printf($form->getWidgetSchema()->getNameFormat(), 'captcha') ?>" id="request_captcha" class="input short_input" autocomplete="off"/></td>
      </tr>
      <tr>
        <td class="widthTd"></td>
        <td><?= $form['captcha']->render() ?></td>
      </tr>
    </table>
    <p><strong><?= __('For specialists working with modern art, students and aspirants of humanity universities.', null, 'request-form') ?></strong></p>
    <p><?= __('After receiving application, we will contact you within the next 7 days.', null, 'request-form') ?></p>
    <input type="submit" value="<?= __('Submit', null, 'request-form') ?>">
  </form>
</div>
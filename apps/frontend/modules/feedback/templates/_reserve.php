<div class="popUp" id="reserve">
  <a class="close" href="javascript:void(0)"><img src="/images/close.png" alt=""></a>
  <h1><small><?= __('Buy tickets', '', 'feedback') ?></small></h1>
  <p class="grey">
    <?= __('Purchase form', '', 'feedback') ?>:
  </p>

  <form action="<?= url_for('feedback/reserve') ?>" method="post" class="ajax-send">
    <table>
      <tbody>
        <tr>
          <td colspan="2"><label for="text"><?= __('Event title', '', 'feedback') ?>:</label></td>
        </tr>
        <tr class="<?= $form['event_id']->hasError() ? 'error' : '' ?>">
          <td colspan="2">
            <?= $form['event_id'] ?>
            <input placeholder="<?= $event->title ?>" disabled="disabled" />
          </td>
        </tr>

        <tr>
          <td colspan="2"><label for="text"><?= __('Name', '', 'feedback') ?>:</label></td>
        </tr>
        <tr class="<?= $form['name']->hasError() ? 'error' : '' ?>">
          <td colspan="2">
            <?= $form['name'] ?>
          </td>
        </tr>

        <tr>
         <td colspan="2"><label for="mail"><?= __('Date', '', 'feedback') ?>:</label></td>
        </tr>
        <tr class="<?= $form['date']->hasError() ? 'error' : '' ?>">
          <td colspan="2">
            <?= $form['date']->render(array('id' => 'datepicker_event_date')) ?><span class="ico icoCall"></span>
            <input type="hidden" name="minDate" class="minDate" value="<?= $event->date_start ?>" />
            <input type="hidden" name="maxDate" class="maxDate" value="<?= $event->date_end ?: $event->date_start ?>" />
            <input type="hidden" name="badDates" class="badDates" value="" />
          </td>
        </tr>

        <tr>
         <td colspan="2"><label for="mail"><?= __('Email', '', 'feedback') ?>:</label></td>
        </tr>
        <tr class="<?= $form['email']->hasError() ? 'error' : '' ?>">
          <td colspan="2">
            <?= $form['email'] ?>
          </td>
        </tr>

        <tr>
          <td colspan="2"><label for="text"><?= __('Phone', '', 'feedback') ?>:</label></td>
        </tr>
        <tr class="<?= $form['phone']->hasError() ? 'error' : '' ?>">
          <td colspan="2">
            <?= $form['phone'] ?>
          </td>
        </tr>

        <tr class="<?= $form['kcaptcha']->hasError() ? 'error' : '' ?>">
          <td colspan="2" class="inlineInput">
            <p class="clearfix"><?= __('Enter verification code', '', 'feedback') ?>:</p>
            <?= $form['kcaptcha'] ?>
          </td>
        </tr>
        <tr class="lastRow">
          <td colspan="2"><input type="submit" value="<?= __('Submit', '', 'feedback') ?>"></td>
        </tr>
      </tbody>
    </table>
  </form>
</div>
<table width="680" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse;background-color:#ffffff;">
  <?php if ($letter->is_image_stored): ?>
    <tr>
      <td colspan="3">
        <div style="width:680px;">
          <?= image_tag('http://'.($host = $sf_request->getHost()).$letter->image, array('alt' => '', 'border' => 0, 'width' => 680)) ?>
        </div>
      </td>
    </tr>
    <tr><td colspan="3"><div style="height:20px"><img src="http://<?= $host ?>/images/garage-mail/i/bl.gif" alt="" border="0" height="20" width="10"></div></td></tr>
  <?php endif ?>
  <tr><td colspan="3"><span style="font-family:Arial; font-size:14px; color:#000000; text-transform:uppercase; font-weight:bold"><?= $letter->subject ?></span></td></tr>
  <tr><td colspan="3"><div style="height:10px"><img src="http://<?= $host = $sf_request->getHost() ?>/images/garage-mail/i/bl.gif" alt="" border="0" height="10" width="10"></div></td></tr>
  <tr>
    <td colspan="3" style="line-height:1;">
      <div style="width:680px; line-height:1">
        <span style="font-family:Arial; font-size:13px; line-height:1.2; color:#2e2e2e;"><?= $letter->getRaw('body') ?></span>
      </div>
    </td>
  </tr>
  <tr><td colspan="3"><div style="height:20px"><img src="http://<?= $host ?>/images/garage-mail/i/bl.gif" alt="" border="0" height="40" width="10"></div></td></tr>
</table>
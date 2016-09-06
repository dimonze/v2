<?php $host = $sf_request->getHost() ?>
<table width="680" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse;background-color:#ffffff;">
  <tr>
    <td>
      <div style="width:680px;">
        <a href="<?= $link ?>" style="text-decoration:none;" target="_blank">
          <?= image_tag('http://'.$host.$letter->getEventImage($item->getRawValue(), 'wide'), array('alt' => $item->Translation[$letter->lang]->title, 'title' => $item->Translation[$letter->lang]->title, 'border' => 0, 'width' => 680)) ?>
        </a>
      </div>
    </td>
  </tr>
  <tr><td><div style="height:20px"><img src="http://<?= $host ?>/images/garage-mail/i/bl.gif" alt="" border="0" height="20" width="10"></div></td></tr>
  <tr>
    <td>
      <span style="color:#000000;">
        <a href="<?= $link ?>" style="font-family:Arial; font-size:14px; color:#000000; text-transform:uppercase; font-weight:bold; text-decoration:none;">
          <?= $item->Translation[$letter->lang]->title ?>
        </a>
      </span>
    </td>
  </tr>
  <tr><td><div style="height:10px"><img src="http://<?= $host ?>/images/garage-mail/i/bl.gif" alt="" border="0" height="10" width="10"></div></td></tr>
  <tr>
    <td style="line-height:1;">
      <span style="font-family:Arial; font-size:13px; line-height:1.2; color:#2e2e2e;"><?= $sf_data->getRaw('text') ?></span>
    </td>
  </tr>
  <tr><td><div style="height:20px"><img src="http://<?= $host ?>/images/garage-mail/i/bl.gif" alt="" border="0" height="20" width="10"></div></td></tr>
  <?php if ($button): ?>
    <tr>
      <td width="103" height="23">
        <div style="height:23px; width:103px">
          <?php include_partial('letter/letter-button', array(
            'id'      => $item->id,
            'lang'    => $letter->lang,
            'button'  => $button,
          )) ?>
        </div>
      </td>
    </tr>
  <?php endif ?>
  <?php if (!$is_last): ?>
    <tr style="border-bottom:1px solid #b4b4b4"><td colspan="3"><div style="height:20px"><img src="http://<?= $host ?>/images/garage-mail/i/bl.gif" alt="" border="0" height="20" width="10"></div></td></tr>
  <?php endif ?>
  <tr><td><div style="height:40px"><img src="http://<?= $host ?>/images/garage-mail/i/bl.gif" alt="" border="0" height="40" width="10"></div></td></tr>
</table>
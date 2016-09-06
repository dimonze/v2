<?php $host = $sf_request->getHost() ?>
<table width="680" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse;background-color:#ffffff;">
  <tr bgcolor="#f9f9f9">
    <td width="335" height="280">
      <div style="width:335px;">
        <a href="<?= $link ?>" style="text-decoration:none;" target="_blank">
          <?= image_tag('http://'.$host.$letter->getEventImage($item->getRawValue(), 'narrow'), array('alt' => $item->Translation[$letter->lang]->title, 'title' => $item->Translation[$letter->lang]->title, 'border' => 0, 'width' => 335, 'style' => 'display:block;')) ?>
        </a>
      </div>
    </td>
    <td width="20"><div style="width:20;"><img src="http://<?= $host ?>/images/garage-mail/i/bl.gif" alt="" border="0" width="20"></div></td>
    <td style="line-height:1;">
      <?php if (!empty($dates)): ?>
        <span style="font-family:Arial; font-size:12px; color:#545454;"><?= $dates ?></span>
        <br><br>
      <?php endif ?>
      <span style="color:#000000;">
        <a href="<?= $link ?>" style="font-family:Arial; font-size:14px; color:#000000; text-transform:uppercase; font-weight:bold; text-decoration:none;">
          <?= $item->Translation[$letter->lang]->title ?>
        </a>
      </span>
      <br><br>
      <span style="font-family:Arial; font-size:13px; line-height:1.2; color:#2e2e2e;"><?= $sf_data->getRaw('text') ?></span>
      <?php if ($button): ?>
        <table width="305" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse;background-color:#f9f9f9;">
          <tr><td><div style="height:15px"><img src="http://<?= $host ?>/images/garage-mail/i/bl.gif" alt="" border="0" height="15" width="10"></div></td></tr>
          <tr>
            <td width="305" height="23">
              <div style="height:23px; width:305px">
                <?php include_partial('letter/letter-button', array(
                  'id'      => $item->id,
                  'lang'    => $letter->lang,
                  'button'  => $button,
                )) ?>
              </div>
            </td>
          </tr>
        </table>
      <?php endif ?>
    </td>
    <td width="20"><div style="width:20;"><img src="http://<?= $host ?>/images/garage-mail/i/bl.gif" alt="" border="0" width="20"></div></td>
  </tr>
  <tr><td><div style="height:30px"><img src="http://<?= $host ?>/images/garage-mail/i/bl.gif" alt="" border="0" height="30" width="10"></div></td></tr>
</table>
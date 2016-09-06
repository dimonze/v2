<?php $host = $sf_request->getHost() ?>
<table width="680" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse;background-color:#ffffff;">
  <tr>
    <?php foreach ($items as $i => $item): ?>
      <td style="background-color:#f9f9f9;" width="335" valign="top">
        <table width="335" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
          <tr>
            <td>
              <div style="width:335px;">
                <a href="<?= $links[$i] ?>" style="text-decoration:none;" target="_blank">
                  <?= image_tag('http://'.$host.$letter->getEventImage($item->getRawValue(), 'narrow'), array('alt' => $item->Translation[$letter->lang]->title, 'title' => $item->Translation[$letter->lang]->title, 'border' => 0, 'width' => 335)) ?>
                </a>
              </div>
            </td>
          </tr>
          <tr><td><div style="height:10px"><img src="http://<?= $host ?>/images/garage-mail/i/bl.gif" alt="" border="0" height="10" width="10"></div></td></tr>
          <?php if (!empty($dates[$i])): ?>
            <tr><td><span style="font-family:Arial; font-size:12px; color:#545454;"><?= $dates[$i] ?></span></td></tr>
            <tr><td><div style="height:5px"><img src="http://<?= $host ?>/images/garage-mail/i/bl.gif" alt="" border="0" height="5" width="10"></div></td></tr>
          <?php endif ?>
          <tr>
            <td style="line-height:1;">
              <span style="color:#000000;">
                <a href="<?= $links[$i] ?>" style="font-family:Arial; font-size:14px; color:#000000; text-transform:uppercase; font-weight:bold; text-decoration:none;">
                  <?= $item->Translation[$letter->lang]->title ?>
                </a>
              </span>
              <?php if ($buttons[$i]): ?>
                <table width="335" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse;background-color:#f9f9f9;">
                  <tr><td><div style="height:15px"><img src="http://<?= $host ?>/images/garage-mail/i/bl.gif" alt="" border="0" height="15" width="10"></div></td></tr>
                  <tr>
                    <td width="335" height="23">
                      <div style="height:23px; width:335px">
                        <?php include_partial('letter/letter-button', array(
                          'id'      => $item->id,
                          'lang'    => $letter->lang,
                          'button'  => $buttons[$i],
                        )) ?>
                      </div>
                    </td>
                  </tr>
                </table>
              <?php endif ?>
            </td>
          </tr>
          <tr><td><div style="height:25px"><img src="http://<?= $host ?>/images/garage-mail/i/bl.gif" alt="" border="0" height="20" width="10"></div></td></tr>
        </table>
      </td>
      <?php if (!$i): ?>
        <td><div style="height:20px; width:10;"><img src="http://<?= $host ?>/images/garage-mail/i/bl.gif" alt="" border="0" height="20" width="10"></div></td>
      <?php endif ?>
    <?php endforeach ?>
  </tr>
  <tr><td><div style="height:30px"><img src="http://<?= $host ?>/images/garage-mail/i/bl.gif" alt="" border="0" height="30" width="10"></div></td></tr>
</table>
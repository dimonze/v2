<?php $caption = $lang != 'ru' ? 'Buy a tiket' : 'Купить билет' ?>
<a href="http://<?= $host = $sf_request->getHost() ?>/<?= $lang ?>/event/<?= $id ?>?button=<?= $button ?>" style="text-decoration:none;" target="_blank">
  <img border="0" src="http://<?= $host ?>/images/garage-mail/i/buy-btn-<?= $lang ?>.gif" alt="<?= $caption ?>" title="<?= $caption ?>" height="23" width="103">
</a>
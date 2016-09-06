<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
</head>
  <body style="background-color:#ffffff;">

    <?php if ($sf_params->get('action') == 'show') include_partial('letter/letter-actions', array('letter' => $letter)) ?>

    <table width="680" align="center" cellpadding="0" cellspacing="0" bgcolor="ffffff" style="border-collapse:collapse;">
      <tr>
        <td width="317" height="110">
          <div style="width:317px; height:110px">
            <a href="http://<?= $host = $sf_request->getHost() ?>/<?= $letter->lang ?>" style="text-decoration:none;" target="_blank">
              <img alt="Garage" title="Garage" src="http://<?= $host = $sf_request->getHost() ?>/images/garage-mail/i/logo.png" border="0" width="316" height="107">
            </a>
          </div>
        </td>
        <td width="363" height="110" align="right" valign="bottom">
          <span style="font-family:Arial; font-size:12px; color:#747474; text-decoration:none">
            <a style="font-family:Arial; font-size:12px; color:#747474!important; text-decoration:none" target="_blank" href="[WEBVERSION]">
              <?= $letter->lang != 'ru' ? 'View in web browser' : 'Посмотреть в браузере' ?>
            </a>
          </span>
        </td>
      </tr>
      <tr><td><div style="height:30px"><img src="http://<?= $host ?>/images/garage-mail/i/bl.gif" alt="" border="0" height="30" width="10"></div></td></tr>
    </table>

<?php
use_helper('I18N');
if ($letter->body) include_partial('letter/letter-body', array('letter' => $letter));

if (count($letter->events)) {
  foreach (array_keys($letter->events->getRawValue()) as $category) {
    if (count($events = $letter->getEventsByCategory($category))) {
      include_partial('letter/letter-events-head', array('title' => $category));

      $i = 0;
      $iterator = $events->getRawValue()->getIterator();
      while ($iterator->valid()) {
        $item = $iterator->current();
        $options = $letter->getEventOptions($item->id);

        if ($options['template'] == 4) {
          $i++;
          $items = array($item);
          $opts = array(
            'dates'   => array($options['dates']),
            'links'   => array($options['link']),
            'buttons' => array($options['button']),
          );

          $iterator->next();
          if ($iterator->valid()) {
            $item = $iterator->current();
            $options = $letter->getEventOptions($item->id);
            if ($options['template'] == 4) {
              $i++;
              $items[] = $item;

              $options = $letter->getEventOptions($item->id);
              $opts['dates'][]    = $options['dates'];
              $opts['links'][]    = $options['link'];
              $opts['buttons'][]  = $options['button'];
              $iterator->next();
            }
          }

          include_partial('letter/letter-event-4', array(
            'letter'  => $letter,
            'items'   => $items,
            'dates'   => $opts['dates'],
            'links'   => $opts['links'],
            'buttons' => $opts['buttons'],
          ));
        }
        else {
          include_partial('letter/letter-event-'.$options['template'], array(
            'letter'  => $letter,
            'item'    => $item,
            'text'    => $options['text'],
            'dates'   => $options['dates'],
            'link'    => $options['link'],
            'button'  => $options['button'],
            'is_last' => ++$i == $iterator->count(),
          ));

          $iterator->next();
        }
      }

    }
  }
}
?>

    <?php include_partial('letter/letter-footer-'.$letter->lang) ?>

  </body>
</html>
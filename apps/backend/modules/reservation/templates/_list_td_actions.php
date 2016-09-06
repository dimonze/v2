<td>
  <ul class="sf_admin_td_actions">
    <?php if (!$reservation->is_answered): ?>
      <li><?= link_to('Отвечено', 'reservation/answered?id=' . $reservation->id) ?></li>
    <?php else: ?>
      <li><img src="/sfDoctrinePlugin/images/tick.png" /></li>
    <?php endif ?>
  </ul>
</td>

<td>
  <ul class="sf_admin_td_actions">
    <?php if (!$feedback->is_answered): ?>
      <li><?= link_to('Отвечено', 'feedback/answered?id=' . $feedback->id) ?></li>
    <?php else: ?>
      <li><img src="/sfDoctrinePlugin/images/tick.png" /></li>
    <?php endif ?>
  </ul>
</td>

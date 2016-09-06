<td>
  <ul class="sf_admin_td_actions">
    <li class="sf_admin_action_promote">
      <?php echo link_to('Выше', '@default?module=banner&action=promote&key='.$banner['key'].'&culture='.$banner['culture']) ?>
    </li>
    <li class="sf_admin_action_demote">
      <?php echo link_to('Ниже', '@default?module=banner&action=demote&key='.$banner['key'].'&culture='.$banner['culture']) ?>
    </li>
    <li class="sf_admin_action_edit">
      <?php echo link_to('Редактировать', '@default?module=banner&action=edit&key='.$banner['key'].'&culture='.$banner['culture']) ?>
    </li>
    <li class="sf_admin_action_delete">
      <?php echo link_to('Удалить', '@default?module=banner&action=delete&key='.$banner['key'].'&culture='.$banner['culture']) ?>
    </li>
  </ul>
</td>

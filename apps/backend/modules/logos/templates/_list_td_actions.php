<td>
  <ul class="sf_admin_td_actions">
    <li class="sf_admin_action_promote">
      <?php echo link_to('Выше', '@default?module=logos&action=promote&key='.$logo['key'].'&culture='.$logo['culture']) ?>
    </li>
    <li class="sf_admin_action_demote">
      <?php echo link_to('Ниже', '@default?module=logos&action=demote&key='.$logo['key'].'&culture='.$logo['culture']) ?>
    </li>
    <li class="sf_admin_action_edit">
      <?php echo link_to('Редактировать', '@default?module=logos&action=edit&key='.$logo['key'].'&culture='.$logo['culture']) ?>
    </li>
    <li class="sf_admin_action_delete">
      <?php echo link_to('Удалить', '@default?module=logos&action=delete&key='.$logo['key'].'&culture='.$logo['culture']) ?>
    </li>
  </ul>
</td>

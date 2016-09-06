<ul class="sf_admin_actions">
  <?php if (!$form->isNew()): ?>
    <li class="sf_admin_action_delete">
      <?php echo link_to('Удалить', '@default?module=banner&action=delete&key='.$banner->key.'&culture='.$banner->culture) ?>
    </li>
  <?php endif ?>
  <li class="sf_admin_action_list">
    <?php echo link_to('Вернуться к списку', '@default?module=banner&action=index') ?>
  </li>
  <li class="sf_admin_action_save">
    <button class="sf_button ui-priority-primary ui-corner-all ui-state-default" type="submit">Сохранить</button>
  </li>
</ul>
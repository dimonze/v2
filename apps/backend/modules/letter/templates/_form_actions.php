<ul class="sf_admin_actions">
  <?= $helper->linkToDelete($form->getObject(), array('params' => array(), 'confirm' => 'Are you sure?', 'class_suffix' => 'delete', 'label' => 'Delete')) ?>
  <?= $helper->linkToList(array('params' => array(), 'class_suffix' => 'list', 'label' => 'Back to list')) ?>
  <?= $helper->linkToSave($form->getObject(), array('params' => array(), 'class_suffix' => 'save', 'label' => 'Save')) ?>
  <li class="sf_admin_action_preview"><input type="submit" name="_save_and_preview" value="Сохранить и посмотреть"></li>
  <li class="sf_admin_action_source"><input type="submit" name="_save_and_source" value="Сохранить и получить код для вставки"></li>
</ul>

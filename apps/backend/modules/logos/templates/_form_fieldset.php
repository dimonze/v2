<fieldset id="sf_fieldset_none">
  <?php foreach ($form->getWidgetSchema()->getFields() as $name => $field): ?>
    <?php if (!isset($form[$name]) || $field->getOption('type') == 'hidden') continue ?>
    <?php include_partial('logos/form_field', array(
      'name'  => $name,
      'form'  => $form,
      'class' => 'sf_admin_form_row sf_admin_text sf_admin_form_field_'.strtolower($name),
    )) ?>
  <?php endforeach ?>
</fieldset>
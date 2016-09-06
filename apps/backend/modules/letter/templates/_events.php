<?php foreach ($form['events'] as $index => $widget): ?>
  <?php include_partial('letter/events-widget', array(
    'widget'      => $widget,
    'form'        => $form,
    'index'       => $index,
    'attributes'  => $attributes,
  )) ?>
<?php endforeach ?>

<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_add_category">
  <a class="add" href="<?= url_for('@default?module=letter&action=addWidget') ?>"><img alt="добавить" src="/sfDoctrinePlugin/images/new.png">добавить категорию</a>
</div>
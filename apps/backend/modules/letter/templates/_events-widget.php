<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_category<?php $widget->hasError() and print ' errors' ?>">
  <?= $widget->renderError() ?>
  <div>
    <?= $widget->renderLabel() ?>
    <a class="remove" href="#"><img alt="удалить" src="/sfDoctrinePlugin/images/delete.png">удалить категорию</a>

    <div class="content"><?= $widget->render($attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes) ?></div>

    <?php if ($help = $widget->renderHelp()): ?>
      <div class="help"><?= $help ?></div>
    <?php endif ?>

    <table class="letter-events-list" id="<?= $form['events'][$index]->renderId() ?>">
      <tbody>
        <?php foreach ($form->getObject()->getEventsByCategory($widget->getWidget('category')->getDefault('category')) as $item): ?>
          <?php include_partial('letter/event-item', array(
            'form'    => $form,
            'item'    => $item,
            'lang'    => $form->getObject()->lang,
            'index'   => $index,
            'options' => $form->getObject()->getEventOptions($item->id),
          )) ?>
        <?php endforeach ?>
      </tbody>
    </table>

  </div>
</div>
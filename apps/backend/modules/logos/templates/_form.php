<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<div class="sf_admin_form">
  <form action="<?php echo url_for('@default?module=logos&action='.($form->isNew() ? 'new&culture='.$sf_params->get('culture') : 'edit&key='.$logo->key.'&culture='.$logo->culture)) ?>" method="post" enctype="multipart/form-data">
    <?php echo $form->renderHiddenFields(false) ?>

    <?php if ($form->hasGlobalErrors()): ?><?php echo $form->renderGlobalErrors() ?><?php endif ?>

    <?php include_partial('logos/form_fieldset', array('form' => $form)) ?>
    <?php include_partial('logos/form_actions', array('logo' => $logo, 'form' => $form)) ?>
  </form>
</div>

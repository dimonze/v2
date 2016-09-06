<?php use_helper('I18N') ?>
<?php include_partial('logos/assets') ?>

<div id="sf_admin_container">
  <h1>Добавление логотипа</h1>

  <?php include_partial('logos/flashes') ?>

  <div id="sf_admin_content">
    <?php include_partial('logos/form', array('logo' => $logo, 'form' => $form)) ?>
  </div>
</div>

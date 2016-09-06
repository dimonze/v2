<?php use_helper('I18N') ?>
<?php include_partial('logos/assets') ?>

<div id="sf_admin_container">
  <h1>Управление логотипами</h1>

  <?php include_partial('logos/flashes') ?>

  <div id="sf_admin_content">
    <?php include_partial('logos/list', array('items' => $logos)) ?>
    <ul class="sf_admin_actions">
      <li class="sf_admin_action_new"><?php echo link_to('Создать RU', '@default?module=logos&action=new&culture=ru') ?></li>
      <li class="sf_admin_action_new"><?php echo link_to('Создать EN', '@default?module=logos&action=new&culture=en') ?></li>
    </ul>
  </div>
</div>
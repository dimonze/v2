<?php use_helper('I18N') ?>
<?php include_partial('banner/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo __('Управление баннерами', array(), 'messages') ?></h1>

  <?php include_partial('banner/flashes') ?>

  <div id="sf_admin_content">
    <?php include_partial('banner/list', array('items' => $banners)) ?>
    <ul class="sf_admin_actions">
      <li class="sf_admin_action_new"><?php echo link_to('Создать RU', '@default?module=banner&action=new&culture=ru') ?></li>
      <li class="sf_admin_action_new"><?php echo link_to('Создать EN', '@default?module=banner&action=new&culture=en') ?></li>
    </ul>
  </div>
</div>
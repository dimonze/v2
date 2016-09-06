<?php use_helper('I18N') ?>
<?php include_partial('banner/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo __('Редактирование баннера "%%title%%"', array('%%title%%' => $banner->title), 'messages') ?></h1>

  <?php include_partial('banner/flashes') ?>

  <div id="sf_admin_content">
    <?php include_partial('banner/form', array('banner' => $banner, 'form' => $form)) ?>
  </div>
</div>

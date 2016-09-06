<div class="sf_admin_list">
  <table cellspacing="0">
    <thead>
      <tr>
        <?php include_partial('banner/list_th') ?>
        <th id="sf_admin_list_th_actions"><?php echo __('Actions', array(), 'sf_admin') ?></th>
      </tr>
    </thead>

    <tbody>
      <?php foreach ($items as $culture => $banners): ?>
        <tr><th colspan="2"><?php echo $culture ?></th></tr>

        <?php foreach ($banners as $key => $banner): ?>
          <?php
            $banner = $banner->getRawValue();
            $banner['key'] = $key;
            $banner['culture'] = $culture;
          ?>
          <tr class="sf_admin_row">
            <?php include_partial('banner/list_td', array('banner' => $banner)) ?>
            <?php include_partial('banner/list_td_actions', array('banner' => $banner)) ?>
          </tr>
        <?php endforeach ?>
      <?php endforeach ?>
    </tbody>
  </table>
</div>
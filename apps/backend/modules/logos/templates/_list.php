<div class="sf_admin_list">
  <table cellspacing="0">
    <thead>
      <tr>
        <?php include_partial('logos/list_th') ?>
        <th id="sf_admin_list_th_actions"><?php echo __('Actions', array(), 'sf_admin') ?></th>
      </tr>
    </thead>

    <tbody>
      <?php foreach ($items as $culture => $logos): ?>
        <tr><th colspan="2"><?php echo $culture ?></th></tr>

        <?php foreach ($logos as $key => $logo): ?>
          <?php
            $logo = $logo->getRawValue();
            $logo['key'] = $key;
            $logo['culture'] = $culture;
          ?>
          <tr class="sf_admin_row">
            <?php include_partial('logos/list_td', array('logo' => $logo)) ?>
            <?php include_partial('logos/list_td_actions', array('logo' => $logo)) ?>
          </tr>
        <?php endforeach ?>
      <?php endforeach ?>
    </tbody>
  </table>
</div>
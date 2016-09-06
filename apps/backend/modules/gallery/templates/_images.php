<?php
  $name_format  = sprintf('%s[Images][%%d][%%s]', $form->getName());
  $id_format    = sprintf('%s_Images_%%d_%%s', $form->getName());
?>

<div id="<?= $form->getName() ?>_images" class="sf_admin_form_row sf_admin_text sf_admin_form_field_Images">
  <div>

    <table>
      <tbody>
        <?php foreach ($form->getObject()->Images as $i => $image): ?>
          <tr>
            <td>
              <?= image_tag($image->thumb) ?>
              <br/>
              <?= tag('input', array('type' => 'file', 'id' => sprintf($id_format, $i, 'file'), 'name' => sprintf($name_format, $i, 'file'))) ?>
            </td>
            <td>
              <table>
                <tbody>
                  <?php foreach (sfConfig::get('sf_languages') as $lang): ?>
                    <tr>
                      <th><?= $lang ?></th>
                      <td>
                        <table>
                          <tbody>
                            <tr>
                              <th><label for="<?= sprintf($id_format, $i, $lang.'_title') ?>">Заголовок</label></th>
                              <td><?= tag('input', array('type' => 'text', 'id' => sprintf($id_format, $i, $lang.'_title'), 'name' => sprintf($name_format, $i, $lang.'][title'), 'value' => $image->Translation[$lang]->title)) ?></td>
                            </tr>
                            <tr>
                              <th><label for="<?= sprintf($id_format, $i, $lang.'_description') ?>">Описание</label></th>
                              <td><?= content_tag('textarea', $image->Translation[$lang]->description, array('id' => sprintf($id_format, $i, $lang.'_description'), 'name' => sprintf($name_format, $i, $lang.'][description'), 'cols' => '60', 'rows' => '1')) ?></td>
                            </tr>
                          </tbody>
                        </table>
                        <?php if ($image->Translation[$lang]->exists()): ?>
                          <?= tag('input', array('type' => 'hidden', 'name' => sprintf($name_format, $i, $lang.'][lang'), 'value' => $lang)) ?>
                        <?php endif ?>
                      </td>
                    </tr>
                  <?php endforeach ?>
                </tbody>
              </table>
            </td>
            <td>
              <a href="#" class="delete-image"><?= image_tag('/sfDoctrinePlugin/images/delete.png') ?></a>
              <?= tag('input', array('type' => 'hidden', 'id' => sprintf($id_format, $i, 'id'), 'name' => sprintf($name_format, $i, 'id'), 'value' => $image->id)) ?>
            </td>
          </tr>
        <?php endforeach ?>
      </tbody>
    </table>

  </div>
</div>

<script type="text/javascript">//<![CDATA[
  $(function(){
    $('a.delete-image', '#<?= $form->getName() ?>_images').on('click', function(){
      var $input = $(this).next('input:hidden').clone();
      $input.removeAttr('id').attr('name', '<?= sprintf($form->getWidgetSchema()->getNameFormat(), 'images_delete][') ?>');
      $('#<?= $form->getName() ?>_images').append($input);
      $(this).parent('td').parent('tr').fadeOut(250, function(){ $(this).remove(); });
      return false;
    });
  });
//]]>
</script>
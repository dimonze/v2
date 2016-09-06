<?php use_helper('Garage', 'Date') ?>

<tr class="tr-sortable">
  <td>
    <?= image_tag($form->getObject()->getEventImage($item->getRawValue(), 'narrow')) ?>
    <input type="file" name="<?= $form['events'][$index]['items']->renderName() ?>[image][]"/>
    <?php if ($form->getObject()->getIsEventImageStored($item->id)): ?>
      <br/><input type="checkbox" name="<?= $form['events'][$index]['items']->renderName() ?>[image_delete][]"/>удалить
    <?php else: ?>
      <input type="hidden" name="<?= $form['events'][$index]['items']->renderName() ?>[image_delete][]"/>
    <?php endif ?>
  </td>
  <td>
    <h3><?= $item->Translation[$lang]->title ?></h3>
    <label>Даты проведения:</label>
    <input type="text" name="<?= $form['events'][$index]['items']->renderName() ?>[dates][]" value="<?= !array_key_exists('dates', $options->getRawValue()) ? event_dates($item) : $options['dates'] ?>"/>
    <br/>
    <textarea id="<?= $form['events'][$index]['items']->renderId() ?><?= $item->id ?>_text" name="<?= $form['events'][$index]['items']->renderName() ?>[text][]" rows="4"><?= empty($options['text']) ? $item->Translation[$lang]->getRaw('description') : $options['text'] ?></textarea>
    <script type="text/javascript">
      tinyMCE.init({
        mode:                              "exact",
        theme:                             "advanced",
        elements:                          "<?= $form['events'][$index]['items']->renderId() ?><?= $item->id ?>_text",
        width:                             "650px",
        height:                            "150px",
        plugins:                           "advlink,advlist,paste,nonbreaking",
        relative_urls:                     false,
        valid_elements:                    "@[style|class|id],#p,span,em/i,strong/b,br,-sub,-sup,-ol,-ul,li,strike,a[!href|rel|target]",
        fix_table_elements:                false,
        button_tile_map:                   true,
        theme_advanced_buttons1:           "fontsizeselect,|,bold,italic,underline,|,justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,link,unlink,|,removeformat,nonbreaking,|,cut,copy,paste,pastetext,pasteword,|,undo,redo,|,cleanup,code",
        theme_advanced_buttons2:           "",
        theme_advanced_buttons3:           "",
        theme_advanced_toolbar_location:   "bottom",
        theme_advanced_toolbar_align:      "left",
        theme_advanced_statusbar_location: "bottom",
        theme_advanced_resizing:           true,
        skin:                              "o2k7",
        skin_variant:                      "silver",
        language:                          "ru",
        cleanup:                           true,
        convert_urls:                      false,
        custom_undo_redo_levels:           10
      });
    </script>
    <label>Тип шаблона:</label>
    <select name="<?= $form['events'][$index]['items']->renderName() ?>[template][]">
      <?php $tpl = empty($options['template']) ? 1 : $options['template'] ?>
      <?php foreach (range(1, 4) as $n): ?>
        <option value="<?= $n ?>"<?= $tpl == $n ? ' selected="selected"' : '' ?>>Тип <?= $n ?></option>
      <?php endforeach ?>
    </select>
    <?php if ($item->Translation[$lang]->html_code): ?>
      <label>с кнопкой №:</label>
      <input type="text" name="<?= $form['events'][$index]['items']->renderName() ?>[button][]" class="narrow" value="<?= empty($options['button']) ? '' : $options['button'] ?>"/>
    <?php else: ?>
      <input type="hidden" name="<?= $form['events'][$index]['items']->renderName() ?>[button][]" class="narrow" value=""/>
    <?php endif ?>
    <br/>
    <label>Ссылка на событие:</label>
    <input type="text" name="<?= $form['events'][$index]['items']->renderName() ?>[link][]" class="wide" value="<?= empty($options['link']) ? sprintf('http://%s/%s/event/%d', $sf_request->getHost(), $lang, $item->id) : $options['link'] ?>"/>
  </td>
  <td>
    <a href="#" class="remove"><img src="/sfDoctrinePlugin/images/delete.png" alt="удалить"/></a>
    <br/><br/>
    <a href="#" class="promote"><img src="/sfDoctrinePlugin/images/desc.png" alt="выше"/></a>
    <br/><br/>
    <a href="#" class="demote"><img src="/sfDoctrinePlugin/images/asc.png" alt="ниже"/></a>
    <input type="hidden" name="<?= $form['events'][$index]['items']->renderName() ?>[id][]" value="<?= $item->id ?>"/>
  </td>
</tr>
<?php use_helper('I18N') ?>
<?php use_javascript('/sfFormExtraPlugin/js/tiny_mce/tiny_mce.js') ?>
<?php include_partial('banner/assets') ?>

<div id="sf_admin_container">
  <h1>Рассылка подписчикам</h1>

  <?php include_partial('banner/flashes') ?>

  <div id="sf_admin_content">
    <div class="sf_admin_form">
      <form action="<?= url_for('subscription/send') ?>" method="post">
        <fieldset id="sf_fieldset_none">
          <div class="sf_admin_form_row">
            Все поля обязательны для заполнения.
          </div>

          <div class="sf_admin_form_row sf_admin_text">
            <label>Обратный адрес</label>
            <input type="text" name="email" value="<?= $sf_params->get('email') ?>" />
          </div>

          <div class="sf_admin_form_row sf_admin_text">
            <label>Заголовок</label>
            <input type="text" name="title" style="width: 60%" value="<?= $sf_params->get('title') ?>" />
          </div>

          <div class="sf_admin_form_row sf_admin_text">
            <label>Текст письма</label>
            <textarea name="text" style="width: 60%; height: 22em" id="message_text"><?= $sf_params->get('text') ?></textarea>
          </div>
        </fieldset>

        <ul class="sf_admin_actions">
          <li class="sf_admin_action_save">
            <button type="submit">Отправить</button>
          </li>
        </ul>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript">
    tinyMCE.init({
      mode:                              "exact",
      theme:                             "advanced",
      elements:                          "message_text",
      language:                          "ru",
      width: "650px",

      relative_urls:                     false,
      theme_advanced_toolbar_location:   "top",
      theme_advanced_toolbar_align:      "left",
      theme_advanced_statusbar_location: "bottom",
      theme_advanced_resizing:           true,
      theme_advanced_buttons1 : "formatselect,separator,bold,italic,underline,strikethrough,separator,justifyleft,justifycenter,justifyright,justifyfull,separator,bullist,numlist,separator,outdent,indent,separator,undo,redo,separator,link,unlink,separator,cleanup,code",
      theme_advanced_buttons2 : "sub,sup,pastetext,pasteword,visualaid,removeformat,charmap,hr",
      theme_advanced_buttons3 : ""
      ,
plugins: "paste,filemanager,embedvideo,table",
theme_advanced_buttons2_add: "separator,image,filemanager_images,filemanager_files,separator,embedvideo,separator,tablecontrols",

    table_styles : "Header 1=header1;Header 2=header2;Header 3=header3",
    table_cell_styles : "Header 1=header1;Header 2=header2;Header 3=header3;Table Cell=tableCel1",
    table_row_styles : "Header 1=header1;Header 2=header2;Header 3=header3;Table Row=tableRow1",
    table_cell_limit : 500,
    table_row_limit : 100,
    table_col_limit : 20
      ,
extended_valid_elements : "iframe[name|src|framespacing|border|frameborder|scrolling|title|height|width],object[declare|classid|codebase|data|type|codetype|archive|standby|height|width|usemap|name|tabindex|align|border|hspace|vspace],param[name|value],embed[src|type|wmode|width|height]"
    });
  </script>
<?php

/**
 * Base project form.
 *
 * @package    garage
 * @subpackage form
 * @author     Garin Studio <eugeniy.b@garin-studio.ru>
 * @version    SVN: $Id: BaseForm.class.php 20147 2009-07-13 11:46:57Z FabianLange $
 */
class BaseForm extends sfFormSymfony
{
  protected
    $_tinymce_options = array(
      'height' => 400,
      'width'  => 650,
      'theme'  => 'advanced',
      'config' => '
        plugins : "table,advimage,advlink,advlist,paste,nonbreaking,embedvideo,filemanager",
        content_css: "/css/tinymce.css",
        body_class: "textZone",
        valid_elements: "@[style|class|id|itemprop|itemscope|itemtype],-noindex,-h1,-h2,-h3,-h4,#p,em/i,strong/b,br,-sub,-sup,-ol,-ul,li,-span,-div,strike,a[!href|rel|target],-table[width|cellspacing|cellpadding|border],-tr,#td[colspan|rowspan],#th[colspan|rowspan],tbody,thead,tfoot,img[!src|!alt|title|width|height],iframe[name|src|framespacing|border|frameborder|scrolling|title|height|width],object[declare|classid|codebase|data|type|codetype|archive|standby|height|width|usemap|name|tabindex|align|border|hspace|vspace],param[name|value],embed[src|type|wmode|width|height]",
        fix_table_elements: false,
        button_tile_map: true,
        theme_advanced_buttons1: "formatselect,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,outdent,indent,|,link,unlink,anchor,|,undo,redo,|,cleanup,code",
        theme_advanced_buttons2: "sub,sup,charmap,|,cut,copy,paste,pastetext,pasteword,visualaid,removeformat,nonbreaking,hr,|,image,filemanager_images,filemanager_files,|,embedvideo,|,tablecontrols",
        theme_advanced_buttons3 : "",
        theme_advanced_toolbar_location: "top",
        theme_advanced_toolbar_align: "left",
        theme_advanced_statusbar_location: "bottom",
        theme_advanced_resizing: true,
        theme_advanced_blockformats : "p,h1,h2,h3,h4",
        skin: "o2k7",
        skin_variant: "silver",
        language: "ru",
        cleanup: true,
        convert_urls: false,
        custom_undo_redo_levels: 10
      ',
    ),
    $_tinymce_mini_options = array(
      'height' => 150,
      'width'  => 650,
      'theme'  => 'advanced',
      'config' => '
        plugins : "advlink,advlist,paste,nonbreaking",
        valid_elements: "@[style|class|id|itemprop|itemscope|itemtype],-noindex,-h1,-h2,-h3,-h4,#p,em/i,strong/b,br,-sub,-sup,-ol,-ul,li,-span,-div,strike,a[!href|rel|target],-table[width|cellspacing|cellpadding|border],-tr,#td[colspan|rowspan],#th[colspan|rowspan],tbody,thead,tfoot,img[!src|!alt|title|width|height]",
        fix_table_elements: false,
        button_tile_map: true,
        theme_advanced_buttons1: "fontsizeselect,|,bold,italic,underline,|,justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,link,unlink,|,removeformat,nonbreaking,|,cut,copy,paste,pastetext,pasteword,|,undo,redo,|,cleanup,code",
        theme_advanced_buttons2: "",
        theme_advanced_buttons3: "",
        theme_advanced_toolbar_location: "bottom",
        theme_advanced_toolbar_align: "left",
        theme_advanced_statusbar_location: "bottom",
        theme_advanced_resizing: true,
        skin: "o2k7",
        skin_variant: "silver",
        language: "ru",
        cleanup: true,
        convert_urls: false,
        custom_undo_redo_levels: 10
      ',
    );


  public function setup()
  {
    parent::setup();
    $this->setI18N();
  }

  public function setValidatorSchema(sfValidatorSchema $validatorSchema)
  {
    parent::setValidatorSchema($validatorSchema);
    $this->setI18N();
    return $this;
  }

  protected function setI18N()
  {
    $i18n = sfContext::getInstance()->getI18N();
    $schema = $this->validatorSchema;

    $schema->setDefaultMessage('required', $i18n->__('Required'));
    $schema->setDefaultMessage('invalid', $i18n->__('Invalid'));

    $validators = array_merge(
      $schema->getFields(),
      $schema->getPreValidator() ? array($schema->getPreValidator()) : array(),
      $schema->getPostValidator() ? array($schema->getPostValidator()) : array()
    );

    foreach ($validators as $validator) {
      $validator->setMessage('required', $i18n->__('Required'));

      if ($validator instanceOf sfValidatorDoctrineUnique) {
        $validator->setMessage('invalid', $i18n->__('Duplicate value'));
      }
      else {
        $validator->setMessage('invalid', $i18n->__('Invalid'));
      }
    }
  }
}

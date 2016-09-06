<?php

/**
 * NewsTranslation form.
 *
 * @package    garage
 * @subpackage form
 * @author     Garin Studio <eugeniy.b@garin-studio.ru>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class NewsTranslationForm extends BaseNewsTranslationForm
{
  public function configure()
  {
    $this->widgetSchema['short'] = new sfWidgetFormTextarea();
    $this->widgetSchema['full'] = new sfWidgetFormTextareaTinyMCE($this->_tinymce_options);

    $this->widgetSchema->setLabels(array(
      'title'             => 'Заголовок',
      'short'             => 'Короткое описание',
      'full'              => 'Полный текст',
    ));
  }
}

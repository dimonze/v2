<?php

/**
 * BookTranslation form.
 *
 * @package    garage
 * @subpackage form
 * @author     Garin Studio <eugeniy.b@garin-studio.ru>
 * @version    SVN: $Id$
 */
class BookTranslationForm extends BaseBookTranslationForm
{
  public function configure()
  {
    $this->widgetSchema['description'] = new sfWidgetFormTextareaTinyMCE($this->_tinymce_options);
    $this->widgetSchema['about_book'] = new sfWidgetFormTextareaTinyMCE($this->_tinymce_mini_options);
    $this->widgetSchema['about_author'] = new sfWidgetFormTextareaTinyMCE($this->_tinymce_mini_options);
    $this->widgetSchema['about_publishing'] = new sfWidgetFormTextareaTinyMCE($this->_tinymce_mini_options);
    $this->widgetSchema['publishing_house'] = new sfWidgetFormInputText();
    $this->widgetSchema['publication_date'] = new sfWidgetFormInputText();


    $this->widgetSchema->setLabels(array(
      'book_name'         => 'Название книги',
      'publishing_house'  => 'Издательство',
      'about_book'        => 'О книге',
      'about_author'      => 'Об авторе',
      'about_publishing'  => 'Об издательстве',
      'publication_date'  => 'Дата издания',
      'description'       => 'Полное описание',
      'price'             => 'Стоимость',
    ));

  }
}

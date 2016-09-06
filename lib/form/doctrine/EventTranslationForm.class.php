<?php

/**
 * EventTranslation form.
 *
 * @package    garage
 * @subpackage form
 * @author     Garin Studio <eugeniy.b@garin-studio.ru>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class EventTranslationForm extends BaseEventTranslationForm
{
  public function configure()
  {
    $this->widgetSchema['short'] = new sfWidgetFormTextarea();
    $this->widgetSchema['description'] = new sfWidgetFormTextareaTinyMCE($this->_tinymce_options);
    $this->widgetSchema['additional'] = new sfWidgetFormTextareaTinyMCE($this->_tinymce_mini_options);
    $this->widgetSchema['special'] = new sfWidgetFormTextareaTinyMCE($this->_tinymce_mini_options);
    $this->widgetSchema['place_address'] = new sfWidgetFormTextareaTinyMCE($this->_tinymce_mini_options);

    $this->widgetSchema['html_code']->setAttributes(array('rows' => 7, 'cols' => 100));

    $this->validatorSchema['title']->setOption('trim', true);

    $this->widgetSchema->setLabels(array(
      'title'             => 'Название',
      'short'             => 'Короткое описание',
      'description'       => 'Полное описание',
      'additional'        => 'Доп. информация',
      'special'           => 'Для членов клуба',
      'place_address'     => 'Адрес проведения',
      'place_phone'       => 'Телефон',
      'place_open_hours'  => 'Часы работы',
      'city'              => 'Город проведения',
      'price'             => 'Стоимость',
      'html_code'         => 'Код кнопки билетов',
    ));

    $this->widgetSchema->setHelp('city', 'Название на английском будет использовано для получения координат.');
  }
}

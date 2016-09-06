<?php

/**
 * Gallery filter form.
 *
 * @package    garage
 * @subpackage filter
 * @author     Garin Studio <eugeniy.b@garin-studio.ru>
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class GalleryFormFilter extends BaseGalleryFormFilter
{
  public function configure()
  {
    $this->setWidget('title', new sfWidgetFormFilterInput(array('with_empty' => false)));
    $this->setValidator('title', new sfValidatorPass(array('required' => false)));

    $this->getWidget('date')->setOption('from_date', new sfWidgetFormI18nDate(array('culture' => 'ru')));
    $this->getWidget('date')->setOption('to_date', new sfWidgetFormI18nDate(array('culture' => 'ru')));
    $this->getWidget('date')->setOption('template', 'с %from_date% по %to_date%');
  }


  protected function addTitleColumnQuery($q, $element, $value)
  {
    if (!empty($value['text'])) {
      $q->andWhere('t.title LIKE ?', '%'.str_replace(' ', '%', $value['text']).'%');
    }
  }
}

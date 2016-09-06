<?php

/**
 * Letter filter form.
 *
 * @package    garage
 * @subpackage filter
 * @author     Garin Studio <eugeniy.b@garin-studio.ru>
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class LetterFormFilter extends BaseLetterFormFilter
{
  public function configure()
  {
    $this->getWidget('created_at')->setOption('from_date', new sfWidgetFormI18nDate(array('culture' => 'ru')));
    $this->getWidget('created_at')->setOption('to_date', new sfWidgetFormI18nDate(array('culture' => 'ru')));
    $this->getWidget('created_at')->setOption('template', 'с %from_date% по %to_date%');

    $this->getWidget('updated_at')->setOption('from_date', new sfWidgetFormI18nDate(array('culture' => 'ru')));
    $this->getWidget('updated_at')->setOption('to_date', new sfWidgetFormI18nDate(array('culture' => 'ru')));
    $this->getWidget('updated_at')->setOption('template', 'с %from_date% по %to_date%');
  }
}

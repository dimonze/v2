<?php

/**
 * Reservation filter form.
 *
 * @package    garage
 * @subpackage filter
 * @author     Garin Studio <eugeniy.b@garin-studio.ru>
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ReservationFormFilter extends BaseReservationFormFilter
{
  public function configure()
  {
    $this->getWidget('date')->setOption('from_date', new sfWidgetFormI18nDate(array('culture' => 'ru')));
    $this->getWidget('date')->setOption('to_date', new sfWidgetFormI18nDate(array('culture' => 'ru')));
    $this->getWidget('date')->setOption('template', 'с&nbsp;&nbsp;&nbsp;%from_date%<br />по&nbsp;%to_date%');
  }
}

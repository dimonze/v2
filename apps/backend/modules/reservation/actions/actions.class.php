<?php

require_once dirname(__FILE__).'/../lib/reservationGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/reservationGeneratorHelper.class.php';

/**
 * reservation actions.
 *
 * @package    garage
 * @subpackage reservation
 * @author     Garin Studio <eugeniy.b@garin-studio.ru>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class reservationActions extends autoReservationActions
{
  public function executeAnswered()
  {
    $reservation = $this->getRoute()->getObject();
    $reservation->is_answered = true;
    $reservation->save();

    $this->redirect('@reservation');
  }
}

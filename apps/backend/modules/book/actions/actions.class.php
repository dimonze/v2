<?php

require_once dirname(__FILE__).'/../lib/bookGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/bookGeneratorHelper.class.php';

/**
 * book actions.
 *
 * @package    garage
 * @subpackage book
 * @author     Garin Studio <eugeniy.b@garin-studio.ru>
 * @version    SVN: $Id$
 */
class bookActions extends autoBookActions
{
  protected function isValidSortColumn($column)
  {
    return parent::isValidSortColumn($column) || $column = 't.book_name' || $column = 't.author' || $column = 't.publishing_house';
  }
}


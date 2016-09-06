<?php

/**
 * news components.
 *
 * @package    garage
 * @subpackage news
 * @author     Garin Studio <eugeniy.b@garin-studio.ru>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class newsComponents extends sfActions
{
  public function executeSlider()
  {
    $i = null;
    $this->video = Doctrine::getTable('Video')->createQueryI18N()
      ->limit(1)
      ->execute();
    
    if ($this->video[0]->on_homepage)
    {
      $i=2;
    }
    $this->news = Doctrine::getTable('News')
            ->createQueryI18N('n', $this->getUser()->getCulture())
            ->andWhere('n.date <= ?', date('Y-m-d'))
            ->limit(5-$i)
            ->orderBy('n.date DESC')
            ->execute();  
  
  }

  public function executeLatest()
  {
    $this->news = Doctrine::getTable('News')
            ->createQueryI18N('n', $this->getUser()->getCulture())
            ->andWhere('n.date <= ?', date('Y-m-d'))
            ->limit(3)
            ->orderBy('n.date DESC')
            ->execute();
  }
}

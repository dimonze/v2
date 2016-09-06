<?php

/**
 * news actions.
 *
 * @package    garage
 * @subpackage news
 * @author     Garin Studio <eugeniy.b@garin-studio.ru>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class newsActions extends sfActions
{
  public function preExecute()
  {
    $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Garage Center for Contemporary Culture'));
  }

  public function executeIndex(sfWebRequest $request)
  {
    $query = Doctrine::getTable('News')
            ->createQueryI18N('n', $this->getUser()->getCulture())
            ->andWhere('n.date <= ?', date('Y-m-d'))
            ->orderBy('n.date DESC');

    $this->pager = new sfDoctrinePager('News', 4);
    $this->pager->setQuery($query);
    $this->pager->setPage($request->getParameter('page'));
    $this->pager->init();
  }

  public function executeShow()
  {
    $this->news = $this->getRoute()->getObject();
  }

  public function executeArtguide()
  {
    $this->news = array();

    try {
      $url = sprintf('http://www.artguide.com/%s/rss?news=1', $this->getUser()->getCulture());
      $xml = simplexml_load_file($url);

      for ($i=0; $i<15; $i++) {
        if (empty($xml->channel->item[$i]->title)) continue;
        if (!in_array($xml->channel->item[$i]->category->__toString(), array('Новости','News'))) continue;

        $this->news[] = array(
          'title' => $xml->channel->item[$i]->title,
          'anons' => $xml->channel->item[$i]->description,
          'date'  => $xml->channel->item[$i]->pubDate,
          'link'  => $xml->channel->item[$i]->link,
          'image' => $xml->channel->item[$i]->enclosure->url,
        );
      }
    }
    catch (Exception $e) {}
  }
}

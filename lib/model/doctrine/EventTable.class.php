<?php

/**
 * EventTable
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class EventTable extends Doctrine_Table
{
  /**
   * Returns an instance of this class.
   *
   * @return object EventTable
   */
  public static function getInstance()
  {
    return Doctrine_Core::getTable('Event');
  }

  public function createQueryI18N($alias = 'e', $culture = null)
  {
    if (!$culture) $culture = sfContext::getInstance()->getUser()->getCulture();
    return $this->createQuery($alias)
      ->innerJoin($alias . '.Translation t with t.title <> "" and t.lang = ?', $culture);
  }

  public function getForSitemap()
  {
    return $this->createQuery('e')
            ->select('e.id, t.id')
            ->leftJoin('e.Translation t')
            ->where('published_at IS NOT NULL')
            ->orderBy('e.id DESC')
            ->fetchArray();
  }

  public function getObjectItem($params)
  {
    return $this->createQueryI18N('e', $params['sf_culture'])
      ->andWhere('e.id = ?', $params['id'])
      ->andWhere('published_at IS NOT NULL')
      ->fetchOne();
  }

  public function retrieveBackendObjectList(Doctrine_Query $q)
  {
    $rootAlias = $q->getRootAlias();
    $q->leftJoin($rootAlias.'.Translation t WITH t.lang = ?', 'ru');

    return $q;
  }
}
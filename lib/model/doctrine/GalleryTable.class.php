<?php

/**
 * GalleryTable
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class GalleryTable extends Doctrine_Table
{
  /**
   * Returns an instance of this class.
   *
   * @return object GalleryTable
   */
  public static function getInstance()
  {
    return Doctrine_Core::getTable('Gallery');
  }


  public function createQueryI18N($alias = 'g', $culture = null)
  {
    if (!$culture) $culture = sfContext::getInstance()->getUser()->getCulture();
    return $this->createQuery($alias)
            ->innerJoin($alias.'.Translation t WITH t.lang = ?', $culture);
  }

  public function getGalleryChoices()
  {
    return $this->createQuery('g')
            ->leftJoin('g.Translation t WITH t.lang = ?', 'ru')
            ->orderBy('t.title');
  }

  public function getForSitemap()
  {
    return $this->createQuery('g')
            ->select('g.id, t.id')
            ->leftJoin('g.Translation t')
            ->orderBy('g.id DESC')
            ->fetchArray();
  }

  public function getObjectItem($params)
  {
    return $this->createQueryI18N('g', $params['sf_culture'])
            ->leftJoin('g.Images i')
            ->leftJoin('i.Translation it WITH it.lang = ?', $params['sf_culture'])
            ->andWhere('g.id = ?', $params['id'])
            ->fetchOne();
  }

  public function retrieveBackendObjectList(Doctrine_Query $q)
  {
    $rootAlias = $q->getRootAlias();
    $q->leftJoin($rootAlias.'.Translation t WITH t.lang = ?', 'ru');

    return $q;
  }
}
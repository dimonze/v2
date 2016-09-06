<?php

class SearchPager extends sfPager
{
  private
    $search, $query,
    $cache, $cache_key,
    $rs;

  public function __construct($maxPerPage = 10)
  {
    $this->setMaxPerPage($maxPerPage);
    $this->parameterHolder = new sfParameterHolder();
  }

  public function init()
  {
    $this->resetIterator();

    $data = $this->getData();
    $this->setNbResults(count($data));

    if (!$this->getPage() || !$this->getMaxPerPage() || !$this->getNbResults()) {
      $this->setLastPage(0);
    }
    else {
      $this->load($data);
      $this->setLastPage(ceil($this->getNbResults() / $this->getMaxPerPage()));
    }
  }

  protected function retrieveObject($offset)
  {
    return $this->rs[$offset];
  }

  public function getResults()
  {
    return $this->rs;
  }

  public function getOffset()
  {
    return ($this->getPage() - 1) * $this->getMaxPerPage();
  }


  private function load(array $data)
  {
    $this->rs = array();

    for ($i = $this->getOffset(); $i < $this->getOffset() + $this->getMaxPerPage(); $i++) {
      if (!isset($data[$i])) {
        break;
      }
      $this->rs[] = (object) array(
        'doc'   => $this->getSearch()->getLucene()->getDocument($data[$i]['id']),
        'score' => $data[$i]['score'],
      );
    }
    $this->loadRecords();
    $this->highlight();
  }


  private function highlight()
  {
    $highlighter = new SearchHighlighter();
    foreach ($this->rs as $i => $hit) {
      $this->rs[$i]->title = $this->getQuery()->htmlFragmentHighlightMatches(
        $this->rs[$i]->doc->title, 'UTF-8', $highlighter
      );
      $this->rs[$i]->contents = SearchHighlighter::excerpt(
        $this->getQuery()->htmlFragmentHighlightMatches(
          $this->rs[$i]->doc->contents, 'UTF-8', $highlighter
        )
      );

      foreach (array('title', 'contents') as $field) {

      }
    }
  }


  private function loadRecords()
  {
    $models = array();

    foreach ($this->rs as $i => $hit) {
      if (!isset($models[$hit->doc->class])) {
        $models[$hit->doc->class] = array();
      }
      $models[$hit->doc->class][$hit->doc->pk] = $i;
    }

    foreach ($models as $model => $ids) {
      $query = Doctrine::getTable($model)->createQuery()
        ->andWhereIn('id', array_keys($ids));
      foreach ($query->execute() as $record) {
        $i = $ids[$record->id];
        $this->rs[$i]->record = $record;
      }
    }
  }

  private function getData()
  {
    $key = $this->getCacheKey();

    if ($this->getCache()->has($key)) {
      $data = unserialize($data = $this->getCache()->get($key));
    }
    else {
      $data = array();
      foreach ($this->getSearch()->getLucene()->find($this->getQuery()) as $hit) {
        $data[] = array(
          'id'    => $hit->id,
          'score' => $hit->score,
        );
      }
      $this->getCache()->set($key, serialize($data));
    }

    return $data;
  }


  /**
   * @return sfCache
   */
  private function getCache()
  {
    if (!$this->cache) {
      $this->cache = new sfFileCache(array(
        'cache_dir' => sfConfig::get('sf_cache_dir') . '/search',
        'lifetime'  => 20 * 60,
      ));
    }
    return $this->cache;
  }

  /**
   * @return sfCache
   */
  private function getCacheKey()
  {
    if (!$this->cache_key) {
      $this->cache_key = md5(serialize($this->getSearch()) . serialize($this->getQuery()));
    }
    return $this->cache_key;
  }


  /**
   * @return Search
   */
  public function getSearch()
  {
    return $this->search;
  }

  public function setSearch(Search $search)
  {
    $this->search = $search;
    $this->cache_key = null;
  }

  /**
   * @return Zend_Search_Lucene_Search_Query
   */
  public function getQuery()
  {
    return $this->query;
  }

  public function setQuery(Zend_Search_Lucene_Search_Query $query)
  {
    $this->query = $query;
    $this->cache_key = null;
  }
}

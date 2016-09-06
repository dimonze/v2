<?php

class Search
{
  const
    TYPE_EXHIBITION = 1,
    TYPE_CHILDREN   = 2,
    TYPE_EDUCATION  = 3,
    TYPE_ABOUT      = 4,
    TYPE_PRESS      = 5,
    TYPE_VISITORS   = 6,
    TYPE_FRIENDS    = 7,
    TYPE_SUPPORT    = 8;

  public static
    $models = array('Event', 'News', 'Page', 'Gallery'),
    $types = array(
      self::TYPE_EXHIBITION => 'Выставки',
      self::TYPE_CHILDREN   => 'Дети',
      self::TYPE_EDUCATION  => 'Образование',
      self::TYPE_ABOUT      => 'О гараже',
      self::TYPE_PRESS      => 'Пресса',
      self::TYPE_VISITORS   => 'Посетителям',
      self::TYPE_FRIENDS    => 'Друзья гаража',
      self::TYPE_SUPPORT    => 'Поддержка',
    );
  protected static $_instances = array();

  /**
   * @param string $culture
   * @return Search
   * @throws Exception
   */
  public static function getInstance($culture = null)
  {
    ProjectConfiguration::registerZend();
    Zend_Search_Lucene_Search_QueryParser::setDefaultEncoding('UTF-8');

    if (null === $culture) {
      $culture = sfContext::getInstance()->getUser()->getCulture();
    }
    if (!in_array($culture, sfConfig::get('sf_languages'))) {
      throw new Exception('Unknown culture: "' . $culture . '"');
    }
    if (!isset(self::$_instances[$culture])) {
      self::$_instances[$culture] = new Search($culture);
    }

    return self::$_instances[$culture];
  }

  /**
   * @param mixed $uniq key
   */
  public static function delete($uniq, $cultures = null)
  {
    ProjectConfiguration::registerZend();

    if ($uniq instanceOf Doctrine_Record) {
      $uniq = sprintf('%s|%s', get_class($uniq), $uniq->id);
    }
    if (!$cultures) {
      $cultures = sfConfig::get('sf_languages');
    }

    $term = new Zend_Search_Lucene_Index_Term($uniq, 'uniq');

    foreach ((array) $cultures as $culture) {
      $index = self::getInstance($culture)->getLucene();
      foreach ($index->termDocs($term) as $id) {
        $index->delete($id);
      }
    }
  }

  /**
   * @param object $item
   * @return Zend_Search_Lucene_Document
   */
  public static function createDocument($item)
  {
    ProjectConfiguration::registerZend();

    $doc = new Zend_Search_Lucene_Document();
    $doc->addField(Zend_Search_Lucene_Field::unIndexed('pk', $item->id));
    $doc->addField(Zend_Search_Lucene_Field::unIndexed('class', get_class($item)));
    $doc->addField(Zend_Search_Lucene_Field::Keyword('uniq', sprintf('%s|%s', $doc->class, $doc->pk)));
    $doc->addField(Zend_Search_Lucene_Field::Keyword('type', self::getDocumentType($item)));

    return $doc;
  }

  public static function getDocumentType($item)
  {
    switch (get_class($item)) {
      case 'Event':
        switch ($item->atype) {
          case Event::TYPE_EXHIBITION: return self::TYPE_EXHIBITION;
          case Event::TYPE_CHILDREN:   return self::TYPE_CHILDREN;
          case Event::TYPE_EDUCATION:  return self::TYPE_EDUCATION;
        }
        return null;

      case 'Gallery':                  return self::TYPE_ABOUT;
      case 'News':                     return self::TYPE_PRESS;

      case 'Page':
        foreach (array($item->id, $item->parent_id) as $id) {
          switch ($id) {
            case 2:                    return self::TYPE_ABOUT;
            case 3:                    return self::TYPE_PRESS;
            case 4:                    return self::TYPE_VISITORS;
            case 5:                    return self::TYPE_FRIENDS;
            case 6:                    return self::TYPE_SUPPORT;
          }
        }
    }
  }

  /**
   * @param strings
   * @return string
   */
  public static function cleanText()
  {
    $text = func_get_args();
    $text = implode("\n", $text);

    $text = strip_tags($text);
    $text = preg_replace('/&[^;]+;/', ' ', $text);
    $text = preg_replace('/[^\p{L}\p{N}]+/u', ' ', $text);
    $text = preg_replace('/\s+/', ' ', $text);
    $text = str_replace('ё', 'е', $text);

    return $text;
  }


  protected $_culture, $_lucene, $_analyzer;

  protected function __construct($culture)
  {
    $this->_culture = $culture;
    $file = sprintf('%s/lucene/%s.index', sfConfig::get('sf_data_dir'), $culture);

    if (file_exists($file)) {
      $this->_lucene = Zend_Search_Lucene::open($file);
    }
    else {
      Zend_Search_Lucene_Storage_Directory_Filesystem::setDefaultFilePermissions(0775);
      $this->_lucene = Zend_Search_Lucene::create($file);
    }
  }

  /**
   * @return Zend_Search_Lucene_Interface
   */
  public function getLucene()
  {
    return $this->_lucene;
  }

  /**
   * @param Zend_Search_Lucene_Document $doc
   */
  public function addDocument(Zend_Search_Lucene_Document $doc)
  {
    self::delete($doc->uniq, $this->_culture);

    if ($doc->type) {
      $this->setAnalyzer();
      $this->_lucene->addDocument($doc);
    }
    else {
      return false;
    }
  }

  public function buildQuery($string, array $types = null)
  {
    $this->setAnalyzer();

    $query = new Zend_Search_Lucene_Search_Query_Boolean();
    $query->addSubquery(Zend_Search_Lucene_Search_QueryParser::parse($string, 'UTF-8'), true);

    if ($types) {
      $type_query = new Zend_Search_Lucene_Search_Query_Boolean();
      foreach ($types as $type) {
        $type_query->addSubquery(Zend_Search_Lucene_Search_QueryParser::parse('type:' . $type, 'UTF-8'));
      }
      $query->addSubquery($type_query, true);
    }

    return $query;
  }


  /**
   * Sets default analyzer
   */
  private function setAnalyzer()
  {
    if (!$this->_analyzer) {
      $this->_analyzer = new Zend_Search_Lucene_Analysis_Analyzer_Common_Utf8_CaseInsensitive();

      $this->_analyzer->addFilter(new Analysis_ShortWords());

      $stop_filter = new Zend_Search_Lucene_Analysis_TokenFilter_StopWords();
      $stop_filter->loadFromFile(sfConfig::get('sf_config_dir').'/stopwords_ru');
      $stop_filter->loadFromFile(sfConfig::get('sf_config_dir').'/stopwords_en');
      $this->_analyzer->addFilter($stop_filter);

      $klass = 'Analysis_Stemmer' . ucfirst($this->_culture);
      $this->_analyzer->addFilter(new $klass);
    }

    Zend_Search_Lucene_Analysis_Analyzer::setDefault($this->_analyzer);
  }
}

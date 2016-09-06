<?php

/** Zend_Search_Lucene_Analysis_TokenFilter */
require_once 'Zend/Search/Lucene/Analysis/TokenFilter.php';


/**
 * Token filter that removes short words. What is short word can be configured with constructor.
 * Multibyte compatible.
 */
class Analysis_ShortWords extends Zend_Search_Lucene_Analysis_TokenFilter
{
  /**
   * Minimum allowed term length
   * @var integer
   */
  private $length;

  /**
   * Constructs new instance of this filter.
   *
   * @param integer $short  minimum allowed length of term which passes this filter (default 3)
   */
  public function __construct($length = 3)
  {
    $this->length = $length;
  }

  /**
   * Normalize Token or remove it (if null is returned)
   *
   * @param Zend_Search_Lucene_Analysis_Token $srcToken
   * @return Zend_Search_Lucene_Analysis_Token
   */
  public function normalize(Zend_Search_Lucene_Analysis_Token $srcToken)
  {
    if (mb_strlen($srcToken->getTermText()) < $this->length) {
      return null;
    } else {
      return $srcToken;
    }
  }
}


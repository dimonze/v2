<?php

require_once 'Zend/Search/Lucene/Analysis/Analyzer.php';
require_once 'Zend/Search/Lucene/Search/Highlighter/Interface.php';

class SearchHighlighter implements Zend_Search_Lucene_Search_Highlighter_Interface
{
  protected $_doc;

  /**
   * Set document for highlighting.
   *
   * @param Zend_Search_Lucene_Document_Html $document
   */
  public function setDocument(Zend_Search_Lucene_Document_Html $document)
  {
    $this->_doc = $document;
  }

  /**
   * Get document for highlighting.
   *
   * @return Zend_Search_Lucene_Document_Html $document
   */
  public function getDocument()
  {
    return $this->_doc;
  }

  /**
   * Highlight specified words
   *
   * @param string|array $words  Words to highlight. They could be organized using the array or string.
   */
  public function highlight($words)
  {
    $this->_doc->highlightN($words);
  }


  public static function excerpt($html, $size = 250)
  {
    if (false === strpos($html, '<mark')) {
      if (mb_strlen($html = mb_substr($html, 0, 250))) {
        return preg_replace('/\s+\S*$/', '&hellip;', $html);
      }
      else {
        return $html;
      }
    }

    $parts = preg_split('/(?<!<mark)(\s+)/isu', $html, null, PREG_SPLIT_DELIM_CAPTURE);
    $target = '';
    $cursor = -1;

    foreach ($parts as $i => $part) {
      if ($cursor >= $i) {
        continue;
      }

      if (false !== strpos($part, '<mark')) {
        self::_sliceSub($parts, $target, $i - 1);
        $target .= $parts[$i] . (isset($parts[$i + 1]) ? $parts[$i + 1] : '');
        $cursor = self::_sliceAdd($parts, $target, $i + 2);
      }

      if (mb_strlen($target) > $size - $size * 0.1) {
        break;
      }
    }

    if ($cursor > 0 && $cursor < count($parts) - 1) {
      $target .= ' &hellip;';
    }

    return $target;
  }

  private static function _sliceSub(array $parts, &$target, $start)
  {
    $len = 0;
    $join = array();
    for ($i = $start; $i >= 0; $i--) {
      $join[] = $parts[$i];
      if (mb_strlen($parts[$i]) > 3 && 3 == ++$len) {
        break;
      }
    }

    if ($i > 0) {
      $join[] = ' &hellip; ';
    }

    $target .= implode('', array_reverse($join));
  }

  private static function _sliceAdd(array $parts, &$target, $start)
  {
    $len = 0;
    for ($i = max(0, $start); $i < count($parts); $i++) {
      $target .= $parts[$i];
      if (mb_strlen($parts[$i]) > 3 && 3 == ++$len) {
        break;
      }
    }
    return $i;
  }
}
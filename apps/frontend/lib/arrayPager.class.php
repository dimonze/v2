<?php

/**
 * @see http://snippets.symfony-project.org/snippet/177
 *
 * @author Alexey Shockov <alexey@shockov.com>
 */
class arrayPager extends sfPager
{
  protected $resultArray = null;

  public function __construct($class = null, $maxPerPage = 10)
  {
    parent::__construct($class, $maxPerPage);
  }

  public function init()
  {
    $this->setNbResults(count($this->resultArray));

    if (($this->getPage() == 0 || $this->getMaxPerPage() == 0))
    {
      $this->setLastPage(0);
    }
    else
    {
      $this->setLastPage(ceil($this->getNbResults() / $this->getMaxPerPage()));
    }
  }

  public function setResultArray($array)
  {
    $this->resultArray = $array;
  }

  public function getResultArray()
  {
    return $this->resultArray;
  }

  public function retrieveObject($offset) {
    return $this->resultArray[$offset];
  }

  public function getResults()
  {
    return array_slice($this->resultArray, ($this->getPage() - 1) * $this->getMaxPerPage(), $this->maxPerPage);
  }

}

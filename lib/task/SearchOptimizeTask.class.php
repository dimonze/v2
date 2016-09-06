<?php

class SearchOptimizeTask extends sfBaseTask
{
  protected function configure()
  {
    $this->namespace        = 'search';
    $this->name             = 'optimize';
    $this->briefDescription = '';
    $this->detailedDescription = '';
  }

  protected function execute($arguments = array(), $options = array())
  {
    foreach (sfConfig::get('sf_languages') as $culture) {
      Search::getInstance($culture)->getLucene()->optimize();
    }

    $this->logSection('Search', 'index optimization complete');
  }
}

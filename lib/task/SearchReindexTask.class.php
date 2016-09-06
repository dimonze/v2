<?php

class LuceneReindexTask extends sfBaseTask
{
  protected function configure()
  {
    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'frontend'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      new sfCommandOption('model', null, sfCommandOption::PARAMETER_OPTIONAL, 'The model name to reindex'),
    ));

    $this->namespace        = 'search';
    $this->name             = 'reindex';
    $this->briefDescription = '';
    $this->detailedDescription = '';
  }

  protected function execute($arguments = array(), $options = array())
  {
    new sfDatabaseManager($this->configuration);

    if (isset($options['model'])) {
      $this->reindex($options['model']);
    }
    else {
      foreach (Search::$models as $model) {
        $this->reindex($model);
      }
    }

    $this->logSection('Search', 'indexation complete');
    $this->runTask('search:optimize');
  }

  private function reindex($model)
  {
    $this->logSection('Search', sprintf('updating "%s" search index', $model));

    $query = Doctrine::getTable($model)->createQuery();
    $nb_pages = ceil($query->count() / 25);

    for ($i = 0; $i < $nb_pages; $i++) {
      $query->offset($i * 25)->limit(25);

      foreach ($query->execute() as $item) {
        $this->logSection($model, $item->id);
        $item->updateSearchIndex();
      }
    }
  }
}

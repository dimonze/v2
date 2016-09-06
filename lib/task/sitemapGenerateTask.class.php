<?php

class sitemapGenerateTask extends sfBaseTask
{
  protected function configure()
  {
    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'frontend'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'prod'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
    ));

    $this->namespace        = 'sitemap';
    $this->name             = 'generate';
    $this->briefDescription = '';
    $this->detailedDescription = '';
  }

  protected function execute($arguments = array(), $options = array())
  {
    new sfDatabaseManager($this->configuration);
    $routing = $this->getRouting();
    $routingOptions = $routing->getOptions();
    $routingOptions['context']['host'] = 'garageccc.com';
    $routing->initialize($this->dispatcher, $routing->getCache(), $routingOptions);
    $routes = $routing->getRoutes();

    $file_path = sprintf('%s/sitemap.xml', sfConfig::get('sf_web_dir'));
    $file_stream = fopen($file_path, 'w');

    flock($file_stream, LOCK_EX);
    fwrite($file_stream, '<?xml version="1.0" encoding="UTF-8"?>'."\n".'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:example="http://www.mysitemapgenerator.com/sitemap.xml">'."\n");

    $c = 0;
    foreach (array('Page','News','Gallery','Event') as $model) {
      $links = '';
      $route_name = sprintf('%s_show', strtolower($model));
      $route_variables = $routes[$route_name]->getVariables();

      foreach(Doctrine::getTable($model)->getForSitemap() as $data) {
        foreach (array_keys($data['Translation']) as $lang) {
          $data_variables = array_intersect_key($data, $route_variables);
          $link = $routing->generate($route_name, array_merge($data_variables, array('sf_culture' => $lang)), true);
          $links .= "\t<url>\n\t\t<loc>".$link."</loc>\n\t</url>\n";
          $c++;
        }
      }

      fwrite($file_stream, $links);
    }

    fwrite($file_stream, '</urlset>');
    fclose($file_stream);

    $this->logSection('xml sitemap', sprintf('%s - %d links', date('Y-m-d H:i:s'), $c));
  }
}

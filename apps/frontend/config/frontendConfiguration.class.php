<?php

class frontendConfiguration extends sfApplicationConfiguration
{
  public function configure()
  {
    require_once $this->getConfigCache()->checkConfig('config/banners.yml');
    require_once $this->getConfigCache()->checkConfig('config/logos.yml');
  }
}

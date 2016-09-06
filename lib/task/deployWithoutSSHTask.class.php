<?php

class deployWithoutSSHTask extends sfProjectDeployTask
{
  protected function configure()
  {
    parent::configure();
    
    $this->namespace        = 'project';
    $this->name             = 'deployWithoutSSH';
  }
  
  /**
   * @see sfTask
   */
  protected function execute($arguments = array(), $options = array())
  {
    $env = $arguments['server'];

    $ini = sfConfig::get('sf_config_dir').'/properties.ini';
    if (!file_exists($ini))
    {
      throw new sfCommandException('You must create a config/properties.ini file');
    }

    $properties = parse_ini_file($ini, true);

    if (!isset($properties[$env]))
    {
      throw new sfCommandException(sprintf('You must define the configuration for server "%s" in config/properties.ini', $env));
    }

    $properties = $properties[$env];

    if (!isset($properties['host']))
    {
      throw new sfCommandException('You must define a "host" entry.');
    }

    if (!isset($properties['module']))
    {
      throw new sfCommandException('You must define a "module" entry. No "dir" for MTW hosting :)');
    }

    $host = $properties['host'];
    $module  = $properties['module'];
    $user = isset($properties['user']) ? $properties['user'].'@' : '';

    if (isset($properties['parameters']))
    {
      $parameters = $properties['parameters'];
    }
    else
    {
      $parameters = $options['rsync-options'];
      if (file_exists($options['rsync-dir'].'/rsync_include.txt'))
      {
        $parameters .= sprintf(' --include-from=%s/rsync_include.txt', $options['rsync-dir']);
      }

      if (file_exists($options['rsync-dir'].'/rsync_exclude.txt'))
      {
        $parameters .= sprintf(' --exclude-from=%s/rsync_exclude.txt', $options['rsync-dir']);
      }

      if (file_exists($options['rsync-dir'].'/rsync.txt'))
      {
        $parameters .= sprintf(' --files-from=%s/rsync.txt', $options['rsync-dir']);
      }
      
      if (file_exists($options['rsync-dir'] . '/rsync_pass.txt'))
      {
        $parameters .= sprintf(' --password-file=%s/rsync_pass.txt', $options['rsync-dir']);
      }
    }

    $dryRun = $options['go'] ? '' : '--dry-run';
    $command = "rsync $dryRun $parameters ./ $user$host::$module";

    $this->getFilesystem()->execute($command, $options['trace'] ? array($this, 'logOutput') : null, array($this, 'logErrors'));

    $this->clearBuffers();
  }
}

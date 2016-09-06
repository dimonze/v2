<?php

class sqlDumpTask extends sfBaseTask
{
  private $conn;


  protected function configure()
  {
    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'frontend'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
    ));

    $this->addArgument('tables', sfCommandArgument::OPTIONAL | sfCommandArgument::IS_ARRAY, 'tables to dump. eg: {event,page,user}');

    $this->namespace        = '';
    $this->name             = 'sql-dump';
    $this->briefDescription = '';
    $this->detailedDescription = '';
  }

  protected function execute($arguments = array(), $options = array())
  {
    $databaseManager = new sfDatabaseManager($this->configuration);
    $this->conn = $databaseManager->getDatabase($options['connection'])->getConnection();

    $tables = empty($arguments['tables']) ? '*' : $arguments['tables'];
    $this->dumpTables($tables);
  }


  private function dumpTables($tables = '*')
  {
    if ($tables == '*') {
      $tables = $this->conn->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN);
    }
    else {
      $tables = is_array($tables) ? $tables : array_map('trim', explode(',', $tables));
    }

    $dump = '';
    $dump .= 'SET FOREIGN_KEY_CHECKS=0;'.PHP_EOL.PHP_EOL;

    foreach ($tables as $table) {
      $dump .= 'DROP TABLE '.$table.';';
      $dump .= PHP_EOL.PHP_EOL;
      $dump .= $this->conn->query('SHOW CREATE TABLE '.$table)->fetchColumn(1);
      $dump .= ';'.PHP_EOL.PHP_EOL;

      $results = $this->conn->query('SELECT * FROM '.$table);
      foreach ($results->fetchAll(PDO::FETCH_NUM) as $columns) {
        $dump .= 'INSERT INTO '.$table.' VALUES(';
        for ($i=0, $c=count($columns); $i<$c; $i++) {
          if (is_null($columns[$i])) {
            $columns[$i] = 'NULL';
          }
          elseif (ctype_digit($columns[$i]) || is_numeric($columns[$i])) {
            $columns[$i] = intval($columns[$i]);
          }
          else {
            $columns[$i] = addslashes($columns[$i]);
            $columns[$i] = str_replace("\r\n", '\r\n', $columns[$i]);
            $columns[$i] = '"'.$columns[$i].'"';
          }

          $dump .= $columns[$i];
          if ($i < $c-1) $dump .= ',';
        }
        $dump .= ');'.PHP_EOL;
      }

      $dump .= PHP_EOL.PHP_EOL;
    }

    $dump .= 'SET FOREIGN_KEY_CHECKS=1;'.PHP_EOL;

    $handle = fopen(sprintf('db-backup-%s-%s.sql', date('Ymd'), md5(implode(',', $tables))), 'w');
    fwrite($handle, $dump);
    fclose($handle);
  }
}

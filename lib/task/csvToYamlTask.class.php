<?php

class stImportCsvToYamlTask extends sfBaseTask
{
  protected function configure()
  {
    // add your own arguments here
    $this->addArguments(array(
      new sfCommandArgument('import_file', sfCommandArgument::REQUIRED, 'Path to CSV file to convert'),
    ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      new sfCommandOption('to-file', null, sfCommandOption::PARAMETER_NONE, 'Write it out to a file'),
      new sfCommandOption('importer', 'i', sfCommandOption::PARAMETER_OPTIONAL, 'Custom class that extends stImportCsvToYaml to use during import', 'stImportCsvToYaml'),
      new sfCommandOption('model', 'm', sfCommandOption::PARAMETER_OPTIONAL, 'Model name for yaml data', 'Object'),
      new sfCommandOption('prefix', 'p', sfCommandOption::PARAMETER_OPTIONAL, 'Prefix for object labels'),
    ));

    $this->namespace        = 'stImport';
    $this->name             = 'csvToYaml';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [importCsv|INFO] task does things.
Call it with:

  [php symfony importCsv|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

    // add your code here
    
    if (!class_exists($options['importer'])) {
      $converter = new $options['importer']();
      throw new sfCommandException('Cannot find the class '.$options['importer']);
    }
    
    $converter = new $options['importer']();
    
    if (!file_exists($arguments['import_file'])) {
      throw new sfCommandException('Cannot find '.$arguments['import_file']);
    }
    
    $converter->setFile($arguments['import_file']);
    $converter->setModel($options['model']);
    $converter->setPrefix($options['prefix']);
    $converter->process();
    $yaml = $converter->toYaml();
    
    if ($options['to-file']) {
      $this->writeToFile($arguments['import_file'], $yaml);
    } else {
      echo $yaml;
    }
  }
  
  protected function writeToFile($sourceFile, $yaml)
  {
    $targetFile = $sourceFile . '.yml';
    
    if (!file_put_contents($targetFile, $yaml)) {
      throw new sfCommandException('Cannot write to '.$targetFile.', it may already exist');
    }

    $this->log('Yaml written to '.$targetFile);
  }
  
}

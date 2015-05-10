<?php
namespace Task;
use Mage\Task\BuiltIn\Symfony2\SymfonyAbstractTask;
use Mage\Console;

class InitDatabase extends SymfonyAbstractTask {

  public function getName() {
    return 'Init database if needed...';
  }

  public function run() {
    $realAppPath = str_replace("/console","",$this->getAppPath());
    $yamlFile = $realAppPath . "/config/parameters.yml";
    Console::output("Yaml file path: " . $yamlFile);
    $parameters = yaml_parse(file_get_contents($yamlFile));
    $dbHost = $parameters['parameters']['database_host'];
    $dbName = $parameters['parameters']['database_name'];
    $dbUser = $parameters['parameters']['database_user'];
    $dbPassword = $parameters['parameters']['database_password'];
    echo "DB Name is $dbName";
    $command = "cd deploy/scripts/database && sh install-db.sh $dbHost $dbName $dbUser $dbPassword";
    $result = $this->runCommandRemote($command);
    return $result;
  }
}

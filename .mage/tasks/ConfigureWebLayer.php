<?php
namespace Task;
use Mage\Task\BuiltIn\Symfony2\SymfonyAbstractTask;
use Mage\Console;

class ConfigureWebLayer extends SymfonyAbstractTask {

  public function getName() {
    return 'Configuring web layer...';
  }

  public function run() {
    $environ =  $this->getParameter("environ","raspberry");
    $serverName = $this->getParameter('serverName', 'localhost');
    $documentRoot = $this->getParameter('documentRoot', '/var/www/localhost');

    if ($environ === "raspberry") {
      $reloadCmd = "sudo service apache2 reload";
      $apacheVhostsPath = "/etc/apache2/sites-enabled";
    }

    $command = "cd deploy/templates && bash fill-vhost-template.sh $serverName \"$documentRoot\" $apacheVhostsPath \"$reloadCmd\"";
    $result = $this->runCommandRemote($command);
    return $result;
  }
}

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

    // add environ osmc 
    if ($environ === "raspberry") {
      $reloadCmd = "sudo /etc/init.d/apache2 restart";
      $apacheVhostsPath = "/etc/apache2/sites-enabled";
    }

    if ($environ === "local") {
      $reloadCmd = "sudo /etc/init.d/apache2 reload";
      $apacheVhostsPath = "/etc/apache2/sites-enabled";
    }

    $command = "cd deploy/templates && bash fill-vhost-template.sh $serverName \"$documentRoot\" $apacheVhostsPath \"$reloadCmd\"";

    $result = ($environ == "local") ? $this->runCommandLocal($command) : $this->runCommandRemote($command);
    return $result;
  }
}

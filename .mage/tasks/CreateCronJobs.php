<?php
namespace Task;
use Mage\Task\BuiltIn\Symfony2\SymfonyAbstractTask;
use Mage\Console;

class CreateCronJobs extends SymfonyAbstractTask {

  public function getName() {
    return 'Creating cronjobs in server...';
  }

  public function run() {
    $environ =  $this->getParameter("environ","raspberry");
    $serverName = $this->getParameter('serverName', 'localhost');
    $documentRoot = $this->getParameter('documentRoot', '/var/www/localhost');

    $baseConsoleForCommandPath = "/var/www/dutils/current/app/console";
    $automatedSearchCommandName = "dutils:automatedSearch";

    // Every 6 hours, 4 times a day
    $cronPattern = "0 */6 * * *";

    /* install-cronjobs like this
     * command="php $INSTALL/indefero/scripts/gitcron.php"
     * job="0 0 * * 0 $command"
     * cat <(fgrep -i -v "$command" <(crontab -l)) <(echo "$job") | crontab -
     */

    $command = "bash deploy/scripts/cron/install-cronjobs.sh \"php $baseConsoleForCommandPath $automatedSearchCommandName\" \"$cronPattern\"";
    $result = $this->runCommandRemote($command);
    return $result;
  }
}

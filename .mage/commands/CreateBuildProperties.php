<?php
namespace Command;
use Mage\Command\AbstractCommand;
use Mage\Console;

class CreateBuildProperties  extends AbstractCommand {

  public function getName() {
    return 'Creating build.properties file...';
  }

  public function run() {
  	
    $commandForBranch = "git status | grep -o \"origin/.*'\"";
    $output = "";
    Console::executeCommand($commandForBranch,$output);
    
    $date = new \DateTime();
    $commandForCommit = 'git rev-parse HEAD';
    
    $result = $output;
    $branch = str_replace("'", "", $result);

    Console::executeCommand($commandForCommit, $output);
    
    $result = $output;
    $commit = $result;
    
    $fileContent = "branch=$branch\n" . "commit=$commit\n" . "date=" . $date->format("d/m/Y H:i");
    
    file_put_contents(getcwd().'/build.properties', $fileContent);

    return $result;
  }
}

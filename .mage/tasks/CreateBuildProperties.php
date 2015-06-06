<?php
namespace Task;
use Mage\Task\AbstractTask;

class CreateBuildProperties extends AbstractTask {

  public function getName() {
    return 'Creating build.properties file...';
  }

  public function run() {
    
    $commandForBranch = "git status | grep -o \"origin/.*'\"";
    $output = $this->runCommandLocal($commandForBranch);
    $branch = str_replace("'", "", $output);
    
    $date = new \DateTime();
    
    $commandForCommit = 'git rev-parse HEAD';
    $output = $this->runCommandLocal($commandForCommit);
    $commit = $output;
        
    $fileContent = "branch=$branch\n" . "commit=$commit\n" . "date=" . $date->format("d/m/Y H:i") ."\n";
    
    file_put_contents(getcwd().'/build.properties', $fileContent);

    return $result;
  }
}

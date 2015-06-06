<?php
namespace Task;
use Mage\Task\AbstractTask;

class CreateBuildProperties extends AbstractTask {

  public function getName() {
    return 'Creating build.properties file...';
  }

  public function run() {
    
    $commandForBranch = "git status | grep -o \"origin/.*'\"";
    $output = "";
    $this->runCommandLocal($commandForBranch, $output);
    $branch = str_replace("'", "", $output);
    
    $date = new \DateTime();
    
    $commandForCommit = "git rev-parse HEAD";
    $result = $this->runCommandLocal($commandForCommit, $output);
    $commit = $output;
        
    $fileContent = "branch=$branch\n" . "commit=$commit\n" . "date=" . $date->format("d/m/Y H:i") ."\n";
    
    file_put_contents(getcwd().'/build.properties', $fileContent);

    return $result;
  }
}

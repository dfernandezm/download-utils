<?php
namespace Task;
use Mage\Task\AbstractTask;

class BuildClient extends AbstractTask {

  public function getName() {
    return 'Building client';
  }

  public function run() {
    $command = 'gulp prod';
    $result = $this->runCommandLocal($command);

    return $result;
  }
}

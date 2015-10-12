<?php
namespace Task;
use Mage\Task\AbstractTask;

class LinkScripts extends AbstractTask {

  public function getName() {
    return 'Building client';
  }

  public function run() {
    $processingDir = '/mediacenter/temp';

    $command = "";
    $result = $this->runCommandLocal($command);

    return $result;
  }
}

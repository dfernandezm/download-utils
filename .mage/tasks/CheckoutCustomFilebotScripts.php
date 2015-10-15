<?php
namespace Task;
use Mage\Task\AbstractTask;

class CheckoutCustomFilebotScripts extends AbstractTask {
  const CUSTOM_SCRIPTS_REPO = "https://github.com/dfernandezm/scripts.git";

  public function getName() {
    return "Checking out custom Filebot scripts";
  }

  public function run() {

    $filebotComponentDir = getcwd() . "/components/filebot";
    $customScriptsDir = "$filebotComponentDir/scripts";

    $checkoutScriptsCommand = "git clone " . self::CUSTOM_SCRIPTS_REPO;
    if (!file_exists($customScriptsDir)) {
        // Checkout the scripts from Git if not present
        $commands = "mkdir -p $filebotComponentDir && cd $filebotComponentDir && $checkoutScriptsCommand";
        $result = $this->runCommandLocal($commands);
    } else {
        $result = $this->runCommandLocal("cd $customScriptsDir && git pull");
    }

    return $result;
  }
}

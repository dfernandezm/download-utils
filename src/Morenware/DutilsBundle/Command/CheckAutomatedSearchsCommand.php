<?php
namespace Morenware\DutilsBundle\Command;

use AppKernel;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use JMS\DiExtraBundle\Annotation as DI;
use JMS\DiExtraBundle\Annotation\Service;
use JMS\DiExtraBundle\Annotation\Tag;
use Morenware\DutilsBundle\Util\GuidGenerator;
use Morenware\DutilsBundle\Service\ProcessManager;
use Symfony\Component\Process\Process;
use Morenware\DutilsBundle\Entity\TorrentState;
use Morenware\DutilsBundle\Service\CommandType;
use Monolog;

/**
 * @Service("checkautomatedSearchs.service")
 * @Tag("console.command")
 *
 */
class CheckAumotatedSearchsCommand extends Command {

	private $logger;

	private $renamerLogger;

	/** @DI\Inject("processmanager.service")
     *  @var \Morenware\DutilsBundle\Service\ProcessManager $processManager
     */
	public $processManager;

	/** @DI\Inject("kernel")
     *  @var AppKernel $kernel
     */
	public $kernel;

	/** @DI\Inject("torrent.service")
     * @var \Morenware\DutilsBundle\Service\TorrentService $torrentService
     */
	public $torrentService;

	/** @DI\Inject("settings.service")
     * @var \Morenware\DutilsBundle\Service\SettingsService $settingsService
     */
	public $settingsService;

    /** @DI\Inject("automatedsearch.service")
     * @var \Morenware\DutilsBundle\Service\AutomatedSearchService $automatedSearchService
     */
    public $automatedSearchService;


	// File containing the PID of this process. Its presence indicates that one and only
	// one is currently running
	const PID_FILE_NAME = "automatedSearchsChecker.pid";

	/**
	 * @DI\InjectParams({
	 *     "logger" = @DI\Inject("logger"),
	 *     "renamerLogger" =  @DI\Inject("monolog.logger.renamer")
	 * })
	 */
	public function __construct(Logger $logger, Logger $renamerLogger) {

		$this->logger = $logger;
		$this->renamerLogger = $renamerLogger;
		parent::__construct();
	}


	protected function configure() {
		$this
		->setName('dutils:automatedSearch')
		->setDescription('Check torrent sources using configured automated searchs');
	}


	protected function execute(InputInterface $input, OutputInterface $output) {

		$pid = getmypid();
		$this->renamerLogger->info("[AUTOMATED-SEARCH] Starting Automated Search process with PID $pid");
		$output->writeln("[AUTOMATED-SEARCH] Starting Automated Search process with PID $pid");

        /** @var  \Morenware\DutilsBundle\Entity\MediaCenterSettings $mediacenterSettings */
		$mediacenterSettings = $this->settingsService->getDefaultMediacenterSettings();

		$pidFile = $mediacenterSettings->getProcessingTempPath() . "/" . self::PID_FILE_NAME;

		// Check race condition, only one rename at a time
		if (file_exists($pidFile)) {
			$this->renamerLogger->info("[AUTOMATED-SEARCH] There is already one Automated Search process running -- exiting");
			return;
		}

        // Write pid file
        file_put_contents($pidFile, $pid);

		try {

            $this->automatedSearchService->executeAutomatedSearchs();

            $this->renamerLogger->info("[AUTOMATED-SEARCH] Finished processing -- exiting $pid");

		} catch (\Exception $e) {
			$this->renamerLogger->error("[AUTOMATED-SEARCH] Error executing Automated Search process with PID $pid -- stopping" . $e->getMessage() . " -- " . $e->getTraceAsString());
		} finally {
			unlink($pidFile);
		}
	}


}

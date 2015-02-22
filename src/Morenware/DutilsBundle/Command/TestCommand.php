<?php
namespace Morenware\DutilsBundle\Command;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;

class TestCommand extends Command {

	public function __construct() {
		parent::__construct();
	}
	
	
	protected function configure() {
		$this
		->setName('dutils:test')
		->setDescription('Monitor Downloads in remote Transmission');
	}
	
	/**
	 * Only 1 monitoring process at a time - check torrent status in Transmission and update states accordingly
	 *
	 * @see \Symfony\Component\Console\Command\Command::execute()
	 */
	protected function execute(InputInterface $input, OutputInterface $output) {
		$output->writeln("Test started with GUID  and PID ");
	}
	
	
}
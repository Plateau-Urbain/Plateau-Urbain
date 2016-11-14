<?php
namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;


class ImportUserCommand extends Command
{
    protected function configure()
    {
        $this->setName('app:importusers')->setDescription('Import Users from CSV files');
	$this->setHelp("TODO...");
	$this->addArgument('csv', InputArgument::REQUIRED, 'CSV file to import');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $csvfile = $input->getArgument('csv');
	$output->writeln('CSV Import : '.$csvfile);
	$f = fopen($csvfile, "r");
	if($f === FALSE) {
		$output->writeln('ERROR can not open '.$csvfile);
		return FALSE;
	} else {
		$headers = fgetcsv($f);       // delimiter ,
		while(!feof($f)) {
			$a = fgetcsv($f);	// delimiter ,
			$output->writeln(print_r($a, true));
		}
		fclose($f);
	}
    }
}


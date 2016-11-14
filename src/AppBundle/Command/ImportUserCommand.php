<?php
namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class ImportUserCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('app:importusers')->setDescription('Import Users from CSV files');
	$this->setHelp("TODO...");
	$this->addArgument('csv', InputArgument::REQUIRED, 'CSV file to import');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
	// get FOSUserBunder User Manager
	// http://symfony.com/doc/master/bundles/FOSUserBundle/user_manager.html
	$userManager = $this->getContainer()->get('fos_user.user_manager');
	$output->writeln(get_class_methods($userManager));
        $csvfile = $input->getArgument('csv');
	$output->writeln('CSV Import : '.$csvfile);
	$f = fopen($csvfile, "r");
	if($f === FALSE) {
		// TODO : Throw exception
		$output->writeln('ERROR can not open '.$csvfile);
		return FALSE;
	}
	$headers = fgetcsv($f);       // delimiter ,
	while(!feof($f)) {
		$a = fgetcsv($f);	// delimiter ,
		$email = trim($a[4]);
		if($email == '') continue;
		$output->writeln(print_r($a, true));
		$user = $userManager->findUserByEmail($email);
		if(is_null($user)) {
			$user = $userManager->createUser($email);
			// Horodateur
			// Civilité
			// Nom
			// Prénom
			// Email
			// Date de naissance
			// Téléphone
			// Présentez-vous
			// Type d'usage
			// Présentation de votre projet
			// Durée d'occupation
			// Surface en m²
			// Date de disponibilité souhaitée
			// Nom de votre structure
			// Statut
			// Date de création
			// Adresse
			// Code postal
			// Ville
			// Site web
			// Facebook
			// Twitter
			// Linkedin
			// Instagram
			// Viadeo
			// Google +
			// Acceptez-vous de recevoir la newsletter de l'association?

			//$userManager->updateUser($user);
		} else {
			$output->writeln("User already in base : $email");
		}
		break;
	}
	fclose($f);
    }
}


<?php
namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

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
	//$output->writeln(get_class_methods($userManager));
	$useTypeRepo = $this->getContainer()->get('doctrine')->getManager()->getRepository('AppBundle:UseType');
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
		$email = strtolower(trim($a[4]));
		if($email == '') continue;
		//$output->writeln(print_r($a, true));
		$user = $userManager->findUserByEmail($email);
		if(is_null($user)) {
			$user = $userManager->createUser($email);
			$user->setTypeUser(0);	// 0 : porteur de projet
			// Horodateur
			$user->setCivility(str_replace('.','',$a[1]));	// Civilité
			$user->setLastName($a[2]);	// Nom
			$user->setFirstName($a[3]);	// Prénom
			$user->setEmail($email);	// Email
			//$user->setDateOfBirth(new \DateTime(str_replace('/','-',$a[5])));	// Date de naissance
			//$user->setDateOfBirth(ImportUserCommand::convDate($a[5]));	// Date de naissance
			$user->setBirthDay(ImportUserCommand::convDate($a[5]));	// Date de naissance
			$phone = trim($a[6]);		// Téléphone
			if(strlen($phone) == 9 && $phone[0] != '0') $phone = '0'.$phone;
			else if(substr($phone, 0, 2) == 33) $phone = '+'.$phone;
			$user->setPhone($phone);
			//$output->writeln($phone);
			$user->setDescription($a[7]);	// Présentez-vous
			$useTypeStr = trim($a[8]);	// Type d'usage
			$u = $useTypeRepo->findOneByName($useTypeStr);
			if(!is_null($u)) $user->setUseType($u);
			else $output->writeln("use type $useTypeStr not found");
			$user->setProjectDescription($a[9]);	// Présentation de votre projet
			$duree = $a[10];	// Durée d'occupation
			foreach(explode(' ',$duree) as $item) {
				if(is_numeric($item)) $user->setUsageDuration(intval($item));
				else switch(strtolower($item)) {
				case 'an':
				case 'ans':
					$user->setLengthTypeOccupation('ans');
					break;
				case 'mois':
					$user->setLengthTypeOccupation('mois');
					break;
				}
			}
			$surface = $a[11];	// Surface en m²
			foreach(explode(' ',$surface) as $item) {
				if(is_numeric($item)) $user->setWishedSize(intval($item));
			}
			$user->setUsageDate(ImportUserCommand::convDate($a[12]));	// Date de disponibilité souhaitée
			$user->setCompany($a[13]);	// Nom de votre structure
			$user->setCompanyStatus($a[14]);// Statut
			$user->setCompanyCreationDate(ImportUserCommand::convDate($a[15]));	// Date de création
			$user->setAddress($a[16]);	// Adresse
			//$user->setAddressSuite()
			$user->setZipcode($a[17]);	// Code postal
			$user->setCity($a[18]);		// Ville
			$user->setCompanySite($a[19]);	// Site web
			$user->setFacebookUrl($a[20]);	// Facebook
			$user->setTwitterUrl($a[21]);	// Twitter
			$user->setLinkedinUrl($a[22]);	// Linkedin
			$user->setInstagramUrl($a[23]);	// Instagram
			//$user->setViadeo// Viadeo
			$user->setGoogleUrl($a[25]);	// Google +
			$newsletter = strtoupper(substr($a[26],0,1)); // Acceptez-vous de recevoir la newsletter de l'association?
			$user->setNewsletter($newsletter != 'N');
			//$output->writeln(get_class_methods($user));
			$user->setPlainPassword(md5(time().rand()));
			$this->sendEmail($user, $output);
			$userManager->updateUser($user);
		} else {
			$output->writeln("User already in base : $email");
			$this->sendEmail($user, $output);
			//$userManager->updateUser($user);
		}
		break;	// STOP AFTER 1ST USER
	}
	fclose($f);
    }

    static function convDate($str)
    {
	$d = explode('/', $str);
	if(count($d) == 0) return NULL;
	return new \DateTime(implode('/', array_reverse($d)));
    }

    function sendEmail(\AppBundle\Entity\User $user, OutputInterface $output)
    {
	$output->writeln("Trying to send email to : ".$user->getEmail());
	//$ttl = $this->getContainer()->getParameter('fos_user.resetting.token_ttl');
	//$output->writeln("TTL = $ttl");
	if (null === $user->getConfirmationToken()) {
		$tokenGenerator = $this->getContainer()->get('fos_user.util.token_generator');
		$token = $tokenGenerator->generateToken();
		$output->writeln("token = $token");
		$user->setConfirmationToken($token);
	}
	$user->setPasswordRequestedAt(new \DateTime());
	//$mailer = $this->getContainer()->get('fos_user.mailer');
	$base_url = $this->getContainer()->getParameter('base_url');
	$from = $this->getContainer()->getParameter('mail_confirmation_from');
	$router = $this->getContainer()->get('router');
	$router->getContext()->setHost($base_url);
	if($base_url != 'pu.plateau-urbain.com') {
		$router->getContext()->setScheme('https'); // PROD en HTTPS
	}
	$url = $router->generate('fos_user_resetting_reset', array('token' => $user->getConfirmationToken()), UrlGeneratorInterface::ABSOLUTE_URL);
	$homeurl = $router->generate('homepage', array(), UrlGeneratorInterface::ABSOLUTE_URL);
	$output->writeln("URL = $url");
	//$output->writeln("   $homeurl");
	// protected method !!!
	//$mailer->sendEmailMessage("ceci est un test\n$url",
	//                          $mailer->parameters['from_email']['resetting'],
	//                          (string) $user->getEmail());
	//$mailer->sendResettingEmailMessage($user); // does not work ?
	$templating = $this->getContainer()->get('templating');
	$message = \Swift_Message::newInstance();
	$message->setSubject('Votre inscription à la plateforme Plateau-Urbain');
	$message->setFrom($from);
	$message->setTo($user->getEmail());
	$message->setBody($templating->render('AppBundle/views/Email/confirm.html.twig',
	                           array('url'=>$url, 'email'=>$user->getEmail(), 'homeurl'=>$homeurl)),
	                           'text/html');
	$message->addPart($templating->render('AppBundle/views/Email/confirm.txt.twig',
	                           array('url'=>$url, 'email'=>$user->getEmail(), 'homeurl'=>$homeurl)),
	                           'text/plain');
	$this->getContainer()->get('mailer')->send($message);
    }
}


<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use AppBundle\Entity\Application;
use AppBundle\Entity\User;
use AppBundle\Entity\Space;
use AppBundle\Entity\Category;

class GenerateFakeApplicationsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:generate-fake-applications')
            ->setDescription('Génère des candidatures fake pour un appel à candidatures')
            ->addArgument('space-id', InputArgument::REQUIRED, 'ID de l\'espace (AAC)')
            ->addOption('count', 'c', InputOption::VALUE_OPTIONAL, 'Nombre de candidatures à créer', 10)
            ->addOption('status', 's', InputOption::VALUE_OPTIONAL, 'Statut spécifique (draft, unread, awaiting, accepted, rejected) ou "random" pour mélanger', 'random')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $spaceId = $input->getArgument('space-id');
        $count = (int) $input->getOption('count');
        $statusOption = $input->getOption('status');

        $em = $this->getContainer()->get('doctrine')->getManager();
        $userManager = $this->getContainer()->get('fos_user.user_manager');

        // Récupérer l'espace
        $space = $em->getRepository('AppBundle:Space')->find($spaceId);
        if (!$space) {
            $output->writeln("<error>Espace avec l'ID $spaceId introuvable.</error>");
            return 1;
        }

        $output->writeln("<info>Génération de $count candidatures fake pour l'espace: {$space->getName()}</info>");

        // Récupérer les catégories disponibles
        $categories = $em->getRepository('AppBundle:Category')->findAll();
        if (empty($categories)) {
            $output->writeln("<error>Aucune catégorie trouvée. Veuillez créer des catégories d'abord.</error>");
            return 1;
        }

        // Statuts possibles
        $statuses = [
            Application::DRAFT_STATUS,
            Application::UNREAD_STATUS,
            Application::WAIT_STATUS,
            Application::ACCEPT_STATUS,
            Application::REJECT_STATUS
        ];

        // Déterminer le statut à utiliser
        if ($statusOption === 'random') {
            $useRandomStatus = true;
        } else {
            $useRandomStatus = false;
            if (!in_array($statusOption, $statuses)) {
                $output->writeln("<error>Statut invalide: $statusOption</error>");
                return 1;
            }
        }

        // Noms et prénoms fictifs
        $firstNames = ['Jean', 'Marie', 'Pierre', 'Sophie', 'Luc', 'Julie', 'Thomas', 'Camille', 'Antoine', 'Emma', 'Nicolas', 'Laura', 'David', 'Sarah', 'Julien', 'Claire'];
        $lastNames = ['Dupont', 'Martin', 'Bernard', 'Dubois', 'Thomas', 'Robert', 'Richard', 'Petit', 'Durand', 'Leroy', 'Moreau', 'Simon', 'Laurent', 'Lefebvre', 'Michel', 'Garcia'];
        $companies = ['Tech Solutions', 'Innovation Lab', 'Creative Studio', 'Digital Agency', 'Startup Hub', 'Business Center', 'Co-working Space', 'Design Studio', 'Marketing Pro', 'Consulting Group'];
        $projectNames = ['Projet Innovant', 'Startup Tech', 'Studio Créatif', 'Agence Digital', 'Espace Co-working', 'Lab Innovation', 'Centre Business', 'Studio Design', 'Pro Marketing', 'Groupe Consulting'];

        $created = 0;
        $skipped = 0;

        for ($i = 1; $i <= $count; $i++) {
            // Générer un email unique
            $email = "fake.candidature.{$spaceId}.{$i}@test.local";
            
            // Vérifier si l'utilisateur existe déjà
            $user = $userManager->findUserByEmail($email);
            if ($user) {
                $output->writeln("<comment>Utilisateur $email existe déjà, passage au suivant...</comment>");
                $skipped++;
                continue;
            }

            // Créer l'utilisateur fake
            $user = $userManager->createUser();
            $user->setEmail($email);
            $user->setUsername($email);
            $user->setEnabled(true);
            $user->setTypeUser(User::PORTEUR); // Porteur de projet
            
            // Données aléatoires
            $firstName = $firstNames[array_rand($firstNames)];
            $lastName = $lastNames[array_rand($lastNames)];
            $user->setFirstname($firstName);
            $user->setLastname($lastName);
            $user->setCivility(User::MISTER);
            $user->setCompany($companies[array_rand($companies)] . ' ' . $i);
            $user->setCompanyStatus('SARL');
            $user->setAddress('123 Rue de Test');
            $user->setZipcode('75001');
            $user->setCity('Paris');
            $user->setCompanyPhone('01' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT));
            $user->setCompanyDescription("Description de l'entreprise fake numéro $i");
            $user->setProjectDescription("Projet de test numéro $i pour l'espace {$space->getName()}");
            $user->setUsageDuration(rand(6, 36));
            $user->setLengthTypeOccupation(Application::MONTH_TYPE);
            $user->setWishedSize(rand(20, 200));
            $user->setUsageDate(new \DateTime('+' . rand(1, 12) . ' months'));
            
            // Mot de passe aléatoire (ne sera jamais utilisé)
            $user->setPlainPassword(uniqid('fake', true));
            $userManager->updateUser($user);

            // Créer la candidature
            $application = new Application();
            $application->setSpace($space);
            $application->setProjectHolder($user);
            $application->setName($projectNames[array_rand($projectNames)] . ' ' . $i);
            $application->setDescription("Candidature fake numéro $i pour tester le système. Cette candidature a été générée automatiquement.");
            $application->setCategory($categories[array_rand($categories)]);
            $application->setWishedSize(rand(20, 200));
            $application->setLengthOccupation(rand(6, 36));
            $application->setLengthTypeOccupation(Application::MONTH_TYPE);
            $application->setStartOccupation(new \DateTime('+' . rand(1, 12) . ' months'));
            $application->setOpenToGlobalProject(rand(0, 1) === 1);
            if ($application->getOpenToGlobalProject()) {
                $application->setContribution("Contribution au projet global pour la candidature $i");
            }
            $application->setDevenirSocietaire(rand(0, 1) === 1);
            $application->setSelected(false);

            // Définir le statut
            if ($useRandomStatus) {
                $status = $statuses[array_rand($statuses)];
            } else {
                $status = $statusOption;
            }
            $application->setStatus($status);

            $em->persist($application);
            $em->flush();

            $created++;
            $output->writeln("<info>✓ Candidature $i/$count créée: $email (statut: {$status})</info>");
        }

        $output->writeln("");
        $output->writeln("<info>Terminé! $created candidatures créées, $skipped ignorées (déjà existantes)</info>");
        
        return 0;
    }
}

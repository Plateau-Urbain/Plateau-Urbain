<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use AppBundle\Entity\User;

class CheckUserRolesCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:check-user-roles')
            ->setDescription('Vérifie les rôles d\'un utilisateur')
            ->addArgument('email', InputArgument::REQUIRED, 'Email de l\'utilisateur');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $email = $input->getArgument('email');
        
        $em = $this->getContainer()->get('doctrine')->getManager();
        $user = $em->getRepository('AppBundle:User')->findOneBy(['email' => $email]);
        
        if (!$user) {
            $output->writeln("<error>Utilisateur non trouvé avec l'email: $email</error>");
            return 1;
        }
        
        $output->writeln("<info>=== Informations utilisateur ===</info>");
        $output->writeln("ID: " . $user->getId());
        $output->writeln("Email: " . $user->getEmail());
        $output->writeln("Username: " . $user->getUsername());
        $output->writeln("TypeUser: " . $user->getTypeUser());
        $output->writeln("Enabled: " . ($user->isEnabled() ? 'Oui' : 'Non'));
        $output->writeln("Locked: " . ($user->isAccountNonLocked() ? 'Non' : 'Oui'));
        
        $output->writeln("\n<info>=== Rôles ===</info>");
        $roles = $user->getRoles();
        foreach ($roles as $role) {
            $output->writeln("- $role");
        }
        
        $output->writeln("\n<info>=== Méthodes de vérification ===</info>");
        $output->writeln("isProprio(): " . ($user->isProprio() ? 'Oui' : 'Non'));
        $output->writeln("isPorteur(): " . ($user->isPorteur() ? 'Oui' : 'Non'));
        
        $output->writeln("\n<info>=== Vérifications de sécurité ===</info>");
        $securityContext = $this->getContainer()->get('security.authorization_checker');
        
        // Simuler l'utilisateur connecté
        $token = new \Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken(
            $user, null, 'main', $user->getRoles()
        );
        $this->getContainer()->get('security.token_storage')->setToken($token);
        
        $output->writeln("ROLE_USER: " . ($securityContext->isGranted('ROLE_USER') ? 'Oui' : 'Non'));
        $output->writeln("ROLE_OWNER: " . ($securityContext->isGranted('ROLE_OWNER') ? 'Oui' : 'Non'));
        $output->writeln("ROLE_ADMIN: " . ($securityContext->isGranted('ROLE_ADMIN') ? 'Oui' : 'Non'));
        
        $output->writeln("\n<info>=== Espaces de l'utilisateur ===</info>");
        $spaces = $em->getRepository('AppBundle:Space')->findBy(['owner' => $user]);
        $output->writeln("Nombre d'espaces: " . count($spaces));
        
        foreach ($spaces as $space) {
            $output->writeln("- ID: " . $space->getId() . ", Nom: " . $space->getName() . ", Enabled: " . ($space->isEnabled() ? 'Oui' : 'Non'));
        }
        
        return 0;
    }
}

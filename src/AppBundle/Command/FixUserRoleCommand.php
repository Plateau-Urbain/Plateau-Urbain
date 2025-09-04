<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use AppBundle\Entity\User;

class FixUserRoleCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:fix-user-role')
            ->setDescription('Corrige les rôles des utilisateurs propriétaires')
            ->addArgument('email', InputArgument::OPTIONAL, 'Email de l\'utilisateur spécifique')
            ->addOption('all', null, InputOption::VALUE_NONE, 'Corriger tous les utilisateurs propriétaires');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $email = $input->getArgument('email');
        $fixAll = $input->getOption('all');
        
        if ($email) {
            // Corriger un utilisateur spécifique
            $user = $em->getRepository('AppBundle:User')->findOneBy(['email' => $email]);
            if (!$user) {
                $output->writeln("<error>Utilisateur non trouvé avec l'email: $email</error>");
                return 1;
            }
            $this->fixUserRole($user, $output);
        } elseif ($fixAll) {
            // Corriger tous les utilisateurs propriétaires
            $users = $em->getRepository('AppBundle:User')->findBy(['typeUser' => User::PROPRIO]);
            $output->writeln("<info>Correction de " . count($users) . " utilisateurs propriétaires...</info>");
            
            foreach ($users as $user) {
                $this->fixUserRole($user, $output);
            }
        } else {
            $output->writeln("<error>Veuillez spécifier un email ou utiliser --all</error>");
            return 1;
        }
        
        $em->flush();
        $output->writeln("<info>Correction terminée !</info>");
        
        return 0;
    }
    
    private function fixUserRole(User $user, OutputInterface $output)
    {
        $roles = $user->getRoles();
        
        if (!in_array('ROLE_OWNER', $roles)) {
            $user->addRole('ROLE_OWNER');
            $output->writeln("<info>✓ Ajouté ROLE_OWNER à " . $user->getEmail() . "</info>");
        } else {
            $output->writeln("<comment>- " . $user->getEmail() . " a déjà ROLE_OWNER</comment>");
        }
    }
}

<?php

namespace AppBundle\Command;

use AppBundle\Entity\Space;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ListSpacesWithDocumentsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:list-spaces-with-documents')
            ->setDescription('List spaces that have required documents')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        
        $spaces = $em->getRepository(Space::class)->findAll();
        
        $io->title('Espaces avec documents obligatoires');
        
        $spacesWithDocs = [];
        foreach ($spaces as $space) {
            $documents = $space->getDocuments();
            if (count($documents) > 0) {
                $spacesWithDocs[] = [
                    'id' => $space->getId(),
                    'name' => $space->getName(),
                    'documents_count' => count($documents),
                    'enabled' => $space->isEnabled() ? 'OUI' : 'NON',
                    'closed' => $space->isClosed() ? 'OUI' : 'NON'
                ];
            }
        }
        
        if (empty($spacesWithDocs)) {
            $io->warning('Aucun espace avec des documents obligatoires trouvé');
            return 0;
        }
        
        $io->table(
            ['ID', 'Nom', 'Documents', 'Publié', 'Fermé'],
            array_map(function($space) {
                return [
                    $space['id'],
                    $space['name'],
                    $space['documents_count'],
                    $space['enabled'],
                    $space['closed']
                ];
            }, $spacesWithDocs)
        );
        
        $io->note('Utilisez: php app/console app:test-document-validation [ID_ESPACE] pour tester la validation');
        
        return 0;
    }
}

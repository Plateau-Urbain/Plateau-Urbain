<?php

namespace AppBundle\Controller\Admin;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;

class SpaceAdminController extends CRUDController
{


    /**
     * Action de suppression en lot personnalisée pour gérer les applications associées
     */
    public function batchActionDelete(ProxyQueryInterface $query)
    {
        $this->admin->checkAccess('batchDelete');
        
        $em = $this->getDoctrine()->getManager();
        
        // Récupérer les Spaces sélectionnés
        $spaces = $query->execute();
        $spaceIds = array();
        
        foreach ($spaces as $space) {
            $spaceIds[] = $space->getId();
        }
        
        if (empty($spaceIds)) {
            $this->addFlash('sonata_flash_info', 'Aucun espace sélectionné.');
            return new RedirectResponse($this->admin->generateUrl('list'));
        }
        
        // Récupérer toutes les applications associées aux Spaces
        $applications = $em->getRepository('AppBundle:Application')->createQueryBuilder('a')
            ->where('a.space IN (:spaceIds)')
            ->setParameter('spaceIds', $spaceIds)
            ->getQuery()
            ->getResult();
        
        // Récupérer les IDs des applications
        $applicationIds = array();
        foreach ($applications as $application) {
            $applicationIds[] = $application->getId();
        }
        
        $nbApplications = count($applicationIds);
        $conn = $em->getConnection();

        $conn->beginTransaction();
        try {
            if (!empty($applicationIds)) {
                // Supprimer tous les fichiers d'application associés
                $em->createQueryBuilder()
                   ->delete('AppBundle:ApplicationFile', 'af')
                   ->where('af.application IN (:applicationIds)')
                   ->setParameter('applicationIds', $applicationIds)
                   ->getQuery()
                   ->execute();

                // Décommenter la ligne ci-dessous pour tester le rollback (puis la remettre en commentaire)
                // throw new \Exception('Test rollback transaction');

                // Supprimer toutes les applications
                $em->createQueryBuilder()
                   ->delete('AppBundle:Application', 'a')
                   ->where('a.id IN (:applicationIds)')
                   ->setParameter('applicationIds', $applicationIds)
                   ->getQuery()
                   ->execute();
            }

            // Supprimer les Spaces
            $nbDeleted = 0;
            foreach ($spaces as $space) {
                $em->remove($space);
                $nbDeleted++;
            }

            $em->flush();
            $conn->commit();
        } catch (\Exception $e) {
            $conn->rollBack();
            $em->clear();
            $this->addFlash('sonata_flash_error', 'Erreur lors de la suppression en lot : ' . $e->getMessage());
            return new RedirectResponse($this->admin->generateUrl('list'));
        }
        
        if ($nbApplications > 0) {
            $this->addFlash(
                'sonata_flash_success',
                sprintf('%d espace(s) supprimé(s) avec %d candidature(s) associée(s).', $nbDeleted, $nbApplications)
            );
        } else {
            $this->addFlash(
                'sonata_flash_success',
                sprintf('%d espace(s) supprimé(s).', $nbDeleted)
            );
        }
        
        return new RedirectResponse($this->admin->generateUrl('list'));
    }
}

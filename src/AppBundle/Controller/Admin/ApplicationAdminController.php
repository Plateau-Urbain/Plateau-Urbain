<?php

namespace AppBundle\Controller\Admin;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Sonata\Exporter\Writer\CsvWriter;

class ApplicationAdminController extends CRUDController
{
    /**
     * Action pour afficher l'aide sur les filtres et l'export
     */
    public function helpFiltersAction()
    {
        return $this->renderWithExtraParams('AppBundle:Admin/Application:help_filters.html.twig', [
            'action' => 'list',
        ]);
    }
    
    /**
     * Action pour sélectionner les champs à exporter
     */
    public function selectExportFieldsAction(Request $request)
    {
        // Récupérer tous les champs disponibles
        $availableFields = $this->getAllAvailableFields();
        
        // IMPORTANT: Récupérer TOUS les paramètres de l'URL (filtres + pagination + tri)
        // car getFilterParameters() de Sonata ne retourne que _sort_by, _sort_order, etc.
        $filterParameters = $request->query->all();
        
        // Debug: logger les paramètres reçus
        $logger = $this->get('logger');
        $logger->info('selectExportFieldsAction - Paramètres complets', [
            'all_params' => $filterParameters,
            'request_uri' => $request->getRequestUri()
        ]);
        
        if ($request->isMethod('POST')) {
            $selectedFields = $request->request->get('fields', []);
            
            // Debug: logger ce qui est reçu
            $logger = $this->get('logger');
            $logger->info('Champs sélectionnés pour export:', ['fields' => $selectedFields, 'filters' => $filterParameters]);
            
            if (empty($selectedFields)) {
                $this->addFlash('sonata_flash_error', 'Veuillez sélectionner au moins un champ à exporter.');
                return $this->renderWithExtraParams('AppBundle:Admin/Application:select_export_fields.html.twig', [
                    'availableFields' => $availableFields,
                    'action' => 'list',
                    'filterParameters' => $filterParameters,
                ]);
            }
            
            // Préparer les paramètres pour l'export en conservant les filtres
            $exportParams = array_merge(
                ['fields' => implode(',', $selectedFields)],
                $filterParameters
            );
            
            // Rediriger vers l'export avec les champs sélectionnés ET les filtres
            return $this->redirect($this->admin->generateUrl('custom_export', $exportParams));
        }
        
        return $this->renderWithExtraParams('AppBundle:Admin/Application:select_export_fields.html.twig', [
            'availableFields' => $availableFields,
            'action' => 'list',
            'filterParameters' => $filterParameters,
        ]);
    }
    
    /**
     * Action d'export personnalisée avec les champs sélectionnés
     */
    public function customExportAction(Request $request)
    {
        $fieldsParam = $request->query->get('fields', '');
        $selectedFieldKeys = array_filter(explode(',', $fieldsParam));
        
        // Debug log
        $logger = $this->get('logger');
        $logger->info('customExportAction appelée', [
            'fields_param' => $fieldsParam,
            'selected_keys' => $selectedFieldKeys,
            'all_query_params' => $request->query->all()
        ]);
        
        if (empty($selectedFieldKeys)) {
            $this->addFlash('sonata_flash_error', 'Aucun champ sélectionné pour l\'export.');
            $logger->warning('Export annulé: aucun champ sélectionné');
            return $this->redirectToList();
        }
        
        // Récupérer tous les champs disponibles
        $allFields = $this->getAllAvailableFields();
        
        // Construire le tableau des champs à exporter
        $exportFields = [];
        foreach ($selectedFieldKeys as $key) {
            if (isset($allFields[$key])) {
                $exportFields[$allFields[$key]['label']] = $allFields[$key]['property'];
            }
        }
        
        $logger->info('Champs à exporter', ['fields' => $exportFields]);
        
        // Récupérer le datagrid
        $datagrid = $this->admin->getDatagrid();
        
        // Appliquer les filtres manuellement depuis les paramètres de l'URL
        $queryParams = $request->query->all();
        $logger->info('Paramètres de requête pour filtres', ['params' => $queryParams]);
        
        // Parcourir les filtres et les appliquer au datagrid
        foreach ($queryParams as $filterName => $filterData) {
            // Ignorer les paramètres système et fields
            if (in_array($filterName, ['_page', '_sort_by', '_sort_order', '_per_page', 'fields'])) {
                continue;
            }
            
            // Si c'est un filtre avec une valeur
            if (is_array($filterData) && isset($filterData['value'])) {
                $value = $filterData['value'];
                
                // Vérifier si la valeur est réellement non vide
                // Pour les valeurs simples (string, number)
                if (is_string($value) || is_numeric($value)) {
                    if ($value !== '' && $value !== null) {
                        $filter = $datagrid->getFilter($filterName);
                        if ($filter) {
                            $filter->apply($datagrid->getQuery(), $filterData);
                            $logger->info("Filtre appliqué: $filterName", ['value' => $value]);
                        }
                    }
                }
                // Pour les tableaux (comme les dates), vérifier qu'il y a des valeurs non vides
                elseif (is_array($value)) {
                    // Pour les dates de type range (start/end)
                    $hasValidValue = false;
                    if (isset($value['start']) && is_array($value['start'])) {
                        // Date range
                        if (!empty($value['start']['day']) || !empty($value['start']['month']) || !empty($value['start']['year'])) {
                            $hasValidValue = true;
                        }
                        if (isset($value['end']) && (!empty($value['end']['day']) || !empty($value['end']['month']) || !empty($value['end']['year']))) {
                            $hasValidValue = true;
                        }
                    } else {
                        // Date simple ou autre tableau
                        if (!empty($value['day']) || !empty($value['month']) || !empty($value['year'])) {
                            $hasValidValue = true;
                        }
                        // Pour les autres tableaux, vérifier s'il y a des valeurs non vides
                        foreach ($value as $v) {
                            if (!empty($v)) {
                                $hasValidValue = true;
                                break;
                            }
                        }
                    }
                    
                    if ($hasValidValue) {
                        $filter = $datagrid->getFilter($filterName);
                        if ($filter) {
                            $filter->apply($datagrid->getQuery(), $filterData);
                            $logger->info("Filtre date appliqué: $filterName", ['value' => $value]);
                        }
                    }
                }
            }
        }
        
        $datagrid->buildPager();
        
        // Obtenir le nombre de résultats via le Pager
        $pager = $datagrid->getPager();
        $resultCount = $pager->getNbResults();
        
        $logger->info('Datagrid construit avec filtres manuels', [
            'result_count' => $resultCount
        ]);
        
        // Utiliser le ModelManager de Sonata pour créer l'itérateur
        $sourceIterator = $this->admin->getModelManager()->getDataSourceIterator($datagrid, $exportFields);
        $sourceIterator->setDateTimeFormat('d/m/Y H:i');
        
        // Préparer le CSV
        $writer = new CsvWriter('php://output');
        $filename = 'export_candidatures_' . date('Y-m-d_H-i-s') . '.csv';
        
        $callback = function () use ($sourceIterator, $writer) {
            // Pour Sonata Exporter moderne
            $handler = \Sonata\Exporter\Handler::create($sourceIterator, $writer);
            $handler->export();
        };
        
        return new StreamedResponse($callback, 200, [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => sprintf('attachment; filename="%s"', $filename),
        ]);
    }
    
    /**
     * Retourne tous les champs disponibles pour l'export
     */
    private function getAllAvailableFields()
    {
        return [
            // Informations générales
            'id' => [
                'label' => 'ID',
                'property' => 'id',
                'category' => 'Informations générales'
            ],
            'name' => [
                'label' => 'Nom du projet',
                'property' => 'name',
                'category' => 'Informations générales'
            ],
            'status' => [
                'label' => 'Statut',
                'property' => 'statusLabel',
                'category' => 'Informations générales'
            ],
            'selected' => [
                'label' => 'Sélectionné',
                'property' => 'selected',
                'category' => 'Informations générales'
            ],
            'created' => [
                'label' => 'Date de création',
                'property' => 'created',
                'category' => 'Informations générales'
            ],
            'updated' => [
                'label' => 'Date de mise à jour',
                'property' => 'updated',
                'category' => 'Informations générales'
            ],
            
            // Informations sur le projet
            'description' => [
                'label' => 'Description du projet',
                'property' => 'description',
                'category' => 'Informations sur le projet'
            ],
            'category' => [
                'label' => 'Catégorie du projet',
                'property' => 'category',
                'category' => 'Informations sur le projet'
            ],
            'contribution' => [
                'label' => 'Contribution au projet du propriétaire',
                'property' => 'contribution',
                'category' => 'Informations sur le projet'
            ],
            'openToGlobalProject' => [
                'label' => 'Ouvert au projet collectif',
                'property' => 'openToGlobalProject',
                'category' => 'Informations sur le projet'
            ],
            'devenirSocietaire' => [
                'label' => 'Souhaite devenir sociétaire',
                'property' => 'devenirSocietaire',
                'category' => 'Informations sur le projet'
            ],
            
            // Informations sur l'occupation
            'wishedSize' => [
                'label' => 'Surface souhaitée (m²)',
                'property' => 'wishedSize',
                'category' => 'Occupation'
            ],
            'lengthOccupation' => [
                'label' => 'Durée d\'occupation',
                'property' => 'lengthOccupation',
                'category' => 'Occupation'
            ],
            'lengthTypeOccupation' => [
                'label' => 'Type de durée',
                'property' => 'lengthTypeOccupation',
                'category' => 'Occupation'
            ],
            'fullLengthOccupation' => [
                'label' => 'Durée complète',
                'property' => 'fullLengthOccupation',
                'category' => 'Occupation'
            ],
            'startOccupation' => [
                'label' => 'Date d\'entrée souhaitée',
                'property' => 'startOccupation',
                'category' => 'Occupation'
            ],
            
            // Informations sur l'espace
            'space' => [
                'label' => 'Espace',
                'property' => 'space',
                'category' => 'Espace'
            ],
            
            // Informations sur le porteur de projet
            'projectHolder_fullName' => [
                'label' => 'Nom complet du porteur',
                'property' => 'projectHolder.fullName',
                'category' => 'Porteur de projet'
            ],
            'projectHolder_email' => [
                'label' => 'Email du porteur',
                'property' => 'projectHolder.email',
                'category' => 'Porteur de projet'
            ],
            'projectHolder_company' => [
                'label' => 'Nom de la structure',
                'property' => 'projectHolder.company',
                'category' => 'Porteur de projet'
            ],
            'projectHolder_companyPhone' => [
                'label' => 'Téléphone',
                'property' => 'projectHolder.companyPhone',
                'category' => 'Porteur de projet'
            ],
            'projectHolder_companyDescription' => [
                'label' => 'Présentation de la structure',
                'property' => 'projectHolder.companyDescription',
                'category' => 'Porteur de projet'
            ],
            'projectHolder_facebookUrl' => [
                'label' => 'Facebook',
                'property' => 'projectHolder.facebookUrl',
                'category' => 'Porteur de projet'
            ],
            'projectHolder_twitterUrl' => [
                'label' => 'Twitter',
                'property' => 'projectHolder.twitterUrl',
                'category' => 'Porteur de projet'
            ],
            'projectHolder_instagramUrl' => [
                'label' => 'Instagram',
                'property' => 'projectHolder.instagramUrl',
                'category' => 'Porteur de projet'
            ],
            'projectHolder_googleUrl' => [
                'label' => 'Google+',
                'property' => 'projectHolder.googleUrl',
                'category' => 'Porteur de projet'
            ],
            'projectHolder_linkedinUrl' => [
                'label' => 'LinkedIn',
                'property' => 'projectHolder.linkedinUrl',
                'category' => 'Porteur de projet'
            ],
            'projectHolder_otherUrl' => [
                'label' => 'Autre URL',
                'property' => 'projectHolder.otherUrl',
                'category' => 'Porteur de projet'
            ],
        ];
    }
}

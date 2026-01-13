# Export ZIP des Candidatures avec Documents

## Vue d'ensemble

Cette fonctionnalité permet aux propriétaires d'espaces et aux administrateurs d'exporter toutes les candidatures d'un espace dans un fichier ZIP organisé, contenant pour chaque candidature :
- Un récapitulatif HTML détaillé
- Tous les documents attachés à la candidature
- Les documents du profil utilisateur (si disponibles)

## Fonctionnalités

### Export organisé par candidature
- **Structure du ZIP** : Un répertoire par candidature nommé `NomCandidat_NomStructure`
- **Récapitulatif** : Fichier HTML `recapitulatif.html` dans chaque dossier
- **Documents** : Organisés dans des sous-dossiers :
  - `documents_candidature/` : Documents spécifiques à la candidature
  - `documents_profil/` : Documents du profil utilisateur (KBIS, pièce d'identité, etc.)

### Contenu du récapitulatif HTML
- Informations générales de la candidature (statut, date, nom du projet)
- Informations complètes du porteur de projet
- Détails du projet (description, surface, durée, etc.)
- Liste des documents joints
- Informations de l'espace concerné

## Utilisation

### Export de toutes les candidatures
1. Se connecter à l'interface de gestion des espaces
2. Aller sur la page des candidatures d'un espace
3. Cliquer sur le bouton **"Exporter avec documents"**
4. Le fichier ZIP se télécharge automatiquement

### Export sélectif des candidatures
1. Se connecter à l'interface de gestion des espaces
2. Aller sur la page des candidatures d'un espace
3. **Sélectionner les candidatures** à exporter :
   - Cocher individuellement les candidatures souhaitées
   - Ou utiliser les boutons de sélection rapide :
     - **"Tout sélectionner"** : Sélectionne toutes les candidatures
     - **"Tout désélectionner"** : Désélectionne toutes les candidatures
     - **"Sélectionner acceptées"** : Sélectionne uniquement les candidatures acceptées
     - **"Sélectionner refusées"** : Sélectionne uniquement les candidatures refusées
4. Cliquer sur **"Exporter sélection (X)"** où X est le nombre de candidatures sélectionnées
5. Le fichier ZIP se télécharge automatiquement

### Pour les administrateurs
- Même procédure que pour les propriétaires
- Accès à tous les espaces du système

## Structure du fichier ZIP généré

```
export_candidatures_NomEspace_2024-01-15_14-30-25.zip
├── Jean_Dupont_Entreprise_ABC/
│   ├── recapitulatif.html
│   ├── documents_candidature/
│   │   ├── Business_plan_ABC.pdf
│   │   └── Presentation_projet.pptx
│   └── documents_profil/
│       ├── KBIS_entreprise_abc.pdf
│       └── Piece_identite_jean_dupont.pdf
├── Marie_Martin_Startup_XYZ/
│   ├── recapitulatif.html
│   ├── documents_candidature/
│   │   └── Dossier_technique.pdf
│   └── documents_profil/
│       └── KBIS_startup_xyz.pdf
└── ...
```

## Filtres appliqués

L'export respecte les mêmes filtres que l'export CSV existant :
- **Tri** : Par date de création (défaut) ou autre critère
- **Ordre** : Croissant ou décroissant
- **Statut** : Toutes les candidatures ou filtrées par statut

## Sécurité et permissions

- **Vérification des droits** : Seuls les propriétaires d'espaces et les administrateurs peuvent exporter
- **Validation des fichiers** : Vérification de l'existence des fichiers avant inclusion
- **Noms de fichiers sécurisés** : Nettoyage automatique des caractères spéciaux

## Limitations techniques

- **Taille des fichiers** : Limite de 20MB par document (configurée dans l'entité ApplicationFile)
- **Taille du ZIP** : Dépend de la taille totale des documents
- **Temps de génération** : Peut être long pour les espaces avec beaucoup de candidatures et documents

## Fonctionnalités de sélection

### Interface de sélection
- **Cases à cocher** : Une case à cocher pour chaque candidature
- **Compteur en temps réel** : Affichage du nombre de candidatures sélectionnées
- **Bouton d'export dynamique** : Activé uniquement quand des candidatures sont sélectionnées
- **Sélection par statut** : Boutons pour sélectionner rapidement par type de candidature

### Sécurité de la sélection
- **Validation côté serveur** : Vérification des IDs de candidatures
- **Token CSRF** : Protection contre les attaques CSRF
- **Vérification des permissions** : Seuls les propriétaires et admins peuvent exporter
- **Validation de l'espace** : Les candidatures doivent appartenir à l'espace concerné

## Fichiers modifiés

### Contrôleur
- `src/AppBundle/Controller/SpaceManagementController.php`
  - Nouvelle action `candidatesExportZipAction()` (export complet)
  - Nouvelle action `candidatesExportZipSelectedAction()` (export sélectif)
  - Méthodes utilitaires `sanitizeFileName()` et `getDocumentTypeLabel()`

### Templates
- `app/Resources/AppBundle/views/SpaceManagement/candidates.html.twig`
  - Ajout du bouton "Exporter avec documents"
  - Ajout du bouton "Exporter sélection" avec compteur
  - Ajout des boutons de sélection rapide
  - Cases à cocher pour toutes les candidatures
  - JavaScript pour la gestion de la sélection
  - CSS pour l'amélioration de l'interface
- `app/Resources/AppBundle/views/SpaceManagement/application_summary.html.twig`
  - Nouveau template pour le récapitulatif HTML

## Configuration requise

- **PHP** : Extension `zip` activée
- **Symfony** : Version 2.x ou 3.x
- **Doctrine** : ORM configuré
- **VichUploaderBundle** : Pour la gestion des fichiers

## Tests

La fonctionnalité a été testée avec :
- ✅ Candidatures existantes avec documents
- ✅ Création de fichiers ZIP
- ✅ Gestion des permissions
- ✅ Nettoyage des noms de fichiers
- ✅ Organisation des documents par type
- ✅ Sélection de candidatures par statut
- ✅ Export sélectif avec validation
- ✅ Interface de sélection interactive
- ✅ Compteur de candidatures sélectionnées

## Maintenance

### Nettoyage automatique
- Les fichiers ZIP temporaires sont automatiquement supprimés après génération
- Pas d'accumulation de fichiers temporaires sur le serveur

### Monitoring
- Surveiller l'espace disque lors d'exports volumineux
- Vérifier les logs en cas d'erreur lors de la génération

## Évolutions possibles

1. **Export PDF** : Convertir le récapitulatif HTML en PDF
2. **Compression** : Optimiser la compression des fichiers
3. **Export asynchrone** : Pour les gros volumes, utiliser un système de queue
4. **Notifications** : Notifier l'utilisateur par email quand l'export est prêt
5. **Historique** : Sauvegarder les exports générés

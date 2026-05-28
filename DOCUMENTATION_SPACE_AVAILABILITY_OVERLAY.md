# Documentation - Branche `feature/space-availability-overlay`

## Vue d'ensemble

Cette branche implémente un système complet de gestion de la disponibilité des espaces avec des fonctionnalités avancées pour les administrateurs et les propriétaires d'espaces. Les modifications apportées permettent une meilleure gestion du cycle de vie des espaces et des candidatures.

## Résumé des commits

La branche contient **14 commits** avec les fonctionnalités suivantes :

1. **Gestion intelligente des candidatures lors de la dépublier d'un espace**
2. **Adaptation des messages de confirmation selon le rôle utilisateur**
3. **Permettre aux propriétaires de publier, dépublier et modifier leurs espaces**
4. **Ajout de commandes pour diagnostiquer et corriger les rôles utilisateurs**
5. **Système de publication des espaces par les admins avec notification email**
6. **Permettre aux admins de voir tous les espaces en front-end avec indicateurs visuels**
7. **Ajout de l'affichage de la disponibilité sur les images des cards**

## Modifications de la base de données

### Migration 1 : Version20250915160603.php
- **Objectif** : Remplacer le champ `surface` par `min_surface` et `max_surface` dans la table `parcel`
- **Changements** :
  - Ajout des champs `min_surface` et `max_surface` (INT NOT NULL DEFAULT 0)
  - Copie de la valeur `surface` vers les nouveaux champs
  - Suppression du champ `surface`

### Migration 2 : Version20250916092058.php
- **Objectif** : Ajouter les champs de gestion des espaces dans la table `space`
- **Changements** :
  - Ajout des champs `nb_spaces`, `min_space`, `max_space` (INT DEFAULT NULL)

## Modifications des entités

### Entité Space
**Nouveaux champs ajoutés :**
- `nbSpaces` : Nombre d'espaces disponibles
- `minSpace` : Surface minimale en m²
- `maxSpace` : Surface maximale en m²

**Nouvelles méthodes :**
- `isPublished()` : Vérifie si l'espace est publié (enabled + submitted)
- `getMinSize()` / `getMaxSize()` : Accesseurs pour les surfaces
- `getDepCode()` : Retourne le code départemental

**Validations ajoutées :**
- Validation de cohérence : `maxSpace >= minSpace`
- Validation des valeurs positives pour les surfaces

### Entité Parcel
**Champs modifiés :**
- Remplacement de `surface` par `minSurface` et `maxSurface`
- Ajout de validations pour les surfaces positives
- Validation de cohérence entre min et max

### Entité Application
**Aucune modification structurelle majeure**, mais amélioration de la gestion des statuts et des validations.

## Modifications des contrôleurs

### SpaceController
**Nouvelles fonctionnalités :**
- `checkStatusAction()` : Endpoint AJAX pour vérifier l'état d'un espace
- Amélioration de la gestion des espaces fermés/suspendus
- Gestion intelligente des candidatures lors de la suspension d'espaces

### SpaceManagementController
**Nouvelles actions :**
- `unpublishAction()` : Dépublier un espace avec gestion des candidatures existantes
- `publishAction()` : Publier un espace avec notifications email
- `removeAction()` : Suppression avec gestion en cascade des candidatures

**Améliorations :**
- Filtres adaptés selon le rôle utilisateur (admin vs propriétaire)
- Gestion des permissions améliorée
- Messages d'alerte contextuels

### SearchController
**Modifications :**
- Les administrateurs peuvent voir tous les espaces (y compris fermés/désactivés)
- Les utilisateurs normaux ne voient que les espaces disponibles
- Indicateurs visuels pour les admins

## Modifications des formulaires

### SpaceType
**Nouveaux champs :**
- `nbSpaces` : Nombre d'espaces (IntegerType)
- `minSpace` : Surface minimale (IntegerType)
- `maxSpace` : Surface maximale (IntegerType)

**Validations :**
- Groupes de validation `save` pour la publication
- Validation de cohérence entre min et max

### ParcelType
**Champs modifiés :**
- `minSurface` et `maxSurface` remplacent `surface`
- Validations de cohérence et de valeurs positives

### ApplicationType
**Aucune modification structurelle**, mais amélioration de la gestion des documents requis.

## Nouvelles commandes console

### CheckUserRolesCommand
- **Nom** : `app:check-user-roles`
- **Usage** : `php bin/console app:check-user-roles email@example.com`
- **Fonction** : Diagnostique les rôles d'un utilisateur spécifique

### FixUserRoleCommand
- **Nom** : `app:fix-user-role`
- **Usage** : 
  - `php bin/console app:fix-user-role email@example.com` (utilisateur spécifique)
  - `php bin/console app:fix-user-role --all` (tous les propriétaires)
- **Fonction** : Corrige les rôles manquants des utilisateurs propriétaires

## Modifications des templates

### Templates principaux modifiés
- `Search/index.html.twig` : Affichage différencié pour les admins
- `Space/show.html.twig` : Indicateurs de disponibilité
- `SpaceManagement/Partials/edit_spaces.html.twig` : Interface de gestion améliorée
- `Space/apply.html.twig` : Gestion des candidatures améliorée

### Nouveaux templates email
- `Email/space_published.html.twig` : Notification de publication
- `Email/space_available_again.html.twig` : Notification de réouverture

## Fonctionnalités implémentées

### 1. Système de publication/dépublication
- **Publication** : Les admins peuvent publier les espaces soumis
- **Dépublication** : Les propriétaires et admins peuvent dépublié temporairement
- **Notifications** : Emails automatiques lors des changements d'état

### 2. Gestion intelligente des candidatures
- Sauvegarde automatique en brouillon si l'espace devient indisponible
- Notifications aux candidats lors de la réouverture d'un espace
- Gestion en cascade lors de la suppression d'espaces

### 3. Interface administrateur améliorée
- Vue globale de tous les espaces pour les admins
- Filtres adaptés selon le rôle
- Indicateurs visuels de statut

### 4. Gestion des surfaces flexible
- Remplacement des surfaces fixes par des plages min/max
- Validation de cohérence automatique
- Interface utilisateur adaptée

### 5. Outils de diagnostic
- Commandes pour vérifier et corriger les rôles utilisateurs
- Diagnostic complet des permissions
- Correction automatique des problèmes de rôles

## Sécurité et permissions

### Rôles et permissions
- **ROLE_ADMIN** : Accès complet à tous les espaces et actions
- **ROLE_OWNER** : Gestion de ses propres espaces
- **ROLE_USER** : Accès limité aux espaces publics

### Vérifications de sécurité
- Contrôle d'accès sur toutes les actions sensibles
- Validation des tokens CSRF
- Vérification de propriété avant modification

## Impact sur l'expérience utilisateur

### Pour les propriétaires
- Contrôle total sur la publication de leurs espaces
- Possibilité de modifications même après soumission
- Notifications automatiques des changements d'état

### Pour les administrateurs
- Vue d'ensemble de tous les espaces
- Outils de gestion avancés
- Diagnostic et correction des problèmes

### Pour les candidats
- Sauvegarde automatique des candidatures
- Notifications lors de la réouverture d'espaces
- Interface plus robuste face aux changements d'état

## Points techniques importants

### Gestion des états
- `enabled` : Espace activé par un admin
- `submitted` : Espace soumis par le propriétaire
- `closed` : Espace fermé (date dépassée ou fermeture manuelle)
- `published` : Espace publié (enabled + submitted)

### Migrations
- Migration des données existantes préservée
- Rollback possible avec les méthodes `down()`
- Validation des contraintes de base de données

### Performance
- Requêtes optimisées avec filtres appropriés
- Pagination maintenue sur toutes les listes
- Cache des rôles utilisateurs

## Tests et validation

### Tests recommandés
1. **Test de publication/dépublication** : Vérifier les changements d'état
2. **Test des permissions** : Vérifier l'accès selon les rôles
3. **Test des candidatures** : Vérifier la sauvegarde automatique
4. **Test des migrations** : Vérifier la migration des données existantes
5. **Test des commandes** : Vérifier le diagnostic et la correction des rôles

### Points de vigilance
- Vérifier la cohérence des données après migration
- Tester les notifications email
- Valider les permissions sur tous les endpoints
- Vérifier la gestion des erreurs

## Conclusion

Cette branche apporte une amélioration significative de la gestion des espaces avec :
- Un système de publication flexible et sécurisé
- Une gestion intelligente des candidatures
- Des outils d'administration avancés
- Une meilleure expérience utilisateur pour tous les acteurs

Les modifications sont rétrocompatibles et incluent des outils de diagnostic pour faciliter la maintenance.

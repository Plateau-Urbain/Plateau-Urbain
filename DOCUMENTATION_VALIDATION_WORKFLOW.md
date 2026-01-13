# Documentation : Workflow de validation des espaces

**Date** : 12 janvier 2026  
**Auteur** : Système de validation à deux niveaux

## Vue d'ensemble

Ce document décrit le nouveau système de validation à deux niveaux pour la publication des espaces (Appels À Candidature) sur la plateforme Plateau Urbain.

## Objectif

Mettre en place un workflow de validation où :
- Les **super admins** (ROLE_ADMIN) peuvent éditer et publier directement tous les espaces
- Les **propriétaires standards** (role_owner:role_user) peuvent créer et éditer des espaces, mais doivent soumettre leurs AAC pour validation avant publication par un super admin

## Rôles et permissions

### Super Admin (ROLE_ADMIN)

**Permissions** :
- ✅ Créer un espace
- ✅ Modifier n'importe quel espace (y compris ceux en attente de validation)
- ✅ Publier directement un espace (bypass de la validation)
- ✅ Approuver et publier les espaces en attente de validation
- ✅ Suspendre, dépublier ou clôturer n'importe quel espace
- ✅ Supprimer des espaces

### Propriétaire Standard (role_owner:role_user)

**Permissions** :
- ✅ Créer un espace
- ✅ Modifier ses propres espaces en brouillon (non soumis)
- ✅ Modifier ses propres espaces publiés
- ✅ Soumettre un espace pour validation
- ❌ Modifier un espace en attente de validation (soumis mais pas encore publié)
- ❌ Publier directement un espace
- ✅ Suspendre ou clôturer ses propres espaces publiés
- ✅ Supprimer ses propres espaces non publiés

## États d'un espace

### 1. Brouillon / En cours d'édition
- `submitted = false`
- `enabled = false`
- **Visible par** : Propriétaire et admins uniquement
- **Statut affiché** : "En cours d'édition"
- **Actions disponibles** :
  - Propriétaire : Modifier, Enregistrer, Soumettre pour validation, Supprimer
  - Admin : Modifier, Enregistrer, Publier directement, Supprimer

### 2. En attente de validation
- `submitted = true`
- `enabled = false`
- **Visible par** : Propriétaire et admins uniquement
- **Statut affiché** : "En attente de validation" (avec icône spinner, style cohérent avec les autres statuts)
- **Actions disponibles** :
  - Propriétaire : Voir l'annonce uniquement (message d'attente)
  - Admin : Modifier, Approuver et Publier, Supprimer

### 3. Publié / En cours
- `submitted = true`
- `enabled = true`
- **Visible par** : Tous les candidats
- **Statut affiché** : "Appel à candidature en cours"
- **Actions disponibles** :
  - Propriétaire : Voir les candidats, Suspendre pour modification, Clôturer
  - Admin : Voir les candidats, Suspendre pour modification, Clôturer

### 4. Suspendu temporairement
- `submitted = true` (ou `submittedAt` existe)
- `enabled = false`
- **Visible par** : Propriétaire et admins uniquement
- **Statut affiché** : "Dépublié temporairement"
- **Actions disponibles** : Modifier et republier

### 5. Clôturé
- `closed = true`
- **Visible par** : Propriétaire, admins et candidats ayant postulé
- **Statut affiché** : "Appel à candidature cloturé"
- **Actions disponibles** : Voir les candidats uniquement

## Workflow détaillé

### Workflow Propriétaire Standard

```
1. Création d'un espace
   ↓
2. Édition et enregistrement (peut être fait en plusieurs fois)
   ↓
3. Clic sur "Soumettre pour validation"
   ↓
4. Confirmation : "Êtes-vous sûr de vouloir soumettre cet espace pour validation ?"
   ↓
5. Espace marqué comme "En attente de validation"
   ↓
6. Email envoyé aux admins
   ↓
7. Message de succès : "Votre espace a été soumis pour validation. 
      Un administrateur le publiera après vérification."
   ↓
8. Attente de l'approbation admin
   ↓
9. Admin approuve et publie
   ↓
10. Email de confirmation envoyé au propriétaire
   ↓
11. Espace publié et visible par tous les candidats
```

### Workflow Super Admin

```
1. Création d'un espace
   ↓
2. Édition et enregistrement (optionnel)
   ↓
3. Clic sur "Publier"
   ↓
4. Confirmation : "ADMIN : Êtes-vous sûr de vouloir publier cet espace ?"
   ↓
5. Espace immédiatement publié (submitted = true, enabled = true)
   ↓
6. Email envoyé au propriétaire
   ↓
7. Message de succès : "L'espace a été publié avec succès."
   ↓
8. Espace visible par tous les candidats
```

### Workflow d'approbation (Admin)

```
1. Réception d'email : "Nouvelle propriété en attente de validation"
   ↓
2. Connexion à l'interface admin
   ↓
3. Filtrer les espaces : "En attente de validation" (status_filter = pending)
   ↓
4. Visualisation de l'espace en attente
   ↓
5. (Optionnel) Modification de l'espace si nécessaire
   ↓
6. Clic sur "Approuver et Publier"
   ↓
7. Confirmation : "ADMIN : Êtes-vous sûr de vouloir approuver et publier cet espace ?"
   ↓
8. Espace publié
   ↓
9. Email envoyé au propriétaire : "Votre espace a été publié sur Plateau Urbain"
   ↓
10. Message de succès : "L'espace a été publié avec succès. 
       Le propriétaire a été notifié par email."
```

## Modifications techniques

### Fichiers modifiés

#### 1. `src/AppBundle/Controller/SpaceManagementController.php`

**Méthode `submitSpace()` modifiée** :
- Ajout de la distinction entre admin et propriétaire standard
- Si admin : publication directe (`enabled = true`)
- Si propriétaire : soumission pour validation (`enabled = false`)
- Emails différents selon le rôle

**Méthode `editAction()` modifiée** :
- Ajout de la vérification : les propriétaires ne peuvent pas modifier un espace en attente de validation
- Les admins peuvent modifier tous les espaces, y compris ceux en attente

**Méthode `publishAction()` modifiée** :
- Restriction : seuls les admins peuvent utiliser cette route
- Email de confirmation envoyé au propriétaire
- Notification des candidats avec brouillons

#### 2. `app/Resources/AppBundle/views/SpaceManagement/Partials/edit_spaces.html.twig`

**Bouton "Publier" modifié** :
- Label dynamique selon le rôle :
  - Admin : "Publier"
  - Propriétaire : "Soumettre pour validation"
- Message de confirmation adapté selon le rôle

#### 3. `app/Resources/AppBundle/views/SpaceManagement/Partials/space.html.twig`

**Overlay de statut ajouté** :
- Nouvel état visuel : "En attente de validation" (orange)

**Bouton "Modifier" conditionnel** :
- Visible pour les espaces en brouillon (tous)
- Visible pour les espaces en attente uniquement pour les admins
- Caché pour les propriétaires si l'espace est en attente

**Bouton "Approuver et Publier" ajouté** :
- Visible uniquement pour les admins
- Affiché uniquement pour les espaces en attente de validation
- Pour les propriétaires : message d'information à la place

#### 4. `app/Resources/AppBundle/views/Email/new_property.html.twig`

**Template d'email amélioré** :
- Design modernisé
- Alerte visuelle pour l'action requise
- Plus d'informations sur la propriété
- Instructions claires pour l'admin

#### 5. `app/Resources/AppBundle/views/Email/space_published.html.twig`

**Template existant utilisé** :
- Notification envoyée au propriétaire après approbation
- Design cohérent avec la charte graphique

## Filtres pour les admins

Les admins peuvent filtrer les espaces par statut :
- **Tous** : Affiche tous les espaces
- **En attente** (`status_filter = pending`) : Espaces soumis mais pas encore publiés
- **Publiés** (`status_filter = enabled`) : Espaces actifs
- **Fermés** (`status_filter = closed`) : Espaces clôturés

## Messages et notifications

### Messages et Pop-ups

#### Propriétaire standard
- **Enregistrement (brouillon)** : Pop-up "Espace enregistré" - "Votre espace a été enregistré. Une fois complété, vous pourrez le soumettre pour validation par un administrateur."
- **Soumission pour validation** : Pop-up spéciale "Espace soumis pour validation" avec message détaillé expliquant le processus
- **Tentative de modification en attente** : Message d'erreur "Cet espace est en attente de validation par un administrateur. Vous ne pouvez pas le modifier pour le moment."

#### Super admin
- **Enregistrement (brouillon)** : Pop-up "Espace enregistré" - "L'espace a été enregistré. Vous pouvez le publier directement depuis la gestion des espaces."
- **Publication directe** : Pop-up "Espace publié avec succès" - "L'espace est maintenant visible par tous les candidats !"
- **Approbation** : Message flash "L'espace a été publié avec succès. Le propriétaire a été notifié par email."

### Emails

#### Email aux admins (soumission)
- **Sujet** : "Nouvelle propriété en attente de validation"
- **Contenu** : Informations sur la propriété + alerte d'action requise

#### Email au propriétaire (approbation)
- **Sujet** : "Votre espace a été publié sur Plateau Urbain"
- **Contenu** : Confirmation de publication + lien vers la gestion des candidatures

## Tests recommandés

### Test 1 : Propriétaire standard - Soumission
1. Se connecter en tant que propriétaire standard
2. Créer un nouvel espace
3. Remplir le formulaire
4. Cliquer sur "Soumettre pour validation"
5. Vérifier le message de succès
6. Vérifier l'email reçu par les admins
7. Vérifier que l'espace apparaît avec le statut "En attente de validation"
8. Vérifier qu'on ne peut plus modifier l'espace

### Test 2 : Admin - Approbation
1. Se connecter en tant qu'admin
2. Filtrer par "En attente de validation"
3. Visualiser l'espace en attente
4. (Optionnel) Modifier l'espace
5. Cliquer sur "Approuver et Publier"
6. Vérifier le message de succès
7. Vérifier l'email reçu par le propriétaire
8. Vérifier que l'espace est visible publiquement

### Test 3 : Admin - Publication directe
1. Se connecter en tant qu'admin
2. Créer un nouvel espace
3. Remplir le formulaire
4. Cliquer sur "Publier"
5. Vérifier que l'espace est immédiatement publié
6. Vérifier l'email reçu par le propriétaire (si différent de l'admin)

### Test 4 : Propriétaire - Tentative de modification en attente
1. Avoir un espace en attente de validation
2. Se connecter en tant que propriétaire
3. Essayer d'accéder à l'édition de l'espace
4. Vérifier le message d'erreur

## Notes importantes

1. **Rétrocompatibilité** : Les espaces existants ne sont pas affectés par ce changement
2. **Performance** : Pas d'impact sur les performances (pas de requêtes supplémentaires)
3. **Sécurité** : Les vérifications sont faites côté serveur (pas seulement côté client)
4. **UX** : Messages clairs et explicites pour guider les utilisateurs

## Support et maintenance

En cas de problème ou de question :
1. Vérifier les logs d'application (`app/logs/`)
2. Vérifier l'état de la base de données (colonnes `is_submitted` et `enabled`)
3. Vérifier la configuration des emails
4. Consulter cette documentation

## Évolutions futures possibles

- [ ] Système de notifications in-app pour les propriétaires
- [ ] Historique des approbations/refus
- [ ] Possibilité de refuser un espace avec commentaire
- [ ] Dashboard admin avec statistiques des espaces en attente
- [ ] Délai maximum de validation (SLA)

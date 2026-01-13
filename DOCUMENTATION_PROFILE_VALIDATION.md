# Système de Validation du Profil Utilisateur

## Vue d'ensemble

Ce système empêche les utilisateurs de candidater tant que leur profil n'est pas complet. Il vérifie automatiquement la complétude du profil et redirige l'utilisateur vers la page de profil si nécessaire.

## Fonctionnalités implémentées

### 1. Validation du profil utilisateur

**Fichier modifié :** `src/AppBundle/Entity/User.php`

#### Méthode `isProfileComplete()`
- Vérifie si tous les champs obligatoires sont remplis
- Contrôle les informations de base (civilité, nom, prénom, email)
- Vérifie les informations de l'entreprise (nom, statut, adresse, code postal, ville)
- Pour les porteurs de projet : vérifie les champs spécifiques (date de naissance, création entreprise, surface souhaitée, etc.)
- Contrôle la présence des documents obligatoires (pièce d'identité et Kbis)

#### Méthode `getMissingProfileFields()`
- Retourne la liste des champs manquants
- Utile pour l'affichage des erreurs et la guidance utilisateur

### 2. Contrôleur de candidature

**Fichier modifié :** `src/AppBundle/Controller/SpaceController.php`

#### Action `applyAction()`
- Vérifie automatiquement si le profil est complet avant d'autoriser la candidature
- Redirige vers le profil avec un paramètre `next` pour revenir à la candidature après complétion
- Affiche un message d'avertissement à l'utilisateur

### 3. Contrôleur de profil

**Fichier modifié :** `src/AppBundle/Controller/SecurityController.php`

#### Actions `inscriptionConfirmationAction()` et `profilAction()`
- Gèrent le paramètre `next` pour rediriger l'utilisateur après complétion du profil
- Redirigent automatiquement vers la page de candidature une fois le profil complété

### 4. Interface utilisateur

**Fichier modifié :** `app/Resources/AppBundle/views/Space/show.html.twig`

#### Bouton de candidature
- Affiche "Veuillez compléter votre profil" si le profil est incomplet
- Affiche "Je candidate" si le profil est complet
- Redirige vers le profil avec le paramètre `next` approprié

**Fichier modifié :** `app/Resources/AppBundle/views/Security/profil.html.twig`

#### Message informatif
- Affiche un message d'information quand l'utilisateur est redirigé depuis une candidature
- Explique que le profil doit être complété pour pouvoir candidater

**Fichier modifié :** `app/Resources/AppBundle/views/Search/index.html.twig`

#### Page d'accueil
- Affiche un message d'avertissement visible si le profil utilisateur est incomplet
- Utilise la méthode `isProfileComplete()` pour une vérification précise
- Message stylisé avec icône d'avertissement et lien direct vers le profil
- Section FAQ mise à jour pour mentionner l'importance du profil complet

## Flux utilisateur

### Scénario 1 : Utilisateur avec profil incomplet
1. L'utilisateur clique sur "Je candidate" sur une fiche espace
2. Le système vérifie automatiquement la complétude du profil
3. Si incomplet : redirection vers le profil avec message d'avertissement
4. L'utilisateur complète son profil
5. Après sauvegarde : redirection automatique vers la page de candidature

### Scénario 2 : Utilisateur avec profil complet
1. L'utilisateur clique sur "Je candidate"
2. Le système vérifie le profil (complet)
3. Accès direct à la page de candidature

### Scénario 3 : Nouvel utilisateur
1. L'utilisateur clique sur "Je candidate" sans être connecté
2. Redirection vers l'inscription/connexion
3. Après connexion : vérification du profil et redirection appropriée

### Scénario 4 : Page d'accueil
1. L'utilisateur connecté visite la page d'accueil
2. Si profil incomplet : message d'avertissement visible avec lien vers le profil
3. Si profil complet : message de bienvenue personnalisé
4. Section FAQ mise à jour pour sensibiliser à l'importance du profil complet

## Champs obligatoires vérifiés

### Informations personnelles
- Civilité
- Prénom
- Nom
- Email

### Informations entreprise
- Nom de l'entreprise
- Statut de l'entreprise
- Adresse
- Code postal
- Ville

### Informations spécifiques porteur de projet
- Date de naissance
- Date de création de l'entreprise
- Surface souhaitée
- Date de disponibilité
- Durée d'occupation

### Documents obligatoires
- Pièce d'identité
- Kbis ou document équivalent

## Tests

Un script de test est disponible dans `test_profile_completion.php` pour vérifier le bon fonctionnement des méthodes de validation.

## Avantages

1. **Expérience utilisateur améliorée** : L'utilisateur est guidé naturellement vers la complétion de son profil
2. **Données complètes** : Garantit que tous les utilisateurs candidats ont un profil complet
3. **Sécurité** : Empêche les candidatures avec des données manquantes
4. **Flexibilité** : Le système s'adapte automatiquement au type d'utilisateur (porteur de projet vs propriétaire)

## Maintenance

Pour ajouter de nouveaux champs obligatoires :
1. Modifier la méthode `isProfileComplete()` dans l'entité User
2. Modifier la méthode `getMissingProfileFields()` pour inclure le nouveau champ
3. Mettre à jour les formulaires si nécessaire
4. Tester avec le script de test

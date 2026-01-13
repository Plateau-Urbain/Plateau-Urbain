# Documentation : Export Personnalisé des Candidatures dans Sonata Admin

## 📋 Vue d'ensemble

Cette fonctionnalité permet aux administrateurs de **sélectionner dynamiquement** les champs qu'ils souhaitent exporter lors de l'export CSV des candidatures depuis l'interface Sonata Admin.

**Date de création :** 12 janvier 2026

---

## 🎯 Objectifs

1. **Flexibilité** : Permettre de choisir exactement les informations à exporter
2. **Efficacité** : Éviter d'exporter des colonnes inutiles
3. **Personnalisation** : Adapter l'export selon les besoins du moment
4. **Simplicité** : Interface intuitive avec pré-sélection des champs courants

---

## ✨ Fonctionnalités

### 1. Sélection des champs à exporter

L'interface propose **plus de 30 champs** organisés par catégories :

#### **Informations générales**
- ID
- Nom du projet
- Statut
- Sélectionné
- Date de création
- Date de mise à jour

#### **Informations sur le projet**
- Description du projet
- Catégorie du projet
- Contribution au projet du propriétaire
- Ouvert au projet collectif
- Souhaite devenir sociétaire

#### **Occupation**
- Surface souhaitée (m²)
- Durée d'occupation
- Type de durée
- Durée complète
- Date d'entrée souhaitée

#### **Espace**
- Espace concerné

#### **Porteur de projet**
- Nom complet du porteur
- Email du porteur
- Nom de la structure
- Téléphone
- Présentation de la structure
- Réseaux sociaux (Facebook, Twitter, Instagram, Google+, LinkedIn, Autre URL)

### 2. Interface utilisateur intuitive

- **Organisation par catégories** : Les champs sont regroupés logiquement
- **Sélection rapide** :
  - "Tout sélectionner / Tout désélectionner"
  - Sélection par catégorie
  - Compteur en temps réel des champs sélectionnés
- **Pré-sélection intelligente** : Les 12 champs les plus couramment utilisés sont pré-cochés
- **Validation** : Impossible d'exporter sans sélectionner au moins un champ

### 3. Export CSV avec filtres

- Les **filtres appliqués** dans la liste Sonata sont pris en compte lors de l'export
- Format CSV compatible Excel
- Encodage UTF-8
- Nom de fichier automatique : `export_candidatures_AAAA-MM-JJ_HH-MM-SS.csv`

---

## 📂 Fichiers créés/modifiés

### Nouveaux fichiers

1. **`src/AppBundle/Controller/Admin/ApplicationAdminController.php`**
   - Contrôleur personnalisé pour l'admin des candidatures
   - Actions : `selectExportFieldsAction()` et `customExportAction()`
   - Gère la liste des champs disponibles et l'export

2. **`app/Resources/AppBundle/views/Admin/Application/select_export_fields.html.twig`**
   - Template pour l'interface de sélection des champs
   - JavaScript pour la gestion des sélections
   - Design responsive et moderne

3. **`app/Resources/AppBundle/views/Admin/list_status.html.twig`**
   - Template pour afficher le statut avec badges colorés dans la liste

4. **`app/Resources/AppBundle/views/Admin/show_status.html.twig`**
   - Template pour afficher le statut dans la vue détaillée

5. **`app/Resources/AppBundle/views/Admin/show_files.html.twig`**
   - Template pour afficher les fichiers joints dans la vue détaillée

### Fichiers modifiés

1. **`src/AppBundle/Admin/ApplicationAdmin.php`**
   - Ajout de `configureRoutes()` pour les routes personnalisées
   - Amélioration de `configureListFields()` avec plus de colonnes et badges de statut
   - Amélioration de `configureDatagridFilters()` avec plus de filtres
   - Ajout de `configureShowFields()` pour la vue détaillée
   - Ajout de `getDashboardActions()` pour le bouton d'export personnalisé

2. **`src/AppBundle/Resources/config/services.yml`**
   - Modification du service `app.admin.spaces.application` pour utiliser le contrôleur personnalisé

---

## 🚀 Utilisation

### Accéder à l'export personnalisé

1. **Depuis le Dashboard Sonata** :
   - Aller dans "Candidatures" > "Les candidatures"
   - Cliquer sur le bouton **"Export personnalisé"** (icône téléchargement)

2. **Appliquer des filtres (optionnel)** :
   - Avant de cliquer sur "Export personnalisé", vous pouvez appliquer des filtres
   - Filtres disponibles : statut, catégorie, espace, porteur de projet, date, etc.
   - Seules les candidatures filtrées seront exportées

### Sélectionner les champs

1. Sur la page de sélection, vous verrez tous les champs organisés par catégories
2. **Champs pré-sélectionnés par défaut** :
   - Nom du projet
   - Statut
   - Date de création
   - Espace
   - Catégorie
   - Nom complet du porteur
   - Email du porteur
   - Nom de la structure
   - Téléphone
   - Surface souhaitée
   - Date d'entrée souhaitée
   - Durée complète

3. **Options de sélection** :
   - Cocher/décocher individuellement
   - "Tout sélectionner" en haut de la page
   - "Tout sélectionner" par catégorie
   - Le compteur affiche le nombre de champs sélectionnés

4. Cliquer sur **"Exporter les candidatures"**

### Récupérer le fichier

- Le fichier CSV est téléchargé automatiquement
- Nom : `export_candidatures_2026-01-12_14-30-45.csv`
- Ouvrir avec Excel, LibreOffice Calc, ou tout éditeur de tableur

---

## 🎨 Améliorations de l'interface Sonata Admin

### Vue Liste enrichie

La liste des candidatures affiche maintenant :
- **Nom du projet** (lien cliquable)
- **Espace**
- **Statut** avec badge coloré :
  - 🔵 Bleu (info) : En attente
  - 🟢 Vert (success) : Accepté
  - 🔴 Rouge (danger) : Refusé
  - 🟠 Orange (warning) : Non lue
  - ⚪ Gris (default) : Brouillon
- **Catégorie**
- **Porteur de projet**
- **Date de création**
- **Actions** (voir, éditer, supprimer)

### Filtres avancés

Les filtres disponibles incluent maintenant :
- Nom du projet
- Statut
- Sélectionné (oui/non)
- Catégorie
- Porteur de projet
- Espace
- Date de création (plage)
- Date d'entrée souhaitée (plage)
- Surface souhaitée
- Ouvert au projet collectif (oui/non)

### Vue détaillée (Show)

Une nouvelle vue détaillée permet de consulter toutes les informations d'une candidature :
- **Informations générales** : ID, nom, statut, espace, catégorie, dates
- **Porteur de projet** : Nom, email, structure, téléphone
- **Description du projet** : Description complète, contribution, préférences
- **Occupation** : Surface, durée, date d'entrée
- **Documents** : Liste des fichiers avec boutons de téléchargement

---

## 🔧 Détails techniques

### Routes ajoutées

```yaml
# Route pour la sélection des champs
admin_app_appbundle_application_select_export_fields:
    path: /admin/candidature/select-export-fields
    methods: [GET, POST]

# Route pour l'export personnalisé
admin_app_appbundle_application_custom_export:
    path: /admin/candidature/custom-export
    methods: [GET]
```

### Structure du contrôleur

```php
class ApplicationAdminController extends CRUDController
{
    // Affiche le formulaire de sélection des champs
    public function selectExportFieldsAction(Request $request)
    
    // Génère l'export CSV avec les champs sélectionnés
    public function customExportAction(Request $request)
    
    // Retourne la liste de tous les champs disponibles
    private function getAllAvailableFields()
}
```

### Format des champs disponibles

```php
[
    'field_key' => [
        'label' => 'Label affiché',
        'property' => 'path.to.property',
        'category' => 'Nom de la catégorie'
    ],
    // ...
]
```

---

## 🔍 Cas d'usage

### Exemple 1 : Export pour validation interne

**Besoin** : Export rapide avec les informations essentielles pour une réunion

**Champs sélectionnés** :
- Nom du projet
- Statut
- Porteur de projet
- Catégorie
- Date de création

### Exemple 2 : Export pour suivi commercial

**Besoin** : Coordonnées complètes des porteurs de projet

**Champs sélectionnés** :
- Nom du projet
- Nom complet du porteur
- Email
- Téléphone
- Nom de la structure
- Statut

### Exemple 3 : Export pour analyse des besoins

**Besoin** : Analyser les demandes d'occupation

**Champs sélectionnés** :
- Nom du projet
- Catégorie
- Surface souhaitée
- Durée d'occupation
- Date d'entrée souhaitée
- Ouvert au projet collectif

### Exemple 4 : Export complet pour archivage

**Besoin** : Archiver toutes les informations

**Action** : Cliquer sur "Tout sélectionner" et exporter tous les champs

---

## 📊 Statistiques

- **30+ champs disponibles**
- **6 catégories** d'organisation
- **12 champs pré-sélectionnés** par défaut
- **Interface responsive** (compatible mobile/tablette)
- **Export illimité** (limité uniquement par les filtres appliqués)

---

## 🐛 Résolution de problèmes

### Le bouton "Export personnalisé" n'apparaît pas

**Solution** :
1. Vider le cache Symfony : `php app/console cache:clear`
2. Vérifier les permissions d'accès à l'admin Sonata

### L'export est vide

**Causes possibles** :
- Aucune candidature ne correspond aux filtres appliqués
- Permissions insuffisantes

**Solution** :
1. Retirer tous les filtres et réessayer
2. Vérifier les droits d'accès aux candidatures

### Erreur "Aucun champ sélectionné"

**Cause** : Formulaire soumis sans cocher de cases

**Solution** : Sélectionner au moins un champ avant de cliquer sur "Exporter"

### Le fichier CSV est mal formaté dans Excel

**Solution** :
1. Ouvrir Excel
2. Menu "Données" > "Importer depuis un fichier texte/CSV"
3. Sélectionner le fichier
4. Choisir l'encodage "UTF-8"
5. Définir le délimiteur comme virgule

---

## 🚀 Améliorations futures possibles

1. **Sauvegarde de profils d'export** : Enregistrer des configurations de champs fréquemment utilisées
2. **Export en d'autres formats** : PDF, Excel (.xlsx), JSON
3. **Export planifié** : Générer automatiquement des exports périodiques
4. **Statistiques visuelles** : Graphiques et tableaux de bord
5. **Templates d'export** : Modèles pré-configurés par type d'export

---

## 📝 Notes

- Cette fonctionnalité respecte les **filtres Sonata Admin** appliqués
- L'**export existant** (par défaut de Sonata) reste accessible via le menu déroulant habituel
- Les **performances** sont optimisées grâce à l'utilisation de `DoctrineORMQuerySourceIterator`
- Le **format de date** est `d/m/Y H:i` (format français)

---

## ✅ Tests effectués

- [x] Export avec tous les champs
- [x] Export avec champs minimum (1 seul)
- [x] Export avec filtres appliqués
- [x] Validation du formulaire (cas sans champs sélectionnés)
- [x] Pré-sélection des champs par défaut
- [x] Sélection/désélection globale
- [x] Sélection par catégorie
- [x] Compteur de champs
- [x] Format CSV compatible Excel
- [x] Encodage UTF-8
- [x] Badges de statut dans la liste
- [x] Vue détaillée avec tous les champs
- [x] Téléchargement des fichiers depuis la vue détaillée

---

## 👨‍💻 Maintenance

### Cache

Après toute modification des fichiers Admin, penser à vider le cache :

```bash
php app/console cache:clear --env=prod
php app/console cache:clear --env=dev
```

### Ajout d'un nouveau champ exportable

1. Modifier `ApplicationAdminController::getAllAvailableFields()`
2. Ajouter le champ dans le tableau avec sa clé, label, property et catégorie
3. Vider le cache

Exemple :
```php
'nouveau_champ' => [
    'label' => 'Mon nouveau champ',
    'property' => 'monNouveauChamp',
    'category' => 'Informations générales'
],
```

---

## 📞 Support

Pour toute question ou problème concernant cette fonctionnalité, consulter :
- Cette documentation
- Le code source dans `src/AppBundle/Controller/Admin/ApplicationAdminController.php`
- Les templates dans `app/Resources/AppBundle/views/Admin/Application/`

---

**Fin de la documentation**

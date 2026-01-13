# 🚀 Guide Rapide : Filtrer et Exporter les Candidatures

## 📍 Où se trouve le bouton d'export ?

Dans **Sonata Admin** > **Candidatures** > **Les candidatures**, vous verrez :
- En haut à droite : Bouton **"Filtres"** (bleu)
- En haut de la liste : Bouton **"Export personnalisé"** (vert)

---

## 🎯 Processus en 3 étapes

```
┌─────────────────────────────────────────────────────────────┐
│  ÉTAPE 1 : FILTRER (optionnel)                              │
│  ──────────────────────────────────────────────────────────  │
│  Dans la liste des candidatures :                           │
│  1. Cliquez sur "Filtres" (coin supérieur droit)           │
│  2. Un panneau s'ouvre sur la gauche                       │
│  3. Remplissez les critères souhaités                      │
│  4. Cliquez sur "Filtrer"                                  │
│                                                              │
│  ✅ La liste affiche maintenant uniquement les              │
│     candidatures correspondant aux filtres                  │
└─────────────────────────────────────────────────────────────┘
                           ↓
┌─────────────────────────────────────────────────────────────┐
│  ÉTAPE 2 : SÉLECTIONNER LES COLONNES                       │
│  ──────────────────────────────────────────────────────────  │
│  Avec vos filtres appliqués (ou pas) :                     │
│  1. Cliquez sur "Export personnalisé" (bouton vert)        │
│  2. Une nouvelle page s'ouvre                              │
│  3. Vous voyez un récapitulatif des filtres appliqués      │
│  4. Cochez les champs que vous voulez dans l'export        │
│                                                              │
│  💡 12 champs sont déjà pré-sélectionnés                    │
└─────────────────────────────────────────────────────────────┘
                           ↓
┌─────────────────────────────────────────────────────────────┐
│  ÉTAPE 3 : TÉLÉCHARGER                                      │
│  ──────────────────────────────────────────────────────────  │
│  1. Cliquez sur "Exporter les candidatures"                │
│  2. Le fichier CSV est téléchargé automatiquement          │
│  3. Ouvrez-le avec Excel ou LibreOffice                    │
│                                                              │
│  ✅ Vous avez exactement les colonnes et lignes            │
│     que vous vouliez !                                      │
└─────────────────────────────────────────────────────────────┘
```

---

## 🔍 Filtres Disponibles

| Filtre | Description | Exemple |
|--------|-------------|---------|
| **Nom du projet** | Recherche par nom | "Café culturel" |
| **Statut** | État de la candidature | "En attente", "Accepté" |
| **Sélectionné** | Marque de sélection | Oui / Non |
| **Catégorie** | Type de projet | "Restaurant", "Artiste" |
| **Porteur de projet** | Nom du candidat | "Jean Dupont" |
| **Espace** | Propriété concernée | "Immeuble A" |
| **Date de création** | Période de dépôt | Du 01/01/2026 au 31/01/2026 |
| **Date d'entrée souhaitée** | Quand ils veulent entrer | Du 01/03/2026 au 30/06/2026 |
| **Surface souhaitée** | Taille en m² | 50, 100, etc. |
| **Ouvert au projet collectif** | Accepte de partager | Oui / Non |

---

## 💡 Exemples Pratiques

### Exemple 1 : Candidatures à traiter cette semaine

**Objectif :** Liste des candidatures en attente avec les coordonnées des porteurs

**ÉTAPE 1 - Filtrer :**
- Statut = "En attente"
- Date de création = "Du 06/01/2026 au 12/01/2026"

**ÉTAPE 2 - Colonnes à exporter :**
- ✅ Nom du projet
- ✅ Porteur (nom)
- ✅ Email
- ✅ Téléphone
- ✅ Date de création
- ✅ Statut

**Résultat :** Fichier avec 6 colonnes et uniquement les candidatures en attente de cette semaine

---

### Exemple 2 : Candidatures acceptées pour comptabilité

**Objectif :** Export des candidatures acceptées avec infos détaillées

**ÉTAPE 1 - Filtrer :**
- Statut = "Accepté"
- Espace = "Votre espace spécifique"

**ÉTAPE 2 - Colonnes à exporter :**
- ✅ Nom du projet
- ✅ Porteur (nom)
- ✅ Structure
- ✅ Email
- ✅ Téléphone
- ✅ Surface souhaitée
- ✅ Durée complète
- ✅ Date d'entrée souhaitée
- ✅ Date de création

**Résultat :** Fichier avec 9 colonnes et uniquement les acceptés de cet espace

---

### Exemple 3 : Export complet sans filtre

**Objectif :** Tout exporter pour archivage

**ÉTAPE 1 - Filtrer :**
- ❌ Ne rien filtrer (export de tout)

**ÉTAPE 2 - Colonnes à exporter :**
- ✅ Cliquer sur "Tout sélectionner" en haut
- ✅ Tous les 30+ champs sont sélectionnés

**Résultat :** Fichier avec toutes les colonnes et toutes les candidatures

---

## ⚠️ Points Importants

### ✅ À FAIRE
- Appliquer les filtres **AVANT** de cliquer sur "Export personnalisé"
- Vérifier le récapitulatif des filtres sur la page de sélection
- Sélectionner au moins 1 champ pour l'export

### ❌ À ÉVITER
- Ne pas oublier d'appliquer les filtres si vous voulez un export ciblé
- Ne pas exporter toutes les candidatures si vous n'en avez besoin que d'une partie
- Ne pas oublier de cliquer sur "Filtrer" après avoir rempli les critères

---

## 🖼️ Repères Visuels

### Dans la liste des candidatures

```
┌──────────────────────────────────────────────────────────┐
│  Les candidatures                    [Filtres] [+ Créer] │
│  ────────────────────────────────────────────────────────│
│  [🟢 Export personnalisé]  [Autres actions ▼]           │
│  ────────────────────────────────────────────────────────│
│  │ Nom      │ Espace   │ Statut    │ Catégorie │ ...   │
│  │ Projet A │ Lieu 1   │ 🟢 Accepté │ Art      │ ...   │
│  │ Projet B │ Lieu 2   │ 🔵 Attente │ Food     │ ...   │
└──────────────────────────────────────────────────────────┘
```

### Page de sélection des champs

```
┌──────────────────────────────────────────────────────────┐
│  ℹ️ Filtres appliqués :                                   │
│  • Statut : En attente                                   │
│  • Date : 01/01/2026 - 31/01/2026                       │
│  [Modifier les filtres]                                  │
│  ────────────────────────────────────────────────────────│
│  Sélectionner les champs à exporter      [?] Aide       │
│  ────────────────────────────────────────────────────────│
│  ☐ Tout sélectionner                    0 champ séléc.  │
│  ────────────────────────────────────────────────────────│
│  📁 Informations générales                               │
│     ☐ ID   ☑ Nom   ☑ Statut   ☐ Sélectionné  ...       │
│  ────────────────────────────────────────────────────────│
│  📁 Porteur de projet                                    │
│     ☑ Nom   ☑ Email   ☑ Téléphone   ☐ Facebook ...     │
│  ────────────────────────────────────────────────────────│
│  [🟢 Exporter les candidatures]  [Annuler]              │
└──────────────────────────────────────────────────────────┘
```

---

## ❓ Questions Fréquentes

### Q: Les filtres sont-ils obligatoires ?
**R:** Non, mais si vous ne filtrez pas, vous exporterez TOUTES les candidatures.

### Q: Puis-je modifier les filtres après avoir cliqué sur "Export personnalisé" ?
**R:** Oui, cliquez sur "Modifier les filtres" sur la page de sélection des champs.

### Q: Combien de champs dois-je sélectionner minimum ?
**R:** Au moins 1 champ. Il y a 12 champs pré-sélectionnés par défaut.

### Q: Le fichier est-il compatible avec Excel ?
**R:** Oui, c'est un fichier CSV standard UTF-8 compatible avec Excel, LibreOffice, Google Sheets.

### Q: Comment ouvrir le fichier CSV dans Excel ?
**R:** 
1. Ouvrir Excel
2. Menu "Données" > "Importer depuis un fichier texte/CSV"
3. Sélectionner votre fichier
4. Choisir "UTF-8" comme encodage
5. Délimiteur : virgule

### Q: Puis-je exporter plusieurs fois avec des colonnes différentes ?
**R:** Oui, autant de fois que vous voulez ! Chaque export est indépendant.

---

## 🆘 Besoin d'aide ?

Cliquez sur le **bouton "?" Aide** en haut à droite de la page de sélection des champs pour voir le guide interactif avec des exemples.

---

**Version :** 1.0  
**Date :** 12 janvier 2026  
**Difficulté :** 🟢 Facile

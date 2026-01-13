# 🎯 Guide : Comment filtrer les candidatures avant l'export

## 📍 Le problème que vous rencontriez

Quand vous appliquiez des filtres (par exemple : filtrer par espace), puis cliquiez sur "Export personnalisé", les filtres n'étaient pas conservés et vous vous retrouviez avec toutes les candidatures au lieu des candidatures filtrées.

## ✅ Solution mise en place

Le système conserve maintenant **automatiquement** tous les filtres appliqués lors de l'export !

---

## 🎬 Processus étape par étape

### **Étape 1 : Accéder aux candidatures**

1. Dans Sonata Admin, allez dans : **Candidatures** > **Les candidatures**
2. Vous voyez la liste de toutes les candidatures

```
┌─────────────────────────────────────────────────────┐
│ Les candidatures              [Filtres] [+ Créer]   │
│ ─────────────────────────────────────────────────── │
│ [Export personnalisé]  [Autres actions ▼]           │
└─────────────────────────────────────────────────────┘
```

---

### **Étape 2 : Appliquer des filtres** 

1. Cliquez sur le bouton **"Filtres"** en haut à droite
2. Un panneau s'ouvre sur la **gauche** de l'écran
3. Remplissez les critères souhaités :

#### Exemple : Filtrer par espace
```
┌─────────────────────────┐
│ Filtres                 │
├─────────────────────────┤
│ Nom du projet          │
│ [                    ] │
│                        │
│ Statut                 │
│ [ Tous             ▼] │
│                        │
│ Espace                 │
│ [ Mon Espace       ▼] │ ← Sélectionnez ici
│                        │
│ Catégorie              │
│ [ Toutes           ▼] │
│                        │
│ [Filtrer] [Réinitialiser]│
└─────────────────────────┘
```

4. Cliquez sur **"Filtrer"** en bas du panneau
5. La liste se met à jour pour afficher **uniquement** les candidatures de l'espace sélectionné

#### Exemple : Filtrer par statut ET espace
```
Statut: "En attente"
Espace: "Mon Espace"
→ Résultat : Uniquement les candidatures en attente de "Mon Espace"
```

---

### **Étape 3 : Vérifier que les filtres sont appliqués**

Dans la liste, vous verrez en haut :
```
┌─────────────────────────────────────────────────────┐
│ ⓘ Filtres actifs : Espace = "Mon Espace"            │
│    [Modifier] [Effacer]                              │
└─────────────────────────────────────────────────────┘
```

Et le nombre de résultats : **"Affichage de 15 résultats sur 15"** (au lieu de 150 par exemple)

---

### **Étape 4 : Lancer l'export personnalisé**

1. **AVEC les filtres appliqués**, cliquez sur le bouton vert **"Export personnalisé"**
2. Vous arrivez sur la page de sélection des colonnes

#### Vous verrez maintenant :
```
┌─────────────────────────────────────────────────────┐
│ ℹ️ FILTRES APPLIQUÉS                                 │
│ Les filtres suivants seront pris en compte :        │
│ • Espace : Mon Espace                                │
│ [Modifier les filtres]                               │
└─────────────────────────────────────────────────────┘
```

✅ **Les filtres sont bien conservés !**

---

### **Étape 5 : Sélectionner les colonnes et exporter**

1. Choisissez les colonnes que vous voulez :
   - Cliquez sur **"Sélection recommandée"** pour un export rapide
   - Ou cochez manuellement les champs souhaités
   
2. Cliquez sur **"Exporter les candidatures"**

3. Le fichier CSV téléchargé contient :
   - ✅ **Uniquement les colonnes sélectionnées**
   - ✅ **Uniquement les candidatures filtrées** (exemple : de "Mon Espace")

---

## 📊 Exemples d'utilisation

### Exemple 1 : Export des candidatures d'un seul espace

**Besoin :** Exporter uniquement les candidatures de "Immeuble A"

**Étapes :**
1. Filtres → Espace = "Immeuble A"
2. Filtrer
3. Export personnalisé
4. ✅ Voir : "Filtres appliqués : Espace = Immeuble A"
5. Sélectionner les colonnes
6. Exporter

**Résultat :** CSV avec uniquement les candidatures de "Immeuble A"

---

### Exemple 2 : Export des candidatures en attente pour un espace

**Besoin :** Candidatures "En attente" de "Immeuble B" avec coordonnées

**Étapes :**
1. Filtres :
   - Statut = "En attente"
   - Espace = "Immeuble B"
2. Filtrer (exemple : 8 résultats)
3. Export personnalisé
4. ✅ Voir : "Filtres appliqués : Statut = En attente, Espace = Immeuble B"
5. Sélectionner :
   - Nom du projet
   - Porteur
   - Email
   - Téléphone
6. Exporter

**Résultat :** CSV avec 8 lignes et 4 colonnes

---

### Exemple 3 : Export avec plusieurs filtres

**Besoin :** Candidatures acceptées en janvier 2026 pour "Immeuble C"

**Étapes :**
1. Filtres :
   - Statut = "Accepté"
   - Espace = "Immeuble C"
   - Date de création = Du 01/01/2026 au 31/01/2026
2. Filtrer (exemple : 3 résultats)
3. Export personnalisé
4. ✅ Voir les 3 filtres listés
5. Sélection recommandée (12 colonnes)
6. Exporter

**Résultat :** CSV avec 3 lignes et 12 colonnes

---

## 🔍 Vérifications avant l'export

### ✅ Liste de contrôle

Avant de cliquer sur "Exporter les candidatures", vérifiez :

1. **Sur la page de sélection des colonnes**, vous voyez :
   ```
   ℹ️ FILTRES APPLIQUÉS
   Les filtres suivants seront pris en compte :
   • [Vos filtres listés ici]
   ```

2. Le nombre de candidatures affichées dans la liste correspond à ce que vous attendez

3. Les colonnes cochées sont bien celles que vous voulez

---

## ⚠️ Attention

### Si vous voyez ce message :
```
⚠️ AUCUN FILTRE APPLIQUÉ
Vous êtes sur le point d'exporter TOUTES les candidatures !
```

**Cela signifie :**
- Vous n'avez pas filtré dans la liste avant de cliquer sur "Export personnalisé"
- L'export contiendra **TOUTES** les candidatures de la base

**Solutions :**
1. Cliquez sur **"Appliquer des filtres d'abord"**
2. Ou cliquez sur **"Annuler"** en bas
3. Retournez à la liste
4. Appliquez vos filtres
5. Relancez l'export

---

## 🐛 Résolution de problèmes

### Problème 1 : "Je ne vois pas mes filtres sur la page d'export"

**Cause possible :** Les filtres n'ont pas été appliqués avant de cliquer sur "Export personnalisé"

**Solution :**
1. Retournez à la liste (bouton "Annuler")
2. Vérifiez que le panneau de filtres est bien rempli
3. Cliquez sur **"Filtrer"** dans le panneau (important !)
4. Attendez que la liste se mette à jour
5. Relancez "Export personnalisé"

---

### Problème 2 : "L'export contient toutes les candidatures alors que j'ai filtré"

**Vérification :**
1. Sur la page de sélection des colonnes, regardez le bloc "Filtres appliqués"
2. Si vous voyez "Aucun filtre appliqué" → Les filtres n'ont pas été conservés

**Solution :**
1. Videz le cache : `php app/console cache:clear`
2. Réessayez le processus complet
3. Vérifiez les logs : `app/logs/dev.log` (cherchez "Filtres appliqués au datagrid")

---

### Problème 3 : "Le bouton 'Export personnalisé' n'apparaît pas"

**Solution :**
1. Videz le cache
2. Vérifiez vos permissions d'administration
3. Actualisez la page (Ctrl+F5)

---

## 📝 Logs de debug

Pour diagnostiquer un problème de filtres, consultez `app/logs/dev.log` :

```bash
# Voir les dernières entrées
tail -f app/logs/dev.log

# Chercher les logs d'export
grep "customExportAction" app/logs/dev.log
grep "Filtres appliqués" app/logs/dev.log
```

Vous devriez voir :
```
[info] customExportAction appelée
[info] Filtres appliqués au datagrid {"filters":{"espace":"Mon Espace"},"result_count":15}
```

Le `result_count` vous indique combien de candidatures seront exportées.

---

## 💡 Astuces

### Astuce 1 : Sauvegarder vos filtres
Malheureusement, Sonata Admin ne sauvegarde pas les filtres entre les sessions. Mais vous pouvez :
- Mettre en favori l'URL de la liste avec les filtres appliqués
- Exemple : `/admin/candidature/list?filter[espace][value]=3`

### Astuce 2 : Export rapide récurrent
Si vous exportez souvent les mêmes données :
1. Appliquez vos filtres habituels
2. Export personnalisé
3. Cliquez sur "Sélection recommandée"
4. Exportez

### Astuce 3 : Vérifier le nombre de résultats
Avant l'export, regardez en bas de la liste :
```
"Affichage de 15 résultats sur 15"
```
Ce chiffre = nombre de lignes dans votre export (hors en-tête)

---

## 📞 Support

Si les filtres ne fonctionnent toujours pas après avoir suivi ce guide :

1. Vérifiez la console du navigateur (F12) pour les erreurs JavaScript
2. Consultez les logs Symfony : `app/logs/dev.log`
3. Envoyez ces informations :
   - Les filtres que vous essayez d'appliquer
   - Le message affiché sur la page de sélection des colonnes
   - Le nombre de résultats dans la liste vs le nombre de lignes dans l'export

---

**Version du guide :** 1.1  
**Date :** 12 janvier 2026  
**Correctif :** Conservation des filtres lors de l'export personnalisé ✅

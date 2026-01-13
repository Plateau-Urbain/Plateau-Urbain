# Guide : Génération de candidatures fake

Cette commande permet de générer des candidatures de test (fake) pour un appel à candidatures sans avoir à créer de vrais emails.

## Comment trouver l'ID de l'AAC (espace)

L'ID de l'AAC correspond à l'ID de l'espace dans la base de données. Vous pouvez le trouver de plusieurs façons :

### Méthode 1 : Via Sonata Admin (recommandé)
1. Connectez-vous à l'interface Sonata Admin
2. Allez dans la section **"Propriétés"** (ou "Espaces")
3. Ouvrez l'AAC que vous voulez
4. Regardez l'URL dans votre navigateur : elle contiendra `/property/{id}/edit` ou `/property/{id}/show`
5. Le nombre dans l'URL est l'ID de l'espace

### Méthode 2 : Via l'interface de gestion des espaces
1. Allez dans "Gestion des espaces" ou "Mes espaces"
2. Ouvrez l'AAC souhaité
3. L'ID est visible dans l'URL de la page de détail

### Méthode 3 : Via une requête SQL
```sql
SELECT id, name FROM space ORDER BY id DESC;
```

### Méthode 4 : Via la console Symfony
```bash
php app/console dbal:run-sql "SELECT id, name FROM space"
```

## Utilisation

### Commande de base

Remplacez `<space-id>` par l'ID de votre AAC trouvé ci-dessus :

```bash
php app/console app:generate-fake-applications <space-id>
```

### Options disponibles

- `--count` ou `-c` : Nombre de candidatures à créer (défaut: 10)
- `--status` ou `-s` : Statut spécifique ou "random" pour mélanger (défaut: "random")

### Statuts disponibles

- `draft` : Brouillon
- `unread` : Non lue
- `awaiting` : En attente
- `accepted` : Accepté
- `rejected` : Refusé
- `random` : Mélange aléatoire de tous les statuts

## Exemples

### Générer 10 candidatures avec statuts aléatoires

```bash
php app/console app:generate-fake-applications 1
```

### Générer 50 candidatures avec statuts aléatoires

```bash
php app/console app:generate-fake-applications 1 --count=50
```

### Générer 20 candidatures toutes en statut "unread"

```bash
php app/console app:generate-fake-applications 1 --count=20 --status=unread
```

### Générer 30 candidatures toutes acceptées

```bash
php app/console app:generate-fake-applications 1 -c 30 -s accepted
```

## Détails techniques

- Les utilisateurs créés ont des emails au format : `fake.candidature.{space-id}.{numero}@test.local`
- Chaque candidature a des données réalistes mais fictives (noms, entreprises, descriptions, etc.)
- Les candidatures sont automatiquement associées à l'espace spécifié
- Si un utilisateur avec le même email existe déjà, il est ignoré (pas de doublon)
- Les candidatures utilisent des catégories existantes de manière aléatoire

## Notes importantes

⚠️ **Attention** : Ces candidatures sont créées en base de données réelle. Assurez-vous d'être en environnement de développement ou de test.

Pour supprimer les candidatures fake créées, vous pouvez utiliser l'interface Sonata Admin ou une requête SQL :

```sql
DELETE FROM application WHERE project_holder_id IN (
    SELECT id FROM fos_user WHERE email LIKE 'fake.candidature.%@test.local'
);
DELETE FROM fos_user WHERE email LIKE 'fake.candidature.%@test.local';
```

# Documentation : Correction du problème d'upload des PDFs

**Date** : 12 janvier 2026  
**Problème** : Les fichiers PDF ne sont pas acceptés dans la section 4 "Documents ressources"

## 🐛 Problème identifié

### Contexte
L'entité `SpaceImage` est utilisée pour gérer **deux types de fichiers différents** :
1. **Photos** (Section 2 - Photos du lieu) → JPEG, PNG, WebP (max 600 Ko)
2. **Documents** (Section 4 - Documents ressources) → PDF, DOC, DOCX (max 10 Mo)

### Cause du bug
La contrainte de validation dans `SpaceImage.php` était configurée pour n'accepter **que les images** :

```php
/**
 * @Assert\File(
 *     maxSize="600k",
 *     mimeTypes={"image/jpeg", "image/jpg", "image/png", "image/webp"},
 *     mimeTypesMessage="Seuls les formats JPEG, PNG et WebP sont acceptés"
 * )
 */
protected $file;
```

Cette validation s'appliquait à **tous** les fichiers uploadés via `SpaceImage`, y compris :
- Les photos de la galerie (section 2) ✅
- Le document "Appel à candidature" (section 4) ❌
- Le document "Répartition des espaces" (section 4) ❌

Résultat : **Les PDFs étaient systématiquement rejetés** même dans la section Documents ressources.

## ✅ Solution implémentée

### 1. Validation conditionnelle basée sur le type de fichier

**Fichier modifié** : `src/AppBundle/Entity/SpaceImage.php`

#### Ajout de l'import nécessaire

```php
use Symfony\Component\Validator\Context\ExecutionContextInterface;
```

#### Suppression de la contrainte statique

La contrainte `@Assert\File` a été supprimée de la propriété `$file` pour éviter qu'elle s'applique à tous les types de fichiers indistinctement.

#### Ajout d'une méthode de validation callback

```php
/**
 * Validation conditionnelle selon le type de fichier
 * 
 * @Assert\Callback
 */
public function validateFile(ExecutionContextInterface $context)
{
    if ($this->file === null) {
        return;
    }

    $fileType = $this->getFileType();

    // Validation pour les images (section 2 - Photos du lieu)
    if ($fileType === self::FILETYPE_IMAGE) {
        $allowedMimeTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
        $maxSize = 600 * 1024; // 600 Ko
        $errorMessage = 'Seuls les formats JPEG, PNG et WebP sont acceptés pour les photos (max 600 Ko)';
    }
    // Validation pour les documents (section 4 - Documents ressources)
    else if ($fileType === self::FILETYPE_DOCUMENT_AAC || $fileType === self::FILETYPE_DOCUMENT_PLAN) {
        $allowedMimeTypes = [
            'application/pdf',
            'application/x-pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
        ];
        $maxSize = 10 * 1024 * 1024; // 10 Mo
        $errorMessage = 'Seuls les formats PDF, DOC et DOCX sont acceptés pour les documents (max 10 Mo)';
    }
    else {
        // Par défaut, accepter les images
        $allowedMimeTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
        $maxSize = 600 * 1024;
        $errorMessage = 'Format de fichier non reconnu';
    }

    // Vérification du type MIME
    if (!in_array($this->file->getMimeType(), $allowedMimeTypes)) {
        $context->buildViolation($errorMessage)
            ->atPath('file')
            ->addViolation();
    }

    // Vérification de la taille
    if ($this->file->getSize() > $maxSize) {
        $maxSizeMB = round($maxSize / (1024 * 1024), 1);
        $context->buildViolation('Le fichier est trop volumineux (max ' . $maxSizeMB . ' Mo)')
            ->atPath('file')
            ->addViolation();
    }
}
```

### 2. Amélioration de l'interface utilisateur

**Fichier modifié** : `app/Resources/AppBundle/views/SpaceManagement/Partials/_space_required_form.html.twig`

Ajout d'un message informatif clair pour l'utilisateur :

```html
<p class="text-muted small">
    <i class="fa fa-info-circle"></i>
    Formats acceptés : <strong>PDF, DOC, DOCX</strong>. Taille maximale : <strong>10 Mo</strong> par document.
</p>
```

## 📋 Récapitulatif des validations

| Type de fichier | Section | Formats acceptés | Taille max | Champ |
|----------------|---------|------------------|------------|-------|
| **Photos** | Section 2 | JPEG, PNG, WebP | 600 Ko | `pics` |
| **Document AAC** | Section 4 | PDF, DOC, DOCX | 10 Mo | `doc_aac` |
| **Document Plan** | Section 4 | PDF, DOC, DOCX | 10 Mo | `doc_plan` |

## 🔧 Fonctionnement technique

### Types MIME acceptés

#### Pour les images (FILETYPE_IMAGE)
- `image/jpeg`
- `image/jpg`
- `image/png`
- `image/webp`

#### Pour les documents (FILETYPE_DOCUMENT_AAC et FILETYPE_DOCUMENT_PLAN)
- `application/pdf`
- `application/x-pdf`
- `application/msword` (DOC)
- `application/vnd.openxmlformats-officedocument.wordprocessingml.document` (DOCX)

### Détection du type de fichier

La méthode `validateFile()` utilise `getFileType()` pour déterminer s'il s'agit :
- D'une image : `FILETYPE_IMAGE = 'image'`
- D'un document AAC : `FILETYPE_DOCUMENT_AAC = 'document_aac'`
- D'un document Plan : `FILETYPE_DOCUMENT_PLAN = 'document_plan'`

Le type est défini lors de l'ajout du fichier dans `SpaceType.php` :

```php
// Pour les documents AAC
if ($newDocAAC instanceof SpaceImage && $newDocAAC->getFile() !== null) {
    $space->addDoc($newDocAAC, SpaceImage::FILETYPE_DOCUMENT_AAC);
}

// Pour les documents Plan
if ($newDocPlan instanceof SpaceImage && $newDocPlan->getFile() !== null) {
    $space->addDoc($newDocPlan, SpaceImage::FILETYPE_DOCUMENT_PLAN);
}
```

## ✅ Tests à effectuer

### Test 1 : Upload d'une photo (Section 2)
1. Aller à la section "Photos du lieu"
2. Essayer d'uploader un PDF → ❌ Devrait être rejeté
3. Essayer d'uploader un JPEG de 500 Ko → ✅ Devrait être accepté
4. Essayer d'uploader un PNG de 800 Ko → ❌ Devrait être rejeté (trop gros)

### Test 2 : Upload d'un document AAC (Section 4)
1. Aller à la section "Documents ressources"
2. Dans "Appel à candidature"
3. Essayer d'uploader un JPEG → ❌ Devrait être rejeté
4. Essayer d'uploader un PDF de 5 Mo → ✅ Devrait être accepté
5. Essayer d'uploader un DOC → ✅ Devrait être accepté
6. Essayer d'uploader un PDF de 12 Mo → ❌ Devrait être rejeté (trop gros)

### Test 3 : Upload d'un document Plan (Section 4)
1. Aller à la section "Documents ressources"
2. Dans "Répartition des espaces"
3. Essayer d'uploader un PDF → ✅ Devrait être accepté
4. Vérifier que le document est bien sauvegardé et téléchargeable

## 📝 Messages d'erreur

Les utilisateurs verront maintenant des messages clairs et spécifiques :

### Pour les images
- ❌ "Seuls les formats JPEG, PNG et WebP sont acceptés pour les photos (max 600 Ko)"
- ❌ "Le fichier est trop volumineux (max 0.6 Mo)"

### Pour les documents
- ❌ "Seuls les formats PDF, DOC et DOCX sont acceptés pour les documents (max 10 Mo)"
- ❌ "Le fichier est trop volumineux (max 10 Mo)"

## 🎯 Avantages de cette solution

1. ✅ **Flexibilité** : Chaque type de fichier a ses propres règles de validation
2. ✅ **Clarté** : Messages d'erreur spécifiques selon le contexte
3. ✅ **Maintenabilité** : Facile d'ajouter de nouveaux types de fichiers ou de modifier les contraintes
4. ✅ **Cohérence** : La logique de validation est centralisée dans l'entité
5. ✅ **UX** : Instructions claires affichées dans l'interface

## 🔄 Migration des données existantes

Cette modification est **rétrocompatible** :
- Les fichiers déjà uploadés ne sont pas affectés
- La validation ne s'applique qu'aux nouveaux uploads
- Pas de migration de base de données nécessaire

## 💡 Améliorations futures possibles

- [ ] Validation JavaScript côté client pour feedback immédiat
- [ ] Preview des PDFs avant upload
- [ ] Compression automatique des fichiers trop volumineux
- [ ] Support de formats supplémentaires (XLS, PPT, etc.)
- [ ] Génération automatique de miniatures pour les PDFs

## 📚 Références

- [Symfony File Constraints](https://symfony.com/doc/2.8/reference/constraints/File.html)
- [Symfony Callback Constraint](https://symfony.com/doc/2.8/reference/constraints/Callback.html)
- [VichUploaderBundle](https://github.com/dustin10/VichUploaderBundle)

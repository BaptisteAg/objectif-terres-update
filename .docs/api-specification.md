# Spécification API - Extraction des Données d'Annonces

## Vue d'ensemble

Cette API permet aux clients externes d'extraire les données des annonces publiées d'Objectif Terres. Elle remplace l'implémentation ETL incomplète par une approche simple de récupération de données via endpoint REST.

## Endpoint Principal

### GET /api/v1/annonces

**URL complète :** `https://objectif-terres.org/api/v1/annonces`

**Méthode :** GET

**Authentification :** Clé API dans l'en-tête `Ot-api-key`

**Cache :** 1 heure (3600 secondes)

**Rate Limiting :** 60 requêtes par minute (uniquement en production)

## Authentification

### Configuration
```bash
# Dans le fichier .env
API_TOKEN=votre_token_secret_ici
```

### Utilisation
```http
GET /api/v1/annonces
Ot-api-key: votre_token_secret_ici
```

**Réponse d'erreur (401) :**
```json
{
    "message": "Unauthorized"
}
```

## Paramètres de Requête

### `limit` (optionnel)
- **Type :** Integer
- **Valeur par défaut :** 4
- **Minimum :** 1
- **Maximum :** 100
- **Description :** Nombre d'annonces à retourner

### `type` (optionnel)
- **Type :** String
- **Valeurs autorisées :**
  - `landOfferAd` : Offres de terrain
  - `landSeekAd` : Recherches de terrain
  - `jobOfferAd` : Offres d'emploi
  - `jobSeekAd` : Recherches d'emploi
  - `associateOfferAd` : Recherches d'associé pour ferme existante
  - `associateSeekAd` : Recherches d'associé pour projet d'installation
- **Valeur par défaut :** `landOfferAd` et `landSeekAd` (annonces de terrain uniquement)

### `region_code` (optionnel)
- **Type :** String
- **Format :** Code INSEE de la région
- **Validation :** Doit exister dans la table `regions`
- **Description :** Filtre les annonces par région

## Critères de Filtrage

### Annonces Incluses
L'API retourne uniquement les annonces qui respectent **tous** les critères suivants :

1. **Statut validé :** `ad_status_id = 1` (AdStatus::APPROVE_ID)
2. **Non-brouillon :** `is_draft = 0`
3. **Avec image :** Au moins un document de type `image/*`
4. **Avec attribution :** Relation `attributionAd` existante

### Ordre de Tri
- **Tri principal :** `created_at DESC` (plus récentes en premier)
- **Limite :** Paramètre `limit` (défaut : 4)

## Format de Réponse

### Structure JSON
```json
[
    {
        "id": 12345,
        "link": "https://objectif-terres.org/annonces/12345",
        "title": "Titre de l'annonce",
        "type": "landOfferAd",
        "type_label": "Offre de terres",
        "offer_types": "Vente, Location",
        "image": "https://objectif-terres.org/storage/documents/image.jpg",
        "surface": "25.5",
        "region_name": "Occitanie",
        "region_code": "76",
        "department_name": "Hérault",
        "department_code": "34",
        "created_at": 1640995200,
        "updated_at": 1640995200
    }
]
```

### Description des Champs

#### `id`
- **Type :** Integer
- **Description :** Identifiant unique de l'annonce

#### `link`
- **Type :** String (URL)
- **Description :** URL complète vers la page de l'annonce
- **Format :** `https://objectif-terres.org/annonces/{id}`

#### `title`
- **Type :** String
- **Description :** Titre de l'annonce
- **Source :** `ads.title`

#### `type`
- **Type :** String
- **Description :** Type technique de l'annonce
- **Valeurs :** `landOfferAd`, `landSeekAd`, `jobOfferAd`, `jobSeekAd`, `associateOfferAd`, `associateSeekAd`

#### `type_label`
- **Type :** String
- **Description :** Libellé français du type d'annonce
- **Mapping :**
  - `landOfferAd` → "Offre de terres"
  - `landSeekAd` → "Recherche de terres"
  - `jobOfferAd` → "Offre d'emploi"
  - `jobSeekAd` → "Recherche d'emploi"
  - `associateOfferAd` → "Recherche Associé pour un ferme existante"
  - `associateSeekAd` → "Recherche d'associé pour projet d'installation"

#### `offer_types`
- **Type :** String | null
- **Description :** Types d'offres pour les annonces de terrain (landOfferAd uniquement)
- **Source :** `land_offer_ads.offerGenres` (relation Many-to-Many)
- **Format :** Valeurs séparées par virgules ("Vente, Location")
- **Valeurs possibles :** "Vente", "Location", "Test agricole", "Leg ou donation"

#### `image`
- **Type :** String (URL)
- **Description :** URL complète vers la première image de l'annonce
- **Source :** Premier document de type `image/*`
- **Logique de fallback :** Si l'image n'existe pas localement, utilise `https://objectif-terres.org`

#### `surface`
- **Type :** String | null
- **Description :** Surface concernée par l'annonce
- **Logique :**
  - **landOfferAd :** `land_offer_ads.surface` (valeur directe)
  - **landSeekAd :** Calcul basé sur `surface_range_min` et `surface_range_max`
    - Si min = max : affiche la valeur exacte
    - Si max = 1000000 et min = 0 : "∞"
    - Si max = 1000000 et min > 0 : "Au moins {min}"
    - Si min = 0 et max < 1000000 : "Jusqu'à {max}"
    - Sinon : "{min} - {max}"
  - **Autres types :** null

#### `region_name`
- **Type :** String
- **Description :** Nom de la région
- **Source :** Déterminée par hiérarchie géographique (voir section Géolocalisation)

#### `region_code`
- **Type :** String
- **Description :** Code INSEE de la région
- **Source :** Déterminée par hiérarchie géographique

#### `department_name`
- **Type :** String | null
- **Description :** Nom du département
- **Source :** Déterminée par hiérarchie géographique

#### `department_code`
- **Type :** String | null
- **Description :** Code INSEE du département
- **Source :** Déterminée par hiérarchie géographique

#### `created_at`
- **Type :** Integer (timestamp Unix)
- **Description :** Date de création de l'annonce

#### `updated_at`
- **Type :** Integer (timestamp Unix)
- **Description :** Date de dernière modification

## Géolocalisation

### Hiérarchie de Résolution
L'API détermine la localisation selon l'ordre de priorité suivant :

1. **Région directe :** `ads.regions` (relation Many-to-Many)
2. **Département puis région :** `ads.departments` → `departments.region`
3. **Ville puis département puis région :** `ads.cities` → `cities.department` → `departments.region`

### Relations Utilisées
- `ads.regions` : Relation morphedByMany avec `regions`
- `ads.departments` : Relation morphedByMany avec `departments`
- `ads.cities` : Relation morphedByMany avec `cities`

## Système de Cache

### Configuration
- **Durée :** 3600 secondes (1 heure)
- **Clé :** `api-ads-{hash}` où `hash = md5(json_encode(parametres_requete))`
- **Invalidation :** Automatique par TTL, manuel en mode non-production

### Stratégie
- **Production :** Cache activé, invalidation uniquement par expiration
- **Non-production :** Cache désactivé à chaque requête pour faciliter le développement

## Rate Limiting

### Configuration Production
- **Limite :** 60 requêtes par minute
- **Middleware :** `throttle:60,1`
- **Application :** Uniquement en environnement `production`

### Développement
- **Limite :** Aucune restriction
- **Environnement :** `local`, `staging`, etc.

## Gestion des Erreurs

### 401 Unauthorized
```json
{
    "message": "Unauthorized"
}
```
**Cause :** Token API manquant ou incorrect

### 422 Validation Error
```json
{
    "message": "The given data was invalid.",
    "errors": {
        "limit": ["The limit must be between 1 and 100."],
        "type": ["The selected type is invalid."],
        "region_code": ["The selected region code is invalid."]
    }
}
```
**Cause :** Paramètres de requête invalides

### 429 Too Many Requests
```json
{
    "message": "Too Many Attempts."
}
```
**Cause :** Limite de rate limiting dépassée (production uniquement)

## Exemples d'Usage

### Récupération de Base
```bash
curl -H "Ot-api-key: votre_token" \
     "https://objectif-terres.org/api/v1/annonces"
```

### Avec Paramètres
```bash
curl -H "Ot-api-key: votre_token" \
     "https://objectif-terres.org/api/v1/annonces?limit=10&type=landOfferAd&region_code=76"
```

### Toutes les Annonces d'Emploi
```bash
curl -H "Ot-api-key: votre_token" \
     "https://objectif-terres.org/api/v1/annonces?limit=50&type=jobOfferAd"
```

## Relations Base de Données

### Requête Principale
```sql
SELECT ads.* FROM ads
INNER JOIN attribution_ads ON ads.id = attribution_ads.ad_id
WHERE attribution_ads.ad_status_id = 1  -- APPROVE_ID
  AND ads.is_draft = 0
  AND EXISTS (
    SELECT 1 FROM documentables 
    INNER JOIN documents ON documentables.document_id = documents.id
    WHERE documentables.documentable_id = ads.id
      AND documentables.documentable_type = 'App\\Models\\Ad'
      AND documents.type LIKE 'image%'
  )
ORDER BY ads.created_at DESC
LIMIT ?
```

### Eager Loading
- `documents` : Images attachées
- `regions` : Régions liées
- `departments` : Départements liés
- `cities` : Villes liées
- `landOfferAd.offerGenres` : Types d'offres pour les annonces de terrain

## Limitations et Considérations

### Données Incluses
- ✅ Annonces validées et publiées uniquement
- ✅ Avec au moins une image
- ✅ Informations de base (titre, type, localisation)
- ✅ Métadonnées (dates, URL)

### Données Exclues
- ❌ Annonces brouillons (`is_draft = 1`)
- ❌ Annonces refusées ou en attente
- ❌ Annonces sans images
- ❌ Contenu détaillé des annonces
- ❌ Données sensibles (contacts, notes internes)
- ❌ Historique des modifications

### Performance
- **Cache :** Réduit la charge sur la base de données
- **Limite :** Maximum 100 annonces par requête
- **Index :** Optimisé pour les requêtes sur `ad_status_id`, `is_draft`, `created_at`

## Évolutions Possibles

### Extensions Futures
1. **Pagination :** Système de pagination avec `offset` et `next_page`
2. **Filtres avancés :** Surface, prix, production, etc.
3. **Contenu détaillé :** Descriptions complètes, coordonnées
4. **Formats multiples :** XML, CSV en plus du JSON
5. **Webhooks :** Notifications de nouvelles annonces
6. **Statistiques :** Endpoint pour les métriques d'usage

### Optimisations Techniques
1. **Compression :** Gzip pour réduire la taille des réponses
2. **CDN :** Cache distribué pour les images
3. **Versioning :** Support de versions multiples de l'API
4. **Documentation :** Swagger/OpenAPI intégré

## Configuration Requise

### Serveur
- **PHP :** >= 8.0
- **Laravel :** 6.x
- **Extensions :** GD/Imagick pour le traitement d'images

### Base de Données
- **Index requis :**
  - `attribution_ads(ad_status_id, ad_id)`
  - `ads(is_draft, created_at)`
  - `documentables(documentable_type, documentable_id)`
  - `documents(type)`

### Variables d'Environnement
```bash
# Configuration API
API_TOKEN=token_secret_complexe

# URLs de base
APP_URL=https://objectif-terres.org

# Cache
CACHE_DRIVER=redis  # recommandé pour la production
```

## Sécurité

### Authentification
- **Token API :** Stocké dans `config/app.php`
- **Validation :** Comparaison stricte en PHP
- **Rotation :** Manuelle via mise à jour de configuration

### Protection
- **Rate limiting :** Prévention des abus
- **Filtrage :** Seules les données publiques sont exposées
- **Validation :** Tous les paramètres sont validés
- **Cache :** Prévention des attaques par déni de service

### Recommandations
1. **Token complexe :** Minimum 32 caractères aléatoires
2. **HTTPS uniquement :** Chiffrement des communications
3. **Logs :** Surveillance des accès API
4. **Rotation régulière :** Changement périodique du token
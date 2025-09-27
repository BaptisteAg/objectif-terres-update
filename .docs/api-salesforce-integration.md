# API Salesforce Integration - Spécification Étendue

## Objectif

Extension de l'API existante `/api/v1/annonces` pour permettre à Salesforce de synchroniser les annonces en mode pull, remplaçant l'ETL incomplet par un découplage propre entre les applications.

## Endpoints Proposés

### 1. Endpoint Principal Étendu

#### `GET /api/v1/annonces`

**Extensions à ajouter :**

##### Nouveau Paramètre : `modified_since`
- **Type :** String (ISO 8601)
- **Format :** `YYYY-MM-DDTHH:MM:SSZ`
- **Description :** Récupère les annonces modifiées après cette date
- **Exemple :** `2025-07-18T10:30:00Z`
- **Utilisation :** `?modified_since=2025-07-18T10:30:00Z`

##### Nouveau Paramètre : `page`
- **Type :** Integer
- **Minimum :** 1
- **Défaut :** 1
- **Description :** Numéro de page pour la pagination

##### Nouveau Paramètre : `per_page`
- **Type :** Integer
- **Minimum :** 1
- **Maximum :** 100
- **Défaut :** 20
- **Description :** Nombre d'éléments par page

##### Paramètre Modifié : `limit`
- **Statut :** Déprécié en faveur de `per_page`
- **Comportement :** Si présent, ignore `page` et `per_page`

#### Structure de Réponse Étendue

```json
{
  "data": [
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
      "updated_at": 1640995200,
      
      // --- NOUVELLES DONNÉES ---
      "status": "published",
      "status_id": 1,
      "published_at": 1640995200,
      "archived_at": null,
      "description": "Description complète de l'annonce...",
      "project_description": "Description du projet...",
      "support_request": "Demande d'accompagnement...",
      "is_partner": false,
      "origin": "web",
      "contact_sharing_accepted": true,
      
      // Données du créateur
      "user": {
        "id": 456,
        "name": "Jean Dupont",
        "email": "jean.dupont@example.com",
        "is_third_party": false
      },
      
      // Données de modération
      "moderation": {
        "moderator_id": 789,
        "moderator_name": "Marie Martin",
        "advisors": [
          {
            "id": 101,
            "name": "Pierre Conseiller",
            "type": "primary"
          }
        ],
        "validated_at": 1640995200,
        "refusal_reason": null
      },
      
      // Localisation détaillée
      "location": {
        "cities": [
          {
            "id": 1,
            "name": "Montpellier",
            "code": "34172",
            "radius": "10"
          }
        ],
        "departments": [
          {
            "id": 34,
            "name": "Hérault",
            "code": "34"
          }
        ],
        "regions": [
          {
            "id": 76,
            "name": "Occitanie",
            "code": "76"
          }
        ]
      },
      
      // Données spécifiques selon le type
      "specific_data": {
        // Pour landOfferAd
        "surface": 25.5,
        "altitude": 150.0,
        "water_access": true,
        "water_access_description": "Forage privé",
        "has_buildings": true,
        "has_houses": false,
        "price": 150000.0,
        "rent_price": null,
        "sau_description": "Terres arables de qualité",
        "is_activity_transfer": false,
        "support_requests": {
          "is_beneficiary": false,
          "is_community_call": false,
          "is_tdl_call": true,
          "is_test_area": false
        },
        "offer_types": [
          {
            "id": 1,
            "name": "Vente",
            "code": "vente"
          }
        ]
      },
      
      // Tous les documents
      "documents": [
        {
          "id": 1,
          "name": "photo_terrain.jpg",
          "type": "image/jpeg",
          "url": "https://objectif-terres.org/storage/documents/photo_terrain.jpg",
          "size": 245760
        }
      ],
      
      // Types de production
      "production_types": [
        {
          "id": 1,
          "name": "Maraîchage",
          "code": "maraichage",
          "type": "actual"
        }
      ]
    }
  ],
  "pagination": {
    "current_page": 1,
    "per_page": 20,
    "total": 150,
    "total_pages": 8,
    "has_next": true,
    "has_previous": false
  },
  "meta": {
    "generated_at": "2025-07-18T12:30:00Z",
    "cache_expires_at": "2025-07-18T13:30:00Z",
    "total_filtered": 150,
    "filters_applied": {
      "modified_since": "2025-07-18T10:30:00Z",
      "type": null,
      "region_code": null
    }
  }
}
```

### 2. Nouveaux Endpoints Spécialisés

#### `GET /api/v1/annonces/{id}`

**Description :** Récupération d'une annonce spécifique avec toutes ses données

**Paramètres :**
- `{id}` : ID de l'annonce

**Réponse :** Objet annonce complet (même structure que dans le tableau `data`)

#### `GET /api/v1/annonces/statuses`

**Description :** Liste des statuts d'annonces disponibles

**Réponse :**
```json
{
  "data": [
    {
      "id": 1,
      "name": "Validée",
      "code": "approved",
      "description": "Annonce modérée publiée"
    },
    {
      "id": 2,
      "name": "En attente",
      "code": "pending",
      "description": "Annonce modérée en attente"
    },
    {
      "id": 3,
      "name": "Refusée",
      "code": "refused",
      "description": "Annonce modérée non publiée"
    },
    {
      "id": 4,
      "name": "À modérer",
      "code": "pending_moderation",
      "description": "Annonce à traiter par un modérateur"
    },
    {
      "id": 5,
      "name": "Archivée",
      "code": "archived",
      "description": "Annonce dépubliée automatiquement"
    }
  ]
}
```

#### `GET /api/v1/annonces/types`

**Description :** Liste des types d'annonces disponibles

**Réponse :**
```json
{
  "data": [
    {
      "type": "landOfferAd",
      "label": "Offre de terres",
      "description": "Proposition de terrain agricole"
    },
    {
      "type": "landSeekAd",
      "label": "Recherche de terres",
      "description": "Recherche de terrain agricole"
    },
    {
      "type": "jobOfferAd",
      "label": "Offre d'emploi",
      "description": "Proposition d'emploi agricole"
    },
    {
      "type": "jobSeekAd",
      "label": "Recherche d'emploi",
      "description": "Recherche d'emploi agricole"
    },
    {
      "type": "associateOfferAd",
      "label": "Recherche d'associé pour ferme existante",
      "description": "Recherche d'associé pour exploitation en cours"
    },
    {
      "type": "associateSeekAd",
      "label": "Recherche d'associé pour projet",
      "description": "Recherche d'associé pour nouveau projet"
    }
  ]
}
```

#### `GET /api/v1/locations/regions`

**Description :** Liste des régions disponibles

**Réponse :**
```json
{
  "data": [
    {
      "id": 76,
      "name": "Occitanie",
      "code": "76"
    }
  ]
}
```

#### `GET /api/v1/locations/departments`

**Paramètres :**
- `region_code` (optionnel) : Filtrer par région

**Description :** Liste des départements disponibles

#### `GET /api/v1/production-types`

**Description :** Liste des types de production disponibles

## Paramètres Étendus

### Filtres Supplémentaires

#### `status`
- **Type :** String ou Array
- **Valeurs :** `published`, `pending`, `refused`, `archived`
- **Défaut :** `published`
- **Exemple :** `?status=published,pending`

#### `created_since`
- **Type :** String (ISO 8601)
- **Description :** Annonces créées après cette date

#### `published_since`
- **Type :** String (ISO 8601)
- **Description :** Annonces publiées après cette date

#### `user_id`
- **Type :** Integer
- **Description :** Filtrer par créateur d'annonce

#### `moderator_id`
- **Type :** Integer
- **Description :** Filtrer par modérateur assigné

#### `has_images`
- **Type :** Boolean
- **Défaut :** `true`
- **Description :** Inclure seulement les annonces avec/sans images

#### `surface_min` / `surface_max`
- **Type :** Float
- **Description :** Filtrer par surface (pour les annonces de terrain)

#### `department_code`
- **Type :** String
- **Description :** Filtrer par département

#### `city_code`
- **Type :** String
- **Description :** Filtrer par ville

## Gestion des Erreurs Étendues

### 400 Bad Request
```json
{
  "error": "bad_request",
  "message": "Invalid date format for modified_since parameter",
  "details": {
    "parameter": "modified_since",
    "expected_format": "YYYY-MM-DDTHH:MM:SSZ",
    "received": "2025-07-18"
  }
}
```

### 404 Not Found
```json
{
  "error": "not_found",
  "message": "Ad not found",
  "ad_id": 99999
}
```

## Optimisations pour Salesforce

### 1. Indexation Base de Données

```sql
-- Index pour les requêtes de synchronisation
CREATE INDEX idx_ads_sync ON ads(updated_at, is_draft, deleted_at);
CREATE INDEX idx_attribution_ads_sync ON attribution_ads(ad_id, ad_status_id, updated_at);
CREATE INDEX idx_ads_published ON attribution_ads(published_on, ad_status_id);
```

### 2. Cache Intelligent

#### Clés de Cache
- `api-ads-list-{hash}` : Liste paginée
- `api-ads-detail-{id}` : Détail d'une annonce
- `api-ads-meta-{date}` : Métadonnées (statuts, types, etc.)

#### Stratégie d'Invalidation
- **Modification d'annonce :** Invalider cache liste + détail
- **Nouvelle annonce :** Invalider cache liste
- **Changement statut :** Invalider cache liste + détail + métadonnées

### 3. Optimisation des Requêtes

#### Eager Loading Complet
```php
$ads = Ad::with([
    'attributionAd.adStatus',
    'attributionAd.userModerator',
    'attributionAd.userAdvisor',
    'attributionAd.userAdvisor2',
    'attributionAd.userAdvisor3',
    'attributionAd.userAdvisor4',
    'userPp',
    'thirdPartyAdUser',
    'documents',
    'regions',
    'departments',
    'cities',
    'landOfferAd.offerGenres',
    'landSeekAd.offerGenres',
    'landOfferAd.building',
    'landOfferAd.house',
    'productionGenres'
]);
```

## Sécurité Renforcée

### 1. Authentification API Key
- **Header :** `Salesforce-Api-Key`
- **Validation :** Token spécifique pour Salesforce
- **Rotation :** Système de rotation automatique

### 2. Rate Limiting Adapté
- **Salesforce :** 1000 requêtes/heure
- **Autres clients :** 60 requêtes/heure
- **Burst :** 100 requêtes/minute pour la synchro initiale

### 3. Monitoring
- **Logs :** Toutes les requêtes API
- **Métriques :** Nombre d'annonces synchronisées
- **Alertes :** Échecs de synchronisation

## Workflow de Synchronisation

### 1. Synchronisation Initiale
```bash
# Toutes les annonces publiées
GET /api/v1/annonces?status=published&per_page=100&page=1

# Continuer jusqu'à has_next = false
```

### 2. Synchronisation Incrémentale
```bash
# Annonces modifiées depuis la dernière sync
GET /api/v1/annonces?modified_since=2025-07-18T10:30:00Z&per_page=100
```

### 3. Gestion des Suppressions
- **Soft Delete :** Annonces supprimées incluses avec `deleted_at`
- **Status :** Annonces archivées avec `status = "archived"`

## Données Spécifiques par Type

### `landOfferAd`
```json
{
  "surface": 25.5,
  "altitude": 150.0,
  "water_access": true,
  "water_access_description": "Forage privé",
  "has_buildings": true,
  "has_houses": false,
  "price": 150000.0,
  "rent_price": null,
  "sau_description": "Description SAU",
  "test_description": "Description test",
  "is_activity_transfer": false,
  "support_requests": {
    "is_beneficiary": false,
    "is_community_call": false,
    "is_tdl_call": true,
    "is_test_area": false
  },
  "building": {
    "id": 1,
    "name": "Hangar agricole",
    "description": "Hangar de 200m²"
  },
  "house": {
    "id": 1,
    "name": "Maison d'habitation",
    "description": "Maison de 150m²"
  }
}
```

### `landSeekAd`
```json
{
  "surface_range_min": 10,
  "surface_range_max": 50,
  "price_max": 200000,
  "rent_max": 1000,
  "is_bio": true,
  "production_type_additional": "Élevage",
  "land_description": "Recherche terrain pour maraîchage",
  "experience_farming": "10 ans d'expérience",
  "installation_type": {
    "id": 1,
    "name": "Installation progressive",
    "code": "progressive"
  }
}
```

### `jobOfferAd`
```json
{
  "job_description": "Recherche ouvrier agricole",
  "experience_farming": "Expérience souhaitée",
  "is_activity_transmission": false
}
```

### `jobSeekAd`
```json
{
  "experience_farming": "5 ans d'expérience en maraîchage"
}
```

### `associateOfferAd`
```json
{
  "surface": 30.0,
  "altitude": 200.0,
  "water_access": 1,
  "has_buildings": true,
  "has_houses": false,
  "associate_description": "Recherche associé motivé",
  "experience_farming": "15 ans d'expérience",
  "is_activity_transmission": true,
  "accept_zip_code_use": true
}
```

### `associateSeekAd`
```json
{
  "is_land_already_found": false,
  "land_description": "Recherche terrain adapté",
  "associate_description": "Recherche associé complémentaire",
  "experience_farming": "Débutant motivé"
}
```

## Tests et Validation

### 1. Tests Unitaires
- Validation des paramètres
- Formatage des réponses
- Gestion des erreurs

### 2. Tests d'Intégration
- Synchronisation complète
- Gestion de la pagination
- Filtres combinés

### 3. Tests de Performance
- Réponse < 2 secondes pour 100 annonces
- Cache hit rate > 80%
- Pas de N+1 queries

## Migration et Déploiement

### 1. Phase 1 : Extension API
- Ajout des nouveaux paramètres
- Enrichissement des données
- Tests avec Salesforce

### 2. Phase 2 : Nouveaux Endpoints
- Endpoints spécialisés
- Optimisations performance
- Monitoring avancé

### 3. Phase 3 : Dépréciation ETL
- Arrêt de l'ancien système
- Migration complète vers API
- Nettoyage du code legacy

## Documentation OpenAPI

```yaml
openapi: 3.0.0
info:
  title: Objectif Terres API - Salesforce Integration
  version: 2.0.0
  description: API étendue pour synchronisation Salesforce

paths:
  /api/v1/annonces:
    get:
      summary: Liste des annonces avec pagination
      parameters:
        - name: modified_since
          in: query
          schema:
            type: string
            format: date-time
          description: Annonces modifiées depuis cette date
        - name: page
          in: query
          schema:
            type: integer
            minimum: 1
            default: 1
        - name: per_page
          in: query
          schema:
            type: integer
            minimum: 1
            maximum: 100
            default: 20
      responses:
        '200':
          description: Liste des annonces
          content:
            application/json:
              schema:
                type: object
                properties:
                  data:
                    type: array
                    items:
                      $ref: '#/components/schemas/Ad'
                  pagination:
                    $ref: '#/components/schemas/Pagination'
                  meta:
                    $ref: '#/components/schemas/Meta'
```

Cette spécification étendue répond aux besoins exprimés par Régis pour découpler les applications et permettre une synchronisation efficace en mode pull par Salesforce.
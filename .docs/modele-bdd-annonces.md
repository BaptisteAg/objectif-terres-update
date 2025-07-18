# Modèle de Base de Données - Annonces

## Vue d'ensemble

Le système d'annonces d'Objectif Terres utilise une architecture polymorphe permettant de gérer différents types d'annonces avec des spécifications métier distinctes.

## Structure Principale

### Table `ads` (Annonces)
Table principale contenant les informations communes à toutes les annonces.

**Colonnes principales :**
- `id` : Identifiant unique
- `user_pp_id` : Créateur de l'annonce (Porteur de Projet)
- `title` : Titre de l'annonce
- `about_content` : Description générale
- `about_project_content` : Description du projet
- `is_draft` : Statut brouillon (0/1)
- `accept_share_contact_infos` : Acceptation du partage des coordonnées
- `support_request_text` : Texte de demande d'accompagnement
- `support_request_territory_id` : Territoire d'accompagnement
- `support_request_id_region` : Région d'accompagnement (à supprimer)
- `is_partner` : Statut partenaire (0/1)
- `origin` : Origine de l'annonce
- `department_id` : Département principal
- `third_party_ad_user_id` : Utilisateur tiers (annonces importées)
- `deleted_at` : Suppression logique
- `created_at/updated_at` : Timestamps

### Table `attribution_ads` (Attribution Modération)
Gestion de l'attribution des annonces aux modérateurs.

**Colonnes principales :**
- `id` : Identifiant unique
- `ad_id` : Référence à l'annonce
- `user_advisor_id` : Conseiller principal
- `user_advisor_2_id` : Conseiller secondaire
- `user_advisor_3_id` : Conseiller tertiaire
- `user_advisor_4_id` : Conseiller quaternaire
- `user_moderator_id` : Modérateur assigné
- `user_supervisor_id` : Responsable territorial
- `ad_status_id` : Statut de modération
- `refusal_type_id` : Type de refus (si applicable)
- `published_on` : Date de publication
- `refused_on` : Date de refus
- `archived_at` : Date d'archivage
- `short_description` : Description courte
- `to_call_back` : À rappeler

## Types d'Annonces Polymorphes

Le système utilise 6 types d'annonces définis dans `Ad::AD_TYPES` :

### 1. Offres de Terrain (`land_offer_ads`)
**Colonnes spécifiques :**
- `surface` : Surface en hectares (float)
- `altitude` : Altitude (float, nullable)
- `water_access` : Accès à l'eau (boolean, nullable)
- `water_access_description` : Description de l'accès à l'eau (string 1500, nullable)
- `has_buildings` : Présence de bâtiments (boolean, nullable)
- `has_houses` : Présence de maisons (boolean, nullable)
- `price` : Prix de vente (float, nullable)
- `rent_price` : Prix de location (float, nullable)
- `sau_description` : Description SAU (string 1500, nullable)
- `test_description` : Description test (string 1500, nullable)
- `accept_use_zip_code` : Acceptation utilisation code postal (boolean, default 1)
- `building_id` : Référence bâtiment (foreign key, nullable)
- `house_id` : Référence maison (foreign key, nullable)
- **Support requests** :
  - `is_beneficiary` : Bénéficiaire (boolean, nullable)
  - `is_activity_transfer` : Transmission d'activité (boolean, nullable)
  - `is_call_for_application_community` : Appel à candidatures communauté (boolean, nullable)
  - `is_call_for_application_terre_de_liens` : Appel à candidatures TDL (boolean, nullable)
  - `is_call_for_application_test_area` : Appel à candidatures zone test (boolean, nullable)

### 2. Recherches de Terrain (`land_seek_ads`)
**Colonnes spécifiques :**
- `surface_range_min` : Surface minimum recherchée (integer, nullable)
- `surface_range_max` : Surface maximum recherchée (integer, nullable)
- `price_max` : Prix maximum (integer, nullable)
- `rent_max` : Loyer maximum (integer, nullable)
- `is_bio` : Agriculture biologique (boolean, nullable)
- `production_type_add` : Type de production additionnelle (string, nullable)
- `land_description` : Description du terrain recherché (text, nullable)
- `experience_farming` : Expérience agricole (text, nullable)
- `installation_type_id` : Type d'installation (foreign key, nullable)

### 3. Offres d'Emploi (`job_offer_ads`)
**Colonnes spécifiques :**
- `job_description` : Description du poste (string 1500)
- `experience_farming` : Expérience agricole requise (string 1500, nullable)
- `is_activity_transmission` : Transmission d'activité (boolean, nullable)

### 4. Recherches d'Emploi (`job_seek_ads`)
**Colonnes spécifiques :**
- `experience_farming` : Expérience agricole du candidat (string 1000)

### 5. Recherches d'Associé (`associate_seek_ads`)
**Colonnes spécifiques :**
- `is_land_already_found` : Terrain déjà trouvé (boolean, nullable)
- `land_description` : Description du terrain (string 1500)
- `associate_description` : Description de l'associé recherché (string 1500)
- `experience_farming` : Expérience agricole (string 1000)

### 6. Offres d'Association (`associate_offer_ads`)
**Colonnes spécifiques :**
- `surface` : Surface disponible (float)
- `altitude` : Altitude (float, nullable)
- `water_access` : Accès à l'eau (tinyInteger)
- `has_buildings` : Présence de bâtiments (boolean)
- `has_houses` : Présence de maisons (boolean)
- `associate_description` : Description de l'offre d'association (string 1500)
- `experience_farming` : Expérience agricole du proposant (string 1000)
- `is_activity_transmission` : Transmission d'activité (boolean)
- `accept_use_zip_code` : Acceptation utilisation code postal (boolean, default 1)

## Système de Localisation

### Table `locationable_ads` (Géolocalisation)
Système polymorphe de géolocalisation des annonces.

**Colonnes :**
- `id` : Identifiant unique (increments)
- `ad_id` : Référence à l'annonce (unsignedInteger, foreign key)
- `locationable_ad_id` : ID de l'entité géographique (unsignedInteger)
- `locationable_ad_type` : Type d'entité (string) - référence aux tables ads, researches
- `radius` : Rayon de recherche (string, nullable)
- `created_at/updated_at` : Timestamps

**Types supportés :**
- `App\Models\City` : Villes
- `App\Models\Department` : Départements
- `App\Models\Region` : Régions

**Contraintes :**
- Foreign key sur `ad_id` → `ads.id` (cascade delete/update)
- Index sur `ad_id`, `locationable_ad_id`, `locationable_ad_type`

## Tables Associées

### Table `favorite_ads` (Favoris)
Gestion des annonces favorites par utilisateur.

**Colonnes :**
- `id` : Identifiant unique (increments)
- `user_id` : Référence utilisateur (unsignedInteger, foreign key)
- `ad_id` : Référence annonce (unsignedInteger, foreign key)
- `created_at/updated_at` : Timestamps

**Contraintes :**
- Foreign key sur `ad_id` → `ads.id` (cascade delete/update)
- Foreign key sur `user_id` → `users.id` (cascade delete)

### Table `threads` (Conversations)
Système de messagerie associé aux annonces.

**Colonnes :**
- `id` : Identifiant unique (increments)
- `title` : Titre de la conversation (text, nullable)
- `is_private` : Conversation privée (boolean, default 1)
- `ad_id` : Référence annonce (unsignedInteger, nullable, foreign key)
- `created_at/updated_at` : Timestamps

**Contraintes :**
- Foreign key sur `ad_id` → `ads.id` (cascade delete/update)

### Table `ad_notes` (Notes Internes)
Notes des conseillers/modérateurs sur les annonces.

**Colonnes :**
- `id` : Identifiant unique (increments)
- `ad_id` : Référence annonce (unsignedInteger, foreign key)
- `user_id` : Auteur de la note (unsignedInteger, foreign key)
- `project_data_key_id` : Clé de données projet (unsignedInteger, nullable, foreign key)
- `project_data_value_id` : Valeur de données projet (unsignedInteger, nullable, foreign key)
- `value` : Contenu de la note (text)
- `contact_name` : Nom du contact (string, nullable)
- `created_at/updated_at` : Timestamps

**Contraintes :**
- Foreign key sur `ad_id` → `ads.id` (cascade delete/update)
- Foreign key sur `user_id` → `users.id` (cascade delete)
- Foreign key sur `project_data_key_id` → `project_data_keys.id` (set null)
- Foreign key sur `project_data_value_id` → `project_data_values.id` (cascade delete)

### Table `documents` (Documents)
Gestion des fichiers attachés via système polymorphe.

**Colonnes :**
- `id` : Identifiant unique (increments)
- `name` : Nom du fichier (string)
- `path` : Chemin de stockage (string)
- `type` : Type MIME (string)
- `size` : Taille en octets (integer)
- `user_id` : Propriétaire (unsigned integer, foreign key)
- `created_at/updated_at` : Timestamps

### Table `documentables` (Relation Documents)
Relation polymorphe entre documents et annonces/projets.

**Colonnes :**
- `id` : Identifiant unique (increments)
- `document_id` : Référence document (unsignedInteger, foreign key)
- `documentable_id` : ID de l'entité (unsignedInteger)
- `documentable_type` : Type d'entité (string) - référence aux tables ads et projects
- `created_at/updated_at` : Timestamps

### Table `productionable_genres` (Types de Production)
Relation polymorphe entre types de production et annonces.

**Colonnes :**
- `id` : Identifiant unique (increments)
- `production_genre_id` : Référence type de production (unsignedInteger, foreign key)
- `productionable_genre_id` : ID de l'entité (unsignedInteger)
- `productionable_genre_type` : Type d'entité (string) - référence aux tables land_seek_ads, land_offer_ads, researches
- `type` : Type de production (enum: "actual", "possible", default "actual")
- `created_at/updated_at` : Timestamps

**Contraintes :**
- Foreign key sur `production_genre_id` → `production_genres.id` (restrict)
- Index sur `production_genre_id`, `productionable_genre_type`, `productionable_genre_id`

## Relations et Contraintes

### Contraintes d'Intégrité
- **Cascade DELETE** : Suppression d'une annonce supprime ses données spécifiques
- **Cascade UPDATE** : Mise à jour propagée
- **Soft DELETE** : Suppression logique des annonces principales
- **Restrict** : Certaines relations (buildings, houses, installation_types) bloquent la suppression

### Relations Principales
- **Ad → User** : Créateur de l'annonce (userPp)
- **Ad → AttributionAd** : Attribution modération (1:1)
- **Ad → SpecificAdType** : Type spécifique (1:1 polymorphe)
- **Ad → Cities/Departments/Regions** : Localisation (N:N polymorphe via locationable_ads)
- **Ad → Documents** : Pièces jointes (N:N polymorphe via documentables)
- **Ad → AdNotes** : Notes internes (1:N)
- **Ad → FavoriteAds** : Favoris utilisateurs (1:N)
- **Ad → Threads** : Conversations (1:N)
- **Ad → ProductionGenres** : Types de production (N:N polymorphe via productionable_genres)
- **Ad → ThirdPartyAdUser** : Utilisateur tiers (N:1, nullable)

### Détection de Type
Le système utilise une détection automatique du type d'annonce :
```php
// Détection basée sur la présence de données dans les tables spécifiques
foreach (Ad::AD_TYPES as $key => $class) {
    if (existe_dans_table_specifique($key)) {
        return $key;
    }
}
```

## Statuts et États

### Statuts de Modération
- **PENDING_MODERATION_STATUS_ID** : En attente de modération
- **APPROVE_ID** : Approuvé et publié
- **REFUSED** : Refusé avec motif

### États d'Annonce
- **is_draft = 1** : Brouillon
- **is_draft = 0** : Soumis pour modération/publication
- **deleted_at IS NOT NULL** : Supprimé logiquement
- **archived_at IS NOT NULL** : Archivé

## Intégrations Externes

### Salesforce
- **Synchronisation** : Certaines annonces sont synchronisées avec Salesforce
- **Formulaires** : URLs de formulaires Salesforce par type d'annonce
- **Mapping** : Correspondance des champs entre systèmes

### Utilisateurs Tiers
- **third_party_ad_user_id** : Gestion des annonces importées
- **ThirdPartyAdUser** : Modèle pour les utilisateurs externes

## Contraintes Métier

### Validation
- **Surface** : Valeurs numériques positives
- **Dates** : Cohérence temporelle
- **Géolocalisation** : Au moins une localisation obligatoire
- **Contenu** : Longueur minimale pour les descriptions

### Permissions
- **Édition** : Créateur ou modérateur assigné
- **Suppression** : Créateur ou administrateur (rôle ≥ 4)
- **Modération** : Modérateurs du territoire concerné

### Règles de Gestion
- **Département principal** : Déterminé par order de priorité :
  1. `department_id` (direct)
  2. Première ville associée
  3. Premier département associé
  4. Premier département de la première région

- **Attribution automatique** : Basée sur le département principal
- **Notifications** : Automatiques lors des changements de statut

## Index et Performance

### Index Principaux
- **ads** : `user_pp_id`, `deleted_at`, `department_id`, `third_party_ad_user_id`
- **attribution_ads** : `ad_id`, `user_advisor_id`, `user_moderator_id`, `user_supervisor_id`
- **land_offer_ads** : `ad_id`, `building_id`, `house_id`
- **land_seek_ads** : `ad_id`, `installation_type_id`
- **job_offer_ads** : `ad_id`
- **job_seek_ads** : `ad_id`
- **associate_offer_ads** : `ad_id`
- **associate_seek_ads** : `ad_id`
- **locationable_ads** : `ad_id`, `locationable_ad_id`, `locationable_ad_type`
- **favorite_ads** : `ad_id`, `user_id`
- **ad_notes** : `ad_id`, `user_id`, `project_data_key_id`, `project_data_value_id`
- **productionable_genres** : `production_genre_id`, `productionable_genre_type`, `productionable_genre_id`

### Soft Delete
- **ads** : Utilise `deleted_at` pour la suppression logique
- **Cascade** : Les tables liées sont supprimées physiquement lors de la suppression d'une annonce

## Évolutions et Maintenance

### Éléments Dépréciés
- **Projets** : Fonctionnalité CRM dépréciée, remplacée par Salesforce
- **support_request_id_region** : À supprimer (commentaire TODO dans Ad.php:393)
- **Recherches** : Ancien système remplacé par les annonces
- **Champs commentés** : Plusieurs champs commentés dans les migrations (land_availability, land_transfer_deadline, etc.)

### Intégrations Actives
- **Salesforce** : Synchronisation des annonces et formulaires externes
- **Third Party Users** : Gestion des utilisateurs externes pour les annonces importées
- **Production Types** : Système de catégorisation des types de production agricole

### Améliorations Futures
- **Performance** : Indexation des requêtes fréquentes
- **Archivage** : Système d'archivage automatique
- **Analytics** : Suivi des performances des annonces
- **Nettoyage** : Suppression des éléments dépréciés (projets, recherches)

## Patterns Architecturaux

### Polymorphisme
Le système utilise massivement le polymorphisme Laravel :
- **Localisation** : `locationable_ads` pour Cities/Departments/Regions
- **Documents** : `documentables` pour Ads/Projects
- **Production** : `productionable_genres` pour LandSeek/LandOffer/Researches
- **Types d'annonces** : 6 tables spécifiques reliées à `ads`

### Repository Pattern
- **Scopes** : `ScopeLocationFilterable`, `ScopeAdTypesFilterable`, `ScopeDataFilterable`
- **Traits** : `Documentable`, `ProductionableGenre`
- **Filtres** : Système de filtrage avancé par localisation, type, etc.

### Observer Pattern
- **Relationship Events** : `HasMorphedByManyEvents`, `HasRelationshipObservables`
- **Notifications** : Attribution automatique avec notifications
- **Audit** : Table `history` pour traçabilité (relation morphMany)
# Processus de Modération et d'Attribution des Annonces

## Vue d'ensemble

Le processus de modération et d'attribution des annonces dans Objectif Terres est un système automatisé qui assigne les annonces aux modérateurs compétents en fonction de critères géographiques et de disponibilité.

## Flux Global du Processus

```
1. Publication d'annonce → 2. Attribution automatique → 3. Notification → 4. Modération → 5. Publication ou refus
```

## Règles d'Attribution Automatique

### 1. Critères Géographiques

L'attribution se base sur le **département principal** de l'annonce :
- Le système récupère le département principal via `$ad->main_department->code`
- L'annonce est attribuée aux modérateurs ayant des permissions sur ce département

### 2. Hiérarchie des Modérateurs

Le système recherche des modérateurs disponibles dans l'ordre suivant :

#### 2.1 Réattribution Prioritaire
- **Si l'annonce a déjà été attribuée** : le même modérateur est maintenu s'il est toujours disponible
- Condition : `$ad->attributionAd->userModerator` existe et est dans la liste des modérateurs disponibles

#### 2.2 Utilisateur avec Permissions Spéciales
- **Priorité 1** : Utilisateur avec permission spéciale (code 1) dans le département
- Recherche via `findOneByUserPermissionAndDepartments(1, $departmentCodes)`

#### 2.3 Modérateurs Standards
- **Priorité 2** : Modérateurs (rôle 1) dans le département
- Recherche via `findByRolesAndDepartments([1], $departmentCodes)`
- **Sélection aléatoire** si plusieurs modérateurs disponibles

#### 2.4 Responsables Territoriaux
- **Priorité 3** : Responsables territoriaux (rôle 3) dans le département
- Recherche via `findByRolesAndDepartments([3], $departmentCodes)`
- **Sélection aléatoire** si plusieurs responsables disponibles

#### 2.5 Modérateur par Défaut
- **Dernier recours** : Utilisateur ID 18552 (objectif-terres@terredeliens.org)
- Utilisé si aucun modérateur n'est trouvé dans le département

### 3. Cas d'Erreur

Si aucun modérateur n'est trouvé dans le département :
- **Exception levée** : `AttributionAdException`
- **Message** : "Aucun modérateur n'a été trouvé dans votre région. Veuillez sauvegarder votre annonce et nous contacter."

## Statuts et États des Annonces

### 1. Statut d'Attribution
- **PENDING_MODERATION_STATUS_ID** : Annonce en attente de modération
- Attribution automatique lors de la demande de publication

### 2. Mise à Jour des Attributions
- **Nouvelle attribution** : Création d'un enregistrement `AttributionAd`
- **Réattribution** : Mise à jour de l'enregistrement existant
- **Condition** : L'annonce ne doit pas être refusée ou archivée

## Notifications Automatiques

### 1. Notification au Modérateur
- **Type** : `NewAdToModerateNotification`
- **Destinataire** : Modérateur assigné
- **Contenu** : Informations sur l'annonce à modérer

### 2. Notification au Porteur de Projet
- **Type** : `PendingModerationNotification`
- **Destinataire** : Créateur de l'annonce
- **Contenu** : Confirmation de soumission pour modération

## Processus Technique

### 1. Méthode Principale
```php
AdService::requestPublishing(Ad $ad)
```

### 2. Étapes d'Exécution
1. **Récupération du département** : `$ad->main_department->code`
2. **Recherche des modérateurs** selon la hiérarchie
3. **Vérification de disponibilité** des modérateurs
4. **Attribution** selon les priorités
5. **Création/mise à jour** de l'enregistrement `AttributionAd`
6. **Envoi des notifications**

### 3. Gestion des Transactions
- **Transaction DB** : Processus atomique pour éviter les incohérences
- **Rollback automatique** en cas d'erreur

## Cas Particuliers

### 1. Annonces Importées
- **Processus** : `AdService::importAd()`
- **Statut** : `APPROVE_ID` (pré-approuvées)
- **Attribution** : Modérateur assigné mais annonce déjà publiée

### 2. Annonces Brouillons
- **Condition** : `$data["is_draft"] = true`
- **Comportement** : Pas d'attribution automatique
- **Attribution** : Seulement lors de la demande de publication

### 3. Réattribution
- **Condition** : Annonce déjà attribuée mais modérateur indisponible
- **Comportement** : Nouveau modérateur selon les règles standard
- **Conservation** : Historique des attributions

## Modèles de Données Impliqués

### 1. Table `ads`
- Contient les informations de base de l'annonce
- Référence au créateur (`user_pp_id`)

### 2. Table `attribution_ads`
- Lien entre annonce et modérateur
- Statut de modération
- Dates de publication et d'archivage

### 3. Table `users`
- Informations sur les modérateurs
- Rôles et permissions départementales

## Règles Métier

### 1. Géographie
- **Une annonce** = **Un département principal**
- **Modérateurs** = **Assignés par département**
- **Territoires** = **Regroupements de départements**

### 2. Rôles et Permissions
- **Rôle 1** : Modérateur standard
- **Rôle 3** : Responsable territorial (peut modérer)
- **Permissions spéciales** : Utilisateurs avec droits étendus

### 3. Disponibilité
- **Modérateurs actifs** : Non supprimés, avec permissions sur le département
- **Sélection aléatoire** : Répartition équitable de la charge

## Monitoring et Suivi

### 1. Historique
- **Traçabilité** : Toutes les attributions sont enregistrées
- **Changements** : Notifications automatiques des changements de rôle

### 2. Métriques
- **Temps de traitement** : Suivi des délais de modération
- **Charge de travail** : Répartition par modérateur

### 3. Alertes
- **Modérateurs manquants** : Alertes si pas de modérateur dans un département
- **Retards** : Notifications pour les modérations en retard
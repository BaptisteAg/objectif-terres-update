# Montée de version Laravel 6 vers 13

Suivi du chantier mené avec [Laravel Shift](https://laravelshift.com). Dernière mise à jour : 13/11/2026.

## Dépôts

| Dépôt | Rôle | Remote local |
|---|---|---|
| `BaptisteAg/objectif-terres-update` | dépôt de travail du chantier (`master`) | `origin` |
| `Pella0/objectif-terres-shift` | copie du développeur précédent, porte le Shift 6 vers 7 | `collegue` |
| `terredeliens/objectif-terres` | dépôt du client, la production fait `git pull` sur son `master` | non configuré |

Le retour vers `terredeliens/objectif-terres` se fera par PR, plus tard. L'historique de `master` descend du `master` du client, ce qui garde ce retour possible.

## Environnement local

DDEV (`.ddev/config.yaml`) : PHP 8.0, MariaDB 10.11, nginx, Composer 2. Dans la VM de travail, chaque commande passe par `host-run --` :

```bash
host-run -- ddev start
host-run -- ddev composer install
host-run -- ddev exec php artisan migrate
host-run -- ddev exec vendor/bin/phpunit
```

- Base de développement `db`, base de test `objectif_terres_test` (créée à la main, attendue par `phpunit.xml`).
- Nova s'installe depuis `https://nova.laravel.com`. Les identifiants sont dans `auth.json` à la racine, ignoré par Git.
- Un clone neuf n'a pas les dossiers `storage/framework/{views,sessions,cache/data}` ni `bootstrap/cache` : les créer avant `composer install`.
- L'application exige `APP_KEY` dès le démarrage, avant que `key:generate` puisse tourner : la renseigner directement dans `.env`.

## Plan

| Étape | Laravel | PHP min | Nova | Shift | Statut |
|---|---|---|---|---|---|
| 1 | 7 | 7.2.5 | 3 | 6 vers 7, fait par le développeur précédent | dépendances installées et vérifiées, à valider |
| 2 | 8 | 7.3 | 3 | 7 vers 8, à l'unité | à faire |
| 3 | 8 | 7.3 | 3 vers 4 | aucun, travail manuel | à faire |
| 4 | 9 | 8.0 | 4 | Legacy Single, 6 mois | à faire |
| 5 | 10 | 8.1 | 4 vers 5 | Legacy Single | à faire |
| 6 | 11 | 8.2 | 5 | Legacy Single + HTML Converter | à faire |
| 7 | 12 | 8.2 | 5 | Legacy Single | à faire |
| 8 | 13 | 8.3 | 5 | Legacy Single | à faire |

Règles : une étape n'est close qu'après `composer update`, tests et vérification manuelle. Shift ne lance jamais `composer update`. Aucun autre chantier (Vite, Vue 3, refactorisation) pendant la montée.

## Étape 1 : Laravel 7

Résultat : `laravel/framework` 7.30.7, `laravel/nova` 3.30.0 (dernière 3.x compatible Laravel 7, la 3.32 exige `laravel/ui` 3 donc Laravel 8), `darkaonline/l5-swagger` 8.6.

Changements au-delà du Shift :

- **Nova** : la copie `nova/` (2.12.0, ajoutée en 2020) est remplacée par le paquet Composer. Deux personnalisations faites dans le code de Nova ont été examinées :
  - les liens « Listes des utilisateurs par territoire » et « Retour sur Objectif Terres » de la barre latérale sont reportés dans `resources/views/vendor/nova/resources/navigation.blade.php` ;
  - la hauteur de 400 px de CKEditor (`nova/resources/css/app.css`) n'a jamais été compilée dans `public/vendor/nova/app.css`, elle était donc sans effet. Non reportée.
  - `resources/views/vendor/nova/partials/user.blade.php` était une copie non modifiée de Nova 2 : supprimée. `meta`, `footer` et `logo` sont personnalisés et conservés.
- **Repoist** (`ozankurt/repoist`) n'existe pas pour Laravel 7 à 11. Seule sa classe `AbstractRepository` servait : elle est reprise dans `app/Repositories/Eloquent/AbstractRepository.php` (licence MIT) et le paquet est retiré.
- **l5-swagger 6 vers 8** :
  - configuration reportée au format 8 (titre, dossier des annotations, middleware `api.doc.auth`, constante `L5_SWAGGER_CONST_HOST`) ;
  - la vue publiée `resources/views/vendor/l5-swagger/index.blade.php` était l'original 6.0.6 non modifié et cassait en version 8 : supprimée ;
  - la route des documents est `docs/api-docs.json`, car le dossier `public/docs` (chartes PDF) masque la route `docs` par défaut côté nginx. L'URL de la spécification reste celle de la production ;
  - le JSON généré est identique à celui de la production, hors URL du serveur et section `tags` ajoutée par la version 8.

### Exceptions de sécurité temporaires

Composer bloque les versions ayant des alertes publiées. Les paquets ci-dessous n'ont aucune version saine compatible avec Laravel 7. Ils sont autorisés dans `config.policy.advisories.ignore` avec `on-audit: false` : `composer audit` continue de les signaler.

| Paquet | Raison |
|---|---|
| `laravel/framework` (^7.0) | version cible de l'étape |
| `league/commonmark`, `league/flysystem`, `guzzlehttp/psr7` | dépendances de Laravel 7 |
| `firebase/php-jwt`, `google/protobuf`, `grpc/grpc` | dépendances de `gluedev/laravel-stackdriver` |

À chaque étape, retirer les exceptions devenues inutiles. Il ne doit plus en rester à Laravel 13.

### Tests

La suite compte 52 tests. Sur la version Laravel 6 d'origine : 36 réussis, 16 en erreur. Sur Laravel 7 : résultat identique test par test.

| Cause des 16 erreurs | Tests |
|---|---|
| lisent des données existantes alors que la base de test est vide | MailTest (7), DocumentsTest, RequestAdPublishingTest |
| utilisent `User::factory()`, syntaxe Laravel 8 | ModeratorReallocationTest (3) |
| règle `role-departement` de Salesforce et envoi de mail | SalesforceServiceTest (3) |
| appel réel à Salesforce sans URL configurée | ApiSalesforceTest |

## Points ouverts

- **Stackdriver** : actif en production (`STACKDRIVER_ENABLED=true`, clé `storage/objectif-terres-312202-*.json` depuis 2022). Ses dépendances Google bloqueront les étapes suivantes. À trancher : quelqu'un consulte-t-il encore Google Cloud Error Reporting ?
- **Seeders** : sur une base neuve, `TerritorySeeder` échoue (doublon sur `territories.id = 1`), une migration ayant déjà inséré des données.
- **Données locales** : sans jeu de données réaliste, les pages et 9 tests ne peuvent pas être vérifiés.
- **Traduction de Nova** : 346 textes sur 426 restent en anglais (325 sur 405 sous Nova 2).
- **Secrets et données personnelles dans Git** : `.env.save`, `.env.nouvellesandbox`, clés privées de `certs/`, `database/sql/users_table.sql`, et deux dumps SQL de 2023 dans l'historique. À signaler à Terre de Liens.
- **Commentaires de la PR Shift #1** (dépôt `collegue`) : non encore relus.

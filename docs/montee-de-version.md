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

### Contrôles du guide de montée Laravel 7

- **Noms de routes en double** : Laravel 7 refuse de mettre en cache deux routes de même nom. `GET` et `POST /connexion` s'appelaient tous deux `login`, ce qui faisait échouer `php artisan optimize`, appelé par `app:update` pendant le déploiement. Le nom est retiré de la route `POST`. Les deux routes ont la même URL, donc `route('login')` ne change pas.
- **Sérialisation des dates** : Laravel 7 sérialise les dates des modèles en ISO 8601 UTC dans `toArray()` et `toJson()`. Sans effet visible ici : l'API formate ses dates elle-même (`AdResource::formatDateToIso`), `History` renvoie des chaînes par ses accesseurs, et les composants Vue ne testent les autres dates que contre `null`. `serializeDate` n'est donc pas redéfini.
- **E-mails** : `config/mail.php` lit `MAIL_MAILER`. La production n'a que `MAIL_DRIVER=smtp`, et la valeur par défaut reste `smtp`.
- **Caches** : `config:cache`, `route:cache`, `view:cache` et `event:cache` passent.
- Aucune balise `<x-…>` dans les vues, et CORS est configuré (`config/cors.php`, `HandleCors`).

À ajouter dans le `.env` de production au déploiement : `MAIL_MAILER=smtp`.

### Commentaires de Shift sur la PR #1 (dépôt `collegue`)

Les 14 commentaires ont été relus le 13/11/2026. Ceux qui demandaient une action :

- **Expéditeur des e-mails perdu** : la remise à zéro de `config/mail.php` (commit Shift `8f09b234`) avait remplacé `'name' => 'Objectif Terres'` par `env('MAIL_FROM_NAME', 'Example')` et l'adresse par défaut par `hello@example.com`. La production ne définit pas `MAIL_FROM_NAME` : les e-mails seraient partis signés « Example ». Les valeurs de Laravel 6 sont rétablies comme valeurs par défaut.
- **Cookie de session** : le commit Shift `ff0b7dc2` passait `same_site` de `null` à `'lax'`. Le retour du SSO Salesforce (`acs()`) est un POST venu d'un autre site : en `lax`, le cookie de session n'y est pas envoyé et `url.intended` est perdue, l'utilisateur atterrit sur l'accueil au lieu de la page demandée. `null` est rétabli ; le cookie a de nouveau les mêmes attributs qu'en production.
- `getOriginal('user_moderator_id')` dans `AttributionAdObserver` : attribut sans cast, valeur inchangée.
- Composants Symfony utilisés directement : `Process` reçoit déjà un tableau, rien à adapter pour Symfony 5.
- Paquets abandonnés signalés : `digital-creative/clickable-table-row` et `numaxlab/nova-ckeditor5-classic` sont à remplacer avec Nova 4 ; `krlove/eloquent-model-generator` n'est qu'en développement.

### Exceptions de sécurité temporaires

Composer bloque les versions ayant des alertes publiées. Les paquets ci-dessous n'ont aucune version saine compatible avec Laravel 7. Ils sont autorisés dans `config.policy.advisories.ignore` avec `on-audit: false` : `composer audit` continue de les signaler.

| Paquet | Raison |
|---|---|
| `laravel/framework` (^7.0) | version cible de l'étape |
| `league/commonmark`, `league/flysystem` | dépendances de Laravel 7 |

`firebase/php-jwt`, `google/protobuf`, `grpc/grpc` et `guzzlehttp/psr7` ont été retirés de la liste avec Stackdriver : `firebase/php-jwt`, requis par Forrest, est passé en 7.2.1, sans alerte.

### Retrait de Stackdriver

Décision du 13/11/2026 (Baptiste Ageron) : `gluedev/laravel-stackdriver` est retiré. Le paquet n'évolue plus depuis la 0.2.2, et ses bibliothèques Google (`google/gax`, `grpc/grpc`, `google/protobuf`) n'ont plus de version compatible à la fois avec PHP 8.0 et sans faille connue. Il aurait bloqué toutes les étapes suivantes.

Ce qui disparaît : l'envoi des erreurs vers Google Cloud Error Reporting et des journaux vers Google Cloud Logging (projet `objectif-terres-312202`). Les erreurs restent journalisées par Laravel, canal `stack` (`daily` et `stdout`).

Supprimés du code : `config/stackdriver.php`, l'appel `StackdriverExceptionHandler::report()` dans `app/Exceptions/Handler.php`, et 16 paquets Google et OpenCensus.

À faire en production, au déploiement de cette version :

- retirer les variables `STACKDRIVER_*` du `.env` ;
- supprimer `storage/objectif-terres-312202-8e27689d1380.json`, la clé du compte de service Google (présente depuis avril 2022) ;
- signaler au détenteur du projet Google Cloud qu'il peut révoquer cette clé, puis fermer le projet s'il ne sert plus.

À chaque étape, retirer les exceptions devenues inutiles. Il ne doit plus en rester à Laravel 13.

### Tests

La suite compte 52 tests. Sur la version Laravel 6 d'origine : 36 réussis, 16 en erreur. Sur Laravel 7 : résultat identique test par test.

| Cause des 16 erreurs | Tests |
|---|---|
| lisent des données existantes alors que la base de test est vide | MailTest (7), DocumentsTest, RequestAdPublishingTest |
| utilisent `User::factory()`, syntaxe Laravel 8 | ModeratorReallocationTest (3) |
| règle `role-departement` de Salesforce et envoi de mail | SalesforceServiceTest (3) |
| appel réel à Salesforce sans URL configurée | ApiSalesforceTest |

### Comparaison avec la production

Base locale chargée le 13/11/2026 depuis la production (`mysqldump --single-transaction`, lecture seule) : 74 tables, 23 396 utilisateurs, 11 371 annonces, aucune migration en attente. Instantané DDEV `prod-2026-11-13`, restaurable par `host-run -- ddev snapshot restore prod-2026-11-13`. Ces données personnelles restent dans DDEV et ne vont jamais dans Git.

Mêmes requêtes anonymes en local (Laravel 7) et en production (Laravel 6), sur les mêmes données :

- 47 pages publiques sans paramètre : codes de réponse identiques, sauf `/rss/news` (500 en production, 200 en local) et `/locations/polygon/departments` (plus de 20 s en production) ;
- 40 fiches d'annonces tirées au hasard : codes de réponse et titres identiques.

Défaut ancien constaté des deux côtés : `/locations/polygon/france` renvoie 500, parce que l'API Nominatim répond 400 à la requête envoyée.

### Tests de fumée (`tests/Smoke`)

À relancer à chaque étape, en plus de la suite habituelle :

```bash
host-run -- ddev exec vendor/bin/phpunit -c phpunit.smoke.xml
```

- Base `objectif_terres_smoke`, copie de la base locale chargée depuis la production. Chaque test tourne dans une transaction annulée ; e-mails et notifications sont neutralisés (`Mail::fake`, `Notification::fake`).
- Parcourt toutes les routes GET sans paramètre en anonyme, puis avec un utilisateur réel de chaque rôle (porteur de projet, modérateur, responsable territorial, admin) ; 15 annonces en ligne ; dans Nova, la liste, les filtres, les actions, une fiche et le formulaire de chacune des 16 ressources.
- Échoue sur toute erreur 500, et si plus de la moitié d'un lot ne répond pas en 2xx, pour ne jamais passer à vide.
- Pour recréer la base : `host-run -- ddev exec -s db 'mysql -uroot -proot -e "DROP DATABASE IF EXISTS objectif_terres_smoke; CREATE DATABASE objectif_terres_smoke; GRANT ALL ON objectif_terres_smoke.* TO \"db\"@\"%\";" && mysqldump -uroot -proot --single-transaction db | mysql -uroot -proot objectif_terres_smoke'`.

Défauts anciens trouvés par cette suite, présents aussi en production :

- corrigés : fiche Nova d'une attribution sans modérateur (priorité d'opérateur dans `App\Nova\AttributionAd::title()`), page « Rapports et indicateurs » d'un responsable territorial (1 171 attributions ont un `ad_status_id` sans statut correspondant, `AdService` ligne 776) ;
- non corrigés, exclus de la suite : `/accompagnement/modifier` plante si l'utilisateur n'a pas de demande d'accompagnement (fonction dépréciée) ; `/mon-espace/recherches/notification` et `/mon-espace/annonces-favorites/sauvegarde` sont des actions en GET qui plantent sans paramètre.

## Points ouverts

- **Seeders** : sur une base neuve, `TerritorySeeder` échoue (doublon sur `territories.id = 1`), une migration ayant déjà inséré des données.
- **Traduction de Nova** : 346 textes sur 426 restent en anglais (325 sur 405 sous Nova 2).
- **Secrets et données personnelles dans Git** : `.env.save`, `.env.nouvellesandbox`, clés privées de `certs/`, `database/sql/users_table.sql`, et deux dumps SQL de 2023 dans l'historique. À signaler à Terre de Liens.
- **Commentaires de la PR Shift #1** (dépôt `collegue`) : non encore relus.

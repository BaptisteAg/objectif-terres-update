<p align="center"><img  src="https://terredeliens.org/IMG/siteon0.png?1529677189" width="100"> X <img src="https://hubspot-partners-prod.s3.amazonaws.com/thumbnails/5431073/500.png" width="200"></p>


<h1>Objectif Terres</h1>
<p>Un projet pour l'association <a href="https://terredeliens.org/">Terre de Liens</a> développé par l'agence web <a href="https://idmkr.io/" >Kaffein Agency</a>.</p>

## Mise à jour du certificat Salesforce chaque année

1. Demander au responsable Salesforce OT d'exporter les certificats "Vers le magasin de clés"
    1. Le bouton est présent sur cette page https://terredeliens.lightning.force.com/lightning/setup/CertificatesAndKeysManagement/home
    2. Le fichier de magasin de clés est un fichier au format "jks"
    3. Le fichier doit être généré avec un mot de passe d'au moins 6 caractères de long. Ce mot de passe n'a d'importance que pour la poursuite de la procédure.
2. Une fois le fichier .jks en main, le but est d'en extraire un fichier .pem et un fichier .key
    1. La procédure à suivre est ici : https://serverfault.com/questions/715827/how-to-generate-key-and-crt-file-from-jks-file-for-httpd-apache-server
    2. Vous devez connaître le nom exact du nouveau certificat annuel à extraire ( visible dans Salesforce ou donné par le responsable )
    3. Vous allez placer ce nom dans la première commande, comme ceci : `keytool -export -alias <NOM_CERTIFICAT_SALESFORCE> -file mydomain.der -keystore mycert.jks`
    4. Les autres commandes sont à copier-coller. Chaque fois qu'il vous est demandé un mot de passe, saisissez celui récupéré à l'étape 1.iii.
    5. Pour terminer, renommez vos fichiers de la sorte : "salesforce_api_<ANNEE>.key/.pem"
3. Il faut ensuite configurer Laravel pour qu'il utilise les nouveaux fichiers.
    1. Copiez-collez vos fichiers dans le dossier /certs
    2. Editez le fichier config/saml2/salesforce_idp_settings.php
    3. Changez les lignes 36 et 37 de façon à référencer vos fichiers
    4. Il nous faut pour finir extraire le fingerprint du certificat qui se trouve à la ligne 86. Suivez les instructions.
4. Les applications connectées doivent enfin être configurées dans Salesforce de manière à lier le nouveau certificat.
    1. Ceci peut être demandé au responsable Salesforce, néanmoins il est conseillé de le faire soi même pour assurer un déploiement sans complications
    2. Aller à l'URL https://terredeliens.lightning.force.com/lightning/setup/ConnectedApplication/home
    3. Modifiez la politique de l'application de votre environnement local
    4. Si tout est OK, pushez en prod et dans foulée modifiez tout de suite la politique de l'application connecté de la prod.

## Glossaire technique

### Les rôles
Liste des rôles utilisteurs: 

[0] `pp` = porteur de projet, qui peut créer des annonces ou des demandes d'accompagnement

[1] `moderator` = modérateur qui traite les annonces

[2] `advisor` = primo-accueillant qui traite les demandes d'accompagnement

[3] `supervisor` = responsable territorial qui suit l'activité de son territoire et assigne les demandes d'accompagnement

[4] `admin` = administrateur qui édite le contenu CMS et la liste des utilisateurs

### Les modèles
Traduction des principaux modèles utilisés : 

`Ad` = annonce

`AttributionAd` = administration d'une annonce

`AdStatus` = status de l'annonce vis à vis de la modération

`Building` = bâtiment agricole

`House` = bâtiment d'habitation

`Land` = terre agricole

`LandOfferAd` = annonce pour une offre de foncier

`LandSeekAd` = annonce pour une recherche de foncier

`JobOfferAd` = annonce pour une offre d'emploi

`JobSeekAd` = annonce pour une recherche d'emploi 

`RefusalType` = type de refus choisi par le modérateur

`ProductionGenre` = système de production agricole

`Project` = projet en lien avec une demande d'accompagnement

`ProjectStatus` = avancement du projet

`Research` = recherche enregistrée

`ResponseTemplate` = réponse type utilisé par le personnel de Terre de Lien

`SupportStage` = stade de l'accompagnement

`SupportState` = état de la demande

`Thread` = fil de discussion

`User` = utilisateur du site (tous roles confondus)

### Compte Test
test+limousin@terredeliens.org
TestAlsace974

devot+mod_alsace@terredeliens.org
OTAlsace23





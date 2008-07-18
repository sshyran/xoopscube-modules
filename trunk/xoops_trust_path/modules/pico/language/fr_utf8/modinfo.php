<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) ) $mydirname = 'pico' ;
$constpref = '_MI_' . strtoupper( $mydirname ) ;

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( $constpref.'_LOADED' ) ) {

define($constpref.'_ADMENU_EXTRAS','Extra');
define($constpref.'_HTMLPR_EXCEPT','Les groupes qui peuvent éviter la correction par HTMLPurifier');
define($constpref.'_HTMLPR_EXCEPTDSC','Les publications des utilisateurs qui n\'appartiennent pas à ces groupes seront
forcément corrigés et HTML filtré par HTMLPurifier dans Protector>=3.14. Cette correction ne peut pas fonctionner avec PHP4');
define($constpref.'_BNAME_MYWAITINGS','Mes publications en attente');
define($constpref.'_BNAME_SUBCATEGORIES','Sous-catégories');
define($constpref.'_NOTIFY_GLOBAL_NEWCONTENT','nouveau contenu');
define($constpref.'_NOTIFY_GLOBAL_NEWCONTENTCAP','Notifier si une nouvelle publication a lieu. (contenu approuvé seulement)');
define($constpref.'_NOTIFY_GLOBAL_NEWCONTENTSBJ','[{X_SITENAME}] {X_MODULE} : Nouvelle Publication');
define($constpref.'_COM_VIEW','Affichage des Commentaires-Intégrés');
define($constpref.'_ADMENU_MYLANGADMIN','Langages');
define($constpref.'_ADMENU_MYTPLSADMIN','Templates');
define($constpref.'_ADMENU_MYBLOCKSADMIN','Blocs/Permissions');
define($constpref.'_ADMENU_MYPREFERENCES','Préférences');
define($constpref.'_SEARCHBYUID','Activer le concept d\'auteur');
define($constpref.'_SEARCHBYUIDDSC','Les publications seront listées dans le profil utilisateur de l\'auteur. Si vous utilisez ce module pour publier du contenu statique, désactivez cette option.');
define($constpref.'_HISTORY_P_C','Combien de revisions sauver dans la BDD');
define($constpref.'_MLT_HISTORY','Temps minimum pour chaque revision (sec)');
define($constpref.'_BRCACHE','Temps du Cache pour les fichiers images (seulement avec le mode wraps)');
define($constpref.'_BRCACHEDSC','Temps de Cache pour le navigateur, en secondes, pour les fichiers autres que HTML (0 pour désactiver)');
define($constpref.'_SUBMENU_SC','Afficher le contenu dans le sous-menu');
define($constpref.'_SUBMENU_SCDSC','Par défaut, uniquement les Catégories seront affichées. Si vous activez cette option, le contenu marqué "menu" sera également affiché');
define($constpref.'_SITEMAP_SC','Afficher le contenu dans le module sitemap');
define($constpref.'_USE_REWRITE','Activer mod_rewrite');
define($constpref.'_USE_REWRITEDSC','Dépend de votre environnement. Si vous activez cette option, renomez .htaccess.rewrite_wraps(avec wraps) ou htaccess.rewrite_normal(sans wraps) en .htaccess dans XOOPS_ROOT_PATH/modules/(repértoire)/');
define($constpref.'_FILTERSF','Filtres Forcés');
define($constpref.'_FILTERSFDSC','ajouter les noms des filtres séparés par ,(virgule). filter:LAST signifie que le filtre est exécuté en dernier. Les autres filtres seront executés dans une premier temps.');
define($constpref.'_FILTERSP','Filtres Interdits');
define($constpref.'_FILTERSPDSC','ajoutez les noms des filtres séparés par,(virgule).');

define( $constpref.'_LOADED' , 1 ) ;

// The name of this module
define($constpref."_NAME","pico");

// A brief description of this module
define($constpref."_DESC","un module pour gérer du contenu statique");

// admin menus
define( $constpref.'_ADMENU_CONTENTSADMIN' , 'Liste de Contenu' ) ;
define( $constpref.'_ADMENU_CATEGORYACCESS' , 'Permissions des Catégories' ) ;
define( $constpref.'_ADMENU_IMPORT' , 'Importer/Synchroniser' ) ;

// configurations
define($constpref.'_USE_WRAPSMODE','Activer le mode Insértion (wraps)');
define($constpref.'_WRAPSAUTOREGIST','Activer l\'auto-enregistrement des fichiers HTML insérés dans la BDD comme contenu');
define($constpref.'_TOP_MESSAGE','Description de la catégorie TOP');
define($constpref.'_TOP_MESSAGEDEFAULT','');
define($constpref.'_MENUINMODULETOP','Afficher menu(index) en tête de ce module');
define($constpref.'_LISTASINDEX',"Afficher l\'index de contenu dans l\'en tête des catégories");
define($constpref.'_LISTASINDEXDSC','OUI signifie que la liste est faite automatique et s\'affiche au dessus de la
catégorie. NON signifie que le contenu avec la plus haute priorité est affiché au lieu de la liste automatique');
define($constpref.'_SHOW_BREADCRUMBS','Afficher les sommaires');
define($constpref.'_SHOW_PAGENAVI','Afficher la page navigation');
define($constpref.'_SHOW_PRINTICON','Afficher l\'icone du format imprimable');
define($constpref.'_SHOW_TELLAFRIEND','Afficher l\'icone pour informer un ami');
define($constpref.'_USE_TAFMODULE','Utiliser le module "tellafriend"');
define($constpref.'_FILTERS','Série de filtres par défaut');
define($constpref.'_FILTERSDSC','Ajoutez les noms des filtres séparés par | ');
define($constpref.'_FILTERSDEFAULT','htmlspecialchars|xcode|smiley|nl2br');
define($constpref.'_USE_VOTE','Activer l\'option de VOTE');
define($constpref.'_GUESTVOTE_IVL','Vote des visiteurs');
define($constpref.'_GUESTVOTE_IVLDSC','Ajoutez 0, pour désactiver le vote des visiteurs anonymes. Autrement ajoutez un nombre équivalent au temps (sec.) pour permettre un deuxième vote depuis le même IP.');
define($constpref.'_HTMLHEADER','En tête HTML commun');
define($constpref.'_CSS_URI','URI du fichier CSS pour ce module');
define($constpref.'_CSS_URIDSC','Vous pouvez indiquer une adresse relative ou absolue. Par défaut: {mod_url}/index.php?page=main_css');
define($constpref.'_IMAGES_DIR','Dossier pour les fichiers images');
define($constpref.'_IMAGES_DIRDSC','Vous pouvez indiquer une adresse relative ou absolue. Par défaut: images');
define($constpref.'_BODY_EDITOR','Editeur du document');
define($constpref.'_COM_DIRNAME','Intégration-commentaires: nom du repértoire de d3forum');
define($constpref.'_COM_FORUM_ID','Intégration-commentaires: ID forum');

// blocks
define($constpref.'_BNAME_MENU','Menu');
define($constpref.'_BNAME_CONTENT','Contenu');
define($constpref.'_BNAME_LIST','Liste');

// Notify Categories
define($constpref.'_NOTCAT_GLOBAL', 'global');
define($constpref.'_NOTCAT_GLOBALDSC', 'notifications de ce module');

// Each Notifications
define($constpref.'_NOTIFY_GLOBAL_WAITINGCONTENT', 'Contenu en attente');
define($constpref.'_NOTIFY_GLOBAL_WAITINGCONTENTCAP', 'Notifier si de nouveaux messages ou modifications sont attente (notifier seulement les administrateurs ou les modérateurs)');
define($constpref.'_NOTIFY_GLOBAL_WAITINGCONTENTSBJ', '[{X_SITENAME}] {X_MODULE}: en attente');

}


?>

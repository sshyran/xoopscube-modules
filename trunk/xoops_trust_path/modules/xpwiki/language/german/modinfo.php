<?php

//
// German Translation Version 1.0 (11.03.2008)
// Translation English --> German: Octopus (hunter0815@googlemail.com)
// sicherlich steckt hier noch reichlich Qualit�tspotential in den �bersetzungen ;-)

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) ) $mydirname = 'wraps' ;
$constpref = '_MI_' . strtoupper( $mydirname ) ;

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( $constpref.'_LOADED' ) ) {

// a flag for this language file has already been read or not.
define( $constpref.'_LOADED' , 1 ) ;

// Names of blocks for this module (Not all module has blocks)
define( $constpref."_BNAME_A_PAGE","Zeige Seite  ({$mydirname})");
define( $constpref."_BDESC_A_PAGE","Der Inhalt kann im Block angezeigt werden, indem der Seiten Name spezifiziert wird.");
define( $constpref."_BNAME_NOTIFICATION","Benachrichtigungen ({$mydirname})");
define( $constpref."_BDESC_NOTIFICATION","Benachrichtigungs-Einstellungen");
define( $constpref."_BNAME_FUSEN","Fusen(Tag) ({$mydirname})");
define( $constpref."_BDESC_FUSEN","Das Kontroll-Men� f�r den das Fusen(Tag)Plugin wird angezeigt.");
define( $constpref."_BNAME_MENUBAR","Men�leiste ({$mydirname})");
define( $constpref."_BDESC_MENUBAR","Zeige Men�leiste");

define( $constpref.'_MODULE_DESCRIPTION' , 'Ein Wiki-Modul basierend auf PukiWiki.' ) ;

define( $constpref.'_PLUGIN_CONVERTER' , 'Plugin Converter' ) ;
define( $constpref.'_SKIN_CONVERTER' , 'Skin Converter' ) ;
define( $constpref.'_ADMIN_CONF' , 'Einstellung' ) ;
define( $constpref.'_ADMIN_TOOLS' , 'Admin Tools' ) ;

define( $constpref.'_COM_DIRNAME','Kommentar-Integration: Ordnername des d3forum');
define( $constpref.'_COM_FORUM_ID','Kommentar-Integration: Forum ID');

// Notify Replaces
define($constpref.'_NOTCAT_REPLASE2MODULENAME', 'dieses Modul');
define($constpref.'_NOTCAT_REPLASE2FIRSTLEV', 'erste Hierarchie');
define($constpref.'_NOTCAT_REPLASE2SECONDLEV', 'zweite Hierarchie');
//define($constpref.'_NOTCAT_REPLASE2PAGENAME', 'diese Seite');

// Notify Categories
define($constpref.'_NOTCAT_PAGE', 'diese Seite');
define($constpref.'_NOTCAT_PAGEDSC', 'Benachrichtigungen �ber diese Seite.');
define($constpref.'_NOTCAT_PAGE1', 'erste Hierarchie oder tiefer');
define($constpref.'_NOTCAT_PAGE1DSC', 'Benachrichtigungen �ber due erste Hierarchie oder tiefer.');
define($constpref.'_NOTCAT_PAGE2', 'zweite Hierarchie oder tiefer');
define($constpref.'_NOTCAT_PAGE2DSC', 'Benachrichtigungen �ber die zweite Hierarchie oder tiefer.');
define($constpref.'_NOTCAT_GLOBAL', 'dieses Modul');
define($constpref.'_NOTCAT_GLOBALDSC', 'Benachrichtigungen �ber alles in diesem Modul.');

// Each Notifications
define($constpref.'_NOTIFY_PAGE_UPDATE', 'bearbeitete Seite');
define($constpref.'_NOTIFY_PAGE_UPDATECAP', 'Benachrichtige mich �ber �nderungen auf dieser Seite.');
define($constpref.'_NOTIFY_PAGE1_UPDATECAP', 'Benachrichtige mich �ber �nderungen auf dieser oder einer tieferen Hierarchiestufe.');
define($constpref.'_NOTIFY_PAGE2_UPDATECAP', 'Benachrichtige mich �ber �nderungen auf der zweiten oder einer tieferen Hierarchiestufe.');
define($constpref.'_NOTIFY_PAGE_UPDATESBJ', '[{X_SITENAME}] {X_MODULE}:{PAGE_NAME} ge�ndert');
define($constpref.'_NOTIFY_GLOBAL_UPDATECAP', 'Benachrichtige mich �ber s�mtliche �nderungen in diesem Modul.');

}

?>
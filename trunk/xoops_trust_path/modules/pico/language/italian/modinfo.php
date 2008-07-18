<?php
//traduzione italiana di evoc cadelsanto@gmail.com www.cadelsanto.org
if( defined( 'FOR_XOOPS_LANG_CHECKER' ) ) $mydirname = 'pico' ;
$constpref = '_MI_' . strtoupper( $mydirname ) ;

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( $constpref.'_LOADED' ) ) {







// Appended by Xoops Language Checker -GIJOE- in 2007-09-22 03:55:47
define($constpref.'_ADMENU_EXTRAS','Extra');

// Appended by Xoops Language Checker -GIJOE- in 2007-09-18 10:36:05
define($constpref.'_HTMLPR_EXCEPT','Groups can avoid purification by HTMLPurifier');
define($constpref.'_HTMLPR_EXCEPTDSC','Post from users who are not belonged these groups will be forced to purified as sanitized HTML by HTMLPurifier in Protector>=3.14. This purification cannot work with PHP4');

// Appended by Xoops Language Checker -GIJOE- in 2007-09-12 17:00:58
define($constpref.'_BNAME_MYWAITINGS','My waiting posts');

// Appended by Xoops Language Checker -GIJOE- in 2007-06-15 05:03:01
define($constpref.'_BNAME_SUBCATEGORIES','Subcategories');
define($constpref.'_NOTIFY_GLOBAL_NEWCONTENT','new content');
define($constpref.'_NOTIFY_GLOBAL_NEWCONTENTCAP','Notify if a new content is registered. (approved contents only)');
define($constpref.'_NOTIFY_GLOBAL_NEWCONTENTSBJ','[{X_SITENAME}] {X_MODULE} : New content');

// Appended by Xoops Language Checker -GIJOE- in 2007-05-29 16:39:06
define($constpref.'_COM_VIEW','View of Comment-integration');

// Appended by Xoops Language Checker -GIJOE- in 2007-05-07 17:48:20
define($constpref.'_ADMENU_MYLANGADMIN','Languages');

define( $constpref.'_LOADED' , 1 ) ;

// The name of this module
define($constpref."_NAME","pico");

// A brief description of this module
define($constpref."_DESC","Un modulo per contenuti statici");

// admin menus
define( $constpref.'_ADMENU_CONTENTSADMIN' , 'Lista dei contenuti' ) ;
define( $constpref.'_ADMENU_CATEGORYACCESS' , 'Permessi delle categorie' ) ;
define( $constpref.'_ADMENU_IMPORT' , 'Importa/Sincronizza' ) ;
define( $constpref.'_ADMENU_MYTPLSADMIN' , 'Templates' ) ;
define( $constpref.'_ADMENU_MYBLOCKSADMIN' , 'Blocchi/Permessi' ) ;
define( $constpref.'_ADMENU_MYPREFERENCES' , 'Preferenze' ) ;

// configurations
define($constpref.'_USE_WRAPSMODE','Abilita modalità mascheramento');
define($constpref.'_USE_REWRITE','Abilita modalità mod_rewrite');
define($constpref.'_USE_REWRITEDSC','Dipende dal tuo ambiente. Se attivi, rinomina .htaccess.rewrite_wraps(with wraps) o htaccess.rewrite_normal(without wraps) in  .htaccess nella cartella XOOPS_ROOT_PATH/modules/(dirname)/');
define($constpref.'_WRAPSAUTOREGIST','Abilita HTML l\'auto registrazione dei files HTML mascherati nel DB come contenuti');
define($constpref.'_TOP_MESSAGE','Descrizione della categoria PRINCIPALE');
define($constpref.'_TOP_MESSAGEDEFAULT','');
define($constpref.'_MENUINMODULETOP','Mostra menu(indice) in cima a questo modulo');
define($constpref.'_LISTASINDEX',"Mostra indice contenuti in cima alla categoria");
define($constpref.'_LISTASINDEXDSC','SI significa che l\'indice autocompilato è mostrato in cima alla categoria. No significa che un contenuto con una più alta priorità è mostrato invece che l\'indice autocompilato');
define($constpref.'_SHOW_BREADCRUMBS','Mostra breadcrumbs');
define($constpref.'_SHOW_PAGENAVI','Mostra pagina di navigazione');
define($constpref.'_SHOW_PRINTICON','Mostra icona per la stampa amichevole');
define($constpref.'_SHOW_TELLAFRIEND','Mostra icone per invia a un\'amico');
define($constpref.'_SEARCHBYUID','Abilita concepts of poster');
define($constpref.'_SEARCHBYUIDDSC','I contenuti saranno messi fra i posts nel profilo utente. Se tu usi questo modulo per contenuti statici, scegli no.');
define($constpref.'_USE_TAFMODULE','Usa modulo "tellafriend"');
define($constpref.'_FILTERS','Default filter set');
define($constpref.'_FILTERSDSC','Inserisci nomi nel filtro, separati da un | (pipe)');
define($constpref.'_FILTERSDEFAULT','htmlspecialchars|xcode|smiley|nl2br');
define($constpref.'_FILTERSF','Filtri forzati');
define($constpref.'_FILTERSFDSC','Immetti nomi da filtrare separati con ,(virgola). filtro: LAST significa che il filtro è passato nell\'ultima fase. Gli altri filtri sono passati nella prima fase.');
define($constpref.'_FILTERSP','Filtri proibiti');
define($constpref.'_FILTERSPDSC','Inserisci i nomi filtro separati da ,(virgola).');
define($constpref.'_SUBMENU_SC','Mostra contenuti nel submenu');
define($constpref.'_SUBMENU_SCDSC','Solo le categorie sono mostrate di default. Se tu cambi questo su SI i contenuti marcati a "menu" saranno mostrati');
define($constpref.'_SITEMAP_SC','Mostra contenuti nel modulo sitemap');
define($constpref.'_USE_VOTE','usa la funzione del Voto');
define($constpref.'_GUESTVOTE_IVL','Voto da anonimi');
define($constpref.'_GUESTVOTE_IVLDSC','Imposta a 0 per disabilitare il voto degli ospiti. Gli altri numeri significano i secondi che devono trascorrere prima di un altro post dallo stesso IP.');
define($constpref.'_HTMLHEADER','Header HTML comuni');
define($constpref.'_CSS_URI','URI del file CSS per questo modulo');
define($constpref.'_CSS_URIDSC','Può essere settato un path relativo o assoluto. Default: {mod_url}/index.css');
define($constpref.'_IMAGES_DIR','Cartella per i files di immagini');
define($constpref.'_IMAGES_DIRDSC','path relativa che dovrebbe essere settata nella cartella del modulo. Default: images');
define($constpref.'_BODY_EDITOR','Editor per il testo');
define($constpref.'_HISTORY_P_C','Quante revisioni sono conservate nel DB');
define($constpref.'_MLT_HISTORY','Tempo di durata minima di ciascuna revisione (sec)');
define($constpref.'_BRCACHE','Durata della cache per le immagini (solo per il modo wraps)');
define($constpref.'_BRCACHEDSC','Tutti i files escluso gli HTML saranno messi in cache dal web browser in questo secondo (0 significa disabilitato)');
define($constpref.'_COM_DIRNAME','Comment-integration: Cartella del d3forum');
define($constpref.'_COM_FORUM_ID','Comment-integration: forum ID');

// blocks
define($constpref.'_BNAME_MENU','Menu');
define($constpref.'_BNAME_CONTENT','Contenuto');
define($constpref.'_BNAME_LIST','Lista');

// Notify Categories
define($constpref.'_NOTCAT_GLOBAL', 'global');
define($constpref.'_NOTCAT_GLOBALDSC', 'Notifica circa questo modulo');

// Each Notifications
define($constpref.'_NOTIFY_GLOBAL_WAITINGCONTENT', 'in attesa');
define($constpref.'_NOTIFY_GLOBAL_WAITINGCONTENTCAP', 'Notifica se nuovi posts o modifiche in attesa di approvazione (Notifica agli amministratori o moderatori)');
define($constpref.'_NOTIFY_GLOBAL_WAITINGCONTENTSBJ', '[{X_SITENAME}] {X_MODULE}: in attesa');

}


?>

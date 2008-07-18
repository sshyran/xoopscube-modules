<?php

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

// Appended by Xoops Language Checker -GIJOE- in 2007-03-26 11:38:35
define($constpref.'_ADMENU_MYTPLSADMIN','Templates');
define($constpref.'_ADMENU_MYBLOCKSADMIN','Blocks/Permissions');
define($constpref.'_ADMENU_MYPREFERENCES','Preferences');

// Appended by Xoops Language Checker -GIJOE- in 2007-03-23 05:52:08
define($constpref.'_SEARCHBYUID','Enable concepts of poster');
define($constpref.'_SEARCHBYUIDDSC','Contents will be listed in user profile of its poster. If you use this module as static contents, turn this off.');

// Appended by Xoops Language Checker -GIJOE- in 2007-03-13 04:23:22
define($constpref.'_HISTORY_P_C','How many revisions are stored in DB');
define($constpref.'_MLT_HISTORY','Minimum lifetime of each revisions (sec)');
define($constpref.'_BRCACHE','Cache life time for image files (only with wraps mode)');
define($constpref.'_BRCACHEDSC','Files other than HTML will be cached by web browser in this second (0 means disabled)');

// Appended by Xoops Language Checker -GIJOE- in 2007-03-10 07:13:28
define($constpref.'_SUBMENU_SC','Show contents in submenu');
define($constpref.'_SUBMENU_SCDSC','Only categories are displayed in default. If you turn this on, contents marked "menu" will be displayed also');
define($constpref.'_SITEMAP_SC','Show contents in sitemap module');

// Appended by Xoops Language Checker -GIJOE- in 2007-03-07 04:39:59
define($constpref.'_USE_REWRITE','enable mod_rewrite mode');
define($constpref.'_USE_REWRITEDSC','Depends your environment. If you turn this on, rename .htaccess.rewrite_wraps(with wraps) or htaccess.rewrite_normal(without wraps) to .htaccess under XOOPS_ROOT_PATH/modules/(dirname)/');

// Appended by Xoops Language Checker -GIJOE- in 2007-03-06 04:56:32
define($constpref.'_FILTERSF','Forced filters');
define($constpref.'_FILTERSFDSC','input filter names separated with ,(comma). filter:LAST means the filter is passed in the last phase. The other filters are passed in the first phase.');
define($constpref.'_FILTERSP','Prohibited filters');
define($constpref.'_FILTERSPDSC','input filter names separated with ,(comma).');

define( $constpref.'_LOADED' , 1 ) ;

// The name of this module
define($constpref."_NAME","pico");

// A brief description of this module
define($constpref."_DESC","Módulo para contenido estático");

// admin menus
define( $constpref.'_ADMENU_CONTENTSADMIN' , 'Lista de contenidos' ) ;
define( $constpref.'_ADMENU_CATEGORYACCESS' , 'Permisos de Categorías' ) ;
define( $constpref.'_ADMENU_IMPORT' , 'Importar/Sincronizar' ) ;

// configurations
define($constpref.'_USE_WRAPSMODE','Habilitar modo de arropado');
define($constpref.'_WRAPSAUTOREGIST','Habilitar el auto-registro de archivos HTML arropados en la base de datos como contenido');
define($constpref.'_TOP_MESSAGE','Descripción de categoría PRINCIPAL');
define($constpref.'_TOP_MESSAGEDEFAULT','');
define($constpref.'_MENUINMODULETOP','Mostrar menú (índice) en la parte superior de este módulo');
define($constpref.'_LISTASINDEX',"Mostrar índice de contenidos en la parte superior de la categoría");
define($constpref.'_LISTASINDEXDSC','SÍ significa que la lista automática es mostrada en la parte superior de la categoría. NO significa que un contenido con la prioridad más alta es mostrado en lugar de la lista automática');
define($constpref.'_SHOW_BREADCRUMBS','Mostrar breadcrumbs');
define($constpref.'_SHOW_PAGENAVI','Mostrar navegación de página');
define($constpref.'_SHOW_PRINTICON','Mostrar icono de versión para imprimir');
define($constpref.'_SHOW_TELLAFRIEND','Mostrar icono de avisa a un amigo');
define($constpref.'_USE_TAFMODULE','Emplear módulo "avisa a un amigo"');
define($constpref.'_FILTERS','Juego de filtros default');
define($constpref.'_FILTERSDSC','Ingresar nombres filtro separados con | (barra vertical)');
define($constpref.'_FILTERSDEFAULT','htmlspecialchars|xcode|smiley|nl2br');
define($constpref.'_USE_VOTE','Emplear función de VOTAR');
define($constpref.'_GUESTVOTE_IVL','Votos de anónimos');
define($constpref.'_GUESTVOTE_IVLDSC','Fijar en cero (0) para deshabilitar votos de anónimos. Otro número significa tiempo en segundos para permitir un segundo voto del mismo número IP.');
define($constpref.'_HTMLHEADER','Encabezado HTML común');
define($constpref.'_CSS_URI','URI del archivo CSS de este módulo');
define($constpref.'_CSS_URIDSC','Puede emplearse ruta relativa o absoluta. default: {mod_url}/index.php?page=main_css');
define($constpref.'_IMAGES_DIR','Directorio para archivo de imágenes');
define($constpref.'_IMAGES_DIRDSC','La ruta relativa debe ser fijada en el directorio del módulo. Default: images');
define($constpref.'_BODY_EDITOR','Editor de texto');
define($constpref.'_COM_DIRNAME','Integración de comentario: dirname de d3forum');
define($constpref.'_COM_FORUM_ID','Integración de comentario: ID de foro');

// blocks
define($constpref.'_BNAME_MENU','Menú');
define($constpref.'_BNAME_CONTENT','Contenido');
define($constpref.'_BNAME_LIST','Lista');

// Notify Categories
define($constpref.'_NOTCAT_GLOBAL', 'Global');
define($constpref.'_NOTCAT_GLOBALDSC', 'Notificaciones para este módulo');

// Each Notifications
define($constpref.'_NOTIFY_GLOBAL_WAITINGCONTENT', 'En espera');
define($constpref.'_NOTIFY_GLOBAL_WAITINGCONTENTCAP', 'Notificar si nuevos envíos o modificaciones están en espera de aprobación (sólo notificar a administradores o moderadores)');
define($constpref.'_NOTIFY_GLOBAL_WAITINGCONTENTSBJ', '[{X_SITENAME}] {X_MODULE}: en espera');

}


?>

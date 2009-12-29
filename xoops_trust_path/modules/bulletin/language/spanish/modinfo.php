<?php /* Spanish Translation by Marcelo Yuji Himoro <http://yuji.ws> */
// Module Info

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) ) $mydirname = 'bulletin' ;
$constpref = '_MI_' . strtoupper( $mydirname ) ;

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( $constpref.'_LOADED' ) ) {

// a flag for this language file has already been read or not.




// Appended by Xoops Language Checker -GIJOE- in 2009-01-18 07:28:25
define($constpref.'_COM_ORDER','Order of comment-integration');

// Appended by Xoops Language Checker -GIJOE- in 2008-05-19 05:51:18
define($constpref.'_CONFIG145','feed RSS into backend.php (only for XCL)');
define($constpref.'_CONFIG145_D','');
define($constpref.'_COM_DIRNAME','dirname of d3forum integrated as the comment system');
define($constpref.'_COM_FORUM_ID','forum_id of d3forum integrated');
define($constpref.'_COM_VIEW','View of comment-integration');
define($constpref.'_COM_POSTSNUM','Max posts displayed in comment-integration');

// Appended by Xoops Language Checker -GIJOE- in 2007-05-15 04:44:32
define($constpref.'_CONFIG19','use common/fckeditor');
define($constpref.'_CONFIG19_D','Posters can use FCKeditor on XOOPS if he/she is allowed to use HTML');

// Appended by Xoops Language Checker -GIJOE- in 2007-05-08 12:57:29
define($constpref.'_ADMENU_MYLANGADMIN','languages');
define($constpref.'_ADMENU_MYTPLSADMIN','templates');
define($constpref.'_ADMENU_MYBLOCKSADMIN','blocks/permissions');
define($constpref.'_CONFIG15','Enable related articles feature?');
define($constpref.'_CONFIG15_D','');
define($constpref.'_CONFIG16','Display recent stories in the same category?');
define($constpref.'_CONFIG16_D','Displays a list of articles in the same category at the bottom of each story.');
define($constpref.'_CONFIG17','Number of recent storeis in the same category.');
define($constpref.'_CONFIG17_D','');
define($constpref.'_CONFIG18','Display category bread crumb?');
define($constpref.'_CONFIG18_D','A category tree is displayed in each articles.');
define($constpref.'_NOTIFY5_TITLE','New comment posted');
define($constpref.'_NOTIFY5_CAPTION','Notify me when a new comment is posted.');
define($constpref.'_NOTIFY5_DESC','Notify me when a new comment is posted.');
define($constpref.'_NOTIFY5_SUBJECT','[{X_SITENAME}] {X_MODULE}: New comment posted');

define( $constpref.'_LOADED' , 1 ) ;

// The name of this module
define($constpref."_NAME","Bulletin");

// A brief description of this module
define($constpref."_DESC","Crea un sistema de noticias tipo Slashdot, donde los usuarios puedan comentar libremente.");

// Names of blocks for this module (Not all module has blocks)
define($constpref."_BNAME1","Categor�as de noticias");
define($constpref."_BDESC1","Bloque de categor�as de noticias");
define($constpref."_BNAME2","Gran noticia de hoy");
define($constpref."_BDESC2","Bloque de gran noticia de hoy");
define($constpref."_BNAME3","Calendario");
define($constpref."_BDESC3","Bloque de calendario");
define($constpref."_BNAME4","Noticias recientes");
define($constpref."_BDESC4","Bloque de noticias recientes");
define($constpref."_BNAME5","Noticias recientes por categor�a");
define($constpref."_BDESC5","Bloque de noticias recientes por categor�a");
define($constpref."_BNAME6","Comentarios recientes de Bulletin");
define($constpref."_BDESC6","Bloque de comentarios recientes de Bulletin");

// Sub menu
define($constpref."_SMNAME1","Enviar noticia");
define($constpref."_SMNAME2","Archivo");

//
define($constpref."_TEMPLATE1","P�gina de archivo");
define($constpref."_TEMPLATE2","P�gina de noticia solitaria");
define($constpref."_TEMPLATE3","Portada");
define($constpref."_TEMPLATE4","Plantilla de noticias");
define($constpref."_TEMPLATE5","P�gina de impresi�n");
define($constpref."_TEMPLATE6","P�gina de RSS");
define($constpref."_TEMPLATE7","Encabezado com�n a todas las p�ginas"); // 1.01 added

// Admin
define($constpref."_ADMENU1","Preferencias");
define($constpref."_ADMENU1_D","Definici�n de las configuraciones b�sicas.");
define($constpref."_ADMENU2","Gestor de categor�as");
define($constpref."_ADMENU2_D","Manejo de categor�as.");
define($constpref."_ADMENU3","Publicar nueva noticia");
define($constpref."_ADMENU3_D","Env�o de una nueva noticia.");
define($constpref."_ADMENU4","Gestor de permisos de env�o");
define($constpref."_ADMENU4_D","Definici�n de permisos para el env�o de noticias.");
define($constpref."_ADMENU5","Gestor de noticias");
define($constpref."_ADMENU5_D","Edici�n/eliminaci�n/aprobaci�n de noticias.");
define($constpref."_ADMENU6","Gestor de grupos/bloques");
define($constpref."_ADMENU6_D","Definici�n de las configuraciones de bloques y permisos de los grupos.");
define($constpref."_ADMENU7","Importar desde news");
define($constpref."_ADMENU7_D","Convierte datos de noticias y categor�as desde news1.1.");

// Title of config items
define($constpref."_CONFIG1", "N� de noticias mostradas en la portada");
define($constpref."_CONFIG1_D", "Define la cantidad de noticias mostradas en la portada.");
define($constpref."_CONFIG2", "�Mostrar caja de navegaci�n?");
define($constpref."_CONFIG2_D", "Para mostrar una caja de navegaci�n de selecci�n de categor�as en el tope de las noticias, elige \"S�\".");
define($constpref."_CONFIG3","Altura del textarea para env�o/edici�n");
define($constpref."_CONFIG3_D", "Define el n� de l�neas de textarea de la p�gina de submit.php.");
define($constpref."_CONFIG4","Anchura del textarea para env�o/edici�n");
define($constpref."_CONFIG4_D", "Define el n� de columnas de textarea de la p�gina de submit.php.");
define($constpref."_CONFIG5","Formato de fecha/hora");
define($constpref."_CONFIG5_D", "Usa como referencia la funci�n date de PHP/formatTimestamp de XOOPS.");
define($constpref."_CONFIG6","Reflejar env�os en el cuento de env�os de los usuarios");
define($constpref."_CONFIG6_D", "Cuando se aprobe una noticia enviada desde submit.php, se la sumar� al \"N� de env�os\" del usuario.");
define($constpref."_CONFIG7","Camino de la carpeta de iconos de categor�a");
define($constpref."_CONFIG7_D", "Define el camino absoluto.");
define($constpref."_CONFIG8","Direcci�n del imagen de la p�gina de impresi�n");
define($constpref."_CONFIG8_D", "Define la direcci�n del logotipo mostrado en la p�gina de impresi�n.");
define($constpref."_CONFIG9","Utilizar el nombre de la noticia como t�tulo del s�tio");
define($constpref."_CONFIG9_D", "Sustituye el t�tulo del s�tio por el asunto de la noticia. Se dice efectivo para SEO.");
define($constpref."_CONFIG10","assign URL de RSS en xoops_module_header");
define($constpref."_CONFIG10_D", "");
// 1.01 added
define($constpref."_CONFIG11","Mostrar icono \"Imprimir\"?");
define($constpref."_CONFIG11_D", "");
define($constpref."_CONFIG12","Mostrar icono \"Enviar a un amigo\"?");
define($constpref."_CONFIG12_D", "");
define($constpref."_CONFIG13","Utilizar el m�dulo Tell A Friend?");
define($constpref."_CONFIG13_D", "");
define($constpref."_CONFIG14","Mostrar enlace para RSS?");
define($constpref."_CONFIG14_D", "");

// Text for notifications
define($constpref."_GLOBAL_NOTIFY", "Global");
define($constpref."_GLOBAL_NOTIFYDSC", "Opciones de notificaci�n globales para el m�dulo de noticias.");

define($constpref."_STORY_NOTIFY", "Noticia actual");
define($constpref."_STORY_NOTIFYDSC", "Opciones de notificaci�n para la noticia actual.");

define($constpref."_GLOBAL_NEWCATEGORY_NOTIFY", "Nueva categor�a");
define($constpref."_GLOBAL_NEWCATEGORY_NOTIFYCAP", "Notificarme cuando se cree una nueva categor�a.");
define($constpref."_GLOBAL_NEWCATEGORY_NOTIFYDSC", "Notificarme cuando se cree una nueva categor�a.");
define($constpref."_GLOBAL_NEWCATEGORY_NOTIFYSBJ", "[{X_SITENAME}] {X_MODULE}: nueva categor�a creada");

define($constpref."_GLOBAL_STORYSUBMIT_NOTIFY", "Nueva noticia enviada");
define($constpref."_GLOBAL_STORYSUBMIT_NOTIFYCAP", "Notificarme cuando se env�e una nova noticia.");
define($constpref."_GLOBAL_STORYSUBMIT_NOTIFYDSC", "Notificarme cuando se env�e una nova noticia.");
define($constpref."_GLOBAL_STORYSUBMIT_NOTIFYSBJ", "[{X_SITENAME}] {X_MODULE}: nueva noticia enviada");

define($constpref."_GLOBAL_NEWSTORY_NOTIFY", "Nueva noticia publicada");
define($constpref."_GLOBAL_NEWSTORY_NOTIFYCAP", "Notificarme cuando se publique una nueva noticia.");
define($constpref."_GLOBAL_NEWSTORY_NOTIFYDSC", "Notificarme cuando se publique una nueva noticia.");
define($constpref."_GLOBAL_NEWSTORY_NOTIFYSBJ", "[{X_SITENAME}] {X_MODULE}: nueva noticia publicada");

define($constpref."_STORY_APPROVE_NOTIFY", "Aprobaci�n de noticia");
define($constpref."_STORY_APPROVE_NOTIFYCAP", "Notificarme cuando se aprobe esta noticia.");
define($constpref."_STORY_APPROVE_NOTIFYDSC", "Notificarme cuando se aprobe esta noticia.");
define($constpref."_STORY_APPROVE_NOTIFYSBJ", "[{X_SITENAME}] {X_MODULE}: noticia aprobada");

}

?>
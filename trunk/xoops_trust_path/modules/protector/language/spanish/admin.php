<?php

// mymenu


// Appended by Xoops Language Checker -GIJOE- in 2007-10-18 05:36:24
define('_AM_LABEL_COMPACTLOG','Compact log');
define('_AM_BUTTON_COMPACTLOG','Compact it!');
define('_AM_JS_COMPACTLOGCONFIRM','Duplicated (IP,Type) records will be removed');
define('_AM_LABEL_REMOVEALL','Remove all records');
define('_AM_BUTTON_REMOVEALL','Remove all!');
define('_AM_JS_REMOVEALLCONFIRM','All logs are removed absolutely. Are you really OK?');

// Appended by Xoops Language Checker -GIJOE- in 2007-07-30 05:37:51
define('_AM_FMT_CONFIGSNOTWRITABLE','Turn the configs directory writable: %s');

define('_MD_A_MYMENU_MYTPLSADMIN','');
define('_MD_A_MYMENU_MYBLOCKSADMIN','Permisos');
define('_MD_A_MYMENU_MYPREFERENCES','Preferencias');

// index.php
define("_AM_TH_DATETIME","Hora");
define("_AM_TH_USER","Usuario");
define("_AM_TH_IP","IP");
define("_AM_TH_AGENT","AGENTE");
define("_AM_TH_TYPE","Tipo");
define("_AM_TH_DESCRIPTION","Descripción");

define( "_AM_TH_BADIPS" , 'IPs malos<br /><br /><span style="font-weight:normal;">Escriba cada IP en una línea.<br />Todo en blanco significa que todos los IPs son permitidos.</span>' ) ;

define( "_AM_TH_GROUP1IPS" , 'IPs permitidos para Grupo=1<br /><br /><span style="font-weight:normal;">Escriba cada IP en una línea.<br />192.168. significa 192.168.*<br />Todo en blanco significa que todos los IPs son permitidos.</span>' ) ;

define( "_AM_LABEL_REMOVE" , "Eliminar los registros marcados:" ) ;
define( "_AM_BUTTON_REMOVE" , "¡Eliminado!" ) ;
define( "_AM_JS_REMOVECONFIRM" , "¿Está seguro de eliminación?" ) ;
define( "_AM_MSG_IPFILESUPDATED" , "Los archivos de IPs fueron actualizados" ) ;
define( "_AM_MSG_BADIPSCANTOPEN" , "El archivo para IPs malos no puede ser abierto" ) ;
define( "_AM_MSG_GROUP1IPSCANTOPEN" , "El archivo para permitir Grupo=1 no puede ser abierto" ) ;
define( "_AM_MSG_REMOVED" , "Registros eliminados" ) ;


// prefix_manager.php
define( "_AM_H3_PREFIXMAN" , "Administrador de prefijos" ) ;
define( "_AM_MSG_DBUPDATED" , "¡Base de datos actualizada exitosamente!" ) ;
define( "_AM_CONFIRM_DELETE" , "Todos los datos serán eliminados. ¿OK?" ) ;
define( "_AM_TXT_HOWTOCHANGEDB" , "Si desea cambiar el prefijo,<br /> edite %s/mainfile.php manualmente.<br /><br />define('XOOPS_DB_PREFIX', '<b>%s</b>');" ) ;


// advisory.php
define("_AM_ADV_NOTSECURE","No es seguro");

define("_AM_ADV_REGISTERGLOBALS","Esta configuración invita a una variedad de ataques por inyección.<br />Si puede instalar .htaccess, edite o cree...");
define("_AM_ADV_ALLOWURLFOPEN","Esta configuración permite a atacantes el ejecutar códigos arbitrarios en servidores remotos.<br />Sólo un administrador puede cambiar esta opción.<br />Si eres un admin, edita php.ini o httpd.conf.<br /><b>Ejemplo de httpd.conf:<br /> &nbsp; php_admin_flag &nbsp; allow_url_fopen &nbsp; off</b><br />De otra manera, pídelo a tus administradores.");
define("_AM_ADV_USETRANSSID","Tu ID de sesión será mostrada en etiquetas ancla, etc.<br />Para evitar el secuestro de sesión, añada una línea en .htaccess de la raíz de XOOPS.<br /><b>php_flag session.use_trans_sid off</b>");
define("_AM_ADV_DBPREFIX","Esta configuración invita a 'inyecciones de SQL'.<br />No olvides encender 'Forzar limpieza *' en las preferencias del módulo.");
define("_AM_ADV_LINK_TO_PREFIXMAN","Ir a Admin. de prefijos");
define("_AM_ADV_MAINUNPATCHED","Debes editar mainfile.php como recomienda README.");

define("_AM_ADV_SUBTITLECHECK","Revisión de Protector");
define("_AM_ADV_CHECKCONTAMI","Contaminaciones");
define("_AM_ADV_CHECKISOCOM","Comentarios Aislados");



?>
<?php
// Translation Info
// *************************************************************** //
// ############################################################### //
// ## XOOPS Cube Legacy 2.1 - Tradu��o para o Portugu�s
// ############################################################### //
// ## Por............: Mikhail Miguel
// ## E-mail.........: mikhail@underpop.com
// ## Website........: http://xoopscube.com.br
// ############################################################### //
// *************************************************************** //
if( defined("FOR_XOOPS_LANG_CHECKER") ) $mydirname = "pico";
$constpref = "_MI_" . strtoupper( $mydirname ) ;

if(defined("FOR_XOOPS_LANG_CHECKER") || ! defined($constpref."_LOADED") ) {



// Appended by Xoops Language Checker -GIJOE- in 2007-09-22 03:55:48
define($constpref.'_ADMENU_EXTRAS','Extra');

// Appended by Xoops Language Checker -GIJOE- in 2007-09-18 10:36:05
define($constpref.'_HTMLPR_EXCEPT','Groups can avoid purification by HTMLPurifier');
define($constpref.'_HTMLPR_EXCEPTDSC','Post from users who are not belonged these groups will be forced to purified as sanitized HTML by HTMLPurifier in Protector>=3.14. This purification cannot work with PHP4');

define($constpref."_LOADED", 1);

// The name of this module
define($constpref."_NAME","pico");

// A brief description of this module
define($constpref."_DESC","M�dulo avan�ado para edi��o de conte�do din�mico e encapsulamento de conte�do est�tico");

// admin menus
define($constpref."_ADMENU_CONTENTSADMIN","Conte�do");
define($constpref."_ADMENU_CATEGORYACCESS","Categorias");
define($constpref."_ADMENU_IMPORT","Importar/sincronizar");
define($constpref."_ADMENU_MYLANGADMIN","Idiomas");
define($constpref."_ADMENU_MYTPLSADMIN","Modelos");
define($constpref."_ADMENU_MYBLOCKSADMIN","Blocos & permiss�es");
define($constpref."_ADMENU_MYPREFERENCES","Prefer�ncias");

// configurations
define($constpref."_USE_WRAPSMODE","Habilitar o modo de encapsulamento");
define($constpref."_USE_REWRITE","Habilitar a tecnologia mod_rewrite");
define($constpref."_USE_REWRITEDSC","Depende das configura��es de seu servidor. Ao habilitar esta op��o, renomeie o arquivo .htaccess.rewrite_wraps (encapsulamento) ou htaccess.rewrite_normal (sem encapsulamento) como .htaccess no diret�rio ra�z deste m�dulo");
define($constpref."_WRAPSAUTOREGIST","Importar automaticamente o artigo est�tico dos arquivos HTML para o banco de dados.");
define($constpref."_TOP_MESSAGE","Descri��o da categoria principal");
define($constpref."_TOP_MESSAGEDEFAULT","");
define($constpref."_MENUINMODULETOP","Mostrar o menu (�ndice) no topo deste m�dulo");
define($constpref."_LISTASINDEX","Mostrar o �ndice de artigos na p�gina inicial");
define($constpref."_LISTASINDEXDSC","Optar por SIM far� com que a p�gina inicial deste m�dulo seja um �ndice dos artigos; optar por N�O far� com que o artigo de maior prioridade seja a p�gina inicial.");
define($constpref."_SHOW_BREADCRUMBS","Mostrar breadcrumbs");
define($constpref."_SHOW_PAGENAVI","Mostrar a p�gina de navega��o do artigo");
define($constpref."_SHOW_PRINTICON","Mostrar o �cone de p�gina para impress�o");
define($constpref."_SHOW_TELLAFRIEND","Mostrar o �cone de indica��o de artigo por email");
define($constpref."_SEARCHBYUID","Habilitar a op��o de conceituar os autores");
define($constpref."_SEARCHBYUIDDSC","As colabora��es de cada associado ser�o mostradas em suas respectivas p�ginas de perfil. Desabilite esta op��o ao utilizar este m�dulo apenas para artigo est�tico.");
define($constpref."_USE_TAFMODULE","Utilizar o m�dulo de indica��o Tellafriend");
define($constpref."_FILTERS","Configura��o de filtros padr�o");
define($constpref."_FILTERSDSC","Nomes dos filtros de entrada separados por barras verticais. Exemplo: PrimeiroFiltro|SegundoFiltro|TerceitoFiltro");
define($constpref."_FILTERSDEFAULT","htmlspecialchars|xcode|smiley|nl2br");
define($constpref."_FILTERSF","Filtros sempre habilitados");
define($constpref."_FILTERSFDSC","Nomes dos filtros de entrada separados por v�rgulas e em ordem de execu��o. Exemplo: PrimeiroFiltro,SegundoNomes dos filtros de entrada separados por v�rgulas e em ordem de execu��o. Exemplo: PrimeiroFiltro,SegundoFiltro,TerceitoFiltro");
define($constpref."_FILTERSP","Filtros sempre proibidos");
define($constpref."_FILTERSPDSC","Nomes dos filtros de entrada separados por v�rgulas.");
define($constpref."_SUBMENU_SC","Mostrar o artigo em um submenu");
define($constpref."_SUBMENU_SCDSC","Ao habilitar esta op��o, as categorias ser�o mostradas por padr�o, como tamb�m qualquer artigo marcado como MENU");
define($constpref."_SITEMAP_SC","Mostrar o artigo no m�dulo sitemap");
define($constpref."_USE_VOTE","Permitir que os visitantes valorem os arquivos");
define($constpref."_GUESTVOTE_IVL","Votos dos an�nimos");
define($constpref."_GUESTVOTE_IVLDSC","Definir como 0, para desabilitar o voto de visitantes. Qualquer outro n�mero significa o tempo (em seg.) para permitir um segundo envio do mesmo IP.");
define($constpref."_HTMLHEADER","Cabe�alho HTML padr�o");
define($constpref."_CSS_URI","Endere�o URI do arquivo CSS para este m�dulo");
define($constpref."_CSS_URIDSC","Pode ser definido o path absoluto ou relativo. padr�o: {mod_url}/index.css");
define($constpref."_IMAGES_DIR","Diret�rio das imagens em portugu�s");
define($constpref."_IMAGES_DIRDSC","O caminho relativo deve ser definido no diret�rio do m�dulo. O padr�o � 'images'");
define($constpref."_BODY_EDITOR","Editor de textos");
define($constpref."_HISTORY_P_C","Quantas altera��es do mesmo artigo ser�o gravadas no hist�rico");
define($constpref."_MLT_HISTORY","Tempo em que cada revis�o ser� arquivada, em segundos");
define($constpref."_BRCACHE","Tempo de acelera��o via cache para as imagens em modo de encapsulamento");
define($constpref."_BRCACHEDSC","Limite de tempo em segundos em que os arquivos bin�rios (como imagens e v�deos) ser�o gravados nos navegadores dos visitantes. Se desejar, configure como 0 (zero) para desabilitar esta op��o.");
define($constpref."_COM_DIRNAME","Integra��o de coment�rios: nome do diret�rio do d3forum");
define($constpref."_COM_FORUM_ID","Integra��o de coment�rios: n�mero do f�rum");
define($constpref."_COM_VIEW","Apar�ncia da integra��o de coment�rios");

// blocks
define($constpref."_BNAME_MENU","Menu");
define($constpref."_BNAME_CONTENT","Artigo");
define($constpref."_BNAME_LIST","Listar");
define($constpref."_BNAME_SUBCATEGORIES","Subcategorias");
define($constpref."_BNAME_MYWAITINGS","Minhas colabora��es em espera");

// Notify Categories
define($constpref."_NOTCAT_GLOBAL","Geral");
define($constpref."_NOTCAT_GLOBALDSC","Notifica��es deste m�dulo");

// Each Notifications
define($constpref."_NOTIFY_GLOBAL_WAITINGCONTENT","Artigo pendente");
define($constpref."_NOTIFY_GLOBAL_WAITINGCONTENTCAP","Notifique-me quando um artigo estiver pendente por aprova��o");
define($constpref."_NOTIFY_GLOBAL_WAITINGCONTENTSBJ","[{X_SITENAME}] {X_MODULE}: Artigo pendente");
define($constpref."_NOTIFY_GLOBAL_NEWCONTENT","Novo artigo");
define($constpref."_NOTIFY_GLOBAL_NEWCONTENTCAP","Notifique-me quando um artigo for publicado.");
define($constpref."_NOTIFY_GLOBAL_NEWCONTENTSBJ","[{X_SITENAME}] {X_MODULE} : Novo artigo");

}


?>
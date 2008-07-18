<?php
// Translation Info
// *************************************************************** //
// ############################################################### //
// ## XOOPS Cube Legacy 2.1 - Tradução para o Português
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
define($constpref."_DESC","Módulo avançado para edição de conteúdo dinâmico e encapsulamento de conteúdo estático");

// admin menus
define($constpref."_ADMENU_CONTENTSADMIN","Conteúdo");
define($constpref."_ADMENU_CATEGORYACCESS","Categorias");
define($constpref."_ADMENU_IMPORT","Importar/sincronizar");
define($constpref."_ADMENU_MYLANGADMIN","Idiomas");
define($constpref."_ADMENU_MYTPLSADMIN","Modelos");
define($constpref."_ADMENU_MYBLOCKSADMIN","Blocos & permissões");
define($constpref."_ADMENU_MYPREFERENCES","Preferências");

// configurations
define($constpref."_USE_WRAPSMODE","Habilitar o modo de encapsulamento");
define($constpref."_USE_REWRITE","Habilitar a tecnologia mod_rewrite");
define($constpref."_USE_REWRITEDSC","Depende das configurações de seu servidor. Ao habilitar esta opção, renomeie o arquivo .htaccess.rewrite_wraps (encapsulamento) ou htaccess.rewrite_normal (sem encapsulamento) como .htaccess no diretório raíz deste módulo");
define($constpref."_WRAPSAUTOREGIST","Importar automaticamente o artigo estático dos arquivos HTML para o banco de dados.");
define($constpref."_TOP_MESSAGE","Descrição da categoria principal");
define($constpref."_TOP_MESSAGEDEFAULT","");
define($constpref."_MENUINMODULETOP","Mostrar o menu (índice) no topo deste módulo");
define($constpref."_LISTASINDEX","Mostrar o índice de artigos na página inicial");
define($constpref."_LISTASINDEXDSC","Optar por SIM fará com que a página inicial deste módulo seja um índice dos artigos; optar por NÃO fará com que o artigo de maior prioridade seja a página inicial.");
define($constpref."_SHOW_BREADCRUMBS","Mostrar breadcrumbs");
define($constpref."_SHOW_PAGENAVI","Mostrar a página de navegação do artigo");
define($constpref."_SHOW_PRINTICON","Mostrar o ícone de página para impressão");
define($constpref."_SHOW_TELLAFRIEND","Mostrar o ícone de indicação de artigo por email");
define($constpref."_SEARCHBYUID","Habilitar a opção de conceituar os autores");
define($constpref."_SEARCHBYUIDDSC","As colaborações de cada associado serão mostradas em suas respectivas páginas de perfil. Desabilite esta opção ao utilizar este módulo apenas para artigo estático.");
define($constpref."_USE_TAFMODULE","Utilizar o módulo de indicação Tellafriend");
define($constpref."_FILTERS","Configuração de filtros padrão");
define($constpref."_FILTERSDSC","Nomes dos filtros de entrada separados por barras verticais. Exemplo: PrimeiroFiltro|SegundoFiltro|TerceitoFiltro");
define($constpref."_FILTERSDEFAULT","htmlspecialchars|xcode|smiley|nl2br");
define($constpref."_FILTERSF","Filtros sempre habilitados");
define($constpref."_FILTERSFDSC","Nomes dos filtros de entrada separados por vírgulas e em ordem de execução. Exemplo: PrimeiroFiltro,SegundoNomes dos filtros de entrada separados por vírgulas e em ordem de execução. Exemplo: PrimeiroFiltro,SegundoFiltro,TerceitoFiltro");
define($constpref."_FILTERSP","Filtros sempre proibidos");
define($constpref."_FILTERSPDSC","Nomes dos filtros de entrada separados por vírgulas.");
define($constpref."_SUBMENU_SC","Mostrar o artigo em um submenu");
define($constpref."_SUBMENU_SCDSC","Ao habilitar esta opção, as categorias serão mostradas por padrão, como também qualquer artigo marcado como MENU");
define($constpref."_SITEMAP_SC","Mostrar o artigo no módulo sitemap");
define($constpref."_USE_VOTE","Permitir que os visitantes valorem os arquivos");
define($constpref."_GUESTVOTE_IVL","Votos dos anônimos");
define($constpref."_GUESTVOTE_IVLDSC","Definir como 0, para desabilitar o voto de visitantes. Qualquer outro número significa o tempo (em seg.) para permitir um segundo envio do mesmo IP.");
define($constpref."_HTMLHEADER","Cabeçalho HTML padrão");
define($constpref."_CSS_URI","Endereço URI do arquivo CSS para este módulo");
define($constpref."_CSS_URIDSC","Pode ser definido o path absoluto ou relativo. padrão: {mod_url}/index.css");
define($constpref."_IMAGES_DIR","Diretório das imagens em português");
define($constpref."_IMAGES_DIRDSC","O caminho relativo deve ser definido no diretório do módulo. O padrão é 'images'");
define($constpref."_BODY_EDITOR","Editor de textos");
define($constpref."_HISTORY_P_C","Quantas alterações do mesmo artigo serão gravadas no histórico");
define($constpref."_MLT_HISTORY","Tempo em que cada revisão será arquivada, em segundos");
define($constpref."_BRCACHE","Tempo de aceleração via cache para as imagens em modo de encapsulamento");
define($constpref."_BRCACHEDSC","Limite de tempo em segundos em que os arquivos binários (como imagens e vídeos) serão gravados nos navegadores dos visitantes. Se desejar, configure como 0 (zero) para desabilitar esta opção.");
define($constpref."_COM_DIRNAME","Integração de comentários: nome do diretório do d3forum");
define($constpref."_COM_FORUM_ID","Integração de comentários: número do fórum");
define($constpref."_COM_VIEW","Aparência da integração de comentários");

// blocks
define($constpref."_BNAME_MENU","Menu");
define($constpref."_BNAME_CONTENT","Artigo");
define($constpref."_BNAME_LIST","Listar");
define($constpref."_BNAME_SUBCATEGORIES","Subcategorias");
define($constpref."_BNAME_MYWAITINGS","Minhas colaborações em espera");

// Notify Categories
define($constpref."_NOTCAT_GLOBAL","Geral");
define($constpref."_NOTCAT_GLOBALDSC","Notificações deste módulo");

// Each Notifications
define($constpref."_NOTIFY_GLOBAL_WAITINGCONTENT","Artigo pendente");
define($constpref."_NOTIFY_GLOBAL_WAITINGCONTENTCAP","Notifique-me quando um artigo estiver pendente por aprovação");
define($constpref."_NOTIFY_GLOBAL_WAITINGCONTENTSBJ","[{X_SITENAME}] {X_MODULE}: Artigo pendente");
define($constpref."_NOTIFY_GLOBAL_NEWCONTENT","Novo artigo");
define($constpref."_NOTIFY_GLOBAL_NEWCONTENTCAP","Notifique-me quando um artigo for publicado.");
define($constpref."_NOTIFY_GLOBAL_NEWCONTENTSBJ","[{X_SITENAME}] {X_MODULE} : Novo artigo");

}


?>
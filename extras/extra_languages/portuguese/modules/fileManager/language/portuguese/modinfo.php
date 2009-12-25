<?php
// Translation Info
// $Id: modinfo.php 374 2009-12-10 07:50:16Z mikhail $
// License http://creativecommons.org/licenses/by/2.5/br/
// ############################################################### //
// ## XOOPS Cube Legacy 2.1 - Tradu��o para o Portugu�s do Brasil
// ############################################################### //
// ## Por............: Mikhail Miguel
// ## E-mail.........: mikhail@underpop.com
// ## Website........: http://xoopscube.com.br
// ## Plus...........: http://card.ly/mikhail
// ############################################################### //
// *************************************************************** //
/**
 * Filemaneger
 * (C)2007-2009 BeaBo Japan by Hiroki Seike
 * http://beabo.net/
 **/

define("_MI_FILEMANAGER_NAME","Arquivos");
define("_MI_FILEMANAGER_DESC","Gerenciador de pastas e arquivos, com capacidade de manipula��o em lote.");
define("_MI_FILEMANAGER_UPDATE","Atualizar");

// --------------------------------------------------------
// Names of admin menu items
// --------------------------------------------------------
define("_MI_FILEMANAGER_MAIN","Lista de arquivos");
define("_MI_FILEMANAGER_MAIN_DSC","Lista de arquivos com op��o de miniaturas autom�ticas para as imagens");
define("_MI_FILEMANAGER_UPLOAD","Enviar arquivo");
define("_MI_FILEMANAGER_UPLOAD_DSC","Enviar arquivos para o diret�rio <q>uploads</q>");

define("_MI_FILEMANAGER_FOLDER","Pasta");
define("_MI_FILEMANAGER_FOLDER_DSC","Gest�o de diret�rios e suas permiss�es");

define("_MI_FILEMANAGER_CHECK","Verificar configura��o");
define("_MI_FILEMANAGER_CHECK_DSC","Verifique as configura��es do gerenciador de arquivos");

// --------------------------------------------------------
// PreferenceEdit
// --------------------------------------------------------
define("_MI_FILEMANAGER_PATH","Principal diret�rio para envios");
define("_MI_FILEMANAGER_PATH_DSC","Defina o caminho sob /uploads/ (nome da pasta apenas, sem a barra no fim)");
define("_MI_FILEMANAGER_DIRHANDLE","Gestor de diret�rios");
define("_MI_FILEMANAGER_DIRHANDLE_DSC","Permitir ou n�o webmasters para criar e apagar pastas");
define("_MI_FILEMANAGER_THUMBSIZE","Tamanho da miniatura");
define("_MI_FILEMANAGER_THUMBSIZE_DSC","Especifique a largura m�xima das miniaturas para a lista de arquivos");
define("_MI_FILEMANAGER_DEBUGON","Habilitar o modo de depura��o");
define("_MI_FILEMANAGER_DEBUGON_DSC","Ativar ou n�o o modo de depura��o (<q>debug</q>) do gerenciador de arquivos, o qual � mostrado em uma p�gina encapsulada (<q>iframe</q>).");


define("_MI_FILEMANAGER_XOOPSLOCK","Ocultar imagens do sistema?");
define("_MI_FILEMANAGER_XOOPSLOCK_DSC","Mostra ou n�o arquivos de 'Image Manager' (por exemplo:. avatares, �cones emoticos, etc)");
define("_MI_FILEMANAGER_EXTENSIONS","Extens�es dos arquivos permitidos para serem enviados ao servidor");
define("_MI_FILEMANAGER_EXTENSIONS_DSC","Separe as extens�es dos formatos dos arquivos com barras verticais.<br /> Certifique-se de utilizar apenas min�sculas e n�o incluir espa��es entre elas as extens�es. <br />O valor predefinido �: <q>gif|jpg|jpeg|png|avi|mov|wmv|mp3|mp4|flv|doc|xls|ods|odt|pdf</q>");

// reserved  options setting

define("_MI_FILEMANAGER_FUSE","[ffmpeg] Utilizar FFmpeg");
define("_MI_FILEMANAGER_FUSE_DSC","FFmpeg � uma solu��o multi-plataforma completa para gravar, converter e servir conte�do  em �udio e v�deo. <br /> FFmpeg deve ser suportada pelo servidor. Se n�o estiver, instale o FFmpeg bin�rios para o seu servidor");
define("_MI_FILEMANAGER_FPATH","[ffmpeg] Caminho do FFmpeg");
define("_MI_FILEMANAGER_FPATH_DSC","Especifique o caminho f�sico (<q>path</q>) da instala��o do FFmpeg. <br />(por exemplo: <tt>/usr/local/bin</tt>, <tt>/usr/bin</tt>)");
define("_MI_FILEMANAGER_FOPT","[ffmpeg] Op��o");
define("_MI_FILEMANAGER_FOPT_DSC","Especifique o comando op��o. Sua vers�o n�o est� dispon�vel");
define("_MI_FILEMANAGER_FCAPTURE","[ffmpeg] tempo para o Screen Shot ");
define("_MI_FILEMANAGER_FCAPTURE_DSC","Tempo a partir do in�cio do v�deo para ter uma imagem");
define("_MI_FILEMANAGER_FCONVERT","[ffmpeg] tamanho m�ximo de FLV convers�o");
define("_MI_FILEMANAGER_FCONVERT_DSC","Especifique o tamanho m�ximo de arquivos FLV v�deo a ser convertido para o formato video. A unidade � MB");
define("_MI_FILEMANAGER_FMOVIEFILE","[ffmpeg] Formato do arquivo para converter para FLV");
define("_MI_FILEMANAGER_FMOVIEFILE_DSC","Separe as extens�es dos formatos dos arquivos com barras verticais.<br />Certifique-se de utilizar todas as palavras em min�sculas e de n�o incluir espa�os entre elas. <br /> O valor predefinido � <q>flv|avi|mwv|mov|mpg|qt|mov|3gp|3gp2|mp4</q>");
?>
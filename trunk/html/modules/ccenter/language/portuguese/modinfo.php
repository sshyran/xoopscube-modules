<?php
// $Id: modinfo.php,v 1.3 2009/07/07 12:00:42 nobu Exp $
// Module Info
// Traduzido para o Portugues do Brasil por: Miraldo Antoninho Ohse (m_ohse@hotmail.com).

// The name of this module
define("_MI_CCENTER_NAME","Centro de contato");

// A brief description of this module
define("_MI_CCENTER_DESC","Formul�rio de contato com armazenamento da mensagem no banco de dados e administra��o");

// Sub Menu
define("_MI_CCENTER_MYCONTACT", "Minhas mensagens");
define("_MI_CCENTER_MYCHARGE", "Contatos para mim");
define("_MI_CCENTER_STAFFDESK", "Suporte administrativo");

// Admin Menu
define("_MI_CCENTER_FORMADMIN", "Formul�rios");
define("_MI_CCENTER_MSGADMIN", "Mensagens");
define("_MI_CCENTER_HELP", "Sobre o m�dulo");

// A brief template of this module
define("_MI_CCENTER_INDEX_TPL", "Lista de Formul�rios");
define("_MI_CCENTER_FORM_TPL", "Formul�rio de contato");
define("_MI_CCENTER_CUST_TPL", "Formul�rio de contato (personalizar)");
define("_MI_CCENTER_CONF_TPL", "Confirmar dados do formul�rio");
define("_MI_CCENTER_LIST_TPL", "Lista de minhas consultas");
define("_MI_CCENTER_CHARGE_TPL", "Lista de contatos para mim");
define("_MI_CCENTER_MSGS_TPL", "Mostrar mensagem de contato");
define("_MI_CCENTER_RECEPT_TPL", "Mostrar suporte administrativo");
define("_MI_CCENTER_WIDGET_TPL", "Formul�rio widgets");

// A brief blocks of this module
define("_MI_CCENTER_BLOCK_RECEIPT","Contato para mim");
define("_MI_CCENTER_BLOCK_FORM","Formul�rio de contato");

// Configs
define("_MI_CCENTER_LISTS","N�mero de �tens listados");
define("_MI_CCENTER_LISTS_DESC","Configurar o n�mero de lista que ser�o mostradas");
define("_MI_CCENTER_DEF_ATTRS","Atributos padr�o");
define("_MI_CCENTER_DEF_ATTRS_DESC","Configura��o das defini��es do formul�rio e outros atributos <a href='help.php#attr'>Atributos padr�o</a>. Examplo: <tt>tamanho=60,linhas=5,colunas=50</tt>");
define("_MI_CCENTER_STATUS_COMBO", "Sele��o dos status");

define("_MI_CCENTER_STATUS_COMBO_DESC","o formato como: <tt>Mostrar-etiqueta: [status1[,status2...]]</tt>, incluir m�ltiplas linhas. o status � um caracter do (-,a,b,c). Exemplo: <tt>Abrir: - a</tt>");
define("_MI_CCENTER_STATUS_COMBO_DEF","Todas: - a b c\nAberta: - a\nFechada: b c\n--------:\nPendente: -\nEm an�lise: a\nRespondidas: b\nEncerradas: c\n");

// Notifications
define("_MI_CCENTER_GLOBAL_NOTIFY","Todos os formul�rios");
define("_MI_CCENTER_FORM_NOTIFY","Este formul�rio");
define("_MI_CCENTER_MESSAGE_NOTIFY","Esta mensagem");

define("_MI_CCENTER_NEWPOST_NOTIFY","Mensagem de contato");
define("_MI_CCENTER_NEWPOST_NOTIFY_CAP","Notifique-me das mensagens de contato");
define("_MI_CCENTER_NEWPOST_SUBJECT","Postar mensagem de contato");

define("_MI_CCENTER_STATUS_NOTIFY","Atualizar status");
define("_MI_CCENTER_STATUS_NOTIFY_CAP","Notifique-me sobre as mudan�as de status");
define("_MI_CCENTER_STATUS_SUBJECT","Status:[{X_MODULE}]{FORM_NAME}");

define("_MI_SAMPLE_FORM","Criar um exemplo de formul�rio");
define("_MI_SAMPLE_TITLE","Fa�a contato");
define("_MI_SAMPLE_DESC","Por favor, utilize este formul�rio quando voc� desejar fazer contato com o administrador deste site.");
define("_MI_SAMPLE_DEFS","Seu nome*,tamanho=40\nE-mail*,mail,tamanho=60\nSobre*,radio,Conte�dos do site,Consulta sobre n�s,Outros\nMensagem,�rea de texto,colunas=50,linhas=5");

// for altsys 
if (!defined('_MD_A_MYMENU_MYTPLSADMIN')) {
    define('_MD_A_MYMENU_MYTPLSADMIN','Modelos');
    define('_MD_A_MYMENU_MYBLOCKSADMIN','Blocos e Permiss�es');
    define('_MD_A_MYMENU_MYPREFERENCES','Prefer�ncias');
}
?>

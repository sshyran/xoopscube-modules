<?php
// $Id: admin.php,v 1.2 2008/07/05 12:54:16 ohwada Exp $

//=========================================================
// webphoto module
// 2008-04-02 K.OHWADA
//=========================================================

// === define begin ===
if( !defined("_AM_WEBPHOTO_LANG_LOADED") ) 
{

define("_AM_WEBPHOTO_LANG_LOADED" , 1 ) ;

//=========================================================
// base on myalbum
//=========================================================

// menu
define("_AM_WEBPHOTO_MYMENU_TPLSADMIN","�ƥ�ץ졼�ȴ���");
define("_AM_WEBPHOTO_MYMENU_BLOCKSADMIN","�֥�å�����/������������");

//define("_AM_WEBPHOTO_MYMENU_MYPREFERENCES","��������");

// add for webphoto
define("_AM_WEBPHOTO_MYMENU_GOTO_MODULE" , "�⥸�塼���" ) ;


// Index (Categories)
//define( "_AM_WEBPHOTO_H3_FMT_CATEGORIES" , "%s ���ƥ��꡼����" ) ;
//define( "_AM_WEBPHOTO_CAT_TH_TITLE" , "���ƥ��꡼̾" ) ;

define( "_AM_WEBPHOTO_CAT_TH_PHOTOS" , "������" ) ;
define( "_AM_WEBPHOTO_CAT_TH_OPERATION" , "���ƥ������" ) ;
define( "_AM_WEBPHOTO_CAT_TH_IMAGE" , "���᡼��" ) ;
define( "_AM_WEBPHOTO_CAT_TH_PARENT" , "�ƥ��ƥ��꡼" ) ;

//define( "_AM_WEBPHOTO_CAT_TH_IMGURL" , "���᡼����URL" ) ;

define( "_AM_WEBPHOTO_CAT_MENU_NEW" , "���ƥ��꡼�ο�������" ) ;
define( "_AM_WEBPHOTO_CAT_MENU_EDIT" , "���ƥ��꡼���Խ�" ) ;
define( "_AM_WEBPHOTO_CAT_INSERTED" , "���ƥ��꡼���ɲä��ޤ���" ) ;
define( "_AM_WEBPHOTO_CAT_UPDATED" , "���ƥ��꡼�򹹿����ޤ���" ) ;
define( "_AM_WEBPHOTO_CAT_BTN_BATCH" , "�ѹ���ȿ�Ǥ���" ) ;
define( "_AM_WEBPHOTO_CAT_LINK_MAKETOPCAT" , "�ȥåץ��ƥ��꡼���ɲ�" ) ;
define( "_AM_WEBPHOTO_CAT_LINK_ADDPHOTOS" , "���Υ��ƥ��꡼�˲������ɲ�" ) ;
define( "_AM_WEBPHOTO_CAT_LINK_EDIT" , "���Υ��ƥ��꡼���Խ�" ) ;
define( "_AM_WEBPHOTO_CAT_LINK_MAKESUBCAT" , "���Υ��ƥ��꡼���˥��֥��ƥ��꡼����" ) ;
define( "_AM_WEBPHOTO_CAT_FMT_NEEDADMISSION" , "̤��ǧ�������� (%s ��)" ) ;
define( "_AM_WEBPHOTO_CAT_FMT_CATDELCONFIRM" , "���ƥ��꡼ %s �������Ƥ�����Ǥ����� �۲��Υ��֥��ƥ��꡼��ޤᡢ�����䥳���Ȥ����٤ƺ������ޤ�" ) ;


// Admission
//define( "_AM_WEBPHOTO_H3_FMT_ADMISSION" , "%s ��Ʋ����ξ�ǧ" ) ;
//define( "_AM_WEBPHOTO_TH_SUBMITTER" , "��Ƽ�" ) ;
//define( "_AM_WEBPHOTO_TH_TITLE" , "�����ȥ�" ) ;
//define( "_AM_WEBPHOTO_TH_DESCRIPTION" , "����ʸ" ) ;
//define( "_AM_WEBPHOTO_TH_CATEGORIES" , "���ƥ��꡼" ) ;
//define( "_AM_WEBPHOTO_TH_DATE" , "�ǽ�������" ) ;


// Photo Manager
//define( "_AM_WEBPHOTO_H3_FMT_PHOTOMANAGER" , "%s ��������" ) ;

define( "_AM_WEBPHOTO_TH_BATCHUPDATE" , "�����å�����������ޤȤ���ѹ�����" ) ;
define( "_AM_WEBPHOTO_OPT_NOCHANGE" , "�ѹ��ʤ�" ) ;
define( "_AM_WEBPHOTO_JS_UPDATECONFIRM" , "���ꤵ�줿���ܤˤĤ��ƤΤߡ������å������������ѹ����ޤ�" ) ;


// Module Checker
//define( "_AM_WEBPHOTO_H3_FMT_MODULECHECKER" , "myAlbum-P ư������å��� (%s)" ) ;

define( "_AM_WEBPHOTO_H4_ENVIRONMENT" , "�Ķ������å�" ) ;
define( "_AM_WEBPHOTO_PHPDIRECTIVE" , "PHP����" ) ;
define( "_AM_WEBPHOTO_BOTHOK" , "ξ��ok" ) ;
define( "_AM_WEBPHOTO_NEEDON" , "��on" ) ;

define( "_AM_WEBPHOTO_H4_TABLE" , "�ơ��֥�����å�" ) ;

//define( "_AM_WEBPHOTO_PHOTOSTABLE" , "�ᥤ������ơ��֥�" ) ;
//define( "_AM_WEBPHOTO_DESCRIPTIONTABLE" , "�ƥ����ȥơ��֥�" ) ;
//define( "_AM_WEBPHOTO_CATEGORIESTABLE" , "���ƥ��꡼�ơ��֥�" ) ;
//define( "_AM_WEBPHOTO_VOTEDATATABLE" , "��ɼ�ǡ����ơ��֥�" ) ;

define( "_AM_WEBPHOTO_COMMENTSTABLE" , "�����ȥơ��֥�" ) ;
define( "_AM_WEBPHOTO_NUMBEROFPHOTOS" , "�������" ) ;
define( "_AM_WEBPHOTO_NUMBEROFDESCRIPTIONS" , "�ƥ��������" ) ;
define( "_AM_WEBPHOTO_NUMBEROFCATEGORIES" , "���ƥ��꡼���" ) ;
define( "_AM_WEBPHOTO_NUMBEROFVOTEDATA" , "��ɼ���" ) ;
define( "_AM_WEBPHOTO_NUMBEROFCOMMENTS" , "���������" ) ;

define( "_AM_WEBPHOTO_H4_CONFIG" , "��������å�" ) ;
define( "_AM_WEBPHOTO_PIPEFORIMAGES" , "���������ץ����" ) ;

//define( "_AM_WEBPHOTO_DIRECTORYFORPHOTOS" , "�ᥤ������ǥ��쥯�ȥ�" ) ;
//define( "_AM_WEBPHOTO_DIRECTORYFORTHUMBS" , "����ͥ���ǥ��쥯�ȥ�" ) ;

define( "_AM_WEBPHOTO_ERR_LASTCHAR" , "���顼: �Ǹ��ʸ����'/'�Ǥʤ���Фʤ�ޤ���" ) ;
define( "_AM_WEBPHOTO_ERR_FIRSTCHAR" , "���顼: �ǽ��ʸ����'/'�Ǥʤ���Фʤ�ޤ���" ) ;
define( "_AM_WEBPHOTO_ERR_PERMISSION" , "���顼: �ޤ����Υǥ��쥯�ȥ��Ĥ��äƲ����������ξ�ǡ������ǽ�����ꤷ�Ʋ�������Unix�Ǥ�chmod 777��Windows�Ǥ��ɤ߼������°���򳰤��ޤ�" ) ;
define( "_AM_WEBPHOTO_ERR_NOTDIRECTORY" , "���顼: ���ꤵ�줿�ǥ��쥯�ȥ꤬����ޤ���." ) ;
define( "_AM_WEBPHOTO_ERR_READORWRITE" , "���顼: ���ꤵ�줿�ǥ��쥯�ȥ���ɤ߽Ф��ʤ����񤭹���ʤ����Τ����줫�Ǥ�������ξ������Ĥ�������ˤ��Ʋ�������Unix�Ǥ�chmod 777��Windows�Ǥ��ɤ߼������°���򳰤��ޤ�" ) ;
define( "_AM_WEBPHOTO_ERR_SAMEDIR" , "���顼: �ᥤ������ѥǥ��쥯�ȥ�ȥ���ͥ����ѥǥ��쥯�ȥ꤬���Ǥ����ʤ���������Բ�ǽ�Ǥ���" ) ;
define( "_AM_WEBPHOTO_LNK_CHECKGD2" , "GD2(truecolor)�⡼�ɤ�ư�����ɤ����Υ����å�" ) ;
define( "_AM_WEBPHOTO_CHECKGD2" , "�ʤ��Υ���褬�����ɽ������ʤ���С�GD2�⡼�ɤǤ�ư���ʤ���Τ�����Ƥ���������" ) ;
define( "_AM_WEBPHOTO_GD2SUCCESS" , "�������ޤ���!<br />�����餯�����Υ����Ф�PHP�Ǥϡ�GD2(true color)�⡼�ɤǲ�����������ǽ�Ǥ���" ) ;

define( "_AM_WEBPHOTO_H4_PHOTOLINK" , "�ᥤ������ȥ���ͥ���Υ�󥯥����å�" ) ;
define( "_AM_WEBPHOTO_NOWCHECKING" , "�����å��� ." ) ;
define( "_AM_WEBPHOTO_FMT_PHOTONOTREADABLE" , "�ᥤ����� (%s) ���ɤ�ޤ���." ) ;
define( "_AM_WEBPHOTO_FMT_THUMBNOTREADABLE" , "����ͥ������ (%s) ���ɤ�ޤ���." ) ;
define( "_AM_WEBPHOTO_FMT_NUMBEROFDEADPHOTOS" , "�����Τʤ��쥳���ɤ� %s �Ĥ���ޤ�����" ) ;
define( "_AM_WEBPHOTO_FMT_NUMBEROFDEADTHUMBS" , "����ͥ��뤬 %s ��̤�����Ǥ�" ) ;
define( "_AM_WEBPHOTO_FMT_NUMBEROFREMOVEDTMPS" , "�ƥ�ݥ��� %s �ĺ�����ޤ���" ) ;
define( "_AM_WEBPHOTO_LINK_REDOTHUMBS" , "����ͥ���ƹ���" ) ;
define( "_AM_WEBPHOTO_LINK_TABLEMAINTENANCE" , "�ơ��֥���ƥʥ�" ) ;


// Redo Thumbnail
//define( "_AM_WEBPHOTO_H3_FMT_RECORDMAINTENANCE" , "myAlbum-P �̿����ƥʥ� (%s)" ) ;

define( "_AM_WEBPHOTO_FMT_CHECKING" , "%s ������å��� ... " ) ;
define( "_AM_WEBPHOTO_FORM_RECORDMAINTENANCE" , "����ͥ���κƹ��ۤʤɡ��̿��ǡ����γƼ���ƥʥ�" ) ;

define( "_AM_WEBPHOTO_FAILEDREADING" , "�̿��ե�������ɤ߹��߼���" ) ;
define( "_AM_WEBPHOTO_CREATEDTHUMBS" , "����ͥ��������λ" ) ;
define( "_AM_WEBPHOTO_BIGTHUMBS" , "����ͥ��������Ǥ��ʤ��Τǡ����ԡ����ޤ���" ) ;
define( "_AM_WEBPHOTO_SKIPPED" , "�����åפ��ޤ�" ) ;
define( "_AM_WEBPHOTO_SIZEREPAIRED" , "(��Ͽ����Ƥ����ԥ�������������ޤ���)" ) ;
define( "_AM_WEBPHOTO_RECREMOVED" , "���Υ쥳���ɤϺ������ޤ���" ) ;
define( "_AM_WEBPHOTO_PHOTONOTEXISTS" , "����������ޤ���" ) ;
define( "_AM_WEBPHOTO_PHOTORESIZED" , "������Ĵ�����ޤ���" ) ;

define( "_AM_WEBPHOTO_TEXT_RECORDFORSTARTING" , "�����򳫻Ϥ���쥳�����ֹ�" ) ;
define( "_AM_WEBPHOTO_TEXT_NUMBERATATIME" , "���٤˽�������̿���" ) ;
define( "_AM_WEBPHOTO_LABEL_DESCNUMBERATATIME" , "���ο����礭����������ȥ����ФΥ����ॢ���Ȥ򾷤��ޤ�" ) ;

define( "_AM_WEBPHOTO_RADIO_FORCEREDO" , "����ͥ��뤬���äƤ��˺�����ľ��" ) ;
define( "_AM_WEBPHOTO_RADIO_REMOVEREC" , "�̿����ʤ��쥳���ɤ�������" ) ;
define( "_AM_WEBPHOTO_RADIO_RESIZE" , "���Υԥ��������������礭�ʲ����ϥ��������ڤ�Ĥ��" ) ;

define( "_AM_WEBPHOTO_FINISHED" , "��λ" ) ;
define( "_AM_WEBPHOTO_LINK_RESTART" , "�ƥ�������" ) ;
define( "_AM_WEBPHOTO_SUBMIT_NEXT" , "����" ) ;


// Batch Register
//define( "_AM_WEBPHOTO_H3_FMT_BATCHREGISTER" , "myAlbum-P ���������Ͽ (%s)" ) ;


// GroupPerm Global
//define( "_AM_WEBPHOTO_GROUPPERM_GLOBAL" , "�ƥ��롼�פθ�������" ) ;

define( "_AM_WEBPHOTO_GROUPPERM_GLOBALDESC" , "���롼�׸ġ��ˤĤ��ơ����¤����ꤷ�ޤ�" ) ;
define( "_AM_WEBPHOTO_GPERMUPDATED" , "����������ѹ����ޤ���" ) ;


// Import
define( "_AM_WEBPHOTO_H3_FMT_IMPORTTO" , '%s �ؤβ�������ݡ���' ) ;
define( "_AM_WEBPHOTO_FMT_IMPORTFROMMYALBUMP" , 'myAblum-P�⥸�塼��: ��%s�� ����μ����ߡʥ��ƥ��꡼ñ�̡�' ) ;
define( "_AM_WEBPHOTO_FMT_IMPORTFROMIMAGEMANAGER" , '���᡼�����ޥ͡����㤫��μ����ߡʥ��ƥ��꡼ñ�̡�' ) ;

//define( "_AM_WEBPHOTO_CB_IMPORTRECURSIVELY" , '���֥��ƥ��꡼�⥤��ݡ��Ȥ���' ) ;
//define( "_AM_WEBPHOTO_RADIO_IMPORTCOPY" , '�����Υ��ԡ��ʥ����Ȥϰ����Ѥ���ޤ����' ) ;
//define( "_AM_WEBPHOTO_RADIO_IMPORTMOVE" , '�����ΰ�ư�ʥ����Ȥ�����Ѥ��ޤ���' ) ;

define( "_AM_WEBPHOTO_IMPORTCONFIRM" , '����ݡ��Ȥ��ޤ���������Ǥ�����' ) ;
define( "_AM_WEBPHOTO_FMT_IMPORTSUCCESS" , '%s ��β����򥤥�ݡ��Ȥ��ޤ���' ) ;


// Export
define( "_AM_WEBPHOTO_H3_FMT_EXPORTTO" , '%s ����¾�⥸�塼�����ؤβ����������ݡ���' ) ;
define( "_AM_WEBPHOTO_FMT_EXPORTTOIMAGEMANAGER" , '���᡼�����ޥ͡�����ؤν񤭽Ф��ʥ��ƥ��꡼ñ�̡�' ) ;
define( "_AM_WEBPHOTO_FMT_EXPORTIMSRCCAT" , '���ԡ������ƥ��꡼' ) ;
define( "_AM_WEBPHOTO_FMT_EXPORTIMDSTCAT" , '���ԡ��襫�ƥ��꡼' ) ;
define( "_AM_WEBPHOTO_CB_EXPORTRECURSIVELY" , '���֥��ƥ��꡼�⥨�����ݡ��Ȥ���' ) ;
define( "_AM_WEBPHOTO_CB_EXPORTTHUMB" , '����ͥ�����������򥨥����ݡ��Ȥ���' ) ;
define( "_AM_WEBPHOTO_EXPORTCONFIRM" , '�������ݡ��Ȥ��ޤ���������Ǥ�����' ) ;
define( "_AM_WEBPHOTO_FMT_EXPORTSUCCESS" , '%s ��β����򥨥����ݡ��Ȥ��ޤ���' ) ;


//---------------------------------------------------------
// move from main.php
//---------------------------------------------------------
define( "_AM_WEBPHOTO_BTN_SELECTALL" , "������" ) ;
define( "_AM_WEBPHOTO_BTN_SELECTNONE" , "������" ) ;
define( "_AM_WEBPHOTO_BTN_SELECTRVS" , "����ȿž" ) ;
define( "_AM_WEBPHOTO_FMT_PHOTONUM" , "%s ��" ) ;

define( "_AM_WEBPHOTO_ADMISSION" , "�����ξ�ǧ" ) ;
define( "_AM_WEBPHOTO_ADMITTING" , "������ǧ���ޤ���" ) ;
define( "_AM_WEBPHOTO_LABEL_ADMIT" , "�����å�����������ǧ����" ) ;
define( "_AM_WEBPHOTO_BUTTON_ADMIT" , "��ǧ" ) ;
define( "_AM_WEBPHOTO_BUTTON_EXTRACT" , "���" ) ;

define( "_AM_WEBPHOTO_LABEL_REMOVE" , "�����å�����������������" ) ;
define( "_AM_WEBPHOTO_JS_REMOVECONFIRM" , "������Ƥ�����Ǥ���" ) ;
define( "_AM_WEBPHOTO_LABEL_MOVE" , "�����å������������ư����" ) ;
define( "_AM_WEBPHOTO_BUTTON_MOVE" , "��ư" ) ;
define( "_AM_WEBPHOTO_BUTTON_UPDATE" , "�ѹ�" ) ;
define( "_AM_WEBPHOTO_DEADLINKMAINPHOTO" , "�ᥤ�������¸�ߤ��ޤ���" ) ;

define("_AM_WEBPHOTO_NOSUBMITTED","��������Ʋ����Ϥ���ޤ���");
define("_AM_WEBPHOTO_ADDMAIN","�ȥåץ��ƥ�����ɲ�");
define("_AM_WEBPHOTO_IMGURL","������URL (�����ι⤵�Ϥ��餫����50pixel��): ");
define("_AM_WEBPHOTO_ADD","�ɲ�");
define("_AM_WEBPHOTO_ADDSUB","���֥��ƥ�����ɲ�");
define("_AM_WEBPHOTO_IN","");
define("_AM_WEBPHOTO_MODCAT","���ƥ����ѹ�");

define("_AM_WEBPHOTO_MODREQDELETED","�ѹ���������");
define("_AM_WEBPHOTO_IMGURLMAIN","����URL (�����ι⤵�Ϥ��餫����50pixel��): ");
define("_AM_WEBPHOTO_PARENT","�ƥ��ƥ���:");
define("_AM_WEBPHOTO_SAVE","�ѹ�����¸");
define("_AM_WEBPHOTO_CATDELETED","���ƥ���ξõλ");
define("_AM_WEBPHOTO_CATDEL_WARNING","���ƥ����Ʊ���ˤ����˴ޤޤ���������ӥ����Ȥ����ƺ������ޤ���������Ǥ�����");

define("_AM_WEBPHOTO_NEWCATADDED","�����ƥ����ɲä�����!");
define("_AM_WEBPHOTO_ERROREXIST","���顼: �󶡤��������Ϥ��Ǥ˥ǡ����١�����¸�ߤ��ޤ���");
define("_AM_WEBPHOTO_ERRORTITLE","���顼: �����ȥ뤬ɬ�פǤ�!");
define("_AM_WEBPHOTO_ERRORDESC","���顼: ������ɬ�פǤ�!");
define("_AM_WEBPHOTO_WEAPPROVED","�����ǡ����١����ؤΥ��������ǧ���ޤ�����");
define("_AM_WEBPHOTO_THANKSSUBMIT","�����ͭ���񤦤������ޤ���");
define("_AM_WEBPHOTO_CONFUPDATED","����򹹿����ޤ�����");

define("_AM_WEBPHOTO_PHOTOBATCHUPLOAD","�����Ф˥��åץ��ɺѥե�����ΰ����Ͽ");
define("_AM_WEBPHOTO_PHOTOPATH","Path:");
define("_AM_WEBPHOTO_TEXT_DIRECTORY","�ǥ��쥯�ȥ�");
define("_AM_WEBPHOTO_DESC_PHOTOPATH","�����δޤޤ��ǥ��쥯�ȥ�����Хѥ��ǻ��ꤷ�Ʋ�����");
define("_AM_WEBPHOTO_MES_INVALIDDIRECTORY","���ꤵ�줿�ǥ��쥯�ȥ꤫��������ɤ߽Ф��ޤ���");
define("_AM_WEBPHOTO_MES_BATCHDONE","%s ��β�������Ͽ���ޤ���");
define("_AM_WEBPHOTO_MES_BATCHNONE","���ꤵ�줿�ǥ��쥯�ȥ�˲����ե����뤬�ߤĤ���ޤ���Ǥ���");


//---------------------------------------------------------
// move from myalbum_constants.php
//---------------------------------------------------------
// Global Group Permission
define( "_AM_WEBPHOTO_GPERM_INSERTABLE" , "��Ʋġ��׾�ǧ��" ) ;
define( "_AM_WEBPHOTO_GPERM_SUPERINSERT" , "��Ʋġʾ�ǧ���ס�" ) ;
define( "_AM_WEBPHOTO_GPERM_EDITABLE" , "�Խ��ġ��׾�ǧ��" ) ;
define( "_AM_WEBPHOTO_GPERM_SUPEREDIT" , "�Խ��ġʾ�ǧ���ס�" ) ;
define( "_AM_WEBPHOTO_GPERM_DELETABLE" , "����ġ��׾�ǧ��" ) ;
define( "_AM_WEBPHOTO_GPERM_SUPERDELETE" , "����ġʾ�ǧ���ס�" ) ;
define( "_AM_WEBPHOTO_GPERM_TOUCHOTHERS" , "¾�桼���Υ��᡼�����Խ�������ġ��׾�ǧ��" ) ;
define( "_AM_WEBPHOTO_GPERM_SUPERTOUCHOTHERS" , "¾�桼���Υ��᡼�����Խ�������ġʾ�ǧ���ס�" ) ;
define( "_AM_WEBPHOTO_GPERM_RATEVIEW" , "��ɼ������" ) ;
define( "_AM_WEBPHOTO_GPERM_RATEVOTE" , "��ɼ��" ) ;
define( "_AM_WEBPHOTO_GPERM_TELLAFRIEND" , "ͧ�ͤ��Τ餻��" ) ;

// add for webphoto
define( "_AM_WEBPHOTO_GPERM_TAGEDIT" , "�����Խ��ġʾ�ǧ���ס�" ) ;


//=========================================================
// add for webphoto
//=========================================================

//---------------------------------------------------------
// google icon
// modify from gnavi
//---------------------------------------------------------

// list
define( "_AM_WEBPHOTO_GICON_ADD" , "��������򿷵��ɲ�" ) ;
define( "_AM_WEBPHOTO_GICON_LIST_IMAGE" , '��������' ) ;
define( "_AM_WEBPHOTO_GICON_LIST_SHADOW" , '����ɡ�' ) ;
define( "_AM_WEBPHOTO_GICON_ANCHOR" , '���󥫡��ݥ����' ) ;
define( "_AM_WEBPHOTO_GICON_WINANC" , '������ɥ����󥫡�' ) ;
define( "_AM_WEBPHOTO_GICON_LIST_EDIT" , '����������Խ�' ) ;

// form
define( "_AM_WEBPHOTO_GICON_MENU_NEW" ,  "��������ο�������" ) ;
define( "_AM_WEBPHOTO_GICON_MENU_EDIT" , "����������Խ�" ) ;
define( "_AM_WEBPHOTO_GICON_IMAGE_SEL" ,  "�����������������" ) ;
define( "_AM_WEBPHOTO_GICON_SHADOW_SEL" , "�������󥷥�ɡ�������" ) ;
define( "_AM_WEBPHOTO_GICON_SHADOW_DEL" , '�������󥷥�ɡ�����' ) ;
define( "_AM_WEBPHOTO_GICON_DELCONFIRM" , "�������� %s �������Ƥ�����Ǥ����� " ) ;


//---------------------------------------------------------
// mime type
// modify from wfdownloads
//---------------------------------------------------------

// Mimetype Form
define("_AM_WEBPHOTO_MIME_CREATEF", "MIME������ ����");
define("_AM_WEBPHOTO_MIME_MODIFYF", "MIME������ �Խ�");
define("_AM_WEBPHOTO_MIME_NOMIMEINFO", "MIME�����פ����򤵤�Ƥ��ޤ���");
define("_AM_WEBPHOTO_MIME_INFOTEXT", "<ul><li>������MIME�����פ�������뤳�Ȥ��Ǥ������Υե����फ���ñ���Խ��ڤӺ�����뤳�Ȥ��Ǥ��ޤ��� </li>
	<li>�����Եڤӥ桼�������åץ��ɤǤ���MIME�����פ��ǧ�Ǥ��ޤ���</li>
	<li>���åץ��ɤ���Ƥ���MIME�����פ��ѹ������������ޤ���</li></ul>
	");

// Mimetype Database
define("_AM_WEBPHOTO_MIME_DELETETHIS", "���򤵤줿MIME�����פ������ޤ���������Ǥ�����");
define("_AM_WEBPHOTO_MIME_MIMEDELETED", "MIME������ %s �Ϻ������ޤ�����");
define("_AM_WEBPHOTO_MIME_CREATED", "MIME�����פ�������ޤ�����");
define("_AM_WEBPHOTO_MIME_MODIFIED", "MIME�����פ򹹿����ޤ�����");

//image admin icon 
define("_AM_WEBPHOTO_MIME_ICO_EDIT","���Υ����ƥ���Խ�");
define("_AM_WEBPHOTO_MIME_ICO_DELETE","���Υ����ƥ����");
define("_AM_WEBPHOTO_MIME_ICO_ONLINE","����饤��");
define("_AM_WEBPHOTO_MIME_ICO_OFFLINE","���ե饤��");

// find mine type
//define("_AM_WEBPHOTO_MIME_FINDMIMETYPE", "Find New Mimetype:");
//define("_AM_WEBPHOTO_MIME_FINDIT", "Get Extension!");

// added for webphoto
define("_AM_WEBPHOTO_MIME_PERMS", "���Ĥ���Ƥ��륰�롼��");
define("_AM_WEBPHOTO_MIME_ALLOWED", "���Ĥ���Ƥ���MIME������");
define("_AM_WEBPHOTO_MIME_NOT_ENTER_EXT", "��ĥ�Ҥ����Ϥ���Ƥ��ʤ�");

//---------------------------------------------------------
// check config
//---------------------------------------------------------
define("_AM_WEBPHOTO_DIRECTORYFOR_PHOTOS" , "���� �ǥ��쥯�ȥ�" ) ;
define("_AM_WEBPHOTO_DIRECTORYFOR_THUMBS" , "����ͥ��� �ǥ��쥯�ȥ�" ) ;
define("_AM_WEBPHOTO_DIRECTORYFOR_GICONS" , "Google �������� �ǥ��쥯�ȥ�" ) ;
define("_AM_WEBPHOTO_DIRECTORYFOR_TMP" ,    "����ե����� �ǥ��쥯�ȥ�" ) ;

//---------------------------------------------------------
// check table
//---------------------------------------------------------
define("_AM_WEBPHOTO_NUMBEROFRECORED", "�쥳���ɿ�");

//---------------------------------------------------------
// manage
//---------------------------------------------------------
define("_AM_WEBPHOTO_MANAGE_DESC","<b>���</b><br />�ơ��֥�ñ�Τδ����Ǥ�<br />��Ϣ����ơ��֥���ѹ�����ޤ���");
define("_AM_WEBPHOTO_ERR_NO_RECORD", "�ǡ�����¸�ߤ��ʤ�");

//---------------------------------------------------------
// cat manager
//---------------------------------------------------------
define("_AM_WEBPHOTO_DSC_CAT_IMGPATH" , "XOOPS���󥹥ȡ����褫��Υѥ������<br />�ʺǽ��'/'��ɬ�ס�" ) ;
define("_AM_WEBPHOTO_OPT_CAT_PERM_POST_ALL" , "���ƤΥ��롼��" ) ;

//---------------------------------------------------------
// import
//---------------------------------------------------------
define("_AM_WEBPHOTO_FMT_IMPORTFROM_WEBPHOTO" , 'webphoto �⥸�塼��: ��%s�� ����μ����ߡʥ��ƥ��꡼ñ�̡�' ) ;
define("_AM_WEBPHOTO_IMPORT_COMMENT_NO" , "�����Ȥ򥳥ԡ����ʤ�" ) ;
define("_AM_WEBPHOTO_IMPORT_COMMENT_YES" , "�����Ȥ򥳥ԡ�����" ) ;

//---------------------------------------------------------
// v0.20
//---------------------------------------------------------
define("_AM_WEBPHOTO_PATHINFO_LINK" , "Pathinfo ��ư�����ɤ����Υ����å�" ) ;
define("_AM_WEBPHOTO_PATHINFO_DSC" , "�ʤ��Υ���褬�����ɽ������ʤ���С�Pathinfo ��ư���ʤ���Τ�����Ƥ���������" ) ;
define("_AM_WEBPHOTO_PATHINFO_SUCCESS" , "�������ޤ���!<br />�����餯�����Υ����ФǤϡ�Pathinfo �����ѤǤ��ޤ�" ) ;
define("_AM_WEBPHOTO_CAP_REDO_EXIF" , "Exif �μ���" ) ;
define("_AM_WEBPHOTO_RADIO_REDO_EXIF_TRY" , "���ꤵ��Ƥ��ʤ��Ȥ��˼���" ) ;
define("_AM_WEBPHOTO_RADIO_REDO_EXIF_ALWAYS" , "��˼�������" ) ;

// === define end ===
}

?>
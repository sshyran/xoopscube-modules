<?php
// $Id: main.php,v 1.3 2008/07/05 12:54:16 ohwada Exp $

//=========================================================
// webphoto module
// 2008-04-02 K.OHWADA
//=========================================================

// === define begin ===
if( !defined("_MB_WEBPHOTO_LANGLOADED") ) 
{

define("_MB_WEBPHOTO_LANG_LOADED" , 1 ) ;

//=========================================================
// base on myalbum
//=========================================================

define("_WEBPHOTO_CATEGORY","���ƥ���");
define("_WEBPHOTO_SUBMITTER","��Ƽ�");
define("_WEBPHOTO_NOMATCH_PHOTO","����������ޤ���");

define("_WEBPHOTO_ICON_NEW","����");
define("_WEBPHOTO_ICON_UPDATE","����");
define("_WEBPHOTO_ICON_POPULAR","��ҥå�");
define("_WEBPHOTO_ICON_LASTUPDATE","���󹹿�");
define("_WEBPHOTO_ICON_HITS","�ҥåȿ�");
define("_WEBPHOTO_ICON_COMMENTS","�����ȿ�");

define("_WEBPHOTO_SORT_IDA","�쥳�����ֹ澺��");
define("_WEBPHOTO_SORT_IDD","�쥳�����ֹ�߽�");
define("_WEBPHOTO_SORT_HITSA","�ҥåȿ� (�㢪��)");
define("_WEBPHOTO_SORT_HITSD","�ҥåȿ� (�⢪��)");
define("_WEBPHOTO_SORT_TITLEA","�����ȥ� (A �� Z)");
define("_WEBPHOTO_SORT_TITLED","�����ȥ� (Z �� A)");
define("_WEBPHOTO_SORT_DATEA","�������� (�좪��)");
define("_WEBPHOTO_SORT_DATED","�������� (������)");
define("_WEBPHOTO_SORT_RATINGA","ɾ�� (�㢪��)");
define("_WEBPHOTO_SORT_RATINGD","ɾ�� (�⢪��)");
define("_WEBPHOTO_SORT_RANDOM","������");

define("_WEBPHOTO_SORT_SORTBY","�¤��ؤ�:");
define("_WEBPHOTO_SORT_TITLE","�����ȥ�");
define("_WEBPHOTO_SORT_DATE","��������");
define("_WEBPHOTO_SORT_HITS","�ҥåȿ�");
define("_WEBPHOTO_SORT_RATING","ɾ��");
define("_WEBPHOTO_SORT_S_CURSORTEDBY","���ߤ��¤ӽ�: %s");

define("_WEBPHOTO_NAVI_PREVIOUS","��");
define("_WEBPHOTO_NAVI_NEXT","��");
define("_WEBPHOTO_S_NAVINFO" , "%s �� - %s �֤�ɽ�� (�� %s ��)" ) ;
define("_WEBPHOTO_S_THEREARE","�ǡ����١����ˤ�������� <b>%s</b> ��Ǥ�");
define("_WEBPHOTO_S_MOREPHOTOS","%s ����β������ä�");
define("_WEBPHOTO_ONEVOTE","��ɼ�� 1");
define("_WEBPHOTO_S_NUMVOTES","��ɼ�� %s");
define("_WEBPHOTO_ONEPOST","�����ȿ�");
define("_WEBPHOTO_S_NUMPOSTS","�����ȿ� %s");
define("_WEBPHOTO_VOTETHIS","��ɼ����");
define("_WEBPHOTO_TELLAFRIEND","ͧ�ͤ��Τ餻��");
define("_WEBPHOTO_SUBJECT4TAF","���򤤼̿��򸫤Ĥ��ޤ���");


//---------------------------------------------------------
// submit
//---------------------------------------------------------
// only "Y/m/d" , "d M Y" , "M d Y" can be interpreted
define("_WEBPHOTO_DTFMT_YMDHI" , "Y-m-d H:i" ) ;

define("_WEBPHOTO_TITLE_ADDPHOTO","�������ɲä���");
define("_WEBPHOTO_TITLE_PHOTOUPLOAD","�������åץ���");
define("_WEBPHOTO_CAP_MAXPIXEL","�������������");
define("_WEBPHOTO_CAP_MAXSIZE","�ե����륵������� (byte)");
define("_WEBPHOTO_CAP_VALIDPHOTO","��ǧ");
define("_WEBPHOTO_DSC_TITLE_BLANK","�����ȥ��������ˤ�����硢�ե�����̾�򥿥��ȥ�Ȥ��ޤ�");

define("_WEBPHOTO_RADIO_ROTATETITLE" , "������ž" ) ;
define("_WEBPHOTO_RADIO_ROTATE0" , "��ž���ʤ�" ) ;
define("_WEBPHOTO_RADIO_ROTATE90" , "����90�ٲ�ž" ) ;
define("_WEBPHOTO_RADIO_ROTATE180" , "180�ٲ�ž" ) ;
define("_WEBPHOTO_RADIO_ROTATE270" , "����90�ٲ�ž" ) ;

define("_WEBPHOTO_SUBMIT_RECEIVED","��������Ͽ���ޤ����������ͭ�񤦤������ޤ���");
define("_WEBPHOTO_SUBMIT_ALLPENDING","���٤Ƥ���Ʋ����ϳ�ǧ�Τ��Ჾ��Ͽ�Ȥʤ�ޤ���");

define("_WEBPHOTO_ERR_MUSTREGFIRST","����������ޤ��󤬥����������¤�����ޤ���<br />��Ͽ���뤫���������ˤ��ꤤ���ޤ���");
define("_WEBPHOTO_ERR_MUSTADDCATFIRST","�ɲä��뤿��ˤϥ��ƥ��꤬ɬ�פǤ���<br />�ޤ����ƥ����������Ʋ�������");
define("_WEBPHOTO_ERR_NOIMAGESPECIFIED","����̤���򡧥��åץ��ɤ��٤������ե���������򤷤Ʋ�������");
define("_WEBPHOTO_ERR_FILE","�������åץ��ɤ˼��ԡ������ե����뤬���Ĥ���ʤ����������¤�ۤ��Ƥޤ���");
define("_WEBPHOTO_ERR_FILEREAD","�����ɹ����ԡ��ʤ�餫����ͳ�ǥ��åץ��ɤ��줿�����ե�������ɤ߽Ф��ޤ���");
define("_WEBPHOTO_ERR_TITLE","�����ȥ뤬ɬ�פǤ�");


//---------------------------------------------------------
// edit
//---------------------------------------------------------
define("_WEBPHOTO_TITLE_EDIT","���β������Խ�����");
define("_WEBPHOTO_TITLE_PHOTODEL","������������");
define("_WEBPHOTO_CONFIRM_PHOTODEL","�������?");
define("_WEBPHOTO_DBUPDATED","�ǡ����١�������������!");
define("_WEBPHOTO_DELETED","������ޤ���!");


//---------------------------------------------------------
// rate
//---------------------------------------------------------
define("_WEBPHOTO_RATE_VOTEONCE","Ʊ������ؤ���ɼ�ϰ��٤����ˤ��ꤤ���ޤ���");
define("_WEBPHOTO_RATE_RATINGSCALE","ɾ���� 1 ���� 10 �ޤǤǤ��� 1 �����㡢 10 ���ǹ�");
define("_WEBPHOTO_RATE_BEOBJECTIVE","�Ҵ�Ū��ɾ���򤪴ꤤ���ޤ���������1��10�Τߤ��Ƚ���դ��ΰ�̣������ޤ���");
define("_WEBPHOTO_RATE_DONOTVOTE","��ʬ����Ͽ������������ɼ�Ǥ��ޤ���");
define("_WEBPHOTO_RATE_IT","��ɼ����!");
define("_WEBPHOTO_RATE_VOTEAPPRE","��ɼ������դ��ޤ���");
define("_WEBPHOTO_RATE_S_THANKURATE","�������� %s �ؤΤ���ɼ�����꤬�Ȥ��������ޤ���");

define("_WEBPHOTO_ERR_NORATING","ɾ�������򤵤�Ƥޤ���");
define("_WEBPHOTO_ERR_CANTVOTEOWN","��ʬ����Ʋ����ˤ���ɼ�Ǥ��ޤ���<br />��ɼ�ˤ������ܤ��̤��ޤ�");
define("_WEBPHOTO_ERR_VOTEONCE","��������ؤ���ɼ�ϰ��٤����ˤ��ꤤ���ޤ���<br />��ɼ�ˤϤ��٤��ܤ��̤��ޤ���");


//---------------------------------------------------------
// movo to admin.php
//---------------------------------------------------------
// New in myAlbum-P

// only "Y/m/d" , "d M Y" , "M d Y" can be interpreted
//define( "_WEBPHOTO_DTFMT_YMDHI" , "Y/m/d H:i" ) ;

//define( "_WEBPHOTO_NEXT_BUTTON" , "����" ) ;
//define( "_WEBPHOTO_REDOLOOPDONE" , "��λ" ) ;

//define( "_WEBPHOTO_BTN_SELECTALL" , "������" ) ;
//define( "_WEBPHOTO_BTN_SELECTNONE" , "������" ) ;
//define( "_WEBPHOTO_BTN_SELECTRVS" , "����ȿž" ) ;
//define( "_WEBPHOTO_FMT_PHOTONUM" , "%s ��" ) ;

//define( "_WEBPHOTO_AM_ADMISSION" , "�����ξ�ǧ" ) ;
//define( "_WEBPHOTO_AM_ADMITTING" , "������ǧ���ޤ���" ) ;
//define( "_WEBPHOTO_AM_LABEL_ADMIT" , "�����å�����������ǧ����" ) ;
//define( "_WEBPHOTO_AM_BUTTON_ADMIT" , "��ǧ" ) ;
//define( "_WEBPHOTO_AM_BUTTON_EXTRACT" , "���" ) ;

//define( "_WEBPHOTO_AM_PHOTOMANAGER" , "�����δ���" ) ;
//define( "_WEBPHOTO_AM_PHOTONAVINFO" , "%s �֡� %s �֤�ɽ�� (�� %s ��)" ) ;
//define( "_WEBPHOTO_AM_LABEL_REMOVE" , "�����å�����������������" ) ;
//define( "_WEBPHOTO_AM_BUTTON_REMOVE" , "���" ) ;
//define( "_WEBPHOTO_AM_JS_REMOVECONFIRM" , "������Ƥ�����Ǥ���" ) ;
//define( "_WEBPHOTO_AM_LABEL_MOVE" , "�����å������������ư����" ) ;
//define( "_WEBPHOTO_AM_BUTTON_MOVE" , "��ư" ) ;
//define( "_WEBPHOTO_AM_BUTTON_UPDATE" , "�ѹ�" ) ;
//define( "_WEBPHOTO_AM_DEADLINKMAINPHOTO" , "�ᥤ�������¸�ߤ��ޤ���" ) ;


//---------------------------------------------------------
// not use
//---------------------------------------------------------
// New MyAlbum 1.0.1 (and 1.2.0)
//define("_WEBPHOTO_MOREPHOTOS","%s ����β������ä�!");
//define("_WEBPHOTO_REDOTHUMBS","����ͥ���κƹ���(<a href='redothumbs.php'>�ƥ�������</a>)");
//define("_WEBPHOTO_REDOTHUMBS2","����ͥ���κƹ���");
//define("_WEBPHOTO_REDOTHUMBSINFO","�礭�ʿ��ͤ����Ϥ���ȥ����С������ॢ���Ȥθ����ˤʤ�ޤ���");
//define("_WEBPHOTO_REDOTHUMBSNUMBER","���٤˽������륵��͡���ο�");
//define("_WEBPHOTO_REDOING","�ƹ��ۤ��ޤ���: ");
//define("_WEBPHOTO_BACK","���");
//define("_WEBPHOTO_ADDPHOTO","�������ɲ�");


//---------------------------------------------------------
// movo to admin.php
//---------------------------------------------------------
// New MyAlbum 1.0.0
//define("_WEBPHOTO_PHOTOBATCHUPLOAD","�����Ф˥��åץ��ɺѥե�����ΰ����Ͽ");
//define("_WEBPHOTO_PHOTOUPLOAD","�������åץ���");
//define("_WEBPHOTO_PHOTOEDITUPLOAD","�������Խ����ƥ��åץ���");
//define("_WEBPHOTO_MAXPIXEL","���������");
//define("_WEBPHOTO_MAXSIZE","���������(byte)");
//define("_WEBPHOTO_PHOTOCAT","���ƥ���");
//define("_WEBPHOTO_PHOTOTITLE","�����ȥ�");
//define("_WEBPHOTO_PHOTOPATH","Path:");
//define("_WEBPHOTO_TEXT_DIRECTORY","�ǥ��쥯�ȥ�");
//define("_WEBPHOTO_DESC_PHOTOPATH","�����δޤޤ��ǥ��쥯�ȥ�����Хѥ��ǻ��ꤷ�Ʋ�����");
//define("_WEBPHOTO_MES_INVALIDDIRECTORY","���ꤵ�줿�ǥ��쥯�ȥ꤫��������ɤ߽Ф��ޤ���");
//define("_WEBPHOTO_MES_BATCHDONE","%s ��β�������Ͽ���ޤ���");
//define("_WEBPHOTO_MES_BATCHNONE","���ꤵ�줿�ǥ��쥯�ȥ�˲����ե����뤬�ߤĤ���ޤ���Ǥ���");
//define("_WEBPHOTO_PHOTODESC","����");
//define("_WEBPHOTO_SELECTFILE","��������");
//define("_WEBPHOTO_NOIMAGESPECIFIED","����̤���򡧥��åץ��ɤ��٤������ե���������򤷤Ʋ�������");
//define("_WEBPHOTO_FILEERROR","�������åץ��ɤ˼��ԡ������ե����뤬���Ĥ���ʤ����������¤�ۤ��Ƥޤ���");
//define("_WEBPHOTO_FILEREADERROR","�����ɹ����ԡ��ʤ�餫����ͳ�ǥ��åץ��ɤ��줿�����ե�������ɤ߽Ф��ޤ���");

//define("_WEBPHOTO_BATCHBLANK","�����ȥ��������ˤ�����硢�ե�����̾�򥿥��ȥ�Ȥ��ޤ�");
//define("_WEBPHOTO_DELETEPHOTO","���?");
//define("_WEBPHOTO_VALIDPHOTO","��ǧ");
//define("_WEBPHOTO_PHOTODEL","�������?");
//define("_WEBPHOTO_DELETINGPHOTO","������ޤ���");
//define("_WEBPHOTO_MOVINGPHOTO","��ư���ޤ���");

//define("_WEBPHOTO_STORETIMESTAMP","�������ѹ����ʤ�");

//define("_WEBPHOTO_POSTERC","���: ");
//define("_WEBPHOTO_DATEC","����: ");
//define("_WEBPHOTO_EDITNOTALLOWED","�����Ȥ��Խ����븢�¤�����ޤ���");
//define("_WEBPHOTO_ANONNOTALLOWED","ƿ̾�桼������ƤǤ��ޤ���");
//define("_WEBPHOTO_THANKSFORPOST","�����ͭ���񤦤������ޤ���");
//define("_WEBPHOTO_DELNOTALLOWED","�����Ȥ������븢�¤�����ޤ���!");
//define("_WEBPHOTO_GOBACK","���");
//define("_WEBPHOTO_AREYOUSURE","���Υ����ȤȤ��β��������Ȥ�����������Ǥ�����");
//define("_WEBPHOTO_COMMENTSDEL","�����Ⱥ����λ��");

// End New


//---------------------------------------------------------
// not use
//---------------------------------------------------------
//define("_WEBPHOTO_THANKSFORINFO","�����ĺ���������θ����ϤǤ�������᤯��Ƥ���ޤ���");
//define("_WEBPHOTO_BACKTOTOP","�ǽ�β��������");
//define("_WEBPHOTO_THANKSFORHELP","������ͭ�񤦤������ޤ���");
//define("_WEBPHOTO_FORSECURITY","�������ƥ��δ������餢�ʤ���IP���ɥ쥹����Ū����¸���ޤ���");

//define("_WEBPHOTO_MATCH","����");
//define("_WEBPHOTO_ALL","����");
//define("_WEBPHOTO_ANY","�ɤ�Ǥ�");
//define("_WEBPHOTO_NAME","̾��");
//define("_WEBPHOTO_DESCRIPTION","����");

//define("_WEBPHOTO_MAIN","����Х�ȥå�");
//define("_WEBPHOTO_NEW","����");
//define("_WEBPHOTO_UPDATED","����");
//define("_WEBPHOTO_POPULAR","��ҥå�");
//define("_WEBPHOTO_TOPRATED","��ɾ��");

//define("_WEBPHOTO_POPULARITYLTOM","�ҥåȿ� (�㢪��)");
//define("_WEBPHOTO_POPULARITYMTOL","�ҥåȿ� (�⢪��)");
//define("_WEBPHOTO_TITLEATOZ","�����ȥ� (A �� Z)");
//define("_WEBPHOTO_TITLEZTOA","�����ȥ� (Z �� A)");
//define("_WEBPHOTO_DATEOLD","���� (�좪��)");
//define("_WEBPHOTO_DATENEW","���� (������)");
//define("_WEBPHOTO_RATINGLTOH","ɾ�� (�㢪��)");
//define("_WEBPHOTO_RATINGHTOL","ɾ�� (�⢪��)");
//define("_WEBPHOTO_LIDASC","�쥳�����ֹ澺��");
//define("_WEBPHOTO_LIDDESC","�쥳�����ֹ�߽�");

//define("_WEBPHOTO_NOSHOTS","����ͥ���ʤ�");
//define("_WEBPHOTO_EDITTHISPHOTO","���β������Խ�");

//define("_WEBPHOTO_DESCRIPTIONC","����");
//define("_WEBPHOTO_EMAILC","Email");
//define("_WEBPHOTO_CATEGORYC","���ƥ���");
//define("_WEBPHOTO_SUBCATEGORY","���֥��ƥ���");
//define("_WEBPHOTO_LASTUPDATEC","���󹹿�");

//define("_WEBPHOTO_HITSC","�ҥåȿ�");
//define("_WEBPHOTO_RATINGC","ɾ��");
//define("_WEBPHOTO_NUMVOTES","��ɼ�� %s");
//define("_WEBPHOTO_NUMPOSTS","�����ȿ� %s");
//define("_WEBPHOTO_COMMENTSC","�����ȿ�");
//define("_WEBPHOTO_RATETHISPHOTO","��ɼ����");
//define("_WEBPHOTO_MODIFY","�ѹ�");
//define("_WEBPHOTO_VSCOMMENTS","�����Ȥ򸫤�/����");

//define("_WEBPHOTO_DIRECTCATSEL","���ƥ�������");
//define("_WEBPHOTO_THEREARE","�ǡ����١����ˤ�������� <b>%s</b> ��Ǥ�");
//define("_WEBPHOTO_LATESTLIST","�ǿ��ꥹ��");

//define("_WEBPHOTO_VOTEAPPRE","��ɼ������դ��ޤ���");
//define("_WEBPHOTO_THANKURATE","�������� %s �ؤΤ���ɼ�����꤬�Ȥ��������ޤ���");
//define("_WEBPHOTO_VOTEONCE","Ʊ������ؤ���ɼ�ϰ��٤����ˤ��ꤤ���ޤ���");
//define("_WEBPHOTO_RATINGSCALE","ɾ���� 1 ���� 10 �ޤǤǤ��� 1 �����㡢 10 ���ǹ�");
//define("_WEBPHOTO_BEOBJECTIVE","�Ҵ�Ū��ɾ���򤪴ꤤ���ޤ���������1��10�Τߤ��Ƚ���դ��ΰ�̣������ޤ���");
//define("_WEBPHOTO_DONOTVOTE","��ʬ����Ͽ������������ɼ�Ǥ��ޤ���");
//define("_WEBPHOTO_RATEIT","��ɼ����!");

//define("_WEBPHOTO_RECEIVED","��������Ͽ���ޤ����������ͭ�񤦤������ޤ���");
//define("_WEBPHOTO_ALLPENDING","���٤Ƥ���Ʋ����ϳ�ǧ�Τ��Ჾ��Ͽ�Ȥʤ�ޤ���");

//define("_WEBPHOTO_RANK","���");
//define("_WEBPHOTO_SUBCATEGORY","���֥��ƥ���");
//define("_WEBPHOTO_HITS","�ҥå�");
//define("_WEBPHOTO_RATING","ɾ��");
//define("_WEBPHOTO_VOTE","��ɼ");
//define("_WEBPHOTO_TOP10","%s �Υȥå�10"); // %s �ϥ��ƥ���Υ����ȥ�

//define("_WEBPHOTO_SORTBY","�¤��ؤ�:");
//define("_WEBPHOTO_TITLE","�����ȥ�");
//define("_WEBPHOTO_DATE","����");
//define("_WEBPHOTO_POPULARITY","�ҥåȿ�");
//define("_WEBPHOTO_CURSORTEDBY","���ߤ��¤ӽ�: %s");
//define("_WEBPHOTO_FOUNDIN","���Ĥ��ä��ΤϤ���:");
//define("_WEBPHOTO_PREVIOUS","��");
//define("_WEBPHOTO_NEXT","��");
//define("_WEBPHOTO_NOMATCH","����������ޤ���");

//define("_WEBPHOTO_CATEGORIES","���ƥ���");
//define("_WEBPHOTO_SUBMIT","���");
//define("_WEBPHOTO_CANCEL","����󥻥�");

//define("_WEBPHOTO_MUSTREGFIRST","����������ޤ��󤬥����������¤�����ޤ���<br>��Ͽ���뤫���������ˤ��ꤤ���ޤ���");
//define("_WEBPHOTO_MUSTADDCATFIRST","�ɲä��뤿��ˤϥ��ƥ��꤬ɬ�פǤ���<br>�ޤ����ƥ����������Ʋ�������");
//define("_WEBPHOTO_NORATING","ɾ�������򤵤�Ƥޤ���");
//define("_WEBPHOTO_CANTVOTEOWN","��ʬ����Ʋ����ˤ���ɼ�Ǥ��ޤ���<br>��ɼ�ˤ������ܤ��̤��ޤ�");
//define("_WEBPHOTO_VOTEONCE2","��������ؤ���ɼ�ϰ��٤����ˤ��ꤤ���ޤ���<br>��ɼ�ˤϤ��٤��ܤ��̤��ޤ���");


//---------------------------------------------------------
// move to admin.php
//---------------------------------------------------------
//%%%%%%	Module Name 'MyAlbum' (Admin)	  %%%%%
//define("_WEBPHOTO_PHOTOSWAITING","��Ƥ��줿�����ξ�ǧ: ��ǧ�Բ�����");
//define("_WEBPHOTO_PHOTOMANAGER","��������");
//define("_WEBPHOTO_CATEDIT","���ƥ�����ɲá��Խ�");
//define("_WEBPHOTO_GROUPPERM_GLOBAL","�ƥ��롼�פθ���");
//define("_WEBPHOTO_CHECKCONFIGS","�⥸�塼��ξ��֥����å�");
//define("_WEBPHOTO_BATCHUPLOAD","���������Ͽ");
//define("_WEBPHOTO_GENERALSET","��������");
//define("_WEBPHOTO_REDOTHUMBS2","Rebuild Thumbnails");

//define("_WEBPHOTO_DELETE","���");
//define("_WEBPHOTO_NOSUBMITTED","��������Ʋ����Ϥ���ޤ���");
//define("_WEBPHOTO_ADDMAIN","�ȥåץ��ƥ�����ɲ�");
//define("_WEBPHOTO_IMGURL","������URL (�����ι⤵�Ϥ��餫����50pixel��): ");
//define("_WEBPHOTO_ADD","�ɲ�");
//define("_WEBPHOTO_ADDSUB","���֥��ƥ�����ɲ�");
//define("_WEBPHOTO_IN","");
//define("_WEBPHOTO_MODCAT","���ƥ����ѹ�");

//define("_WEBPHOTO_MODREQDELETED","�ѹ���������");
//define("_WEBPHOTO_IMGURLMAIN","����URL (�����ι⤵�Ϥ��餫����50pixel��): ");
//define("_WEBPHOTO_PARENT","�ƥ��ƥ���:");
//define("_WEBPHOTO_SAVE","�ѹ�����¸");
//define("_WEBPHOTO_CATDELETED","���ƥ���ξõλ");
//define("_WEBPHOTO_CATDEL_WARNING","���ƥ����Ʊ���ˤ����˴ޤޤ���������ӥ����Ȥ����ƺ������ޤ���������Ǥ�����");
//define("_WEBPHOTO_YES","�Ϥ�");
//define("_WEBPHOTO_NO","������");
//define("_WEBPHOTO_NEWCATADDED","�����ƥ����ɲä�����!");
//define("_WEBPHOTO_ERROREXIST","���顼: �󶡤��������Ϥ��Ǥ˥ǡ����١�����¸�ߤ��ޤ���");
//define("_WEBPHOTO_ERRORTITLE","���顼: �����ȥ뤬ɬ�פǤ�!");
//define("_WEBPHOTO_ERRORDESC","���顼: ������ɬ�פǤ�!");
//define("_WEBPHOTO_WEAPPROVED","�����ǡ����١����ؤΥ��������ǧ���ޤ�����");
//define("_WEBPHOTO_THANKSSUBMIT","�����ͭ���񤦤������ޤ���");
//define("_WEBPHOTO_CONFUPDATED","����򹹿����ޤ�����");


//---------------------------------------------------------
// move from myalbum_constants.php
//---------------------------------------------------------
// Caption
define( "_WEBPHOTO_CAPTION_TOTAL" , "Total:" ) ;
define( "_WEBPHOTO_CAPTION_GUESTNAME" , "������" ) ;
define( "_WEBPHOTO_CAPTION_REFRESH" , "����" ) ;
define( "_WEBPHOTO_CAPTION_IMAGEXYT" , "������" ) ;
define( "_WEBPHOTO_CAPTION_CATEGORY" , "���ƥ��꡼" ) ;


//=========================================================
// add for webphoto
//=========================================================

//---------------------------------------------------------
// database table items
//---------------------------------------------------------

// photo table
define("_WEBPHOTO_PHOTO_TABLE" , "�̿��ơ��֥�" ) ;
define("_WEBPHOTO_PHOTO_ID" , "�̿�ID" ) ;
define("_WEBPHOTO_PHOTO_TIME_CREATE" , "��������" ) ;
define("_WEBPHOTO_PHOTO_TIME_UPDATE" , "��������" ) ;
define("_WEBPHOTO_PHOTO_CAT_ID" ,  "���ƥ����ֹ�" ) ;
define("_WEBPHOTO_PHOTO_GICON_ID" , "GoogleMap ���������ֹ�" ) ;
define("_WEBPHOTO_PHOTO_UID" ,   "�桼���ֹ�" ) ;
define("_WEBPHOTO_PHOTO_DATETIME" ,  "��������" ) ;
define("_WEBPHOTO_PHOTO_TITLE" , "�̿������ȥ�" ) ;
define("_WEBPHOTO_PHOTO_PLACE" , "���ƾ��" ) ;
define("_WEBPHOTO_PHOTO_EQUIPMENT" , "���Ƶ���" ) ;
define("_WEBPHOTO_PHOTO_FILE_URL" ,  "�ե����� URL" ) ;
define("_WEBPHOTO_PHOTO_FILE_PATH" , "�ե����� �ѥ�" ) ;
define("_WEBPHOTO_PHOTO_FILE_NAME" , "�ե����� ̾" ) ;
define("_WEBPHOTO_PHOTO_FILE_EXT" ,  "�ե����� ��ĥ��" ) ;
define("_WEBPHOTO_PHOTO_FILE_MIME" ,  "�ե����� MIME������" ) ;
define("_WEBPHOTO_PHOTO_FILE_MEDIUM" ,  "�ե����� ��ǥ���������" ) ;
define("_WEBPHOTO_PHOTO_FILE_SIZE" , "�ե����� ������" ) ;
define("_WEBPHOTO_PHOTO_CONT_URL" ,    "�̿� URL" ) ;
define("_WEBPHOTO_PHOTO_CONT_PATH" ,   "�̿� �ѥ�" ) ;
define("_WEBPHOTO_PHOTO_CONT_NAME" ,   "�̿� �ե�����̾" ) ;
define("_WEBPHOTO_PHOTO_CONT_EXT" ,    "�̿� ��ĥ��" ) ;
define("_WEBPHOTO_PHOTO_CONT_MIME" ,   "�̿� MIME������" ) ;
define("_WEBPHOTO_PHOTO_CONT_MEDIUM" , "�̿� ��ǥ���������" ) ;
define("_WEBPHOTO_PHOTO_CONT_SIZE" ,   "�̿� �ե����륵����" ) ;
define("_WEBPHOTO_PHOTO_CONT_WIDTH" ,  "�̿� ��������" ) ;
define("_WEBPHOTO_PHOTO_CONT_HEIGHT" , "�̿� �����⤵" ) ;
define("_WEBPHOTO_PHOTO_CONT_DURATION" , "�ӥǥ���������" ) ;
define("_WEBPHOTO_PHOTO_CONT_EXIF" , "Exif ����" ) ;
define("_WEBPHOTO_PHOTO_MIDDLE_WIDTH" ,  "�ߥɥ� ��������" ) ;
define("_WEBPHOTO_PHOTO_MIDDLE_HEIGHT" , "�ߥɥ� �����⤵" ) ;
define("_WEBPHOTO_PHOTO_THUMB_URL" ,    "����ͥ��� URL" ) ;
define("_WEBPHOTO_PHOTO_THUMB_PATH" ,   "����ͥ��� �ѥ�" ) ;
define("_WEBPHOTO_PHOTO_THUMB_NAME" ,   "����ͥ��� �ե�����̾" ) ;
define("_WEBPHOTO_PHOTO_THUMB_EXT" ,    "����ͥ��� ��ĥ��" ) ;
define("_WEBPHOTO_PHOTO_THUMB_MIME" ,   "����ͥ��� MIME������" ) ;
define("_WEBPHOTO_PHOTO_THUMB_MEDIUM" , "����ͥ��� ��ǥ���������" ) ;
define("_WEBPHOTO_PHOTO_THUMB_SIZE" ,   "����ͥ��� �ե����륵����" ) ;
define("_WEBPHOTO_PHOTO_THUMB_WIDTH" ,  "����ͥ��� ��������" ) ;
define("_WEBPHOTO_PHOTO_THUMB_HEIGHT" , "����ͥ��� �����⤵" ) ;
define("_WEBPHOTO_PHOTO_GMAP_LATITUDE" ,  "GoogleMap ����" ) ;
define("_WEBPHOTO_PHOTO_GMAP_LONGITUDE" , "GoogleMap ����" ) ;
define("_WEBPHOTO_PHOTO_GMAP_ZOOM" ,      "GoogleMap ������" ) ;
define("_WEBPHOTO_PHOTO_GMAP_TYPE" ,      "GoogleMap ������" ) ;
define("_WEBPHOTO_PHOTO_PERM_READ" , "��������" ) ;
define("_WEBPHOTO_PHOTO_STATUS" ,   "����" ) ;
define("_WEBPHOTO_PHOTO_HITS" ,     "�ҥåȿ�" ) ;
define("_WEBPHOTO_PHOTO_RATING" ,   "ɾ��" ) ;
define("_WEBPHOTO_PHOTO_VOTES" ,    "��ɼ��" ) ;
define("_WEBPHOTO_PHOTO_COMMENTS" , "�����ȿ�" ) ;
define("_WEBPHOTO_PHOTO_TEXT1" ,  "text1" ) ;
define("_WEBPHOTO_PHOTO_TEXT2" ,  "text2" ) ;
define("_WEBPHOTO_PHOTO_TEXT3" ,  "text3" ) ;
define("_WEBPHOTO_PHOTO_TEXT4" ,  "text4" ) ;
define("_WEBPHOTO_PHOTO_TEXT5" ,  "text5" ) ;
define("_WEBPHOTO_PHOTO_TEXT6" ,  "text6" ) ;
define("_WEBPHOTO_PHOTO_TEXT7" ,  "text7" ) ;
define("_WEBPHOTO_PHOTO_TEXT8" ,  "text8" ) ;
define("_WEBPHOTO_PHOTO_TEXT9" ,  "text9" ) ;
define("_WEBPHOTO_PHOTO_TEXT10" , "text10" ) ;
define("_WEBPHOTO_PHOTO_DESCRIPTION" ,  "�̿�����ʸ" ) ;
define("_WEBPHOTO_PHOTO_SEARCH" ,  "����ʸ" ) ;

// category table
define("_WEBPHOTO_CAT_TABLE" , "���ƥ���ơ��֥�" ) ;
define("_WEBPHOTO_CAT_ID" ,          "���ƥ���ID" ) ;
define("_WEBPHOTO_CAT_TIME_CREATE" , "��������" ) ;
define("_WEBPHOTO_CAT_TIME_UPDATE" , "��������" ) ;
define("_WEBPHOTO_CAT_GICON_ID" ,  "GoogleMap ���������ֹ�" ) ;
define("_WEBPHOTO_CAT_FORUM_ID" ,  "�ե�������ֹ�" ) ;
define("_WEBPHOTO_CAT_PID" ,    "���ֹ�" ) ;
define("_WEBPHOTO_CAT_TITLE" ,  "���ƥ���̾" ) ;
define("_WEBPHOTO_CAT_IMG_PATH" , "���������Хѥ�" ) ;
define("_WEBPHOTO_CAT_IMG_MODE" , "������ɽ���⡼��" ) ;
define("_WEBPHOTO_CAT_ORIG_WIDTH" ,  "�����θ����β���" ) ;
define("_WEBPHOTO_CAT_ORIG_HEIGHT" , "�����θ����ι⤵" ) ;
define("_WEBPHOTO_CAT_MAIN_WIDTH" ,  "�ᥤ�󥫥ƥ���ɽ���β����β���" ) ;
define("_WEBPHOTO_CAT_MAIN_HEIGHT" , "�ᥤ�󥫥ƥ���ɽ���β����ι⤵" ) ;
define("_WEBPHOTO_CAT_SUB_WIDTH" ,   "���֥��ƥ���ɽ���β����β���" ) ;
define("_WEBPHOTO_CAT_SUB_HEIGHT" ,  "���֥��ƥ���ɽ���β����ι⤵" ) ;
define("_WEBPHOTO_CAT_WEIGHT" , "ɽ����" ) ;
define("_WEBPHOTO_CAT_DEPTH" ,  "����" ) ;
define("_WEBPHOTO_CAT_ALLOWED_EXT" , "���Ĥ��줿��ĥ��" ) ;
define("_WEBPHOTO_CAT_ITEM_TYPE" ,      "�����Υ�����" ) ;
define("_WEBPHOTO_CAT_GMAP_MODE" ,      "GoogleMap ɽ���⡼��" ) ;
define("_WEBPHOTO_CAT_GMAP_LATITUDE" ,  "GoogleMap ����" ) ;
define("_WEBPHOTO_CAT_GMAP_LONGITUDE" , "GoogleMap ����" ) ;
define("_WEBPHOTO_CAT_GMAP_ZOOM" ,      "GoogleMap ������" ) ;
define("_WEBPHOTO_CAT_GMAP_TYPE" ,      "GoogleMap ������" ) ;
define("_WEBPHOTO_CAT_PERM_READ" , "��������" ) ;
define("_WEBPHOTO_CAT_PERM_POST" , "��Ƹ���" ) ;
define("_WEBPHOTO_CAT_TEXT1" ,  "text1" ) ;
define("_WEBPHOTO_CAT_TEXT2" ,  "text2" ) ;
define("_WEBPHOTO_CAT_TEXT3" ,  "text3" ) ;
define("_WEBPHOTO_CAT_TEXT4" ,  "text4" ) ;
define("_WEBPHOTO_CAT_TEXT5" ,  "text5" ) ;
define("_WEBPHOTO_CAT_DESCRIPTION" ,  "���ƥ�������ʸ" ) ;

// vote table
define("_WEBPHOTO_VOTE_TABLE" , "��ɼ�ơ��֥�" ) ;
define("_WEBPHOTO_VOTE_ID" ,          "��ɼID" ) ;
define("_WEBPHOTO_VOTE_TIME_CREATE" , "��������" ) ;
define("_WEBPHOTO_VOTE_TIME_UPDATE" , "��������" ) ;
define("_WEBPHOTO_VOTE_PHOTO_ID" , "�̿��ֹ�" ) ;
define("_WEBPHOTO_VOTE_UID" ,      "�桼���ֹ�" ) ;
define("_WEBPHOTO_VOTE_RATING" ,   "ɾ��" ) ;
define("_WEBPHOTO_VOTE_HOSTNAME" , "IP���ɥ쥹" ) ;

// google icon table
define("_WEBPHOTO_GICON_TABLE" , "Google��������ơ��֥�" ) ;
define("_WEBPHOTO_GICON_ID" ,          "��������ID" ) ;
define("_WEBPHOTO_GICON_TIME_CREATE" , "��������" ) ;
define("_WEBPHOTO_GICON_TIME_UPDATE" , "��������" ) ;
define("_WEBPHOTO_GICON_TITLE" ,     "��������̾" ) ;
define("_WEBPHOTO_GICON_IMAGE_PATH" ,  "���� �ѥ�" ) ;
define("_WEBPHOTO_GICON_IMAGE_NAME" ,  "���� �ե�����̾" ) ;
define("_WEBPHOTO_GICON_IMAGE_EXT" ,   "���� ��ĥ��" ) ;
define("_WEBPHOTO_GICON_SHADOW_PATH" , "����ɡ� �ѥ�" ) ;
define("_WEBPHOTO_GICON_SHADOW_NAME" , "����ɡ� �ե�����̾" ) ;
define("_WEBPHOTO_GICON_SHADOW_EXT" ,  "����ɡ� ��ĥ��" ) ;
define("_WEBPHOTO_GICON_IMAGE_WIDTH" ,  "���� ��������" ) ;
define("_WEBPHOTO_GICON_IMAGE_HEIGHT" , "���� �����⤵" ) ;
define("_WEBPHOTO_GICON_SHADOW_WIDTH" ,  "����ɡ� ��������" ) ;
define("_WEBPHOTO_GICON_SHADOW_HEIGHT" , "����ɡ� �����⤵" ) ;
define("_WEBPHOTO_GICON_ANCHOR_X" , "���󥫡� X������" ) ;
define("_WEBPHOTO_GICON_ANCHOR_Y" , "���󥫡� Y������" ) ;
define("_WEBPHOTO_GICON_INFO_X" , "WindowInfo X������" ) ;
define("_WEBPHOTO_GICON_INFO_Y" , "WindowInfo Y������" ) ;

// mime type table
define("_WEBPHOTO_MIME_TABLE" , "MIME�����ץơ��֥�" ) ;
define("_WEBPHOTO_MIME_ID" ,          "MIME ID" ) ;
define("_WEBPHOTO_MIME_TIME_CREATE" , "��������" ) ;
define("_WEBPHOTO_MIME_TIME_UPDATE" , "��������" ) ;
define("_WEBPHOTO_MIME_EXT" ,   "��ĥ��" ) ;
define("_WEBPHOTO_MIME_MEDIUM" ,  "��ǥ���������" ) ;
define("_WEBPHOTO_MIME_TYPE" ,  "MIME������" ) ;
define("_WEBPHOTO_MIME_NAME" ,  "MIME̾��" ) ;
define("_WEBPHOTO_MIME_PERMS" , "�ѡ��ߥå����" ) ;

// added in v0.20
define("_WEBPHOTO_MIME_FFMPEG" , "ffmpeg ���ץ����" ) ;

// tag table
define("_WEBPHOTO_TAG_TABLE" , "�����ơ��֥�" ) ;
define("_WEBPHOTO_TAG_ID" ,          "����ID" ) ;
define("_WEBPHOTO_TAG_TIME_CREATE" , "��������" ) ;
define("_WEBPHOTO_TAG_TIME_UPDATE" , "��������" ) ;
define("_WEBPHOTO_TAG_NAME" ,   "����̾" ) ;

// photo-to-tag table
define("_WEBPHOTO_P2T_TABLE" , "�̿�������Ϣ�ơ��֥�" ) ;
define("_WEBPHOTO_P2T_ID" ,          "�̿�������ϢID" ) ;
define("_WEBPHOTO_P2T_TIME_CREATE" , "��������" ) ;
define("_WEBPHOTO_P2T_TIME_UPDATE" , "��������" ) ;
define("_WEBPHOTO_P2T_PHOTO_ID" , "�̿��ֹ�" ) ;
define("_WEBPHOTO_P2T_TAG_ID" ,   "�����ֹ�" ) ;
define("_WEBPHOTO_P2T_UID" ,      "�桼���ֹ�" ) ;

// synonym table
define("_WEBPHOTO_SYNO_TABLE" , "�����ơ��֥�" ) ;
define("_WEBPHOTO_SYNO_ID" ,          "�����ID" ) ;
define("_WEBPHOTO_SYNO_TIME_CREATE" , "��������" ) ;
define("_WEBPHOTO_SYNO_TIME_UPDATE" , "��������" ) ;
define("_WEBPHOTO_SYNO_WEIGHT" , "�¤ӽ�" ) ;
define("_WEBPHOTO_SYNO_KEY" , "����" ) ;
define("_WEBPHOTO_SYNO_VALUE" , "�����" ) ;


//---------------------------------------------------------
// title
//---------------------------------------------------------
define("_WEBPHOTO_TITLE_LATEST","����");
define("_WEBPHOTO_TITLE_SUBMIT","���");
define("_WEBPHOTO_TITLE_POPULAR","��͵�");
define("_WEBPHOTO_TITLE_HIGHRATE","�ȥåץ��");
define("_WEBPHOTO_TITLE_MYPHOTO","��ʬ�����");
define("_WEBPHOTO_TITLE_RANDOM","������̿�");
define("_WEBPHOTO_TITLE_HELP","�إ��");
define("_WEBPHOTO_TITLE_CATEGORY_LIST", "���ƥ��� ����");
define("_WEBPHOTO_TITLE_TAG_LIST",  "���� ����");
define("_WEBPHOTO_TITLE_TAGS",  "����");
define("_WEBPHOTO_TITLE_USER_LIST", "��Ƽ� ����");
define("_WEBPHOTO_TITLE_DATE_LIST", "�������� ����");
define("_WEBPHOTO_TITLE_PLACE_LIST","���ƾ�� ����");
define("_WEBPHOTO_TITLE_RSS","RSS");

define("_WEBPHOTO_VIEWTYPE_LIST", "�ꥹ�ȷ���");
define("_WEBPHOTO_VIEWTYPE_TABLE", "�ơ��֥����");

define("_WEBPHOTO_CATLIST_ON",   "���ƥ����ɽ������");
define("_WEBPHOTO_CATLIST_OFF",  "���ƥ����ɽ�����ʤ�");
define("_WEBPHOTO_TAGCLOUD_ON",  "�������饦�ɤ�ɽ������");
define("_WEBPHOTO_TAGCLOUD_OFF", "�������饦�ɤ�ɽ�����ʤ�");
define("_WEBPHOTO_GMAP_ON",  "Google�ޥåפ�ɽ������");
define("_WEBPHOTO_GMAP_OFF", "Google�ޥåפ�ɽ�����ʤ�");

define("_WEBPHOTO_NO_TAG","���������ꤵ��Ƥ��ʤ�");

//---------------------------------------------------------
// google maps
//---------------------------------------------------------
define("_WEBPHOTO_TITLE_GET_LOCATION", "���١����٤�����");
define("_WEBPHOTO_GMAP_DESC", "Google�ޥåפΥޡ������򥯥�å�����ȡ�����ͥ��������ɽ������ޤ�");
define("_WEBPHOTO_GMAP_ICON", "GoogleMap ��������");
define("_WEBPHOTO_GMAP_LATITUDE", "GoogleMap ����");
define("_WEBPHOTO_GMAP_LONGITUDE","GoogleMap ����");
define("_WEBPHOTO_GMAP_ZOOM","GoogleMap ������");
define("_WEBPHOTO_GMAP_ADDRESS",  "����");
define("_WEBPHOTO_GMAP_GET_LOCATION", "���١����٤��������");
define("_WEBPHOTO_GMAP_SEARCH_LIST",  "������̤ΰ���");
define("_WEBPHOTO_GMAP_CURRENT_LOCATION",  "���ߤΰ���");
define("_WEBPHOTO_GMAP_CURRENT_ADDRESS",  "���ߤν���");
define("_WEBPHOTO_GMAP_NO_MATCH_PLACE",  "���������꤬�ʤ�");
define("_WEBPHOTO_GMAP_NOT_COMPATIBLE", "�����Υ֥饦���Ǥ� GoogleMaps ��ɽ���Ǥ��ޤ���");
define("_WEBPHOTO_JS_INVALID", "�����Υ֥饦���Ǥ� JavaScript �����ѤǤ��ޤ���");
define("_WEBPHOTO_IFRAME_NOT_SUPPORT","�����Υ֥饦���Ǥ� iframe �����ѤǤ��ʤ�");

//---------------------------------------------------------
// search
//---------------------------------------------------------
define("_WEBPHOTO_SR_SEARCH","����");

//---------------------------------------------------------
// popbox
//---------------------------------------------------------
define("_WEBPHOTO_POPBOX_REVERT", "����å�����ȡ����ξ������̿��ˤʤ�");

//---------------------------------------------------------
// tag
//---------------------------------------------------------
define("_WEBPHOTO_TAGS","����");
define("_WEBPHOTO_EDIT_TAG","�������Խ�����");
define("_WEBPHOTO_DSC_TAG_DIVID", "ʣ���� ���ꤹ����� ����� , �Ƕ��ڤ�");
define("_WEBPHOTO_DSC_TAG_EDITABLE", "��ʬ����Ͽ���������Τ��Խ��Ǥ��ޤ�");

//---------------------------------------------------------
// submit form
//---------------------------------------------------------
define("_WEBPHOTO_CAP_ALLOWED_EXTS", "���Ĥ���Ƥ����ĥ��");
define("_WEBPHOTO_CAP_PHOTO_SELECT","�ᥤ�����������");
define("_WEBPHOTO_CAP_THUMB_SELECT", "����ͥ������������");
define("_WEBPHOTO_DSC_THUMB_SELECT", "���ꤷ�ʤ��Ȥ��ϡ��ᥤ�������꼫ư���������");
define("_WEBPHOTO_DSC_SET_DATETIME",   "�������������ꤹ��");
define("_WEBPHOTO_DSC_SET_TIME_UPDATE", "�����������ѹ�����");
define("_WEBPHOTO_DSC_PIXCEL_RESIZE", "����ʾ��礭�������ϥꥵ�������ޤ�");
define("_WEBPHOTO_DSC_PIXCEL_REJECT", "����ʾ��礭�������ϥ��åץ��ɤǤ��ޤ���");
define("_WEBPHOTO_BUTTON_CLEAR", "�ꥻ�å�");
define("_WEBPHOTO_SUBMIT_RESIZED", "�������礭���Τǡ��ꥵ��������");

// PHP upload error
// http://www.php.net/manual/en/features.file-upload.errors.php
define("_WEBPHOTO_PHP_UPLOAD_ERR_OK", "���顼�Ϥʤ����ե����륢�åץ��ɤ��������Ƥ��ޤ�");
define("_WEBPHOTO_PHP_UPLOAD_ERR_INI_SIZE", "���åץ��ɤ��줿�ե�����ϡ�upload_max_filesize ���ͤ�Ķ���Ƥ��ޤ�");
define("_WEBPHOTO_PHP_UPLOAD_ERR_FORM_SIZE", "���åץ��ɤ��줿�ե�����ϡ�%s ��Ķ���Ƥ��ޤ�");
define("_WEBPHOTO_PHP_UPLOAD_ERR_PARTIAL", "���åץ��ɤ��줿�ե�����ϰ����Τߤ������åץ��ɤ���Ƥ��ޤ���");
define("_WEBPHOTO_PHP_UPLOAD_ERR_NO_FILE", "�ե�����ϥ��åץ��ɤ���ޤ���Ǥ���");
define("_WEBPHOTO_PHP_UPLOAD_ERR_NO_TMP_DIR", "�ƥ�ݥ��ե����������ޤ���");
define("_WEBPHOTO_PHP_UPLOAD_ERR_CANT_WRITE", "�ǥ������ؤν񤭹��ߤ˼��Ԥ��ޤ���");
define("_WEBPHOTO_PHP_UPLOAD_ERR_EXTENSION", "�ե�����Υ��åץ��ɤ���ĥ�⥸�塼��ˤ�ä���ߤ���ޤ���");

// upload error
define("_WEBPHOTO_UPLOADER_ERR_NOT_FOUND", "���åץ��ɡ��ե����뤬���Ĥ���ʤ�");
define("_WEBPHOTO_UPLOADER_ERR_INVALID_FILE_SIZE", "�ե����롦�����������ꤵ��Ƥ��ʤ�");
define("_WEBPHOTO_UPLOADER_ERR_EMPTY_FILE_NAME", "�ե�����̾�����ꤵ��Ƥ��ʤ�");
define("_WEBPHOTO_UPLOADER_ERR_NO_FILE", "�ե�����ϥ��åץ��ɤ���Ƥʤ�");
define("_WEBPHOTO_UPLOADER_ERR_NOT_SET_DIR", "���åץ��ɡ��ǥ��쥯�ȥ꤬���ꤵ��Ƥ��ʤ�");
define("_WEBPHOTO_UPLOADER_ERR_NOT_ALLOWED_EXT", "���Ĥ���Ƥ��ʤ���ĥ�ҤǤ�");
define("_WEBPHOTO_UPLOADER_ERR_PHP_OCCURED", "���åץ������ǥ��顼��ȯ������ ");
define("_WEBPHOTO_UPLOADER_ERR_NOT_OPEN_DIR", "���åץ��ɡ��ǥ��쥯�ȥ꤬�����ץ�Ǥ��ʤ� ");
define("_WEBPHOTO_UPLOADER_ERR_NO_PERM_DIR", "���åץ��ɡ��ǥ��쥯�ȥ�Υ����������¤��ʤ� ");
define("_WEBPHOTO_UPLOADER_ERR_NOT_ALLOWED_MIME", "���Ĥ���Ƥ��ʤ�MIME�����פǤ� ");
define("_WEBPHOTO_UPLOADER_ERR_LARGE_FILE_SIZE", "�ե����롦���������礭������ ");
define("_WEBPHOTO_UPLOADER_ERR_LARGE_WIDTH", "�����������礭������ ");
define("_WEBPHOTO_UPLOADER_ERR_LARGE_HEIGHT", "�����⤵���礭������ ");
define("_WEBPHOTO_UPLOADER_ERR_UPLOAD", "���åץ��ɤ˼��Ԥ��� ");

//---------------------------------------------------------
// help
//---------------------------------------------------------
define("_WEBPHOTO_HELP_DSC", "�����Υѥ������ư��륢�ץꥱ�����硼��������Ǥ�");

define("_WEBPHOTO_HELP_PICLENS_TITLE", "PicLens");
define("_WEBPHOTO_HELP_PICLENS_DSC", '
Piclens �� Cooliris �Ҥ��󶡤��� FireFox �Υ��ɥ���Ǥ�<br />
WEB�����Ȥμ̿����������ӥ塼��Ǥ�<br /><br />
<b>���͵���</b><br />
<a href="http://www.forest.impress.co.jp/article/2007/09/13/piclens.html" target="_blank">
������ͭ�������������������ѤΥӥ塼����ɲä���Firefox��ĥ��PicLens��
</a><br /><br />
<b>������ˡ</b><br />
(1) FireFox ���������ɤ���<br />
<a href="http://www.mozilla-japan.org/products/firefox/" target="_blank">
http://www.mozilla-japan.org/products/firefox/
</a><br /><br />
(2) Piclens ���ɥ��� ���������ɤ���<br />
<a href="http://www.piclens.com/" target="_blank">
http://www.piclens.com/
</a><br /><br />
(3) FireFox �� webphoto �򸫤�<br />
http://���Υ�����/modules/webphoto/ <br /><br />
(4) Firefox �α�����Ĥ��ޡ���������å�����<br />
�ޡ����������Ȥ��ϡ�piclens �ϻ��ѤǤ��ʤ�<br />' );

define("_WEBPHOTO_HELP_MEDIARSSSLIDESHOW_TITLE", "Media RSS ���饤�ɥ��硼");
define("_WEBPHOTO_HELP_MEDIARSSSLIDESHOW_DSC", '
Media RSS ���饤�ɥ��硼 �� Google �������åȤǤ�<br />
���󥿡��ͥåȤ���μ̿��򥹥饤�ɥ��硼��ɽ�����ޤ�<br /><br />
<b>������ˡ</b><br />
(1) Google �ǥ����ȥå� ���������ɤ���<br />
<a href="http://desktop.google.co.jp/" target="_blank">
http://desktop.google.co.jp/
</a><br /><br />
(2) ��Media RSS ���饤�ɥ��硼�פΥ������åȤ��������ɤ���<br />
<a href="http://desktop.google.com/plugins/i/mediarssslideshow.html" target="_blank">
http://desktop.google.com/plugins/i/mediarssslideshow.html
</a><br /><br />
(3) �������åȤΥ��ץ����ˤơ���MediaRSS �� URL�פ򲼵����ѹ�����<br />' );

//---------------------------------------------------------
// others
//---------------------------------------------------------
define("_WEBPHOTO_RANDOM_MORE","������̿����äȸ���");
define("_WEBPHOTO_USAGE_PHOTO","�̿��򥯥�å�����ȡ��礭�ʼ̿����ݥåץ��åפ��ޤ�");
define("_WEBPHOTO_USAGE_TITLE","�����ȥ�򥯥�å�����ȡ����μ̿��Υڡ����������ޤ�");
define("_WEBPHOTO_DATE_NOT_SET","�������� ����ʤ�");
define("_WEBPHOTO_PLACE_NOT_SET","���ƾ�� ����ʤ�");
define("_WEBPHOTO_GOTO_ADMIN", "�����Բ��̤�");

//---------------------------------------------------------
// search for Japanese
//---------------------------------------------------------
define("_WEBPHOTO_SR_CANDICATE","�����θ���");
define("_WEBPHOTO_SR_ZENKAKU","����");
define("_WEBPHOTO_SR_HANKAKU","Ⱦ��");

define("_WEBPHOTO_JA_KUTEN",   "��");
define("_WEBPHOTO_JA_DOKUTEN", "��");
define("_WEBPHOTO_JA_PERIOD",  "��");
define("_WEBPHOTO_JA_COMMA",   "��");

//---------------------------------------------------------
// v0.20
//---------------------------------------------------------
define("_WEBPHOTO_TITLE_VIDEO_THUMB_SEL", "ư��Υ���ͥ�������򤹤�");
define("_WEBPHOTO_TITLE_VIDEO_REDO","���åץ��ɺѤߤ�ư���� Flashư��ȥ���ͥ������������");
define("_WEBPHOTO_CAP_REDO_THUMB","����ͥ������������");
define("_WEBPHOTO_CAP_REDO_FLASH","Flash ư�����������");
define("_WEBPHOTO_ERR_VIDEO_FLASH", "Flash ư��������Ǥ��ʤ��ä�");
define("_WEBPHOTO_ERR_VIDEO_THUMB", "ư��Υ���ͥ��뤬�����Ǥ��ʤ��ä��Τǡ�������������Ѥ���");
define("_WEBPHOTO_BUTTON_SELECT", "����");

define("_WEBPHOTO_DSC_DOWNLOAD_PLAY","��������ɤ��ƺ�������");
define("_WEBPHOTO_ICON_VIDEO", "ư��");
define("_WEBPHOTO_HOUR", "����");
define("_WEBPHOTO_MINUTE", "ʬ");
define("_WEBPHOTO_SECOND", "��");

// === define end ===
}

?>
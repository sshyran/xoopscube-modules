<?php
// $Id: modinfo.php,v 1.6 2008/09/04 00:46:47 ohwada Exp $

//=========================================================
// webphoto module
// 2008-04-02 K.OHWADA
//=========================================================

$constpref = strtoupper( '_MI_' . $GLOBALS['MY_DIRNAME']. '_' ) ;

// === define begin ===
if( !defined($constpref."LANG_LOADED") ) 
{

define($constpref."LANG_LOADED" , 1 ) ;

//=========================================================
// same as myalbum
//=========================================================

// The name of this module
define($constpref."NAME","WEB �̿���");

// A brief description of this module
define($constpref."DESC","��������ơ���󥯤���¾�ε�ǽ����Ĳ�����������������");

// Names of blocks for this module (Not all module has blocks)
define($constpref."BNAME_RECENT","�Ƕ�β���");
define($constpref."BNAME_HITS","�͵�����");
define($constpref."BNAME_RANDOM","�ԥå����åײ���");
define($constpref."BNAME_RECENT_P","�Ƕ�β���(������)");
define($constpref."BNAME_HITS_P","�͵�����(������)");

// Config Items
define( $constpref."CFG_PHOTOSPATH" , "�����ե��������¸��ǥ��쥯�ȥ�" ) ;
define( $constpref."CFG_DESCPHOTOSPATH" , "XOOPS���󥹥ȡ����褫��Υѥ������ʺǽ��'/'��ɬ�ס��Ǹ��'/'�����ס�<br />Unix�ǤϤ��Υǥ��쥯�ȥ�ؤν��°����ON�ˤ��Ʋ�����" ) ;
define( $constpref."CFG_THUMBSPATH" , "����ͥ���ե��������¸��ǥ��쥯�ȥ�" ) ;
define( $constpref."CFG_DESCTHUMBSPATH" , "�ֲ����ե��������¸��ǥ��쥯�ȥ�פ�Ʊ���Ǥ�" ) ;
// define( $constpref."CFG_USEIMAGICK" , "����������ImageMagick��Ȥ�" ) ;
// define( $constpref."CFG_DESCIMAGICK" , "�Ȥ�ʤ����ϡ��ᥤ�������Ĵ���ϵ�ǽ����������ͥ����������GD��Ȥ��ޤ���<br />��ǽ�Ǥ����ImageMagick�λ��Ѥ������Ǥ�" ) ;
define( $constpref."CFG_IMAGINGPIPE" , "����������Ԥ碌��ѥå���������" ) ;
define( $constpref."CFG_DESCIMAGINGPIPE" , "�ۤȤ�ɤ�PHP�Ķ���ɸ��Ū�����Ѳ�ǽ�ʤΤ�GD�Ǥ�����ǽŪ������ޤ�<br />��ǽ�Ǥ����ImageMagick��NetPBM�λ��Ѥ򤪴��ᤷ�ޤ�" ) ;
define( $constpref."CFG_FORCEGD2" , "����GD2�⡼��" ) ;
define( $constpref."CFG_DESCFORCEGD2" , "����Ū��GD2�⡼�ɤ�ư����ޤ�<br />������PHP�Ǥ϶���GD2�⡼�ɤǥ���ͥ�������˼��Ԥ��ޤ�<br />���������ѥå������Ȥ���GD�����򤷤����Τ߰�̣������ޤ�" ) ;
define( $constpref."CFG_IMAGICKPATH" , "ImageMagick�μ¹ԥѥ�" ) ;
define( $constpref."CFG_DESCIMAGICKPATH" , "convert��¸�ߤ���ǥ��쥯�ȥ��ե�ѥ��ǻ��ꤷ�ޤ���������Ǥ��ޤ��Ԥ����Ȥ�¿���Ǥ��礦��<br />���������ѥå������Ȥ���ImageMagick�����򤷤����Τ߰�̣������ޤ�" ) ;
define( $constpref."CFG_NETPBMPATH" , "NetPBM�μ¹ԥѥ�" ) ;
define( $constpref."CFG_DESCNETPBMPATH" , "pnmscale����¸�ߤ���ǥ��쥯�ȥ��ե�ѥ��ǻ��ꤷ�ޤ���������Ǥ��ޤ��Ԥ����Ȥ�¿���Ǥ��礦��<br />���������ѥå������Ȥ���NetPBM�����򤷤����Τ߰�̣������ޤ�" ) ;
define( $constpref."CFG_POPULAR" , "'POP'�������󤬤Ĥ������ɬ�פʥҥåȿ�" ) ;
define( $constpref."CFG_NEWDAYS" , "'new'��'update'��������ɽ�����������" ) ;
define( $constpref."CFG_NEWPHOTOS" , "�ȥåץڡ����ǿ��������Ȥ���ɽ�������" ) ;

//define( $constpref."CFG_DEFAULTORDER" , "���ƥ���ɽ���ǤΥǥե����ɽ����" ) ;

define( $constpref."CFG_PERPAGE" , "1�ڡ�����ɽ������������" ) ;
define( $constpref."CFG_DESCPERPAGE" , "�����ǽ�ʿ����� | �Ƕ��ڤäƲ�����<br />��: 10|20|50|100" ) ;
define( $constpref."CFG_ALLOWNOIMAGE" , "�����Τʤ���Ƥ���Ĥ���" ) ;
define( $constpref."CFG_MAKETHUMB" , "����ͥ�����������" ) ;
define( $constpref."CFG_DESCMAKETHUMB" , "���������ʤ��פ������������פ��ѹ��������ˤϡ��֥���ͥ���κƹ��ۡפ�ɬ�פǤ���" ) ;

//define( $constpref."CFG_THUMBWIDTH" , "����ͥ����������" ) ;
//define( $constpref."CFG_DESCTHUMBWIDTH" , "��������륵��ͥ�������ι⤵�ϡ������鼫ư�׻�����ޤ�" ) ;
//define( $constpref."CFG_THUMBSIZE" , "����ͥ������������(pixel)" ) ;

define( $constpref."CFG_THUMBRULE" , "����ͥ�������ˡ§" ) ;
define( $constpref."CFG_WIDTH" , "���������" ) ;
define( $constpref."CFG_DESCWIDTH" , "�������åץ��ɻ��˼�ưĴ�������ᥤ������κ�������<br />GD�⡼�ɤ�TrueColor�򰷤��ʤ����ˤ�ñ�ʤ륵��������" ) ;
define( $constpref."CFG_HEIGHT" , "���������" ) ;
define( $constpref."CFG_DESCHEIGHT" , "��������Ʊ����̣�Ǥ�" ) ;
define( $constpref."CFG_FSIZE" , "����ե���������" ) ;
define( $constpref."CFG_DESCFSIZE" , "���åץ��ɻ��Υե�������������(byte)" ) ;

//define( $constpref."CFG_MIDDLEPIXEL" , "���󥰥�ӥ塼�Ǥκ������������" ) ;
//define( $constpref."CFG_DESCMIDDLEPIXEL" , "��x�⤵ �ǻ��ꤷ�ޤ���<br />���� 480x480��" ) ;

define( $constpref."CFG_ADDPOSTS" , "�̿�����Ƥ������˥�����ȥ��åפ������ƿ�" ) ;
define( $constpref."CFG_DESCADDPOSTS" , "�ＱŪ�ˤ�0��1�Ǥ�������ͤ�0�ȸ��ʤ���ޤ�" ) ;
define( $constpref."CFG_CATONSUBMENU" , "���֥�˥塼�ؤΥȥåץ��ƥ��꡼����Ͽ" ) ;
define( $constpref."CFG_NAMEORUNAME" , "��Ƽ�̾��ɽ��" ) ;
define( $constpref."CFG_DESCNAMEORUNAME" , "������̾���ϥ�ɥ�̾�����򤷤Ʋ�����" ) ;

//define( $constpref."CFG_VIEWCATTYPE" , "����ɽ����ɽ��������" ) ;
define( $constpref."CFG_VIEWTYPE" , "����ɽ����ɽ��������" ) ;

//define( $constpref."CFG_COLSOFTABLEVIEW" , "�ơ��֥�ɽ�����Υ�����" ) ;
define( $constpref."CFG_COLSOFTABLE" , "�ơ��֥�ɽ�����Υ�����" ) ;

//define( $constpref."CFG_ALLOWEDEXTS" , "���åץ��ɵ��Ĥ���ե������ĥ��" ) ;
//define( $constpref."CFG_DESCALLOWEDEXTS" , "�ե�����γ�ĥ�Ҥ�jpg|jpeg|gif|png �Τ褦�ˡ�'|' �Ƕ��ڤä����Ϥ��Ʋ�������<br />���٤ƾ�ʸ���ǻ��ꤷ���ԥꥪ�ɤ���������ʤ��ǲ�������<br />��̣��Ƚ�äƤ������ʳ��ϡ�php��phtml�ʤɤ��ɲä��ʤ��ǲ�����" ) ;
//define( $constpref."CFG_ALLOWEDMIME" , "���åץ��ɵ��Ĥ���MIME������" ) ;
//define( $constpref."CFG_DESCALLOWEDMIME" , "MIME�����פ�image/gif|image/jpeg|image/png �Τ褦�ˡ�'|' �Ƕ��ڤä����Ϥ��Ʋ�������<br />MIME�����פˤ������å���Ԥ�ʤ����ˤϡ����������ˤ��ޤ�" ) ;

define( $constpref."CFG_USESITEIMG" , "���᡼���ޥ͡���������Ǥ�[siteimg]����" ) ;
define( $constpref."CFG_DESCUSESITEIMG" , "���᡼���ޥ͡���������ǡ�[img]�����������[siteimg]��������������褦�ˤʤ�ޤ���<br />���ѥ⥸�塼��¦��[siteimg]������ͭ���˵�ǽ����褦�ˤʤäƤ���ɬ�פ�����ޤ�" ) ;

define( $constpref."OPT_USENAME" , "�ϥ�ɥ�̾" ) ;
define( $constpref."OPT_USEUNAME" , "������̾" ) ;

define( $constpref."OPT_CALCFROMWIDTH" , "������ͤ����Ȥ��ơ��⤵��ư�׻�" ) ;
define( $constpref."OPT_CALCFROMHEIGHT" , "������ͤ�⤵�Ȥ��ơ�����ư�׻�" ) ;
define( $constpref."OPT_CALCWHINSIDEBOX" , "�����⤵���礭������������ͤˤʤ�褦��ư�׻�" ) ;

define( $constpref."OPT_VIEWLIST" , "����ʸ�եꥹ��ɽ��" ) ;
define( $constpref."OPT_VIEWTABLE" , "�ơ��֥�ɽ��" ) ;

// Sub menu titles
//define($constpref."TEXT_SMNAME1","���");
//define($constpref."TEXT_SMNAME2","��͵�");
//define($constpref."TEXT_SMNAME3","�ȥåץ��");
//define($constpref."TEXT_SMNAME4","��ʬ�����");

// Names of admin menu items
//define($constpref."ADMENU0","��Ƥ��줿�����ξ�ǧ");
//define($constpref."ADMENU1","��������");
//define($constpref."ADMENU2","���ƥ������");
//define($constpref."ADMENU_GPERM","�ƥ��롼�פθ���");
//define($constpref."ADMENU3","ư������å���");
//define($constpref."ADMENU4","���������Ͽ");
//define($constpref."ADMENU5","����ͥ���κƹ���");
//define($constpref."ADMENU_IMPORT","��������ݡ���");
//define($constpref."ADMENU_EXPORT","�����������ݡ���");
//define($constpref."ADMENU_MYBLOCKSADMIN","�֥�å���������������");
//define($constpref."ADMENU_MYTPLSADMIN","�ƥ�ץ졼�ȴ���");


// Text for notifications
define($constpref."GLOBAL_NOTIFY", "�⥸�塼������");
define($constpref."GLOBAL_NOTIFYDSC", "�⥸�塼�����Τˤ��������Υ��ץ����");
define($constpref."CATEGORY_NOTIFY", "���ƥ��꡼");
define($constpref."CATEGORY_NOTIFYDSC", "������Υ��ƥ��꡼���Ф������Υ��ץ����");
define($constpref."PHOTO_NOTIFY", "�̿�");
define($constpref."PHOTO_NOTIFYDSC", "ɽ����μ̿����Ф������Υ��ץ����");

define($constpref."GLOBAL_NEWPHOTO_NOTIFY", "�����̿���Ͽ");
define($constpref."GLOBAL_NEWPHOTO_NOTIFYCAP", "�����˼̿�����Ͽ���줿�������Τ���");
define($constpref."GLOBAL_NEWPHOTO_NOTIFYDSC", "�����˼̿�����Ͽ���줿�������Τ���");
define($constpref."GLOBAL_NEWPHOTO_NOTIFYSBJ", "[{X_SITENAME}] {X_MODULE}: �����˼̿�����Ͽ����ޤ���");

define($constpref."CATEGORY_NEWPHOTO_NOTIFY", "���ƥ�����ο��̿���Ͽ");
define($constpref."CATEGORY_NEWPHOTO_NOTIFYCAP", "���Υ��ƥ���˿����˼̿�����Ͽ���줿�������Τ���");
define($constpref."CATEGORY_NEWPHOTO_NOTIFYDSC", "���Υ��ƥ���˿����˼̿�����Ͽ���줿�������Τ���");
define($constpref."CATEGORY_NEWPHOTO_NOTIFYSBJ", "[{X_SITENAME}] {X_MODULE}: �����˼̿�����Ͽ����ޤ���");


//=========================================================
// add for webphoto
//=========================================================

// Config Items
define($constpref."CFG_SORT" , "�ǥե���Ȥ�ɽ����" ) ;
define($constpref."OPT_SORT_IDA","�쥳�����ֹ澺��");
define($constpref."OPT_SORT_IDD","�쥳�����ֹ�߽�");
define($constpref."OPT_SORT_HITSA","�ҥåȿ� (�㢪��)");
define($constpref."OPT_SORT_HITSD","�ҥåȿ� (�⢪��)");
define($constpref."OPT_SORT_TITLEA","�����ȥ� (A �� Z)");
define($constpref."OPT_SORT_TITLED","�����ȥ� (Z �� A)");
define($constpref."OPT_SORT_DATEA","�������� (�좪��)");
define($constpref."OPT_SORT_DATED","�������� (������)");
define($constpref."OPT_SORT_RATINGA","ɾ�� (�㢪��)");
define($constpref."OPT_SORT_RATINGD","ɾ�� (�⢪��)");
define($constpref."OPT_SORT_RANDOM","������");

define($constpref."CFG_GICONSPATH" , "Google ��������ե��������¸��ǥ��쥯�ȥ�" ) ;

//define($constpref."CFG_TMPPATH" ,   "����ե��������¸��ǥ��쥯�ȥ�" ) ;

define($constpref."CFG_MIDDLE_WIDTH" ,  "���󥰥�ӥ塼�Ǥβ�������" ) ;
define($constpref."CFG_MIDDLE_HEIGHT" , "���󥰥�ӥ塼�Ǥβ����ι⤵" ) ;
define($constpref."CFG_THUMB_WIDTH" ,  "����ͥ����������" ) ;
define($constpref."CFG_THUMB_HEIGHT" , "����ͥ�������ι⤵" ) ;

define($constpref."CFG_APIKEY","Google API Key");
define($constpref."CFG_APIKEY_DSC", "Google Maps �����Ѥ������ <br /> <a href=\"http://www.google.com/apis/maps/signup.html\" target=\"_blank\">Sign Up for the Google Maps API</a> <br /> �ˤ� <br /> API key ��������Ƥ�������<br /><br />�ѥ�᡼���ξܺ٤ϲ���������������<br /><a href=\"http://www.google.com/apis/maps/documentation/reference.html\" target=\"_blank\">Google Maps API Reference</a>");
define($constpref."CFG_LATITUDE", "����");
define($constpref."CFG_LONGITUDE","����");
define($constpref."CFG_ZOOM","������");

define($constpref."CFG_USE_POPBOX","PopBox ����Ѥ���");

define($constpref."CFG_INDEX_DESC", "�ȥåץڡ�����ɽ����������ʸ");
define($constpref."CFG_INDEX_DESC_DEFAULT", "�����ˤ�����ʸ��ɽ�����ޤ���<br />����ʸ�ϡְ�������פˤ��Խ��Ǥ��ޤ���<br />");

// Sub menu titles
define($constpref."SMNAME_SUBMIT","���");
define($constpref."SMNAME_POPULAR","��͵�");
define($constpref."SMNAME_HIGHRATE","�ȥåץ��");
define($constpref."SMNAME_MYPHOTO","��ʬ�����");

// Names of admin menu items
define($constpref."ADMENU_ADMISSION","��Ƥ��줿�����ξ�ǧ");
define($constpref."ADMENU_PHOTOMANAGER","��������");
define($constpref."ADMENU_CATMANAGER","���ƥ������");
define($constpref."ADMENU_CHECKCONFIGS","ư������å���");
define($constpref."ADMENU_BATCH","���������Ͽ");
define($constpref."ADMENU_REDOTHUMB","����ͥ���κƹ���");
define($constpref."ADMENU_GROUPPERM","�ƥ��롼�פθ���");
define($constpref."ADMENU_IMPORT","��������ݡ���");
define($constpref."ADMENU_EXPORT","�����������ݡ���");

define($constpref."ADMENU_GICONMANAGER","Google�����������");
define($constpref."ADMENU_MIMETYPES","MIME�����״���");
define($constpref."ADMENU_IMPORT_MYALBUM","Myalbum ����ΰ�祤��ݡ���");
define($constpref."ADMENU_CHECKTABLES","�ơ��֥�ư������å�");
define($constpref."ADMENU_PHOTO_TABLE_MANAGE","�̿��ơ��֥����");
define($constpref."ADMENU_CAT_TABLE_MANAGE","���ƥ���ơ��֥����");
define($constpref."ADMENU_VOTE_TABLE_MANAGE","��ɼ�ơ��֥����");
define($constpref."ADMENU_GICON_TABLE_MANAGE","Google��������ơ��֥����");
define($constpref."ADMENU_MIME_TABLE_MANAGE","MIME�ơ��֥����");
define($constpref."ADMENU_TAG_TABLE_MANAGE","�����ơ��֥����");
define($constpref."ADMENU_P2T_TABLE_MANAGE","�̿�������Ϣ�ơ��֥����");
define($constpref."ADMENU_SYNO_TABLE_MANAGE","�����ơ��֥����");

//---------------------------------------------------------
// v0.20
//---------------------------------------------------------
define($constpref."CFG_USE_FFMPEG"  , "ffmpeg ����Ѥ���" ) ;
define($constpref."CFG_FFMPEGPATH"  , "ffmpeg �μ¹ԥѥ�" ) ;
define($constpref."CFG_DESCFFMPEGPATH" , "ffmpeg ��¸�ߤ���ǥ��쥯�ȥ��ե�ѥ��ǻ��ꤷ�ޤ�������Ǥ��ޤ��Ԥ����Ȥ�¿���Ǥ��礦��<br />��ffmpeg ����Ѥ���פΡ֤Ϥ��פ����򤷤����Τ߰�̣������ޤ�" ) ;
define($constpref."CFG_USE_PATHINFO","pathinfo ����Ѥ���");

//---------------------------------------------------------
// v0.30
//---------------------------------------------------------
define($constpref."CFG_TMPDIR" ,   "����ե��������¸��ǥ��쥯�ȥ�" ) ;
define($constpref."CFG_TMPDIR_DSC" , "�ե�ѥ������ʺǸ��'/'�����ס�<br />�ɥ�����ȡ��롼�Ȱʳ������ꤹ�뤳�Ȥ򤪴��ᤷ�ޤ�");
define($constpref."CFG_MAIL_HOST"  , "�᡼�� �����С� �ۥ���̾" ) ;
define($constpref."CFG_MAIL_USER"  , "�᡼�� �桼����ID" ) ;
define($constpref."CFG_MAIL_PASS"  , "�᡼�� �ѥ����" ) ;
define($constpref."CFG_MAIL_ADDR"  , "����� �᡼�륢�ɥ쥹" ) ;
define($constpref."CFG_MAIL_CHARSET"  , "�᡼���ʸ��������" ) ;
define($constpref."CFG_MAIL_CHARSET_DSC" , "'|' �Ƕ��ڤä����Ϥ��Ʋ�������<br />ʸ�������ɤˤ������å���Ԥ�ʤ����ˤϡ����������ˤ��ޤ�" ) ;
define($constpref."CFG_MAIL_CHARSET_LIST","ISO-2022-JP|JIS|Shift_JIS|EUC-JP|UTF-8");
define($constpref."CFG_FILE_DIR"  , "FTP �ե��������¸��ǥ��쥯�ȥ�" ) ;
define($constpref."CFG_FILE_DIR_DSC" , "�ե�ѥ������ʺǸ��'/'�����ס�<br />�ɥ�����ȡ��롼�Ȱʳ������ꤹ�뤳�Ȥ򤪴��ᤷ�ޤ�" ) ;
define($constpref."CFG_FILE_SIZE"  , "FTP ����ե��������� (byte)" ) ;
define($constpref."CFG_FILE_DESC"  , "FTP �إ������ʸ");
define($constpref."CFG_FILE_DESC_DSC"  , "�֥ե�������ơפθ��¤�������ˡ��إ�פ�ɽ������ޤ�");
define($constpref."CFG_FILE_DESC_TEXT"  , "
<b>FTP �����С�</b><br />
FTP �����С� �ۥ���̾: xxx<br />
FTP �桼����ID: xxx<br />
FTP �ѥ����: xxx<br />" ) ;

define($constpref."ADMENU_MAILLOG_MANAGER","�᡼�������");
define($constpref."ADMENU_MAILLOG_TABLE_MANAGE","�᡼������ơ��֥����");
define($constpref."ADMENU_USER_TABLE_MANAGE","�桼������ơ��֥����");

//---------------------------------------------------------
// v0.40
//---------------------------------------------------------
define($constpref."CFG_BIN_PASS" , "���ޥ�ɤΥѥ����" ) ;
define($constpref."CFG_COM_DIRNAME",  "���������礹��d3forum��dirname");
define($constpref."CFG_COM_FORUM_ID", "���������礹��ե��������ֹ�");
define($constpref."CFG_COM_VIEW",     "�����������ɽ����ˡ");

define($constpref."ADMENU_UPDATE", "���åץǡ���");
define($constpref."ADMENU_ITEM_TABLE_MANAGE", "�����ƥࡦ�ơ��֥����");
define($constpref."ADMENU_FILE_TABLE_MANAGE", "�ե����롦�ơ��֥����");


}
// === define begin ===

?>
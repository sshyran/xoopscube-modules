<?php
// Module Info
if( defined( 'FOR_XOOPS_LANG_CHECKER' ) ) $mydirname = 'd3imgtag' ;
$constpref = '_MI_' . strtoupper( $mydirname ) ;

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( $constpref.'_LOADED' ) ) {

define( $constpref.'_LOADED' , 1 ) ;

// The name of this module
define($constpref."_NAME","IMG����D3");

// A brief description of this module
define($constpref."_DESC","��������ơ�ɽ��������դ�����¾�ε�ǽ��������Ū�ʲ��������꡼���������");

// Names of blocks for this module (Not all module has blocks)
define( $constpref."_BNAME_RECENT","�Ƕ�β���");
define( $constpref."_BNAME_HITS","�͵�����");
define( $constpref."_BNAME_RANDOM","���������");
define( $constpref."_BNAME_RECENT_P","�Ƕ�β���(������)");
define( $constpref."_BNAME_HITS_P","�͵�����(������)");

// Config Items	@remove_CFG_
define( $constpref."_PHOTOSPATH" , "�����ե��������¸��ǥ��쥯�ȥ�" ) ;
define( $constpref."_DESCPHOTOSPATH" , "XOOPS���󥹥ȡ����褫��Υѥ������ʺǽ��'/'��ɬ�ס��Ǹ��'/'�����ס�<br />Unix�ǤϤ��Υǥ��쥯�ȥ�ؤν��°����ON�ˤ��Ʋ�����" ) ;
define( $constpref."_THUMBSPATH" , "����ͥ���ե��������¸��ǥ��쥯�ȥ�" ) ;
define( $constpref."_DESCTHUMBSPATH" , "�ֲ����ե��������¸��ǥ��쥯�ȥ�פ�Ʊ���Ǥ�" ) ;
// define( $constpref."_USEIMAGICK" , "����������ImageMagick��Ȥ�" ) ;
// define( $constpref."_DESCIMAGICK" , "�Ȥ�ʤ����ϡ��ᥤ�������Ĵ���ϵ�ǽ����������ͥ����������GD��Ȥ��ޤ���<br />��ǽ�Ǥ����ImageMagick�λ��Ѥ������Ǥ�" ) ;
define( $constpref."_IMAGINGPIPE" , "���������ץ��å���������" ) ;
define( $constpref."_DESCIMAGINGPIPE" , "�ۤȤ�ɤ�PHP�Ķ���ɸ��Ū�����Ѳ�ǽ�ʤΤ�GD�Ǥ�����ǽŪ������ޤ�<br />��ǽ�Ǥ����ImageMagick��NetPBM�λ��Ѥ򤪴��ᤷ�ޤ�" ) ;
define( $constpref."_FORCEGD2" , "����GD2�⡼��" ) ;
define( $constpref."_DESCFORCEGD2" , "����Ū��GD2�⡼�ɤ�ư����ޤ�<br />������PHP�Ǥ϶���GD2�⡼�ɤǥ���ͥ�������˼��Ԥ��ޤ�<br />���������ѥå������Ȥ���GD�����򤷤����Τ߰�̣������ޤ�" ) ;
define( $constpref."_IMAGICKPATH" , "ImageMagick�μ¹ԥѥ�" ) ;
define( $constpref."_DESCIMAGICKPATH" , "convert��¸�ߤ���ǥ��쥯�ȥ��ե�ѥ��ǻ��ꤷ�ޤ���������Ǥ��ޤ��Ԥ����Ȥ�¿���Ǥ��礦��<br />���������ѥå������Ȥ���ImageMagick�����򤷤����Τ߰�̣������ޤ�" ) ;
define( $constpref."_NETPBMPATH" , "NetPBM�μ¹ԥѥ�" ) ;
define( $constpref."_DESCNETPBMPATH" , "pnmscale����¸�ߤ���ǥ��쥯�ȥ��ե�ѥ��ǻ��ꤷ�ޤ���������Ǥ��ޤ��Ԥ����Ȥ�¿���Ǥ��礦��<br />���������ѥå������Ȥ���NetPBM�����򤷤����Τ߰�̣������ޤ�" ) ;
define( $constpref."_POPULAR" , "'POP'�������󤬤Ĥ������ɬ�פʥҥåȿ�" ) ;
define( $constpref."_NEWDAYS" , "'new'��'update'��������ɽ�����������" ) ;
define( $constpref."_NEWPHOTOS" , "�ȥåץڡ����ǿ��������Ȥ���ɽ�������" ) ;
define( $constpref."_DEFAULTORDER" , "���ƥ���ɽ���ǤΥǥե����ɽ����" ) ;
define( $constpref."_PERPAGE" , "1�ڡ�����ɽ������������" ) ;
define( $constpref."_DESCPERPAGE" , "�����ǽ�ʿ����� | �Ƕ��ڤäƲ�����<br />��: 10|20|50|100" ) ;
define( $constpref."_ALLOWNOIMAGE" , "�����Τʤ���Ƥ���Ĥ���" ) ;
define( $constpref."_MAKETHUMB" , "����ͥ�����������" ) ;
define( $constpref."_DESCMAKETHUMB" , "���������ʤ��פ������������פ��ѹ��������ˤϡ��֥���ͥ���κƹ��ۡפ�ɬ�פǤ���" ) ;
define( $constpref."_MAKEPREVIEW" , "�ץ�ӥ塼���������" );
define( $constpref."_DESCMAKEPREVIEW" , "���������ʤ��פ������������פ��ѹ��������ˤϡ��֥���ͥ���κƹ��ۡפ�ɬ�פǤ���" );
//define( $constpref."_THUMBWIDTH" , "����ͥ����������" ) ;
//define( $constpref."_DESCTHUMBWIDTH" , "��������륵��ͥ�������ι⤵�ϡ������鼫ư�׻�����ޤ�" ) ;
define( $constpref."_THUMBSIZE" , "����ͥ������������(pixel)" ) ;
define( $constpref."_THUMBRULE" , "����ͥ�������ˡ§" ) ;
define( $constpref."_WIDTH" , "���������" ) ;
define( $constpref."_DESCWIDTH" , "�������åץ��ɻ��˼�ưĴ�������ᥤ������κ�������<br />GD�⡼�ɤ�TrueColor�򰷤��ʤ����ˤ�ñ�ʤ륵��������" ) ;
define( $constpref."_HEIGHT" , "���������" ) ;
define( $constpref."_DESCHEIGHT" , "��������Ʊ����̣�Ǥ�" ) ;
define( $constpref."_FSIZE" , "����ե����륵����" ) ;
define( $constpref."_DESCFSIZE" , "���åץ��ɻ��Υե����륵��������(byte)" ) ;
define( $constpref."_MIDDLEPIXEL" , "���󥰥�ӥ塼�Ǥκ������������" ) ;
define( $constpref."_DESCMIDDLEPIXEL" , "��x�⤵ �ǻ��ꤷ�ޤ���<br />���� 480x480��" ) ;
define( $constpref."_ADDPOSTS" , "�̿�����Ƥ������˥�����ȥ��åפ������ƿ�" ) ;
define( $constpref."_DESCADDPOSTS" , "�ＱŪ�ˤ�0��1�Ǥ�������ͤ�0�ȸ��ʤ���ޤ�" ) ;
define( $constpref."_CATONSUBMENU" , "���֥�˥塼�ؤΥȥåץ��ƥ��꡼����Ͽ" ) ;
define( $constpref."_NAMEORUNAME" , "��Ƽ�̾��ɽ��" ) ;
define( $constpref."_DESCNAMEORUNAME" , "������̾���ϥ�ɥ�̾�����򤷤Ʋ�����" ) ;
define( $constpref."_VIEWCATTYPE" , "����ɽ����ɽ��������" ) ;
define( $constpref."_COLSOFTABLEVIEW" , "�ơ��֥�ɽ�����Υ�����" ) ;
define( $constpref."_ALLOWEDEXTS" , "���åץ��ɵ��Ĥ���ե������ĥ��" ) ;
define( $constpref."_DESCALLOWEDEXTS" , "�ե�����γ�ĥ�Ҥ�jpg|jpeg|gif|png �Τ褦�ˡ�'|' �Ƕ��ڤä����Ϥ��Ʋ�������<br />���٤ƾ�ʸ���ǻ��ꤷ���ԥꥪ�ɤ���������ʤ��ǲ�������<br />��̣��Ƚ�äƤ������ʳ��ϡ�php��phtml�ʤɤ��ɲä��ʤ��ǲ�����" ) ;
define( $constpref."_ALLOWEDMIME" , "���åץ��ɵ��Ĥ���MIME������" ) ;
define( $constpref."_DESCALLOWEDMIME" , "MIME�����פ�image/gif|image/jpeg|image/png �Τ褦�ˡ�'|' �Ƕ��ڤä����Ϥ��Ʋ�������<br />MIME�����פˤ������å���Ԥ�ʤ����ˤϡ����������ˤ��ޤ�" ) ;
define( $constpref."_USESITEIMG" , "���᡼���ޥ͡���������Ǥ�[siteimg]����" ) ;
define( $constpref."_DESCUSESITEIMG" , "���᡼���ޥ͡���������ǡ�[img]�����������[siteimg]��������������褦�ˤʤ�ޤ���<br />���ѥ⥸�塼��¦��[siteimg]������ͭ���˵�ǽ����褦�ˤʤäƤ���ɬ�פ�����ޤ�" ) ;

define( $constpref."_OPT_USENAME" , "�ϥ�ɥ�̾" ) ;
define( $constpref."_OPT_USEUNAME" , "������̾" ) ;

define( $constpref."_OPT_CALCFROMWIDTH" , "������ͤ����Ȥ��ơ��⤵��ư�׻�" ) ;
define( $constpref."_OPT_CALCFROMHEIGHT" , "������ͤ�⤵�Ȥ��ơ�����ư�׻�" ) ;
define( $constpref."_OPT_CALCWHINSIDEBOX" , "�����⤵���礭������������ͤˤʤ�褦��ư�׻�" ) ;

define( $constpref."_OPT_VIEWLIST" , "����ʸ�եꥹ��ɽ��" ) ;
define( $constpref."_OPT_VIEWTABLE" , "�ơ��֥�ɽ��" ) ;


// Sub menu titles
define( $constpref."_TEXT_SMNAME1","���");
define( $constpref."_TEXT_SMNAME2","��͵�");
define( $constpref."_TEXT_SMNAME3","�ȥåץ��");
define( $constpref."_TEXT_SMNAME4","��ʬ�����");

// Names of admin menu items
define( $constpref."_D3IMGTAG_ADMENU0","��Ƥ��줿�����ξ�ǧ");
define( $constpref."_D3IMGTAG_ADMENU1","��������");
define( $constpref."_D3IMGTAG_ADMENU2","���ƥ������");
define( $constpref."_D3IMGTAG_ADMENU_GPERM","�ƥ��롼�פθ���");
define( $constpref."_D3IMGTAG_ADMENU3","ư������å���");
define( $constpref."_D3IMGTAG_ADMENU4","���������Ͽ");
define( $constpref."_D3IMGTAG_ADMENU5","����ͥ���κƹ���");
//define( $constpref."_D3IMGTAG_ADMENU_IMPORT","��������ݡ���");
//define( $constpref."_D3IMGTAG_ADMENU_EXPORT","�����������ݡ���");
define( $constpref.'_ADMENU_MYLANGADMIN' , '�����������' ) ;
define( $constpref.'_ADMENU_MYTPLSADMIN' , '�ƥ�ץ졼�ȴ���' ) ;
define( $constpref.'_ADMENU_MYBLOCKSADMIN' , '�֥�å�����/������������' ) ;
define( $constpref.'_ADMENU_MYPREFERENCES' , '��������' ) ;


// Text for notifications
define( $constpref.'_GLOBAL_NOTIFY', '�⥸�塼������');
define( $constpref.'_GLOBAL_NOTIFYDSC', 'IMGTag�⥸�塼�����Τˤ��������Υ��ץ����');
define( $constpref.'_CATEGORY_NOTIFY', '���ƥ��꡼');
define( $constpref.'_CATEGORY_NOTIFYDSC', '������Υ��ƥ��꡼���Ф������Υ��ץ����');
define( $constpref.'_PHOTO_NOTIFY', '�̿�');
define( $constpref.'_PHOTO_NOTIFYDSC', 'ɽ����μ̿����Ф������Υ��ץ����');

define( $constpref.'_GLOBAL_NEWPHOTO_NOTIFY', '�����̿���Ͽ');
define( $constpref.'_GLOBAL_NEWPHOTO_NOTIFYCAP', '�����˼̿�����Ͽ���줿�������Τ���');
define( $constpref.'_GLOBAL_NEWPHOTO_NOTIFYDSC', '�����˼̿�����Ͽ���줿�������Τ���');
define( $constpref.'_GLOBAL_NEWPHOTO_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE}: �����˼̿�����Ͽ����ޤ���');

define( $constpref.'_CATEGORY_NEWPHOTO_NOTIFY', '���ƥ�����ο��̿���Ͽ');
define( $constpref.'_CATEGORY_NEWPHOTO_NOTIFYCAP', '���Υ��ƥ���˿����˼̿�����Ͽ���줿�������Τ���');
define( $constpref.'_CATEGORY_NEWPHOTO_NOTIFYDSC', '���Υ��ƥ���˿����˼̿�����Ͽ���줿�������Τ���');
define( $constpref.'_CATEGORY_NEWPHOTO_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE}: �����˼̿�����Ͽ����ޤ���');


// KickassAMD Added Constants
define($constpref."_CHECKREFERER", "�ۥåȥ�󥯥ץ�ƥ������");
define($constpref."_CHECKREFERERDESC", "�����Υۥåȥ�󥯤�����ɸ���ǽ�ˤ���<br>*������������Ȥβ�����¾�Υ����Ȥ˥ۥåȥ�󥯤����ʤ��褦�ˤ��ޤ�");
define($constpref."__REFERERS", "�����Υۥåȥ�󥯤���Ĥ��륵����");
define($constpref."__REFERERSDESC", "���Υꥹ�Ⱦ�Υ����Ȥϲ����Υ�󥯤��ǽ�Ȥ��ޤ��������Ȥ� | �϶��ڤäƻ��ꤷ�ޤ���<br><b>��ʬ�Υ����Ȥ��ޤޤ�Ƥ��뤳�Ȥ��ǧ���Ƥ�������!!</b>.");
define($constpref."_DATEFORMAT", "���եե����ޥå�");
define($constpref."_DATEFORMATDESC", "��������������Υե����ޥåȤ���ꤹ�롣 <a href='http://www.php.net/date/'>PHP Date</a> �򻲾Ȥ��Ƥ���������");
define($constpref."_PREVIEWSIZE" , "�ץ�ӥ塼�����Υ����� (pixel)");
define($constpref."_PREVIEWRULE" , "�ץ�ӥ塼���������롼��");
define($constpref."_AJAX", "AJAX��ǽ");
define($constpref."_AJAXDESC", "ưŪ�� AJAX��ǽ����Ѳ�ǽ�ˤ���");
define($constpref."_MINFILE", "�ե�����̾�κǾ���Ĺ��");
define($constpref."_MINFILEDESC", "������ʥե�����̾��Ĺ���κǾ��ͤ���ꤹ�롣�侩�ͤ�: 10");
define($constpref."_MAXFILE", "�ե�����̾�κ����Ĺ��");
define($constpref."_MAXFILEDESC", "������ʥե�����̾��Ĺ���κ����ͤ���ꤹ�롣�侩�ͤ�: 50");
define($constpref."_FILERULE", "�ե�����̾�Υ����ಽ�롼��");
define($constpref."_FILERULEDESC", "������ʥե�����̾����������Ȥ��˻��Ѥ����Τ����򤹤�");
define($constpref."_BADREFCHECK", "�ۥåȥ�󥯤Υ��������");
define($constpref."_BADREFCHECKDESC", "�ۥåȥ�󥯤��줿�Ȥ��Υ������������򤹤�");
define($constpref."_BADREFTXT", "�ۥåȥ�󥯤��Τ餻��ʸ");
define($constpref."_BADREFTXTDESC", "�ۥåȥ�󥯤򤵤줿�Ȥ��������ɽ������ƥ����Ȥޤ��ϥ�����쥯�Ȼ��Υƥ����Ȥ���ꤹ��");
define($constpref."_PREVIEWSPATH" , "�ץ�ӥ塼�ե��������¸��ǥ��쥯�ȥ�");
define($constpref."_DESCPREVIEWSPATH" , "�ֲ����ե��������¸��ǥ��쥯�ȥ�פ�Ʊ���Ǥ�");
//define($constpref."_POPULAR", "'POP'�������󤬤Ĥ������ɬ�פ�ɽ����");
define($constpref."_EXINFO", "�ɲäβ�������");
define($constpref."_EXINFODESC", "��������˥ե����륵�����Ȳ����٤�ɽ������");
define($constpref."_SHARE", "�����ζ�ͭ");
define($constpref."_SHAREDESC", "¾�Υ����ȤȲ����Υ��������ǽ�ˤ���");
define($constpref."_WATER", "�����������ޡ���");
define($constpref."_WATERDESC", "������˥ƥ����Ȥ��ɲä���");
define($constpref."_WATERVALUE", "ɽ������ƥ�����");
define($constpref."_WATERVALUEDESC", "�����������ޡ����Ȥ���ɽ������ƥ����Ȥ���ꤹ��");
define($constpref."_WATERSIZE", "�ƥ����ȤΥ�����");
define($constpref."_WATERSIZEDESC", "�ƥ����ȤΥ���������� 1 - 100 �ޤǲ�ǽ�Ǥ�");
define($constpref."_WATERPOS", "�����������ޡ����ΰ���");
define($constpref."_WATERPOSDESC", "�����������ޡ�����ɽ�������������ΰ��֤���ꤹ��");
define($constpref."_WATERFONT", "�ե���ȥ�����");
define($constpref."_WATERFONTDESC", "�ƥ����Ȥ˻Ȥ��ե���Ȥ����򤹤�<br> * IMGTag���font�ե�����˼�ʬ���Ȥ�truetype�ե���Ȥ��ɲä��뤳�Ȥ��Ǥ��ޤ����������ե���Ȥ��ɲä�����ϥ⥸�塼�륢�åץǡ��Ȥ�ɬ�פǤ���");
define($constpref."_DELETEBATCH", "�������ǲ�����������");
define($constpref."_DELETEBATCHDESC", "�����ΰ������ǥ���ݡ��Ȥ����Τ�Ʊ�ͤ˲����������뤳�Ȥ��Ǥ��ޤ�");
define($constpref."_AJAXEFFECT", "AJAX��ǽ��٥�");
define($constpref."_AJAXEFFECTDESC", "AJAX��ǽ�Υ�٥�����򤹤�");

}

?>
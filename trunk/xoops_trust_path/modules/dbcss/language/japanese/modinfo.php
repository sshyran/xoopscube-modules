<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) ) $mydirname = 'dbcss' ;
$constpref = '_MI_' . strtoupper( $mydirname ) ;

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( $constpref.'_LOADED' ) ) {

define( $constpref.'_LOADED' , 1 ) ;

// The name of this module
define($constpref."_NAME","DB css");

// A brief description of this module
define($constpref."_DESC","�������̾�ǥ������륷���Ȥ��Խ��Ǥ���褦�ˤ���⥸�塼��");

// admin menus
define($constpref.'_ADMENU_CSSADMIN','CSS����ݡ���/�������ݡ���') ;
define($constpref.'_ADMENU_METAHEAD','META��������') ;
define($constpref.'_ADMENU_SCRIPTHEAD','����������ץȥ����Խ�') ;
define($constpref.'_ADMENU_MYLANGADMIN','�����������') ;
define($constpref.'_ADMENU_MYTPLSADMIN','�ƥ�ץ졼�ȴ���') ;
define($constpref.'_ADMENU_MYBLOCKSADMIN','�֥�å�����/������������') ;
define($constpref.'_ADMENU_MYPREFERENCES','��������') ;

// blocks
define($constpref.'_BNAME_DBCSSHOOK','DB�������륷���ȥեå��֥�å�') ;
define($constpref.'_BNAME_CSSHOOK','�������륷���ȥեå��֥�å�') ;
define($constpref.'_BNAME_METAHOOK','META�����եå��֥�å�') ;
define($constpref.'_BNAME_SCRIPTHOOK','SCRIPT�����եå��֥�å�') ;

// configs
define($constpref.'_CSS_TEMPLATE','�ǥե���Ȥˤ���ƥ�ץ졼��̾');
define($constpref.'_CSS_TEMPLATEDSC','���Υ⥸�塼��ǻ��Ѥ���ƥ�ץ졼��̾����ꤷ�ޤ����ǥե���Ȥ� common.css �Ǥ���');
define($constpref.'_CSS_URI','�⥸�塼����CSS�ե������URI');
define($constpref.'_CSS_URIDSC','�ǥե���Ȥǻ��Ѥ���CSS�ե������URI�����Хѥ��ޤ������Хѥ��ǻ��ꤷ�ޤ���<br />�ǥե���Ȥ�<{$xoops_url}>/common/css/common.css�Ǥ���');
define($constpref.'_CSSCACHETIME','CSS�Υ֥饦������å������(sec)') ;
define($constpref.'_CSSEXPORT_DIR','CSS�������ݡ�����ǥ��쥯�ȥ�') ;
define($constpref.'_CSSEXPORT_DIRDSC','��CSS�������ݡ��ȡ׵�ǽ�Υ������ݡ�����ǥ��쥯�ȥ��XOOPS�Υ��󥹥ȡ����褫��Υѥ��ǻ��ꤷ�ޤ����ޤ������Υǥ��쥯�ȥ�˽��°�������ꤷ�Ƥ��顢���Ȥ�����������<br />������ : common/css/ (�ǽ�� / �����ס��Ǹ�� / ��ɬ�פǤ�)') ;
define($constpref.'_METADATA_CASHE','META�����Υǡ�����ե����륭��å������¸����') ;
define($constpref.'_METADATA_CASHEDSC','ON�ˤ���ȡ�META���������פ��Խ������ǡ�����ե����륭��å������¸���ޤ����ʤ����ե����륭��å������¸������� XOOPS_TRUST_PATH/cache/ �ǥ��쥯�ȥ���ꡢ���°�������ꤹ��ɬ�פ�����ޤ���') ;
define($constpref.'_SCRIPTDATA_CASHE','����������ץȤΥǡ�����ե����륭��å������¸����') ;
define($constpref.'_SCRIPTDATA_CASHEDSC','ON�ˤ���ȡ�XOOPS_TRUST_PATH/cache/ �ˡ��ֳ���������ץȴ����פ��Խ������ǡ�����ե����륭��å������¸���ޤ���XOOPS_TRUST_PATH/cache/ �� DocumentRoot ���˺��ʤ����ϡ����ε�ǽ�� OFF �ˤ��뤳�Ȥ򤪴��ᤷ�ޤ���') ;

}

?>
<?php
// $Id: blocks.php,v 1.3 2008/08/08 04:36:09 ohwada Exp $

//=========================================================
// webphoto module
// 2008-04-02 K.OHWADA
//=========================================================

$constpref = strtoupper( '_BL_' . $GLOBALS['MY_DIRNAME']. '_' ) ;

// === define begin ===
if( !defined($constpref."LANG_LOADED") ) 
{

define($constpref."LANG_LOADED" , 1 ) ;

//=========================================================
// same as myalbum
//=========================================================

define($constpref."BTITLE_TOPNEW","�ǿ��β���");
define($constpref."BTITLE_TOPHIT","�ҥåȿ���¿������");
define($constpref."BTITLE_RANDOM","�ԥå����åײ���");
define($constpref."TEXT_DISP","ɽ����");
define($constpref."TEXT_STRLENGTH","����̾�κ���ɽ��ʸ����");
define($constpref."TEXT_CATLIMITATION","���ƥ������");
define($constpref."TEXT_CATLIMITRECURSIVE","���֥��ƥ�����о�");
define($constpref."TEXT_BLOCK_WIDTH","����ɽ��������");
define($constpref."TEXT_BLOCK_WIDTH_NOTES","�ʢ� ������0�ˤ�����硢����ͥ�������򤽤ΤޤޤΥ�������ɽ�����ޤ���");
define($constpref."TEXT_RANDOMCYCLE","�������ڤ��ؤ�������ñ�̤��á�");
define($constpref."TEXT_COLS","���������");

//---------------------------------------------------------
// v0.20
//---------------------------------------------------------
define($constpref."POPBOX_REVERT", "����å�����ȡ����ξ������̿��ˤʤ�");

//---------------------------------------------------------
// v0.30
//---------------------------------------------------------
define($constpref."TEXT_CACHETIME", "����å������");

// === define end ===
}

?>
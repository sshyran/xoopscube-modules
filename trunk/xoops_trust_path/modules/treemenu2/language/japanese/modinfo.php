<?php
if( defined( 'FOR_XOOPS_LANG_CHECKER' ) ) $mydirname = 'treemenu' ;
$constpref = '_MI_' . strtoupper( $mydirname ) ;

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( $constpref.'_LOADED' ) ) {
    define( $constpref.'_LOADED' , 1 ) ;

	define( $constpref."_MODULE_NAME" , "�ĥ꡼��˥塼2" );
	define( $constpref."_MODULE_DSC" , "�ĥ꡼��˥塼��֥�å�ɽ���������ȥޥåץ⥸�塼��" );

	define( $constpref."_BLOCK_NAME" , "�ĥ꡼��˥塼" );
	define( $constpref."_BLOCK_DSC" , "��˥塼�֥�å�" );
	define( $constpref."_BLOCK2_NAME" , "�����ȥޥå�" );
	define( $constpref."_BLOCK2_DSC" , "��˥塼�򥵥��ȥޥåפǥ֥�å�ɽ��" );

	define( $constpref."_VIEWTYPE_TITLE" , "�֥ĥ꡼��˥塼�ץ֥�å��Ǥ�ɽ������" );
	define( $constpref."_VIEWTYPE_DSC" , "����ɽ�� �� ��Ͽ����Ƥ���������ɽ��<br />
				�����ȥǥ��쥯�ȥ�ΰ�Ĳ��ޤ�ɽ�� �� �����ؤξ�̳��ؤ��٤ƤȲ��̣��ؤ�ɽ��<br />
				�����ȥǥ��쥯�ȥ�����ɽ�� �� ������֤�Ʊ��֥�å��򤹤٤�ɽ��<br />
				�ץ�������� �� �裲���ؤޤǤ����Ƥȡ�ɽ������Ƥ������Ƥβ��̣��ؤޤǤ�ɽ��<br />
			");
	define( $constpref."_VIEWTYPE_OPT1" , "����ɽ��" );
	define( $constpref."_VIEWTYPE_OPT2" , "�����ȥǥ��쥯�ȥ�ΰ�Ĳ��ޤ�ɽ��" );
	define( $constpref."_VIEWTYPE_OPT3" , "�����ȥǥ��쥯�ȥ�����ɽ��" );
	define( $constpref."_VIEWTYPE_OPT4" , "�ץ��������" );
	define( $constpref."_TARGETBLANK_TIT" , "�������åȥ֥��" );
	define( $constpref."_TARGETBLANK_DSC" , '������󥯤ξ�� A ������ target="_blank" ���ղä���' );
	define( $constpref."_COLUMNS_TITLE" , "�����ȥޥå�ɽ���������" );
	define( $constpref."_COLUMNS_DSC" , XOOPS_URL."/modules/$mydirname/ �ؤΥ���������������ɽ������륵���ȥޥå�" );

	// ADMIN MENU
	define( $constpref."_ADMINMENU1" , "��˥塼����" );
	define( $constpref."_ADMINMENU2" , "��˥塼ɽ������" );

	define( $constpref.'_ADMENU_MYLANGADMIN' , '�����������' );
	define( $constpref.'_ADMENU_MYTPLSADMIN' , '�ƥ�ץ졼�ȴ���' );
	define( $constpref.'_ADMENU_MYBLOCKSADMIN' , '�֥�å���������������' );
	define( $constpref.'_ADMENU_MYPREFERENCES' , 'Altsys��������' );


}
?>
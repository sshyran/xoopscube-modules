<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) ) $mydirname = 'miniamazon' ;
$constpref = '_MI_' . strtoupper( $mydirname ) ;


if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( $constpref.'_LOADED' ) ) {
  define( $constpref.'_LOADED' , 1 ) ;


	define( $constpref.'_NAME' , 'miniamazon' );
	define( $constpref.'_DESC' , '����ץ�� Amazon �⥸�塼��' );

	define( $constpref.'_CONF_ID_TITLE' , 'AMAZON ASSOCIATE ID' );
	define( $constpref.'_CONF_ID_DESC' , '');
	define( $constpref.'_CONF_PP_TITLE' , '�ڡ���������Υ����ƥ��' );
	define( $constpref.'_CONF_PP_DESC' , '�⥸�塼��ȥåס����ƥ���ɽ�� �ǻ���');
	define( $constpref.'_CONF_NS_TITLE' , '������ʬ��ɽ��ʸ����' );
	define( $constpref.'_CONF_NS_DESC' , '�⥸�塼��ȥåס����ƥ���ɽ�� �ǻ��ѡ�0 ����ꤹ������¤��ʤ��ʤ�ޤ���');
	define( $constpref.'_COM_ALLOW' , '��������������Ѥ���' );
	define( $constpref.'_COM_DIRNAME' , '���������礹�� d3forum �� dirname' );
	define( $constpref.'_COM_FORUM_ID' , '���������礹��ե��������ֹ�' );

	define( $constpref.'_BNAME_NEWITEM' , '���奢���ƥ�' );

	define( $constpref.'_ADMENU1' , '���ƥ��꡼�Խ�' );
	define( $constpref.'_ADMENU2' , '��Ƹ���' );
	define( $constpref.'_ADMENU3' , '��ǧ' );
	define( $constpref.'_ADMENU4' , '����礻' );

	if( !defined('_MD_A_MYMENU_MYTPLSADMIN') ) define( '_MD_A_MYMENU_MYTPLSADMIN' , '�ƥ�ץ졼�ȴ���' );
	if( !defined('_MD_A_MYMENU_MYBLOCKSADMIN') ) define( '_MD_A_MYMENU_MYBLOCKSADMIN' , '�֥�å���������������' );
	if( !defined('_MD_A_MYMENU_MYLANGADMIN') ) define( '_MD_A_MYMENU_MYLANGADMIN' , '�����������' );

}
?>

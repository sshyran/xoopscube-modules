<?php
if( defined( 'FOR_XOOPS_LANG_CHECKER' ) ) $mydirname = 'flatdata' ;
$constpref = '_MI_' . strtoupper( $mydirname ) ;

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( $constpref.'_LOADED' ) ) 
{
  define( $constpref.'_LOADED' , 1 ) ;

	define( $constpref .'_NAME','�ե�åȥǡ���');
	define( $constpref .'_DESC','�ʰץǡ����١����⥸�塼��');

	//block name
	define( $constpref .'_BNAME1','FLATDATA BLOCK');
	define( $constpref .'_BNAME2','FLATDATA ���ƥ���');

	//admin menu
	define( $constpref .'_ADMENU1','���ܴ���');
	define( $constpref .'_ADMENU2','���롼�׸���');
	define( $constpref .'_ADMENU_MYLANGADMIN' , '�����������' );
	define( $constpref .'_ADMENU_MYTPLSADMIN' , '�ƥ�ץ졼�ȴ���' );
	define( $constpref .'_ADMENU_MYBLOCKSADMIN' , '�֥�å���������������' );
	define( $constpref .'_ADMENU_MYPREFERENCES' , 'Altsys��������' );

	//config items
	define( $constpref .'_NUM_OF_LIST','�ڡ����������ɽ������ǡ����ο�');
	define( $constpref .'_NUM_OF_LIST_D', '');
	define( $constpref .'_EMBED_DISPPERM','��������Ⱦ���ǤΥ���٥åɻ��Ρȱ������¡ɤ�����Ԥȳ����桼���ΤߤȤ���');
	define( $constpref .'_EMBED_DISPPERM_D', '���줬�֤Ϥ��פξ�硢�⥸�塼��¦�ϥ⥸�塼������ԤΤߤα����Ȥʤ�ޤ���');
	define( $constpref .'_USE_BBCODE','BB�����ɡ��饢�����󡢲��Ԥʤɤ��Ѵ������ǡ����򥢥����󤹤�');
	define( $constpref .'_USE_BBCODE_D', '�ƥ�ץ졼�ȤǤ� {$fd.data_bb[1]} �Τ褦�����Ѥ���');
	define( $constpref .'_CAT_GROUP','XCat �����ꤷ�����ƥ��꡼���롼�פ�ID��gr_id��');
	define( $constpref .'_CAT_GROUP_D', '���ƥ�������Ѥ��������ꤷ�Ƥ���������<a href="http://xoops.trpg-labo.com/" target="_blank">XCat �⥸�塼���ɹ�� XOOPS ���漼��</a>');

}
?>
<?php
if( defined( 'FOR_XOOPS_LANG_CHECKER' ) ) $mydirname = 'coupons' ;
$constpref = '_MI_' . strtoupper( $mydirname ) ;

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( $constpref.'_LOADED' ) ) 
{
  define( $constpref.'_LOADED' , 1 ) ;

	define( $constpref .'_NAME','�����ݥ�');
	define( $constpref .'_DESC','�����ݥ����Ͽ��ɽ������⥸�塼��');

	//block name
	define( $constpref .'_BNAME1','�����ݥ�֥�å�');

	//admin menu
	define( $constpref .'_ADMENU1','���ƥ������');
	define( $constpref .'_ADMENU2','��Ƹ��´���');
	define( $constpref .'_ADMENU3','��ǧ');
	define( $constpref .'_ADMENU_MYLANGADMIN' , '�����������' );
	define( $constpref .'_ADMENU_MYTPLSADMIN' , '�ƥ�ץ졼�ȴ���' );
	define( $constpref .'_ADMENU_MYBLOCKSADMIN' , '�֥�å���������������' );
	define( $constpref .'_ADMENU_MYPREFERENCES' , 'Altsys��������' );

	//config items
	define( $constpref .'_DATE_TYPE','���դ�ɽ����ˡ');
	define( $constpref .'_DATE_TYPE_DSC', '');
	define( $constpref .'_ADDFIELD','�����ɲõ�ǽ�����Ѥ���');
	define( $constpref .'_ADDFIELDDSC', '');
	define( $constpref .'_PERPAGE','���ڡ������ɽ�����륯���ݥ�η��');
	define( $constpref .'_PERPAGEDSC', '����ɽ���ǣ��ڡ����������ɽ���������������ꤷ�Ƥ���������');
	define( $constpref .'_QRCODE','QR �����ɤΥ�������px��');
	define( $constpref .'_QRCODEDSC', 'Google Chart API �����Ѥ��� QR �����ɤ��������ޤ�������������ˤ���� QR �����ɥ饤�֥���'.XOOPS_URL.'/common/qrcode/�ˤ��������ߤޤ�');
	define( $constpref .'_CATICON_PATH','���ƥ��ꥤ�᡼���Υѥ�');
	define( $constpref .'_CATICON_PATHDESC',"���Υѥ���β��������ƥ�������ǥ��ƥ���������������Ǥ��ޤ�<br />����ͤ� modules/$mydirname/images/categories �Ǥ���");
	define( $constpref.'_COM_DIRNAME' , '���������礹�� d3forum �� dirname' );
	define( $constpref.'_COM_FORUM_ID' , '���������礹��ե��������ֹ�' );

	//notifications
	define( $constpref .'_GLOBAL_NOTIFY', '�⥸�塼������');
	define( $constpref .'_GLOBAL_NOTIFYDSC', '�����ݥ�⥸�塼�����Τˤ��������Υ��ץ����');

	define( $constpref .'_GLOBAL_NEWCOUPON_NOTIFY', '���������ݥ�Ǻ�');
	define( $constpref .'_GLOBAL_NEWCOUPON_NOTIFYCAP', '���������ݥ󤬷Ǻܤ��줿�������Τ���');
	define( $constpref .'_GLOBAL_NEWCOUPON_NOTIFYDSC', '���������ݥ󤬷Ǻܤ��줿�������Τ���');
	define( $constpref .'_GLOBAL_NEWCOUPON_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE}: ���������ݥ󤬷Ǻܤ���ޤ���');

	define( $constpref .'_GLOBAL_COUPON_DELETE_NOTIFY', '����Υꥯ������');
	define( $constpref .'_GLOBAL_COUPON_DELETE_NOTIFYCAP', '����Υꥯ�����Ȥ����ä��������Τ���');
	define( $constpref .'_GLOBAL_COUPON_DELETE_NOTIFYDSC', '����Υꥯ�����Ȥ����ä��������Τ���');
	define( $constpref .'_GLOBAL_COUPON_DELETE_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE}: ����Υꥯ�����Ȥ�����ޤ���');

}
?>
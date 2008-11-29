<?php
// $Id: modinfo.php,v 1.5 2005/12/16 14:54:35 mcleines Exp $
//  ------------------------------------------------------------------------ //
//                    xcGal 2.0 - XOOPS Gallery Modul                        //
//  ------------------------------------------------------------------------ //
//  Based on      xcGallery 1.1 RC1 - XOOPS Gallery Modul                    //
//                    Copyright (c) 2003 Derya Kiran                         //
//  ------------------------------------------------------------------------ //
//  Based on Coppermine Photo Gallery 1.10 http://coppermine.sourceforge.net///
//                      developed by Gr��ory DEMAR                           //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //
if( defined( 'FOR_XOOPS_LANG_CHECKER' ) ) $mydirname = 'd3xcgal' ;
$constpref = '_MI_' . strtoupper( $mydirname ) ;
global $xoopsConfig;	//add for line 104

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( $constpref.'_LOADED' ) ) {

define( $constpref.'_LOADED' , 1 ) ;

define($constpref."_D3XCGAL_NAME","xcGalleryD3");
define($constpref."_D3XCGAL_ADMENU1", "xcGalleryD3����");
define($constpref."_D3XCGAL_ADMENU2", "����Х५�ƥ��꡼����");
define($constpref."_D3XCGAL_ADMENU3", "�桼��������");
define($constpref."_D3XCGAL_ADMENU4", "���롼�״���");
define($constpref."_D3XCGAL_ADMENU5", "e�����ɴ���");
define($constpref."_D3XCGAL_ADMENU6", "���åץ��ɲ��������Ͽ");

define($constpref."_D3XCGAL_SCROLL","Scrolling Thumbnails");
define($constpref."_D3XCGAL_CATMENU","xcGallery Categories");
define($constpref."_D3XCGAL_STATIC","Static Thumbnails");
define($constpref."_D3XCGAL_METAALB","Meta Albums");

// configs
define($constpref."_ANONSEE", "ƿ̾�Υ桼��������Х�򸫤뤳�Ȥ��ǽ�ˤ��ޤ���");
define($constpref."_SUBCAT_LEVEL", "���ƥ��곬�ؤ�ɽ����");
define($constpref."_ALB_PER_PAGE", "����Х�ɽ����");
define($constpref."_ALB_LIST_COLS", "����Х�ꥹ�Ȥ����");
define($constpref."_ALB_THUMB_SIZE", "����ͥ���Υ����� (�ԥ�����)");
define($constpref."_MAIN_LAYOUT", "�ᥤ��ڡ����Υ���ƥ��");
define($constpref."_THUMBCOLS", "����ͥ���ڡ��������");
define($constpref."_THUMBROWS", "����ͥ���ڡ����ιԿ�");
define($constpref."_MAX_TABS", "ɽ������٤����֤κ����");
define($constpref."_TEXT_THUMBVIEW", "����ͥ���β��˼̿�������ɽ������ (�̿�̾���ɲ�)");
define($constpref."_COM_COUNT", "����ͥ���β���ɽ�����륳���ȿ�");
define($constpref."_DEF_SORT", "����ͥ���ɽ��: �̿�ɽ����Υǥե����");
define($constpref."_SORT_NA", "̾���ξ���");
define($constpref."_SORT_ND", "̾���ι߽�");
define($constpref."_SORT_DA", "���դξ���");
define($constpref."_SORT_DD", "���դι߽�");
define($constpref."_MIN_VOTES", "����ɾ���̿����ꥹ�Ȥ�ɽ�������̿��κ�����ɼ��");
define($constpref."_DIS_PICINFO", "����ͥ���β��˼̿�������ɽ������");
define($constpref."_JPG_QUAL", "JPEG�ե�������ʼ�");
define($constpref."_THUMB_WIDTH", "����ͥ���κ������ޤ��Ϲ⤵ *");
define($constpref."_MAKE_INTERM", "��ּ̿����������");
define($constpref."_PICTURE_WIDTH", "��ּ̿��κ��������Ϲ⤵ *");
define($constpref."_MAX_UPL_SIZE", "����ե����륵���� (KB)<br />���åץ��ɻ��Υե����륵��������");
define($constpref."_MAX_UPL_WIDTH", "���åץ��ɤ���Ĥ�������κ������ޤ��Ϲ⤵ (�ԥ�����)");
define($constpref."_ALLOW_PRIVATE", "�桼�������ץ饤�١��ȥ���Х����������");
define($constpref."_UF_NAME1", "���������Τ���Υ�������ե������̾ 1 (���Ѥ��ʤ����϶���)");
define($constpref."_UF_NAME2", "�ե������̾ 2");
define($constpref."_UF_NAME3", "�ե������̾ 3");
define($constpref."_UF_NAME4", "�ե������̾ 4");
define($constpref."_FORB_FNAME", "�ե�����̾�Ƕؤ���ʸ���λ���");
define($constpref."_FILE_EXT", "���åץ��ɤ���Ĥ���ե������ĥ�Ҥ���ꤹ��");
define($constpref."_THUMB_METHOD", "����������Ԥ碌��ѥå���������");
define($constpref."_THUMB_METHODDESC", "�ۤȤ�ɤ�PHP�Ķ���ɸ��Ū�����Ѳ�ǽ�ʤΤ�GD�Ǥ�����ǽŪ������ޤ�<br />��ǽ�Ǥ����ImageMagick��NetPBM�λ��Ѥ򤪴��ᤷ�ޤ�");
define($constpref."_IMPATH", "ImageMagick�ڤ�NetPBM�μ¹ԥѥ��λ���");
define($constpref."_IMPATHDESC", "convert��¸�ߤ���ǥ��쥯�ȥ��ե�ѥ��ǻ���<br />�ѥ��κǸ��'/'��ɬ�פǤ� (�㡡Linux /usr/bin/)");
define($constpref."_ALLOW_IMG_TYPES", "���ѤǤ������������ (ImageMagick�Τߤ�ͭ��)");
define($constpref."_IM_OPTIONS", "ImageMagick�Υ��ޥ�ɥ饤�󥪥ץ����");
define($constpref."_READ_EXIF", "JPEG�ե������EXIF�ǡ������ɤ߼�� (needs php exif extension)");
define($constpref."_FULLPATH", "����Х�ǥ��쥯�ȥ�λ��� *");
define($constpref."_USERPICS", "�桼�����ǥ��쥯�ȥ�λ��� *");
define($constpref."_NORMAL_PFX", "��ּ̿�����Ƭ�� *");
define($constpref."_THUMB_PFX", "����ͥ������Ƭ�� *");
define($constpref."_DIR_MODE", "�ǥ��쥯�ȥ�Υǥե���ȡ��ѡ��ߥå����⡼��");
define($constpref."_PIC_MODE", "�̿��Υǥե���ȡ��ѡ��ߥå����⡼��");
define($constpref."_COOKIE_NAME", "������ץȤǻ��Ѥ��륯�å���̾");
define($constpref."_COOKIE_PATH", "������ץȤǻ��Ѥ��륯�å�������¸��");
define($constpref."_DEBUG_MODE", "�ǥѥå��⡼�ɤ�ͭ���ˤ���");
define($constpref."_ECRAD_SEE_MORE", "e�����ɤΡ֤�ä�¿���μ̿��򸫤�ץ������åȥ��ɥ쥹");
define($constpref."_ECRAD_TYPE", "�����ɥ����פ�����");
define($constpref."_TEXT_CARD", "Text");
define($constpref."_HTML_CARD", "Html");
define($constpref."_ECRAD_PER_HOUR", "�桼���������٤����뤳�Ȥ��Ǥ���e������������");
define($constpref."_ECRAD_SAVE", "�ǡ����١�������¸����e�����ɡʻ��ֻ����");
define($constpref."_ECRAD_TEXT","Ecard�ƥ�����");
define($constpref."_ECRAD_TEXTDESC","(ecard�ˤĤ���ƥ����Ȥ򵭽�)<br /><b>Useful Tags</b><br />{X_SITEURL} �ϡ�".XOOPS_URL."�פ�ɽ��<br />{X_SITENAME} �ϡ�".$xoopsConfig['sitename']."�פ�ɽ��<br />{R_NAME} �ϼ����Ԥ�̾����ɽ��<br />{R_MAIL} �����Ԥ�email���ɥ쥹��ɽ��<br />{S_NAME} �����Ԥ�̾����ɽ��<br />{S_MAIL} �����Ԥ�email���ɥ쥹��ɽ��<br />{SAVE_DAYS} ecard��DB����¸����������ɽ��<br />{CARD_LINK} ecard��pick-up����url��ɽ��");
define($constpref."_ECRAD_TEXTVALUE","����ˤ��� {R_NAME}����\n\n{S_NAME}({S_MAIL}) ���󤫤餢�ʤ��ؤ�ecard���Ϥ��Ƥ���ޤ���\n���Υ���褫��ecard��pick-up���Ƥ������� ({CARD_LINK})��\n���ʤ���ecard�� {SAVE_DAYS} ���֥ǡ����١������ݴɤ���ޤ���\n\nregards\n{X_SITENAME} team ({X_SITEURL})");
define($constpref."_KEEP_VOTES", "�桼������ɼ��ǡ����١�������¸��������");
define($constpref."_SEARCH_THUMB", "userinfo�ڡ�����xcGallery�������������˥���ͥ����ɽ��");
define($constpref."_WATERMARKING", "Watermark�λ���");
define($constpref."_WATERMARK_TEXTDESC", "Watermark�� (�⥸�塼��̾)/images/watermark.png ����¸����ɬ�פ�����ޤ���");
define($constpref."_BATCHSHOWALL", "�Хå����åץ��� - ����ɽ��");
define($constpref."_BATCHSHOWALLDESC", "���˥���Х�ˤ���ե������ޤ�����ƤΥե������ɽ�����ޤ����֤������פξ��Ͽ������ե�����Τ�ɽ�����ޤ���");
define($constpref.'_CSS_URI','�⥸�塼����CSS��URI');
define($constpref.'_CSS_URIDSC','���Υ⥸�塼�����Ѥ�CSS�ե������URI�����Хѥ��ޤ������Хѥ��ǻ��ꤷ�ޤ����ǥե���Ȥ� {mod_url}/index.php?page=main_css �Ǥ���');

// admin menu
define($constpref.'_ADMENU_MYLANGADMIN' , '�����������' ) ;
define($constpref.'_ADMENU_MYTPLSADMIN' , '�ƥ�ץ졼�ȴ���' ) ;
define($constpref.'_ADMENU_MYBLOCKSADMIN' , '�֥�å�����/������������' ) ;
define($constpref.'_ADMENU_MYPREFERENCES' , '��������' ) ;

}

?>
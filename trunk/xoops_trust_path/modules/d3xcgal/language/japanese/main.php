<?php
// $Id: main.php,v 1.4 2005/09/22 08:08:02 mcleines Exp $
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
// shortcuts for Byte, Kilo, Mega
define("_MD_D3XCGAL_BYTES","�Х���");
define("_MD_D3XCGAL_KB","KB");
define("_MD_D3XCGAL_MB","MB");

define("_MD_D3XCGAL_NPICS","�ե������:%s");
define("_MD_D3XCGAL_PICS","�̿�");
define("_MD_D3XCGAL_ALBUM","����Х�");
define("_MD_D3XCGAL_ERROR","���");
define("_MD_D3XCGAL_KEYS","�������");
define("_MD_D3XCGAL_CONTINUE","³����");

define("_MD_D3XCGAL_RANDOM","������ե�����");
define("_MD_D3XCGAL_LASTUP","����̿�");
define("_MD_D3XCGAL_LASTCOM","�ǿ�������");
define("_MD_D3XCGAL_TOPN","��͵��̿�");
define("_MD_D3XCGAL_TOPRATED","��ɾ���̿�");
define("_MD_D3XCGAL_LASTHITS","�ǿ��ҥå�");
define("_MD_D3XCGAL_SEARCH","����");
define("_MD_D3XCGAL_USEARCH","����ͥ������ ");
define("_MD_D3XCGAL_MOST_SENT","�������줿e������");

define("_MD_D3XCGAL_ACCESS_DENIED","���Υڡ������Ф��륢��������������ޤ���");
define("_MD_D3XCGAL_PERM_DENIED","��������Ԥ����¤�����ޤ���");
define("_MD_D3XCGAL_PARAM_MISSING","ɬ�פʥѥ�᡼��̵���ǥ�����ץȤ��¹Ԥ���ޤ�����");
define("_MD_D3XCGAL_NON_EXIST_AP","���򤵤줿����Х�/�̿���¸�ߤ��ޤ���");
define("_MD_D3XCGAL_QUOTA_EXCEEDED","�ǥ����������̥����С�<br /><br />���ʤ������ѤǤ���ǥ��������̤� [quota]K�Ǥ������� [space]K����Ѥ��Ƥ��ޤ������Υե�������ɲä���ȥǥ��������̤򥪡��С����ޤ���");
define("_MD_D3XCGAL_GD_FILE_TYPE_ERR","GD���᡼���饤�֥�꡼����Ѥ����硢JPEG��PNG�����Υե�����Τ߻��Ѳ�ǽ�Ǥ���");
define("_MD_D3XCGAL_INVALID_IMG","���ʤ������åץ��ɤ������᡼������»��������GD�饤�֥�꡼�ǽ������뤳�Ȥ��Ǥ��ޤ���");
define("_MD_D3XCGAL_RESIZE_FAILED","���᡼�������������������ᡢ����ͥ��������Ǥ��ޤ���");
define("_MD_D3XCGAL_NO_IMG_TO_DISPLAY","ɽ�����륤�᡼���Ϥ���ޤ���");
define("_MD_D3XCGAL_NO_EXIST_CAT","���򤷤����ƥ����¸�ߤ��ޤ���");
define("_MD_D3XCGAL_ORPHAN_CAT","¸�ߤ��ʤ��ƥ��ƥ������äƤ��ޤ������ƥ���ޥ͡����㡼��Ȥä�������褷�Ƥ�������!");
define("_MD_D3XCGAL_DIRECTORY_RO","�ǥ��쥯�ȥ�� %s �פ˽���߸�������ޤ��󡣥ե�����κ���ϤǤ��ޤ���");
define("_MD_D3XCGAL_PIC_IN_INVALID_ALBUM","¸�ߤ��ʤ�����Х�(%s)��˥ե����뤬����ޤ� !?");
define("_MD_D3XCGAL_GD_VERSION_ERR","���ʤ��Υ����С��������PHP��GD�С������2.x��ٱ礷�ޤ���config�ڡ�����GD�С������1.x���ѹ����Ƥ�������");
define("_MD_D3XCGAL_NO_GD_FOUND","PHP�����ʤ��Υ����С���Ǽ¹ԤǤ���GD���᡼���饤�֥�꡼�ϥ��ݡ��Ȥ���Ƥ��ޤ���ImageMagick�ޤ���Netpbm�Υ��󥹥ȡ����侩���ޤ���");
define("_MD_D3XCGAL_IM_ERROR","ImageMagick-�֤���-��¹Ԥ��륨�顼");
define("_MD_D3XCGAL_IM_ERROR_CMD","���ޥ�ɥ饤��");
define("_MD_D3XCGAL_IM_ERROR_CONV","The convert program said");

// ------------------------------------------------------------------------- //
// File include/theme_func.php
// ------------------------------------------------------------------------- //
define("_MD_D3XCGAL_THM_ALB_LT","����Х�ꥹ�Ȥذ�ư");
define("_MD_D3XCGAL_THM_ALB_LL","����Х�ꥹ��");
define("_MD_D3XCGAL_THM_GAL_MYT","�ѡ����ʥ륮���꡼�ذ�ư");
define("_MD_D3XCGAL_THM_GAL_MYL","�ޥ������꡼");
define("_MD_D3XCGAL_THM_ADM_MT","�����ԥ⡼�ɤ��ѹ�");
define("_MD_D3XCGAL_THM_ADM_ML","�����ԥ⡼��");
define("_MD_D3XCGAL_THM_USER_MT","�桼���⡼�ɤ��ѹ�");
define("_MD_D3XCGAL_THM_USER_ML","�桼���⡼��");
define("_MD_D3XCGAL_THM_UPLT","����Х�˥ե�����򥢥åץ���");
define("_MD_D3XCGAL_THM_UPLL","�ե�����Υ��åץ���");
define("_MD_D3XCGAL_THM_UPLTMORE","����Х��ʣ���ե�����򥢥åץ���");
define("_MD_D3XCGAL_THM_UPLLMORE","ʣ���ե�����Υ��åץ���");
define("_MD_D3XCGAL_THM_UPLTBATCH","�ǥ��쥯�ȥ꤫��ե�����ΰ����Ͽ");
define("_MD_D3XCGAL_THM_UPLLBATCH","�ե�����ΰ����Ͽ");
define("_MD_D3XCGAL_THM_LAST_UPL","�ǿ����åץ���");
define("_MD_D3XCGAL_THM_LAST_COM","�ǿ�������");
define("_MD_D3XCGAL_THM_MOST_VIEW","��͵��̿�");
define("_MD_D3XCGAL_THM_TOP_RATE","��ɾ���̿�");
define("_MD_D3XCGAL_THM_SEARCH","����");
define("_MD_D3XCGAL_THM_UPL_APPR","���åץ��ɤξ�ǧ");

define("_MD_D3XCGAL_THM_ALBMGR_LNK","�ޥ�����Х�κ���/����");
define("_MD_D3XCGAL_THM_MODIFY_LNK","�ޥ�����Х�ν���");
define("_MD_D3XCGAL_THM_CAT","���ƥ���");
define("_MD_D3XCGAL_THM_ALB","����Х�");
define("_MD_D3XCGAL_THM_PIC","�ե�����");
define("_MD_D3XCGAL_THM_ALBONPAGE","����Х�� %d / %d�ڡ�����");
define("_MD_D3XCGAL_THM_DATE","����");
define("_MD_D3XCGAL_THM_NAME","�ե�����̾");
define("_MD_D3XCGAL_THM_SORT_DA","���դξ�����¤��ؤ�");
define("_MD_D3XCGAL_THM_SORT_DD","���դι߽���¤��ؤ�");
define("_MD_D3XCGAL_THM_SORT_NA","�ե�����̾�ξ�����¤��ؤ�");
define("_MD_D3XCGAL_THM_SORT_ND","�ե�����̾�ι߽���¤��ؤ�");
define("_MD_D3XCGAL_THM_PICPAGE","�ե������ %d / %d�ڡ�����");
define("_MD_D3XCGAL_THM_USERPAGE","�桼���� %d / %d�ڡ�����");

// ------------------------------------------------------------------------- //
// File include/functions.inc.php
// ------------------------------------------------------------------------- //

define("_MD_D3XCGAL_FUNC_FNAME","�ե�����̾ : ");
define("_MD_D3XCGAL_FUNC_FSIZE","�ե����륵����: ");
define("_MD_D3XCGAL_FUNC_DIM","�礭�� : ");
define("_MD_D3XCGAL_FUNC_DATE","��Ͽ�� : ");
define("_MD_D3XCGAL_FUNC_COM","�����ȿ� %s");
define("_MD_D3XCGAL_FUNC_VIEW","�ҥåȿ� %s");
define("_MD_D3XCGAL_FUNC_VOTE","��ɼ�� %s");
define("_MD_D3XCGAL_FUNC_SEND","%s times");
define("_MD_D3XCGAL_FUNC_DELUSER","Deleted User");
// ------------------------------------------------------------------------- //
// File admin.php
// ------------------------------------------------------------------------- //
define("_MD_D3XCGAL_ADMIN_LEAVE","�����ԥ⡼�ɤ�λ�� ...");
define("_MD_D3XCGAL_ADMIN_ENTER","�����ԥ⡼�ɤ˰ܹ��� ...");

// ------------------------------------------------------------------------- //
// File albmgr.php
// ------------------------------------------------------------------------- //

define("_MD_D3XCGAL_ALBMGR_NEED_NAME","����Х�ˤϥ���Х�̾��ɬ�פǤ� !");
define("_MD_D3XCGAL_ALBMGR_CONF_MOD","�����˹������Ƥ⵹�����Ǥ��� ?");
define("_MD_D3XCGAL_ALBMGR_NO_CHANGE","�����ѹ�����Ƥ��ޤ��� !");
define("_MD_D3XCGAL_ALBMGR_NEW_ALB","����������Х�");
define("_MD_D3XCGAL_ALBMGR_CONF_DEL1","�����ˤ��μ̿��������Ƥ������Ǥ���?");
define("_MD_D3XCGAL_ALBMGR_CONF_DEL2","����Х�˴ޤޤ�����Ƥμ̿��ȥ����ȤϺ������ޤ� !");
define("_MD_D3XCGAL_ALBMGR_SELECT_FIRST","�ǽ�˥���Х�����򤷤Ƥ���������");
define("_MD_D3XCGAL_ALBMGR_ALB_MGR","����Х����");
define("_MD_D3XCGAL_ALBMGR_MY_GAL","* �ޥ������꡼ *");
define("_MD_D3XCGAL_ALBMGR_NO_CAT","* ���ƥ���̵�� *");
define("_MD_D3XCGAL_ALBMGR_DEL","���");
define("_MD_D3XCGAL_ALBMGR_NEW","��������");
define("_MD_D3XCGAL_ALBMGR_APPLY","������Ŭ��");
define("_MD_D3XCGAL_ALBMGR_SELECT","���ƥ�������");

// ------------------------------------------------------------------------- //
// File db_input.php
// ------------------------------------------------------------------------- //

define("_MD_D3XCGAL_DB_ALB_NEED_TITLE","����Х�̾�����Ϥ��Ƥ������� !");
define("_MD_D3XCGAL_DB_NO_NEED","������ɬ�פ���ޤ���");
define("_MD_D3XCGAL_DB_ALB_UPDATED","����Хब��������ޤ�����");
define("_MD_D3XCGAL_DB_UNKOWN","���򤷤�����Хब¸�ߤ��ʤ������Ϥ��Υ���Х�˥��åץ��ɤ��븢�¤�����ޤ���");
define("_MD_D3XCGAL_DB_NO_PICUP","�̿��ϥ��åץ��ɤ���ޤ���Ǥ��� !<br /><br />���åץ��ɤ���̿������������򤷤���硢�����Ф�</br>�ե�����Υ��åץ��ɤ���Ĥ��Ƥ��뤫��ǧ���Ƥ������� ...");
define("_MD_D3XCGAL_DB_ERR_MKDIR","�ǥ��쥯�ȥ� %s �κ����˼��Ԥ��ޤ��� !");
define("_MD_D3XCGAL_DB_DEST_DIR_RO","�оݥǥ��쥯�ȥ� %s �ϥ�����ץȤˤ�����ߤ�����ޤ��� !");
define("_MD_D3XCGAL_DB_ERR_FEXT","���γ�ĥ�ҤΥե�����Τ߻��ѤǤ��ޤ� : <br /><br />%s.");
define("_MD_D3XCGAL_DB_ERR_MOVE","Impossible to move %s to %s!");
define("_MD_D3XCGAL_DB_ERR_PIC_SIZE","���ʤ������åץ��ɤ����̿��Υ��������礭�᤮�ޤ� (���祵������ %s x %s�Ǥ�");
define("_MD_D3XCGAL_DB_ERR_FSIZE","���ʤ������åץ��ɤ����ե�����Υ��������礭�᤮�ޤ� (���祵������ %s KB�Ǥ�) !");
define("_MD_D3XCGAL_DB_ERR_IMG_INVALID","���ʤ������åץ��ɤ����ե������ͭ���ʲ����ǤϤ���ޤ��� !");
define("_MD_D3XCGAL_DB_IMG_ALLOWED"," %s �β����Τߥ��åץ��ɽ���ޤ���");
define("_MD_D3XCGAL_DB_ERR_INSERT","�̿� '%s' �ϥ���Х����Ͽ�Ǥ��ޤ��� ");
define("_MD_D3XCGAL_DB_UPLOAD_SUCC","���ʤ��μ̿�������˥��åץ��ɤ���ޤ���<br /><br />�����Ԥξ�ǧ���ɽ������ޤ���");
define("_MD_D3XCGAL_DB_UPL_SUCC","���ʤ��μ̿����������Ͽ����ޤ�����");
// ------------------------------------------------------------------------- //
// File delete.php
// ------------------------------------------------------------------------- //
define("_MD_D3XCGAL_DEL_CAPTION","����ץ����");
define("_MD_D3XCGAL_DEL_FS_PIC","�ե륵�������᡼��");
define("_MD_D3XCGAL_DEL_DEL_SUCCESS","�������");
define("_MD_D3XCGAL_DEL_NS_PIC","�Ρ��ޥ륵�������᡼��");
define("_MD_D3XCGAL_DEL_ERR_DEL","����Բ�");
define("_MD_D3XCGAL_DEL_THUMB","����ͥ���");
define("_MD_D3XCGAL_DEL_COMMENT","������");
define("_MD_D3XCGAL_DEL_IMGALB","����Х���Υ��᡼��");
define("_MD_D3XCGAL_DEL_ALB_DEL_SUC","����Х�� %s �פ��������ޤ�����");
define("_MD_D3XCGAL_DEL_ALBMGR","����Х�ޥ͡����㡼");
define("_MD_D3XCGAL_DEL_INVALID","�� %s �פ������ʥǡ�����ȯ�����ޤ�����");
define("_MD_D3XCGAL_DEL_CREATE","����Х�� %s �פκ�����");
define("_MD_D3XCGAL_DEL_UPDATE","����Х�� %s �� ����Х�̾�� %s �� ����ǥå����� %s �פ򹹿����Ƥ��ޤ���");
define("_MD_D3XCGAL_DEL_DELPIC","�ե�����κ��");
define("_MD_D3XCGAL_DEL_DELALB","����Х�κ��");

// ------------------------------------------------------------------------- //
// File displayimage.php
// ------------------------------------------------------------------------- //
define("_MD_D3XCGAL_DIS_CONF_DEL","�����ˤ��Υե�����������Ƥ������Ǥ��� ? p}nƱ���˥����Ȥ�������ޤ���");
define("_MD_D3XCGAL_DIS_DEL_PIC","���μ̿�����");
define("_MD_D3XCGAL_DIS_SIZE","%s x %s �ԥ�����");
define("_MD_D3XCGAL_DIS_VIEWS","%s ��");
define("_MD_D3XCGAL_DIS_SLIDE","���饤�ɥ��硼");
define("_MD_D3XCGAL_DIS_STOP_SLIDE","���饤�ɥ��硼�����");
define("_MD_D3XCGAL_DIS_FULL","����å��ǥե륵�����β�����ɽ��");
define("_MD_D3XCGAL_DIS_TITLE","�ե��������");
define("_MD_D3XCGAL_DIS_FNAME","�ե�����̾");
define("_MD_D3XCGAL_DIS_ANAME","����Х�̾");
define("_MD_D3XCGAL_DIS_RATING","�졼�ƥ��� (��ɼ�� %s ��)");
define("_MD_D3XCGAL_DIS_FSIZE","�ե����륵����");
define("_MD_D3XCGAL_DIS_DIMEMS","�ǥ���󥷥��");
define("_MD_D3XCGAL_DIS_DISPLAYED","ɽ��");
define("_MD_D3XCGAL_DIS_CAMERA","�����");
define("_MD_D3XCGAL_DIS_DATA_TAKEN","��������");
define("_MD_D3XCGAL_DIS_APERTURE","���");
define("_MD_D3XCGAL_DIS_EXPTIME","Ϫ�л���");
define("_MD_D3XCGAL_DIS_FLENGTH","������Υ");
define("_MD_D3XCGAL_DIS_COMMENT","������");
define("_MD_D3XCGAL_DIS_BACK_TNPAGE","����ͥ���ڡ��������");
define("_MD_D3XCGAL_DIS_SHOW_PIC_INFO","�ե���������ɽ��/��ɽ��");
define("_MD_D3XCGAL_DIS_SEND_CARD","���μ̿���e�����ɤȤ�����������");
define("_MD_D3XCGAL_DIS_CARD_DISABLE","e�����ɤ�̵��");
define("_MD_D3XCGAL_DIS_CARD_DISABLEMSG","e�����ɤ������Ǥ��ޤ���");
define("_MD_D3XCGAL_DIS_NEXT","����");
define("_MD_D3XCGAL_DIS_PREV","����");
define("_MD_D3XCGAL_DIS_PICPOS","����Х� %s/%s");
define("_MD_D3XCGAL_DIS_RATE_THIS","���Υե������ɾ������");
define("_MD_D3XCGAL_DIS_NO_VOTE","( ̤��ɼ )");
define("_MD_D3XCGAL_DIS_RATINGCUR","( ���ߤΥ졼�ƥ���: %s/5&nbsp;&nbsp;&nbsp;��ɼ�� %s�� )");
define("_MD_D3XCGAL_DIS_RUBBISH","��");
define("_MD_D3XCGAL_DIS_POOR","����");
define("_MD_D3XCGAL_DIS_FAIR","����");
define("_MD_D3XCGAL_DIS_GOOD","�ɤ�");
define("_MD_D3XCGAL_DIS_EXCELLENT","�����餷��");
define("_MD_D3XCGAL_DIS_GREAT","����");
define("_MD_D3XCGAL_DIS_UPLOADER","������");
define("_MD_D3XCGAL_DIS_EXIF_ERR","PHP running on your server does not support reading EXIF data in JPEG files, please turn this off on the general configuration page.");
define("_MD_D3XCGAL_DIS_VIEW_MORE_BY","�����Ԥ�¾�β����򸫤�");
define("_MD_D3XCGAL_DIS_SUBIP","������ IP���ɥ쥹");
define("_MD_D3XCGAL_DIS_SENT","e������������");
// ------------------------------------------------------------------------- //
// File ecard.php
// ------------------------------------------------------------------------- //

define("_MD_D3XCGAL_CARD_TITLE","e�����ɤ�����");
define("_MD_D3XCGAL_CARD_INVALIDE_EMAIL","<b>�ٹ�</b> : �᡼�륢�ɥ쥹������������ޤ��� !");
define("_MD_D3XCGAL_CARD_ECARD_TITLE","%s ��e������");
define("_MD_D3XCGAL_CARD_VIEW_ECARD","e�����ɤ������ɽ������ʤ����ϡ����Υ�󥯤򥯥�å����Ƥ���������");
define("_MD_D3XCGAL_CARD_VIEW_MORE_PICS","��äȼ̿��򸫤���ϡ����Υ�󥯤򥯥�å����Ƥ������� !");
define("_MD_D3XCGAL_CARD_SEND_SUCCESS","e�����ɤ���������ޤ�����");
define("_MD_D3XCGAL_CARD_SEND_FAILED","�������������ޤ���e�����ɤ���������ޤ���Ǥ��� ...");
define("_MD_D3XCGAL_CARD_FROM","From");
define("_MD_D3XCGAL_CARD_YOUR_NAME","̾��");
define("_MD_D3XCGAL_CARD_YOUR_EMAIL","�᡼�륢�ɥ쥹");
define("_MD_D3XCGAL_CARD_TO","To");
define("_MD_D3XCGAL_CARD_RCPT_NAME","����ͤ�̾��");
define("_MD_D3XCGAL_CARD_RCPT_EMAIL","����ͤΥ᡼�륢�ɥ쥹");
define("_MD_D3XCGAL_CARD_GREETINGS","��������");
define("_MD_D3XCGAL_CARD_MESSAGE","��å�����");
define("_MD_D3XCGAL_CARD_PERHOUR","%s �ˤ��IP���ɥ쥹 %s ��� %s ( �����꡼���� ) ����������ޤ�����");
define("_MD_D3XCGAL_CARD_NOTINDB","e�����ɥǡ�����ǡ����١�������¸�Ǥ��ޤ���<br />�����Ԥ˳�ǧ���Ʋ�����");


// ------------------------------------------------------------------------- //
// File editpics.php
// ------------------------------------------------------------------------- //

define("_MD_D3XCGAL_EDITPICS_PIC_INFO","�̿�����");
define("_MD_D3XCGAL_EDITPICS_TITLE","�̿�̾");
define("_MD_D3XCGAL_EDITPICS_DESC","����");
define("_MD_D3XCGAL_EDITPICS_INFOSTR","%sx%s - %s KB - �ҥåȲ�� %s - ��ɼ��� %s");
define("_MD_D3XCGAL_EDITPICS_APPROVE","�ե�����ξ�ǧ");
define("_MD_D3XCGAL_EDITPICS_PP_APPROVE","��ǧ�α��");
define("_MD_D3XCGAL_EDITPICS_DEL_PIC","�ե�����κ��");
define("_MD_D3XCGAL_EDITPICS_RVIEW","�ҥåȥ����󥿤Υꥻ�å�");
define("_MD_D3XCGAL_EDITPICS_RVOTES","��ɼ��ꥻ�å�");
define("_MD_D3XCGAL_EDITPICS_DCOM","�����Ȥκ��");
define("_MD_D3XCGAL_EDITPICS_UPL_APPROVAL","���åץ��ɾ�ǧ");
define("_MD_D3XCGAL_EDITPICS_EDIT","�ե�������Խ�");
define("_MD_D3XCGAL_EDITPICS_NEXT","����");
define("_MD_D3XCGAL_EDITPICS_PREV","����");
define("_MD_D3XCGAL_EDITPICS_NUMDIS","�ե�����ɽ����");
define("_MD_D3XCGAL_EDITPICS_APPLY","������Ŭ��");

// ------------------------------------------------------------------------- //
// File index.php
// ------------------------------------------------------------------------- //

define("_MD_D3XCGAL_INDEX_CONF_DEL","�����ˤ��Υ���Х�������Ƥ⵹�����Ǥ��� ? Ʊ�������Ƥμ̿��ȥ����ȤϺ������ޤ���");
define("_MD_D3XCGAL_INDEX_DEL","���");
define("_MD_D3XCGAL_INDEX_MOD","�ץ�ѥƥ�");
define("_MD_D3XCGAL_INDEX_EDIT","�̿����Խ�");
define("_MD_D3XCGAL_INDEX_STAT1","���ƥ����:<b>[cat]</b>&nbsp;&nbsp;&nbsp;����Х��:<b>[albums]</b>&nbsp;&nbsp;&nbsp;�̿����:<b>[pictures]</b>&nbsp;&nbsp;&nbsp;�����ȿ�:<b>[comments]</b>&nbsp;&nbsp;&nbsp;�ҥåȲ��:<b>[views]</b>");
define("_MD_D3XCGAL_INDEX_STAT2","����Х��:<b>[albums]</b>&nbsp;&nbsp;&nbsp;�̿����:<b>[pictures]</b>&nbsp;&nbsp;&nbsp;�ҥåȲ��:<b>[views]</b>");
define("_MD_D3XCGAL_INDEX_USERS_GAL","%s�Υ����꡼");
define("_MD_D3XCGAL_INDEX_STAT3","����Х��:<b>[albums]</b>&nbsp;&nbsp;&nbsp;�̿����:<b>[pictures]</b>&nbsp;&nbsp;&nbsp;�����ȿ�:<b>[comments]</b>&nbsp;&nbsp;&nbsp;�ҥåȲ��:<b>[views]</b>");
define("_MD_D3XCGAL_INDEX_ULIST","�桼���ꥹ��");
define("_MD_D3XCGAL_INDEX_NO_UGAL","�桼�������꡼�Ϥ���ޤ���");
define("_MD_D3XCGAL_INDEX_NALBS","����Х�� %s");
define("_MD_D3XCGAL_INDEX_NPICS","�ե������ %s");
define("_MD_D3XCGAL_INDEX_LASTADD","���ǽ��ɲ���:%s");

//--------------------------------------------------------------------------//
// File modifyalb.php
// ------------------------------------------------------------------------- //
define("_MD_D3XCGAL_MODIFYALB_UPD_ALB_N","����Х�ι��� %s");
define("_MD_D3XCGAL_MODIFYALB_GEN_SET","��������");
define("_MD_D3XCGAL_MODIFYALB_ALB_TITLE","����Х�̾");
define("_MD_D3XCGAL_MODIFYALB_ALB_CAT","���ƥ���");
define("_MD_D3XCGAL_MODIFYALB_ALB_DESC","����");
define("_MD_D3XCGAL_MODIFYALB_ALB_THUMB","����ͥ���");
define("_MD_D3XCGAL_MODIFYALB_ALB_PERM","���Υ���Х���Ф���ѡ��ߥå����");
define("_MD_D3XCGAL_MODIFYALB_CAN_VIEW","����Х�ɽ����ǽ");
define("_MD_D3XCGAL_MODIFYALB_CAN_UPLOAD","�ӥ������ϼ̿��򥢥åץ��ɽ����");
define("_MD_D3XCGAL_MODIFYALB_CAN_COM","�ӥ������ϥ����Ȥ���ƤǤ���");
define("_MD_D3XCGAL_MODIFYALB_CAN_RATE","�ӥ������ϼ̿���ɾ�������");
define("_MD_D3XCGAL_MODIFYALB_USER_GAL","�桼�������꡼");
define("_MD_D3XCGAL_MODIFYALB_NO_CAT","* ���ƥ��꡼̵�� *");
define("_MD_D3XCGAL_MODIFYALB_ALB_EMPTY","����Х�ˤϲ������äƤ��ޤ���");
define("_MD_D3XCGAL_MODIFYALB_LAST_UPL","�ǿ����åץ���");
define("_MD_D3XCGAL_MODIFYALB_PUB_ALB","���� (�ѥ֥�å�����Х�)");
define("_MD_D3XCGAL_MODIFYALB_ME_ONLY","��Τ�");
define("_MD_D3XCGAL_MODIFYALB_OWNER_ONLY","����Х�ν�ͭ�� (%s) �Τ�");
define("_MD_D3XCGAL_MODIFYALB_GROUP_ONLY"," '%s' ���롼�ץ��С��Τ�");
define("_MD_D3XCGAL_MODIFYALB_ERR_NO_ALB","�����Ǥ��륢��Хब�ǡ����١����ˤ���ޤ���");
define("_MD_D3XCGAL_MODIFYALB_UPDATE","����Х�ι���");

// ------------------------------------------------------------------------- //
// File ratepic.php
// ------------------------------------------------------------------------- //
define("_MD_D3XCGAL_RATE_ALREADY","�������������ޤ��󡢤��ʤ��ϴ��ˤ��Υե������ɾ�����Ƥ��ޤ���");
define("_MD_D3XCGAL_RATE_OK","���ʤ�����ɼ�ϼ�������ޤ�����");

// ------------------------------------------------------------------------- //
// File search.php - OK
// ------------------------------------------------------------------------- //
define("_MD_D3XCGAL_SEARCH_TITLE","�̿��θ���");

// ------------------------------------------------------------------------- //
// File upload.php
// ------------------------------------------------------------------------- //
define("_MD_D3XCGAL_UPL_TITLE","�ե�����Υ��åץ���");
define("_MD_D3XCGAL_UPL_MAX_FSIZE","���åץ��ɲ�ǽ�ʺ���ե����륵������ %s KB�Ǥ���");
define("_MD_D3XCGAL_UPL_ALBUM","����Х�");
define("_MD_D3XCGAL_UPL_PICTURE","�ե�����");
define("_MD_D3XCGAL_UPL_PIC_TITLE","�ե�����̾");
define("_MD_D3XCGAL_UPL_DESCRIPTION","�ե����������");
define("_MD_D3XCGAL_UPL_KEYWORDS","������� (Ⱦ�ѥ��ڡ����Ƕ��ڤ�)");
define("_MD_D3XCGAL_UPL_ERR_NO_ALB_UPLOAD","�������������ޤ��󡣤��ʤ����ե�����򥢥åץ��ɵ��Ĥ���Ƥ��륢��Х�Ϥ���ޤ���");
define("_MD_D3XCGAL_UPL_YOURALB","�ץ饤�١��ȥ���Х�");
define("_MD_D3XCGAL_UPL_ALBPUB","�ѥ֥�å�����Х�");
define("_MD_D3XCGAL_UPL_OUSERALB","Other User Albums");



?>
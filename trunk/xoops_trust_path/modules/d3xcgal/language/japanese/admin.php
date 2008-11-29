<?php
// $Id: admin.php,v 1.2 2005/09/01 13:58:33 mcleines Exp $
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
define("_AM_D3XCGAL_CONFIG","xcGalleryD3 ����");
define("_AM_D3XCGAL_GENERALCONF","��������");
define("_AM_D3XCGAL_CATMNGR","���ƥ��꡼����");
define("_AM_D3XCGAL_USERMNGR","�桼��������");
define("_AM_D3XCGAL_GROUPMNGR","���롼�״���");
define("_AM_D3XCGAL_BATCHADD","���åץ��ɲ����ΰ����Ͽ");
define("_AM_D3XCGAL_ECARDMNGR","e�����ɴ���");
define("_AM_D3XCGAL_PICAPP","��ǧ�Ԥ�����");

define("_AM_D3XCGAL_PARAM_MISSING","������ץȤ��׵ᤵ�줿�ѥ�᡼����(s)�ʤ��ǸƤӤ�����ޤ�����");


// ------------------------------------------------------------------------- //
// File usermgr.php
// ------------------------------------------------------------------------- //
define("_AM_D3XCGAL_USERMGR_TITLE","xcGallery�桼���δ���");
define("_AM_D3XCGAL_USERMGR_USHOW","����Х�/�����桼������ɽ��");
define("_AM_D3XCGAL_USERMGR_USHOWDEL","���٤Ƥκ�����줿�桼���Υ���Х��ɽ�����ޤ�");
define("_AM_D3XCGAL_USERMGR_ULIST","�桼�����ꥹ��");
define("_AM_D3XCGAL_USERMGR_USER","�桼����");
define("_AM_D3XCGAL_USERMGR_ALBUMS","����Х�");
define("_AM_D3XCGAL_USERMGR_PICS","�̿�");
define("_AM_D3XCGAL_USERMGR_QUOTA","�Ѥ����Ƥ���������");
define("_AM_D3XCGAL_USERMGR_ALB","����Х�");
define("_AM_D3XCGAL_USERMGR_DELUID","�ǥ饦�������桼��id");
define("_AM_D3XCGAL_USERMGR_OPT","���");
define("_AM_D3XCGAL_USERMGR_NOTMOVE","** ��ư���ޤ��� **");
define("_AM_D3XCGAL_USERMGR_DEL","���");
define("_AM_D3XCGAL_USERMGR_PROPS","�ץ�ѥƥ�");
define("_AM_D3XCGAL_USERMGR_EDITP","�ե�������Խ�");

define("_AM_D3XCGAL_USERMGR_UONPAGE","�桼���� %d / %d�ڡ�����");
define("_AM_D3XCGAL_USERMGR_NOUSER","���򤷤��桼����¸�ߤ��ޤ��� !");

// ------------------------------------------------------------------------- //
// File searchnew.php
// ------------------------------------------------------------------------- //
define("_AM_D3XCGAL_SRCHNEW_TITLE","�������ե�����θ���");
define("_AM_D3XCGAL_SRCHNEW_SEL_DIR","�ǥ��쥯�ȥ�����");
define("_AM_D3XCGAL_SRCHNEW_SEL_DIR_MSG","�����Ǥ�FTP�ˤ�ꥵ���Ф˥��åץ��ɤ����ե�����򥢥�Х�˰����Ͽ���ޤ���<br /><br />�ե�����򥢥åץ��ɤ����ǥ��쥯�ȥ�����򤷤Ƥ���������");
define("_AM_D3XCGAL_SRCHNEW_NO_PIC_ADD","�ɲä���ե�����Ϥ���ޤ���");
define("_AM_D3XCGAL_SRCHNEW_NEED_ONE_ALB","���ε�ǽ��Ȥ�����ˤ�1�İʾ�Υ���Хबɬ�פǤ���");
define("_AM_D3XCGAL_SRCHNEW_WARNING","�ٹ�");
define("_AM_D3XCGAL_SRCHNEW_CHG_PERM","������ץȤ����Υǥ��쥯�ȥ�˽����ޤ���Ǥ������ե�������ɲä������˥ǥ��쥯�ȥ�Υѡ��ߥå����⡼�ɤ�755�ޤ���777���ѹ�����ɬ�פ�����ޤ� !");
define("_AM_D3XCGAL_SRCHNEW_TARGET_ALB","<b>��</b>%s<b>����Υե������</b>%s<b>���ɲä���</b>");
define("_AM_D3XCGAL_SRCHNEW_FOLDER","�ե����");
define("_AM_D3XCGAL_SRCHNEW_IMAGE","����");
define("_AM_D3XCGAL_SRCHNEW_ALB","����Х�");
define("_AM_D3XCGAL_SRCHNEW_RESULT","���");
define("_AM_D3XCGAL_SRCHNEW_DIR_RO","����߸�������ޤ���");
define("_AM_D3XCGAL_SRCHNEW_CANT_READ","�ɼ�긢������ޤ���");
define("_AM_D3XCGAL_SRCHNEW_INSERT","�����ե�����Υ����꡼�ؤ��ɲ�");
define("_AM_D3XCGAL_SRCHNEW_LIST_NEW","�����ե��������");
define("_AM_D3XCGAL_SRCHNEW_INS_SEL","���򤷤��ե�������ɲ�");
define("_AM_D3XCGAL_SRCHNEW_NO_PIC","�������ե�����ϸ��Ĥ���ޤ���Ǥ�����");
define("_AM_D3XCGAL_SRCHNEW_PATIENT","�ä����Ԥ�����������");
define("_AM_D3XCGAL_SRCHNEW_NOTES","<ul><li><b>OK</b> : ����˥ե����뤬�ɲä���ޤ�����<li><b>DP</b> : �ե����뤬��ʣ���ƴ��˥ǡ����١�������Ͽ����Ƥ��ޤ���<li><b>PB</b> : �ե�������ɲäǤ��ޤ���Ǥ��������ꤪ��ӥե����뤬��Ͽ�����ǥ��쥯�ȥ�Υѡ��ߥå������ǧ���Ƥ���������<li><b>NA</b> : �ե�������ɲä��륢��Хब���򤵤�Ƥ��ޤ���<li>OK��DP��PB������Τ������ɽ������ʤ��ä����ϡ�PHP���顼��ɽ�����뤿�����»�����̿��򥯥�å����Ƥ���������<li>�����ॢ���Ȥ�ȯ��������硢�֥饦���ι����ܥ���򥯥�å����Ƥ���������</ul>");


// ------------------------------------------------------------------------- //
// File groupmgr.php
// ------------------------------------------------------------------------- //

define("_AM_D3XCGAL_GRPMGR_KB","KB");
define("_AM_D3XCGAL_GRPMGR_NAME","���롼��̾");
define("_AM_D3XCGAL_GRPMGR_QUOTA","�ǥ������������");
define("_AM_D3XCGAL_GRPMGR_RATE","�̿���ɾ����ǽ");
define("_AM_D3XCGAL_GRPMGR_SENDCARD","e�����ɤ�������ǽ");
define("_AM_D3XCGAL_GRPMGR_COM","�����Ȥ������뤳�Ȥ��Ǥ��ޤ�");
define("_AM_D3XCGAL_GRPMGR_UPLOAD","�̿��򥢥åץ��ɲ�ǽ");
define("_AM_D3XCGAL_GRPMGR_PRIVATE","�ѡ����ʥ륮���꡼������ǽ");
define("_AM_D3XCGAL_GRPMGR_APPLY","Ŭ��");
define("_AM_D3XCGAL_GRPMGR_MANAGE","�桼�������롼�פ�������Ƥ�������");
define("_AM_D3XCGAL_GRPMGR_PUB_APPR","�ѥ֥�å����åץ��ɾ�ǧ (1)");
define("_AM_D3XCGAL_GRPMGR_PRIV_APPR","�ץ饤�١��ȥ��åץ��ɾ�ǧ (2)");
define("_AM_D3XCGAL_GRPMGR_PUB_NOTE","<b>(1)</b> �ѥ֥�å�����Х�إ��åץ��ɤ��줿�̿��ϴ����Ԥξ�ǧ��ɬ�פǤ���");
define("_AM_D3XCGAL_GRPMGR_PRIV_NOTE","<b>(2)</b> �桼���Υ���Х�إ��åץ��ɤ��줿�̿��ϴ����Ԥξ�ǧ��ɬ�פǤ���");
define("_AM_D3XCGAL_GRPMGR_NOTES","���");
define("_AM_D3XCGAL_GRPMGR_SYN","Ʊ��");
define("_AM_D3XCGAL_GRPMGR_SYN_NOTE","xcGallery���롼�פ�Xoops���롼�פ�Ʊ��������ˤϡ�Ʊ���פ򥯥�å����Ƥ���������");
define("_AM_D3XCGAL_GRPMGR_EMPTY","���롼�ץơ��֥뤬���Ǥ�!<br /><br />�ǥե���ȥ��롼�פ���������ޤ�����");
// ------------------------------------------------------------------------- //
// File catmgr.php
// ------------------------------------------------------------------------- //

define("_AM_D3XCGAL_CAT_MISS_PARAM","'%s'������ɬ�פʥѥ�᡼�����Ϥ���Ƥ��ޤ��� !");
define("_AM_D3XCGAL_CAT_UNKOWN","���򤷤����ƥ���ϥǡ����١�����¸�ߤ��ޤ���");
define("_AM_D3XCGAL_CAT_UGAL_CAT_RO","�桼�������꡼�Υ��ƥ��꡼�Ϻ������ޤ��� !");
define("_AM_D3XCGAL_CAT_MNGCAT","���ƥ���δ���");
define("_AM_D3XCGAL_CAT_CONF_DEL","�����ˤ��Υ��ƥ���������Ƥ⵹�����Ǥ��� ?");
define("_AM_D3XCGAL_CAT_CAT","���ƥ��꡼");
define("_AM_D3XCGAL_CAT_OP","���");
define("_AM_D3XCGAL_CAT_MOVE","��ư��");
define("_AM_D3XCGAL_CAT_UPCR","���ƥ���κ���/����");
define("_AM_D3XCGAL_CAT_PARENT","�ƥ��ƥ���");
define("_AM_D3XCGAL_CAT_TITLE","���ƥ���̾");
define("_AM_D3XCGAL_CAT_DESC","���ƥ�������");
define("_AM_D3XCGAL_CAT_NOCAT","* ���ƥ��꤬����ޤ��� *");

// ------------------------------------------------------------------------- //
// File ecardmgr.php
// ------------------------------------------------------------------------- //

define("_AM_D3XCGAL_CARDMGR_TITLE","xcGallery e�����ɴ���");
define("_AM_D3XCGAL_CARDMGR_TIME","����");
define("_AM_D3XCGAL_CARDMGR_SUNAME","�����桼����̾");
define("_AM_D3XCGAL_CARDMGR_SEMAIL","�����Żҥ᡼�륢�ɥ쥹");
define("_AM_D3XCGAL_CARDMGR_SIP","������IP");
define("_AM_D3XCGAL_CARDMGR_PID","�̿� ID");
define("_AM_D3XCGAL_CARDMGR_STATUS","Picked");
define("_AM_D3XCGAL_CARDMGR_DEL_SELECTED","���򤵤줿e�����ɤ�������");
define("_AM_D3XCGAL_CARDMGR_DEL_ALL","e�����ɤ��٤Ƥ�������");
define("_AM_D3XCGAL_CARDMGR_DEL_PICKED","��������e�����ɤ򤹤٤ƺ�����Ƥ�������");
define("_AM_D3XCGAL_CARDMGR_DEL_UNPICKED","���̤���Ƥ��ʤ�e�����ɤ򤹤٤ƺ������");
define("_AM_D3XCGAL_CARDMGR_CONPAGE","%d e������ on %d �ڡ���(s)");

?>
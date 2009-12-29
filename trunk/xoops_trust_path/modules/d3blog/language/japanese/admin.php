<?php
/**
 * @version $Id: admin.php 300 2008-02-27 02:47:17Z hodaka $
 * @author kuri <kuri@keynext.co.jp>
 */

// <--- LANG PROPERTY --->
define ( '_MD_A_D3BLOG_LANG_EDIT','�Խ�' );
define ( '_MD_A_D3BLOG_LANG_CATEGORY_MANAGER','���ƥ��꡼����' );
define ( '_MD_A_D3BLOG_LANG_CATEGORY_LIST','���ƥ��꡼����' );
define ( '_MD_A_D3BLOG_LANG_CATEGORY_NAME','���ƥ��꡼̾' );
define ( '_MD_A_D3BLOG_LANG_CATEGORY_PARENT','�ƥ��ƥ��꡼' );
define ( '_MD_A_D3BLOG_LANG_CATEGORY_WEIGHT','ɽ����' );
define ( '_MD_A_D3BLOG_LANG_CATEGORY_IMAGE','���ƥ��꡼���᡼��' );
define ( '_MD_A_D3BLOG_LANG_REGISTER_ANDOR_EDIT_CATEGORY','���ƥ��꡼�ο�����Ͽ/�Խ�' );
define ( '_MD_A_D3BLOG_LANG_CATEGORY_GLOBAL','�⥸�塼������' );
define ( '_MD_A_D3BLOG_LANG_PERMISSION_MANAGER','�ѥߥå�������' );
define ( '_MD_A_D3BLOG_LANG_GROUP_NAME','���롼��̾' );
define ( '_MD_A_D3BLOG_LANG_SELECT_INPORTMODULE','����ݡ��ȸ��⥸�塼�������' );
define ( '_MD_A_D3BLOG_LANG_APPROVAL_MANAGER','��ǧ����' );
define ( '_MD_A_D3BLOG_LANG_APPROVAL_SUMMARY','��ǧ�����Τ���ǡ�������' );
define ( '_MD_A_D3BLOG_LANG_ENTRY_TITLE','����ȥ�̾' );
define ( '_MD_A_D3BLOG_LANG_BLOG_TITLE','�֥�̾' );
define ( '_MD_A_D3BLOG_LANG_ENTRY_DATE','�����' );
define ( '_MD_A_D3BLOG_LANG_COMMENTER','��Ƽ�/�֥�̾' );
define ( '_MD_A_D3BLOG_LANG_APPROVAL_TYPE','��ǧ������' );
define ( '_MD_A_D3BLOG_LANG_APPROVAL_TYPE_ENTRY','����ȥ�' );
define ( '_MD_A_D3BLOG_LANG_CREATE_DATE','�����' );
define ( '_MD_A_D3BLOG_LANG_BLOG_NAME_INBOUND','�֥�̾' );
define ( '_MD_A_D3BLOG_LANG_BLOG_EXCERPT_INBOUND','����' );
define ( '_MD_A_D3BLOG_LANG_TRACKBACK_DATE_INBOUND','������' );
define ( '_MD_A_D3BLOG_LANG_APPROVAL_TYPE_COMMENT','������' );
define ( '_MD_A_D3BLOG_LANG_APPROVAL_TYPE_TRACKBACK','�ȥ��' );
define ( '_MD_A_D3BLOG_LANG_COMMENTS','������/����' );
define ( '_MD_A_D3BLOG_LANG_COMMENT_DATE','������' );
define ( '_MD_A_D3BLOG_LANG_APPROVAL','��ǧ' );
define ( '_MD_A_D3BLOG_LANG_TEMPLATE_NAME','�ƥ�ץ졼��̾' );
define ( '_MD_A_D3BLOG_LANG_TEMPLATE_TYPE','������' );
define ( '_MD_A_D3BLOG_LANG_TEMPLATE_FILE','���ꥸ�ʥ�ե�����' );
define ( '_MD_A_D3BLOG_LANG_CSS_FILE','CSS�ե�����' );
define ( '_MD_A_D3BLOG_LANG_WRITE_CSS_FILE','�񤭽Ф�' );

// <--- MESSAGE PROPERTY --->
define ( '_MD_A_D3BLOG_MESSAGE_DBUPDATE_SUCCESS','DB��������λ���ޤ���' );
define ( '_MD_A_D3BLOG_MESSAGE_DBUPDATE_FAILED','DB���������顼��ȯ�����ޤ���' );
define ( '_MD_A_D3BLOG_MESSAGE_DELETE_SUCCESSED','%s�������ޤ���' );
define ( '_MD_A_D3BLOG_MESSAGE_DELETE_FAILED','%s�κ�����Ǥ��ޤ���Ǥ���' );
define ( '_MD_A_D3BLOG_MESSAGE_IMPORTDONE','����ݡ��Ȥ���λ���ޤ���' );
define ( '_MD_A_D3BLOG_MESSAGE_MIGHT_REWRITE_LINKPATH','</br />��ʸ�Υ�󥯥ѥ��񤭴�����˺��ʤ��Ǥ���������' );
define ( '_MD_A_D3BLOG_MESSAGE_DB_UPDATE_SUCCESS','%s�ι�������λ���ޤ���' );
define ( '_MD_A_D3BLOG_MESSAGE_DB_DELETE_SUCCESS','%s�κ������λ���ޤ���' );
define ( '_MD_A_D3BLOG_MESSAGE_DB_UPDATE_FAILED','%s�ι��������Ԥ��ޤ���' );
define ( '_MD_A_D3BLOG_MESSAGE_DB_DELETE_FAILED','%s�κ�������Ԥ��ޤ���' );
define ( '_MD_A_D3BLOG_MESSAGE_ARE_YOU_SURE_TO_OVERWRITE_CSSFILE','CSS�ե�������񤭤��Ƥ����Ǥ�����' );
define ( '_MD_A_D3BLOG_MESSAGE_CANNOT_OPEN_CSS_DIR','�񤭹��߸��¤Τ���CSS�ǥ��쥯�ȥ� %s ������ޤ�����˺������Ƥ���������' );
define ( '_MD_A_D3BLOG_MESSAGE_CANNOT_WRITE_CSS_DIR','CSS�ǥ��쥯�ȥ� %s �˽񤭹��߸��¤�����ޤ���' );
define ( '_MD_A_D3BLOG_MESSAGE_CANNOT_WRITE_CSS_FILE','�������륷���� %s �ˤϽ񤭹��߸��¤�����ޤ���' );
define ( '_MD_A_D3BLOG_MESSAGE_NOT_CSS_FILE','%s ��CSS�ե�����ǤϤ���ޤ��󡣺�����Ƥ���������' );
define ( '_MD_A_D3BLOG_MESSAGE_YOU_MUST_PREPARE_CSS_DIRECTORY','����̵���Ǥ���CSS�ǥ��쥯�ȥ�������Ƥ���������' );
define ( '_MD_A_D3BLOG_MESSAGE_CSS_FILES_SUCCESSFULLY_WRITTEN','CSS�ե�����ν񤭹��ߤ���λ���ޤ�����' );

// <--- ERROR PROPERTY --->
define ( '_MD_A_D3BLOG_ERROR_WRONG_PID','�ƥ��ƥ��꤬����ޤ��󡣥ơ��֥뤬����Ƥ��뤫�⡣' );
define ( '_MD_A_D3BLOG_ERROR_NAME_REQUIRED','���ƥ���̾��ɬ�ܤǤ�' );
define ( '_MD_A_D3BLOG_ERROR_NAME_SIZEOVER','���ƥ���̾��Ĺ����%s��Ķ���Ƥ��ޤ�' );
define ( '_MD_A_D3BLOG_ERROR_WRONG_IMGURL','imgurl�Υե����ޥåȤ������Ǥ�' );
define ( '_MD_A_D3BLOG_ERROR_NO_SUCH_CATEGORY','�������륫�ƥ��꤬����ޤ���' );
define ( '_MD_A_D3BLOG_ERROR_INVALIDMID', '�⥸�塼��ID������������ޤ���');
define ( '_MD_A_D3BLOG_ERROR_SQLONIMPORT', '�ǡ����١�������������sql�˥��顼�Ǥ�');
define ( '_MD_A_D3BLOG_ERROR_NO_SUCH_TEMPLATE_SET','�ƥ�ץ졼�ȥ��åȤ�̵���Ǥ���' );
define ( '_MD_A_D3BLOG_ERROR_NO_SUCH_TEMPLATE_FILE','�ƥ�ץ졼��̾ %s ��̵���Ǥ���' );

// <--- FORMAT PROPERTY --->
define ( '_MD_A_D3BLOG_FORMAT_CSS_DIRECTORY','CSS�ǥ��쥯�ȥ�� %s �Ǥ���' );

// <--- PERMDESC PROPERTY --->
define ( '_MD_A_D3BLOG_PERMDESC_CAN_VIEW_BLOG','������ǽ' );
define ( '_MD_A_D3BLOG_PERMDESC_CAN_EDIT_BLOG','��ơ��Խ���ǽ' );
define ( '_MD_A_D3BLOG_PERMDESC_CAN_APPROVE_BLOG_SELF','���ʾ�ǧ��ǽ' );
define ( '_MD_A_D3BLOG_PERMDESC_CAN_VIEW_COM','�����ȱ�����ǽ' );
define ( '_MD_A_D3BLOG_PERMDESC_CAN_EDIT_COM','��������Ʋ�ǽ' );
define ( '_MD_A_D3BLOG_PERMDESC_CAN_APPROVE_COM_SELF','�����Ⱦ�ǧ����' );
define ( '_MD_A_D3BLOG_PERMDESC_CAN_DELETE_COM_SELF','�����Ⱥ������' );
define ( '_MD_A_D3BLOG_PERMDESC_ALLOW_HTML','HTML����' );
define ( '_MD_A_D3BLOG_PERMDESC_EDITOR','�Խ���' );

$xoopsModule =& XoopsModule::getByDirname($mydirname);
define('_MD_A_D3BLOG_CONFIG', $xoopsModule->getVar('name').'����');
define('_MD_A_D3BLOG_PREFERENCES', _PREFERENCES);
define('_MD_A_D3BLOG_PREFERENCESDSC', '����Ū��ư������ꤷ�ޤ�');
define('_MD_A_D3BLOG_GO', _GO);
define('_MD_A_D3BLOG_CANCEL', _CANCEL);
define('_MD_A_D3BLOG_DELETE', _DELETE);
define('_MD_A_D3BLOG_MODIFY', '�ѹ�����');
define('_MD_A_D3BLOG_TITLE', 'Title');

// <--- STRUCTURE PROPERTY --->
define('_MD_A_D3BLOG_H2_IMPORTFROM', '����ݡ��ȥޥͥ��㡼');
define('_MD_A_D3BLOG_H3_IMPORTDATABASE', '�ǡ����١����Υ��ԡ�');
define('_MD_A_D3BLOG_H3_IMPORTCOM', '�����ȡ����٥�����ΤΥ���ݡ���');
define('_MD_A_D3BLOG_H3_SYNCHRONIZE', '�����ȡ��ȥ�å��Хå����κƽ���');
define('_MD_A_D3BLOG_LABEL_SELECTMODULE', '����ݡ��ȸ��⥸�塼��');
define('_MD_A_D3BLOG_LABEL_SELECTDIRECTORY', '��ư���⥸�塼��');
define('_MD_A_D3BLOG_LANG_SELECT_IMPORTMODULE', '���򤷤Ƥ�������');
define('_MD_A_D3BLOG_BTN_DOIMPORT', '����ݡ��ȳ���');
define('_MD_A_D3BLOG_BTN_DOIMAGEIMPORT', '��ư����');
define('_MD_A_D3BLOG_BTN_DOSYNCHRONIZE', '�ƽ��׳���');
define('_MD_A_D3BLOG_CONFIRM_DOIMPORT', '�ǡ����١����򥤥�ݡ��Ȥ��Ƥ����Ǥ�����');
define('_MD_A_D3BLOG_CONFIRM_DOCOMIMPORT', '�����ȡ����٥�����Τ򥤥�ݡ��Ȥ��Ƥ����Ǥ�����');
define('_MD_A_D3BLOG_CONFIRM_DOSYNCHRONIZE', '�ƽ��פ��Ƥ����Ǥ�����');
define('_MD_A_D3BLOG_HELP_IMPORTFROM', '<p>����ݡ��ȸ�����ơ��֥�ǡ�����<strong>���ԡ�</strong>���ޤ�������ݡ��ȸ��Υơ��֥�ǡ����ϥ⥸�塼��򥢥󥤥󥹥ȡ��뤹��ޤǳ��ݤ���ޤ���</p>'.
    '<p><strong style="padding-right:1em">���</strong>�֥�å����ƥ�ץ졼�ȡ�����������ܤϰܹ��оݤǤϤ���ޤ���</p>');
define('_MD_A_D3BLOG_HELP_COMIMPORT', '<p>���ꤷ������ݡ��ȸ�����Ƥ��줿�����ȡ����٥�����Υǡ����򤳤Υ⥸�塼��˰ܤ��ޤ���</p>'.
    '<p><strong style="padding-right:1em">���</strong>����ݡ��ȸ��ޤᥳ������ƿ���ƽ��פ��ޤ���</p>');
define('_MD_A_D3BLOG_HELP_SYNCHRONIZE', '<p>�����Ȥȥȥ�å��Хå�����ƽ��פ��ޤ���</p>'.
    '<p><strong style="padding-right:1em">���</strong>phpmyadmin�ʤɤǥǡ����١������Խ��������ʤɡ����פ����ä����������ޤ���</p>');
define ( '_MD_A_D3BLOG_H2_CSSMANAGER','CSS�ޥͥ��㡼' );
define ( '_MD_A_D3BLOG_H3_WRITE_CSSFILE','�������륷���ȥե�����ν񤭽Ф�' );
define ( '_MD_A_D3BLOG_HELP_CSSMANAGER', '<p>�ƥ�ץ졼�Ȥ���CSS�ե������񤭽Ф��ޤ��������ƥ�ץ졼�Ȥ�����å����ơֽ񤭽Ф��פ򥯥�å����ޤ���</p>'.
    '<p><strong style="padding-right:1em">���</strong>�����ȤΥƥ�ץ졼�ȥ��åȤ�CSS�ե�����κǽ����������⿷������硢��ưŪ�˥����å�������ޤ���</p>');

?>
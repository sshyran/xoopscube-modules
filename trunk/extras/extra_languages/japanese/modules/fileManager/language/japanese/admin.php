<?php
/**
 * Filemaneger
 * (C)2007-2009 BeaBo Japan by Hiroki Seike
 * http://beabo.net/
 **/

// --------------------------------------------------------
// �ᥤ��
// --------------------------------------------------------
define('_AD_FILEMANAGER_PATH_HOME', "�ۡ���");
define('_AD_FILEMANAGER_TYPE', "������");
define('_AD_FILEMANAGER_EDIT', "�ɲ�");
define('_AD_FILEMANAGER_DEL', "���");
define('_AD_FILEMANAGER_RETURN', "�ꥹ�Ȥ����");
define('_AD_FILEMANAGER_ACTION_DELETE', "&nbsp;���");
define('_AD_FILEMANAGER_ACTION_DEFULT', "&nbsp;-----");
define('_AD_FILEMANAGER_ACTION_SUBMIT', "&nbsp;Ŭ��&nbsp;");
define('_AD_FILEMANAGER_FILE_TOTAL', "���");

// --------------------------------------------------------
// ���顼��å�����
// --------------------------------------------------------
define('_AD_FILEMANAGER_ERROR_REQUIRED', "{0}��ɬ�����Ϥ��Ʋ�����");
define('_AD_FILEMANAGER_ERROR_PERMISSION', "�����������¤�����ޤ���");
define('_AD_FILEMANAGER_ERROR_FILE_PERMISSION', "%s �ϡ������������¤�����ޤ���");
define('_AD_FILEMANAGER_ERROR_DELETE_FOR_PERMISSION', "%s �ϡ�������륢���������¤��ʤ��٥ե�����ޥ͡����㡼�������Ǥ��ޤ���");
define('_AD_FILEMANAGER_NOTFOUND', "�ե����뤬���Ĥ���ޤ���");
define('_AD_FILEMANAGER_ERROR_FILE_EXISTS', "'%s' �����Ĥ���ޤ���");

// --------------------------------------------------------
// ���åץ���
// --------------------------------------------------------
define('_AD_FILEMANAGER_PREVIEW', "�ץ�ӥ塼");
define('_AD_FILEMANAGER_FILENAME', "�ե�����");
define('_AD_FILEMANAGER_FOLDER_ADD', "�ǥ��쥯�ȥ��ɲ�");
define('_AD_FILEMANAGER_SIZE', "������");
define('_AD_FILEMANAGER_DATE', "��������");
define('_AD_FILEMANAGER_UPLOAD', "���åץ���");
define('_AD_FILEMANAGER_UPLOAD_DSC', "Upload�򥯥�å����ơ��ե���������򤹤�ȥ��åץ��ɤ򳫻Ϥ��ޤ���");
define('_AD_FILEMANAGER_UPLOAD_NOTACCESS',  "%s �ϡ����åץ��ɤǤ��ޤ���FTP���եȤʤɤǡ��ѡ��ߥå������ѹ����Ʋ�������");
define('_AD_FILEMANAGER_UPLOAD_PERMISSION', "���åץ��ɥѥ������Ĥ���ʤ��������åץ��ɸ��¤�����ޤ���");
define('_AD_FILEMANAGER_UPLOAD_NOFILE', "���åץ��ɤ���ե����뤬���Ĥ���ޤ��󡣥ե���������򤷤Ʋ�������");
define('_AD_FILEMANAGER_SINGLEUPLOAD', "�ե����륢�åץ���");
define('_AD_FILEMANAGER_NOTFOUNDURL', "���åץ��ɥѥ������Ĥ���ޤ���");
define('_AD_FILEMANAGER_CONFIRMMSSAGE', "%s �إե�����򥢥åץ��ɤ��ޤ���<br />���åץ��ɲ�ǽ�ʥե����륵������ %s�ޤǲ�ǽ�Ǥ���");

// --------------------------------------------------------
// �ե����
// --------------------------------------------------------
define('_AD_FILEMANAGER_FOLDER', "�ե����");
define('_AD_FILEMANAGER_FOLDERNAME', "�ե����̾");
define('_AD_FILEMANAGER_FOLDER_UPLOAD', "���Υե�����˥��åץ���");
define('_AD_FILEMANAGER_ERROR_FOLDERNAME', "�ե����̾������������ޤ��󡣥ե����̾���ǧ���Ʋ�������<br />�ե����̾�ǻȤ���ʸ���ϡ�Ⱦ�ѱѿ���-~_�Τߤ����ѽ���ޤ���<br />�ѻ��Ͼ�ʸ���Τߤ����ѽ���ޤ���");
define('_AD_FILEMANAGER_ERROR_PATH', "�ե����̾�λ��꤬����������ޤ��󡣥ե����̾���ǧ���Ʋ�������");
define('_AD_FILEMANAGER_ADDFOLDER', "�ե�������ɲ�");
define('_AD_FILEMANAGER_ADDFOLDER_DSC', "�������ե�������ɲä��ޤ����������줿�ե�����ϥե�����ޥ͡����㡼�������Ǥ��ޤ���");
define('_AD_FILEMANAGER_ADDFOLDER_SUCCESS', "�ե�������ɲä��ޤ�����");
define('_AD_FILEMANAGER_ADDFOLDER_ERROR', "�ե�������ʤ����������������¤��ʤ��١��ե�������ɲý���ޤ���");
define('_AD_FILEMANAGER_ADDFOLDER_CONFIRMMSSAGE', "%s �β��˥ե������������ޤ���<br />��������ե����̾�����Ϥ��Ʋ�������");
define('_AD_FILEMANAGER_DELFOLDER', "�ե�����κ��");
define('_AD_FILEMANAGER_DELFOLDER_DSC', "���ꤷ���ե�����������ޤ���");
define('_AD_FILEMANAGER_DELFOLDER_CONFIRMMSSAGE', "�ե���� %s �������ޤ���");
define('_AD_FILEMANAGER_DELFOLDER_FILE_EXISTS', "�ե�����˥ե����뤬����� %s �Ϻ���Ǥ��ޤ��󡣥ե���������Ƥ��ǧ���Ʋ�������");
define('_AD_FILEMANAGER_DELFOLDER_SUCCESS', "�ե�����������ޤ�����");
define('_AD_FILEMANAGER_DELFOLDER_ERROR', "�ե������������ޤ��󡣻��ꤷ���ե���������Ǥʤ�����Ŭ�ڤʥѡ��ߥå����Ǥ���ޤ���");
define('_AD_FILEMANAGER_DELFOLDER_ISDIR', "�ե���� %s �ϡ��ե�����Ǥʤ��٥ե�����ޥ͡����㡼�������Ǥ��ޤ���");
define('_AD_FILEMANAGER_DELFOLDER_NOTACCESS', "�ե���� %s �ϡ��ե�����ޥ͡����㡼�������Ǥ��ޤ���FTP���եȤʤɤǡ��ѡ��ߥå������ѹ����Ʋ�������");
define('_AD_FILEMANAGER_FILECOUNT', "�ե�������");

// --------------------------------------------------------
// SWFUpload
// --------------------------------------------------------
define('_AD_FILEMANAGER_SWF_UPLOAD_QUEUE', "���åץ���");
define('_AD_FILEMANAGER_SWF_UPLOAD_CNACEL', "���٤ƤΥ��åץ��ɤ򥭥�󥻥뤹��");
define('_AD_FILEMANAGER_SWF_COULD_NOT_LOAD', "SWFUpload �饤�֥�����ɽ���ޤ���JavaScript �����Ѥ���Ĥ��Ʋ�������");
define('_AD_FILEMANAGER_SWF_LOADING', "SWFUpload �饤�֥����ɤ߹���Ǥ��ޤ������Ф餯���Ԥ���������...");
define('_AD_FILEMANAGER_SWF_LOAD_HAS_FAILED', "SWFUpload �饤�֥�����ɽ���ޤ��󡣥饤�֥�꤬���åȤ���Ƥ��뤫��ǧ���뤫��Flash �ץ쥤�䡼�򥤥󥹥ȡ��뤷�Ʋ�������");
define('_AD_FILEMANAGER_SWF_INSTALL_FLASH', "SWFUpload  �饤�֥�����ɽ���ޤ��󡣥饤�֥�꤬���åȤ���Ƥ��뤫��ǧ���뤫��Flash �ץ쥤�䡼�򥤥󥹥ȡ��뤷�Ʋ�������<br />�����餫�� <a href=\"http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash\">Adobe website</a>Flash �ץ쥤�䡼�򥤥󥹥ȡ��뤷�Ʋ�����");

// --------------------------------------------------------
// �����ǧ
// --------------------------------------------------------
define('_AD_FILEMANAGER_OPTION', "���ץ����");
define('_AD_FILEMANAGER_OPTION_DSC', "���ץ����");
define('_AD_FILEMANAGER_CHECK_NG', "�饤�֥��Υե����뤬���Ĥ���ޤ��󡣥ե�����򥢥åץ��ɤ��Ʋ�������<br />");
define('_AD_FILEMANAGER_CHECK_OK', "�饤�֥��ե���������֤ϡ���λ���Ƥ��ޤ���");
define('_AD_FILEMANAGER_CHECK', "ư��Ķ��γ�ǧ");
define('_AD_FILEMANAGER_CHECK_DSC_1', "SWFUpload�����Ѥ�����");
define('_AD_FILEMANAGER_CHECK_DSC_2', "SWFUpload��Ȥä����åץ��ɤ���̤˸�������Τϥ�������Ǥ��ޤ���<br />�饤�֥��Τ������htaccess��Ȥä������������¤����ꤷ�Ƥ���������");
define('_AD_FILEMANAGER_HTACCESS_DSC_1', "�����ե�����򥯥�å�������������Ƥ�����Ǥ��ޤ���");
define('_AD_FILEMANAGER_HTACCESS_DSC_2', "���ߥ����������Ƥ���IP���ɥ쥹�Τߵ��Ĥ�����ʼ�ưŪ��������������ץ�Ǥ������Ȥ��Υ����дĶ��˹�碌���ѹ����Ʋ���������");
define('_AD_FILEMANAGER_HTACCESS_PATH', "htaccess�ե���������֤���ѥ�");

// --------------------------------------------------------
// FFMPEG ���
// --------------------------------------------------------
define('_AD_FILEMANAGER_ACTION_CONVERT', "FLV�Ѵ�");
define('_AD_FILEMANAGER_ACTION_CAPTURE', "����ץ��㡼��������");

?>

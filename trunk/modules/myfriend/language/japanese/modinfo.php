<?php
$root = XCube_Root::getSingleton();
if (is_object($root->mContext->mUser) && $root->mContext->mUser->isInRole('Site.GuestUser')) {
  define('_MI_MYFRIEND_NAME', '������Ͽ�ˤĤ���');
} else {
  define('_MI_MYFRIEND_NAME', '�ޥ��ե���');
}
define('_MI_MYFRIEND_GROUP', '�桼���Υ��롼��');
define('_MI_MYFRIEND_GROUP_DESC', 'SNS�ǻ��Ѥ���桼���Υ��롼��');

define('_MI_MYFRIEND_DELDAYS', '�������');
define('_MI_MYFRIEND_DELDAYS_DESC', '���ԼԤ�����������');

define('_MI_MYFRIEND_BLOCK_NAME', '����֥�å�');

define('_MI_MYFRIEND_SUB_SEARCH', '�桼������');
define('_MI_MYFRIEND_SUB_FAVORITES', '����������');
define('_MI_MYFRIEND_INSTALL_ERROR', '���Υ⥸�塼���PHP5.0�ʾ�Ǥʤ���ư��ޤ���');
?>

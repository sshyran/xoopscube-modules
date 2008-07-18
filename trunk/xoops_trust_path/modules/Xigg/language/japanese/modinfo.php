<?php
$const_prefix = '_MI_' . strtoupper($module_dirname);

if (!defined($const_prefix)) {
define($const_prefix, 1);

define($const_prefix . '_NAME', 'Xigg(' . $module_dirname . ')');
define($const_prefix . '_DESC', 'Xigg module for XOOPS powered by Sabai Framework');

// Blocks
define($const_prefix . '_BNAME_CATEGORIES', '���ƥ���');
define($const_prefix . '_BDESC_CATEGORIES', '���ƥ���֥�å�');
define($const_prefix . '_BNAME_TAG_CLOUD', '����');
define($const_prefix . '_BDESC_TAG_CLOUD', '�������饦��');
define($const_prefix . '_BNAME_RECENT_NODES', '�Ƕ�θ�������');
define($const_prefix . '_BDESC_RECENT_NODES', '�Ƕ����Ƶ�����ɽ��');
define($const_prefix . '_BNAME_RECENT_COMMENTS', '�Ƕ�Υ�����');
define($const_prefix . '_BDESC_RECENT_COMMENTS', '�Ƕ�Υ����Ȥ�ɽ��');
define($const_prefix . '_BNAME_RECENT_TRACKBACKS', '�Ƕ�Υȥ�å��Хå�');
define($const_prefix . '_BDESC_RECENT_TRACKBACKS', '�Ƕ�Υȥ�å��Хå���ɽ��');
define($const_prefix . '_BNAME_RECENT_VOTES', '�Ƕ����ɼ');
define($const_prefix . '_BDESC_RECENT_VOTES', '�Ƕ����ɼ��ɽ��');
define($const_prefix . '_BNAME_RECENT_NODES2', '�Ƕ�θ�������2');
define($const_prefix . '_BDESC_RECENT_NODES2', '�Ƕ����Ƶ�������ӥȥå���ɼ������ɽ��');

// Admin menu
define($const_prefix . '_ADMENU_CATEGORIES', '���ƥ������');
define($const_prefix . '_ADMENU_NODES', '�����δ���');
define($const_prefix . '_ADMENU_TAGS', '��������');
define($const_prefix . '_ADMENU_PLUGINS', '�ץ饰�������');
define($const_prefix . '_ADMENU_ROLES', '�������');
define($const_prefix . '_ADMENU_XROLES', '���������ơʥ��롼���̡�');
define($const_prefix . '_ADMENU_USERS', '�桼������');

define($const_prefix . '_SMENU_SUBMIT', '���������');
define($const_prefix . '_SMENU_COMMENTS', '�����Ȱ���');
define($const_prefix . '_SMENU_TAGCLOUD', '�������饦��');


define($const_prefix . '_C_SITETITLE', '�����Ȥ�̾��');
define($const_prefix . '_C_SITEDESC', '�����Ȥ�����');
define($const_prefix . '_C_GCOMALLOWED', '�����ȥ桼���ˤ�륳���Ȥ����');
define($const_prefix . '_C_GCOMALLOWEDD', '�֤Ϥ��פ����򤷤���硢����θ�������˴ؤ�餺���ƤΥ桼���������Ȥ���ƤǤ���褦�ˤʤ�ޤ���');
define($const_prefix . '_C_GVOTEALLOWED', '�����ȥ桼���ˤ����ɼ�����');
define($const_prefix . '_C_GVOTEALLOWEDD', '�֤Ϥ��פ����򤷤���硢����θ�������˴ؤ�餺���ƤΥ桼������ɼ�Ǥ���褦�ˤʤ�ޤ���');
define($const_prefix . '_C_NUMNODES', '�ȥåץڡ�����ɽ�����뵭���ο�');
define($const_prefix . '_C_NUMCOMS', '1�ڡ�����ɽ�����륳���Ȥο�');
define($const_prefix . '_C_NUMTBS', '1�ڡ�����ɽ������ȥ�å��Хå��ο�');
define($const_prefix . '_C_NUMVOTES', '1�ڡ�����ɽ��������ɼ�ο�');
define($const_prefix . '_C_UTIME', '�����Ȥ��Խ�����Ĥ�����֤�Ĺ��');
define($const_prefix . '_C_UTIME_OPT1', '�Խ��ϵ��Ĥ��ʤ�');
define($const_prefix . '_C_UTIME_OPT2', '1����');
define($const_prefix . '_C_UTIME_OPT3', '2����');
define($const_prefix . '_C_UTIME_OPT4', '1��');
define($const_prefix . '_C_UTIME_OPT5', '2����');
define($const_prefix . '_C_UTIME_OPT6', '1����');
define($const_prefix . '_C_UTIME_OPT7', '10����');
define($const_prefix . '_C_UTIME_OPT8', '30����');
define($const_prefix . '_C_NUMVPOP', '�����Ԥ����������������Τ�ɬ�פ���ɼ��');
define($const_prefix . '_C_UPCOMING', '�����Ԥ������ε�ǽ��ͭ���ˤ���');
define($const_prefix . '_C_UPCOMINGD', '���ε�ǽ��ͭ���ˤ��뤳�Ȥˤ�ꡢ�̾�Υ桼���ˤ����Ƥϸ����Ԥ������Ȥ�����Ͽ����ޤ������ε�ǽ��̵���ˤ�����硢��Ƥ��줿���������Ƹ��������Ȥʤ�ޤ���');
define($const_prefix . '_C_VOTING', '��ɼ��ǽ��ͭ���ˤ���');
define($const_prefix . '_C_VOTINGD', '���ε�ǽ��ͭ���ˤ��뤳�Ȥˤ�ꡢ��Ͽ�桼�����Ƶ������Ф�����ɼ�Ǥ���褦�ˤʤ�ޤ���');
define($const_prefix . '_C_PERIOD', '�ȥåץڡ�����ɽ�����뵭����ɽ����');
define($const_prefix . '_C_PERIOD_OPT1', '��Ƥο�������Τ���');
define($const_prefix . '_C_PERIOD_OPT2', '��ɼ��¿�����24���֡�');
define($const_prefix . '_C_PERIOD_OPT3', '��ɼ��¿�����1���֡�');
define($const_prefix . '_C_PERIOD_OPT4', '��ɼ��¿�����1�����');
define($const_prefix . '_C_PERIOD_OPT5', '��ɼ��¿��������Ƥδ��֡�');
define($const_prefix . '_C_PERIOD_OPT6', '�����Ȥο�������Τ���');
define($const_prefix . '_C_PERIOD_OPT7', '��Ƥޤ��ϥ����Ȥο�������Τ���');
define($const_prefix . '_C_TOPTITLE', 'Xigg�ȥåץڡ����Υ����ȥ�');
define($const_prefix . '_C_HPURL', '�ۡ���ڡ�����URL');
define($const_prefix . '_C_COMMENT', '�����ȵ�ǽ��ͭ���ˤ���');
define($const_prefix . '_C_COMMENTD', '���ε�ǽ��ͭ���ˤ��뤳�Ȥˤ�ꡢ�Ƶ������Ф��ƥ����Ȥ�����դ��뤳�Ȥ��Ǥ��ޤ���');
define($const_prefix . '_C_TBACK', '�ȥ�å��Хå���ǽ��ͭ���ˤ���');
define($const_prefix . '_C_TBACKD', '���ε�ǽ��ͭ���ˤ��뤳�Ȥˤ�ꡢ�Ƶ������Ф���ȥ�å��Хå�������դ��뤳�Ȥ��Ǥ��ޤ���');
define($const_prefix . '_C_SHOWVC', '�Ƶ����α�������ɽ������');
}
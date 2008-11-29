<?php
/**
 * @file
 * @package bizforum
 * @version $Id$
**/

define('_MI_BIZFORUM_INSTALL_ERROR_MODULE_INSTALLED', "Module not installed.");
define('_MI_BIZFORUM_INSTALL_ERROR_PERM_ADMIN_SET', "Module admin permission could not set.");
define('_MI_BIZFORUM_INSTALL_ERROR_PERM_READ_SET', "Module read permission could not set.");
define('_MI_BIZFORUM_INSTALL_MSG_MODULE_INSTALLED', "Module '{0}' has installed.");
define('_MI_BIZFORUM_INSTALL_ERROR_SQL_FILE_NOT_FOUND', "SQL file '{0}' is not found.");
define('_MI_BIZFORUM_INSTALL_MSG_DB_SETUP_FINISHED', "Database setup is finished.");
define('_MI_BIZFORUM_INSTALL_MSG_SQL_SUCCESS', "SQL success : {0}");
define('_MI_BIZFORUM_INSTALL_MSG_SQL_ERROR', "SQL error : {0}");
define('_MI_BIZFORUM_INSTALL_MSG_TPL_INSTALLED', "Template '{0}' is installed.");
define('_MI_BIZFORUM_INSTALL_ERROR_TPL_INSTALLED', "Template '{0}' could not installed.");
define('_MI_BIZFORUM_INSTALL_ERROR_TPL_UNINSTALLED', "Template '{0}' could not uninstalled.");
define('_MI_BIZFORUM_INSTALL_MSG_BLOCK_INSTALLED', "Block '{0}' is installed.");
define('_MI_BIZFORUM_INSTALL_ERROR_BLOCK_COULD_NOT_LINK', "Block '{0}' could not link to module.");
define('_MI_BIZFORUM_INSTALL_ERROR_PERM_COULD_NOT_SET', "Block permission of '{0}' could not set.");
define('_MI_BIZFORUM_INSTALL_ERROR_BLOCK_PERM_SET', "Block permission of '{0}' could not set.");
define('_MI_BIZFORUM_INSTALL_MSG_BLOCK_TPL_INSTALLED', "Block template '{0}' is installed.");
define('_MI_BIZFORUM_INSTALL_ERROR_BLOCK_TPL_INSTALLED', "Block template '{0}' could not installed.");
define('_MI_BIZFORUM_INSTALL_MSG_BLOCK_UNINSTALLED', "Block '{0}' is uninstalled.");
define('_MI_BIZFORUM_INSTALL_ERROR_BLOCK_UNINSTALLED', "Block '{0}' could not uninstalled.");
define('_MI_BIZFORUM_INSTALL_ERROR_BLOCK_PERM_DELETE', "Block permission of '{0}' could not deleted.");
define('_MI_BIZFORUM_INSTALL_MSG_BLOCK_UPDATED', "Block '{0}' is updated.");
define('_MI_BIZFORUM_INSTALL_ERROR_BLOCK_UPDATED', "Block '{0}' could not updated.");
define('_MI_BIZFORUM_INSTALL_ERROR_BLOCK_INSTALLED', "Block '{0}' could not installed.");
define('_MI_BIZFORUM_INSTALL_MSG_BLOCK_TPL_UNINSTALLED', "Block template '{0}' is uninstalled.");
define('_MI_BIZFORUM_INSTALL_MSG_CONFIG_ADDED', "Config '{0}' is added.");
define('_MI_BIZFORUM_INSTALL_ERROR_CONFIG_ADDED', "Config '{0}' could not added.");
define('_MI_BIZFORUM_INSTALL_MSG_CONFIG_DELETED', "Config '{0}' is deleted.");
define('_MI_BIZFORUM_INSTALL_ERROR_CONFIG_DELETED', "Config '{0}' could not deleted.");
define('_MI_BIZFORUM_INSTALL_MSG_CONFIG_UPDATED', "Config '{0}' is updated.");
define('_MI_BIZFORUM_INSTALL_ERROR_CONFIG_UPDATED', "Config '{0}' could not updated.");
define('_MI_BIZFORUM_INSTALL_ERROR_CONFIG_NOT_FOUND', "Config is not found.");
define('_MI_BIZFORUM_INSTALL_MSG_MODULE_INFORMATION_DELETED', "Module information is deleted.");
define('_MI_BIZFORUM_INSTALL_ERROR_MODULE_INFORMATION_DELETED', "Module information could not deleted.");
define('_MI_BIZFORUM_INSTALL_MSG_TABLE_DOROPPED', "Table '{0}' is doropped.");
define('_MI_BIZFORUM_INSTALL_ERROR_TABLE_DOROPPED', "Table '{0}' could not doropped.");
define('_MI_BIZFORUM_INSTALL_ERROR_BLOCK_TPL_DELETED', "Block template could not deleted.<br />{0}");
define('_MI_BIZFORUM_INSTALL_MSG_MODULE_UNINSTALLED', "Module '{0}' is uninstalled.");
define('_MI_BIZFORUM_INSTALL_ERROR_MODULOE_UNINSTALLED', "Module '{0}' could not uninstalled.");
define('_MI_BIZFORUM_INSTALL_MSG_UPDATE_STARTED', "Module update started.");
define('_MI_BIZFORUM_INSTALL_MSG_UPDATE_FINISHED', "Module update is finished.");
define('_MI_BIZFORUM_INSTALL_ERROR_UPDATE_FINISHED', "Module could not updated.");
define('_MI_BIZFORUM_INSTALL_MSG_MODULE_UPDATED', "Module '{0}' is updated.");
define('_MI_BIZFORUM_INSTALL_ERROR_MODULE_UPDATED', "Module '{0}' could not updated.");
define('_MI_BIZFORUM_LANG_BIZFORUM', "BIZFORUM");
define('_MI_BIZFORUM_DESC_BIZFORUM', "BIZFORUM");
define('_MI_BIZFORUM_LANG_AUTHOR', "AUTHOR");
define('_MI_BIZFORUM_LANG_CREDITS', "CREDITS");
define('_MI_BIZFORUM_TPL_TOPIC_LIST', "TOPIC_LIST");
define('_MI_BIZFORUM_TPL_TOPIC_EDIT', "TOPIC_EDIT");
define('_MI_BIZFORUM_TPL_TOPIC_DELETE', "TOPIC_DELETE");
define('_MI_BIZFORUM_TPL_TOPIC_VIEW', "TOPIC_VIEW");
define('_MI_BIZFORUM_TPL_POST_LIST', "POST_LIST");
define('_MI_BIZFORUM_TPL_POST_EDIT', "POST_EDIT");
define('_MI_BIZFORUM_TPL_POST_DELETE', "POST_DELETE");
define('_MI_BIZFORUM_TPL_POST_VIEW', "POST_VIEW");
define('_MI_BIZFORUM_TPL_POST_RSS', "POST_RSS");
define('_MI_BIZFORUM_TITLE_GR_ID', "カテゴリグループID");
define('_MI_BIZFORUM_DESC_GR_ID', "XCat のカテゴリグループIDを指定");
define('_MI_BIZFORUM_TITLE_CSS_FILE', "CSS ファイル指定");
define('_MI_BIZFORUM_TITLE_PER_PAGE', "一覧表示時の件数");
define('_MI_BIZFORUM_TITLE_PERMIT', "対応する XCat の権限名");
define('_MI_BIZFORUM_DESC_PERMIT', "閲覧権限|投稿権限|編集権限 の名前をこの順番に | で区切って指定してください。デフォルト：viewer|poster|editor");
define('_MI_BIZFORUM_BLOCK_NAME_TOPIC', "新着トピック");
define('_MI_BIZFORUM_BLOCK_DESC_TOPIC', "最近更新のあったトピックの表示");
define('_MI_BIZFORUM_BLOCK_NAME_CAT', "カテゴリ一覧");
define('_MI_BIZFORUM_BLOCK_DESC_CAT', "カテゴリ一覧をツリー表示");
define('_MI_BIZFORUM_TITLE_SHOW_RSS', "RSSを出力する");
define('_MI_BIZFORUM_DESC_SHOW_RSS', "RSSでは、閲覧権限を無視してすべて表示します。閲覧の制限をしている場合はRSSは出力しないでください");
?>

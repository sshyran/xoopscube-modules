<?php
if (!defined('XOOPS_ROOT_PATH')) { exit(); }

$adminmenu[] = array('title' => _AM_MYXBACKUP_REPORT_TITLE,	'link' => "admin/report.php");
$adminmenu[] = array('title' => _AM_MYXBACKUP_OPTIMIZE_TITLE,	'link' => "admin/optimize.php");
$adminmenu[] = array('title' => _AM_MYXBACKUP_CHECK_TITLE,	'link' => "admin/check.php");
$adminmenu[] = array('title' => _AM_MYXBACKUP_CLEANUP_TITLE,	'link' => "admin/cleanup.php");
$adminmenu[] = array('title' => _AM_MYXBACKUP_BACKUP_TITLE,	'link' => "admin/backup.php");
$adminmenu[] = array('title' => _AM_MYXBACKUP_BACKUPMOD_TITLE,	'link' => "admin/backup_bymod.php");
$adminmenu[] = array('title' => _AM_MYXBACKUP_DUMP_TITLE,	'link' => "admin/dump.php");
$adminmenu[] = array('title' => _AM_MYXBACKUP_EXPORT_TITLE,	'link' => "admin/export.php");
$adminmenu[] = array('title' => _AM_MYXBACKUP_RESTORE_TITLE,	'link' => "admin/restore.php");
?>
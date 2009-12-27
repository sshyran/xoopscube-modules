<?php
if (!defined('XOOPS_ROOT_PATH')) { exit(); }

//	General
define ("_AM_MYXBACKUP_GOBACK_TO_MENU",	"Retour au Menu");
define ("_AM_MYXBACKUP_ERROR",		"Erreur !");
define ("_AM_MYXBACKUP_PARAMETERERROR",	"Erreur Param�tre !");
define ("_AM_MYXBACKUP_DBCHECKERROR",	"Erreur ! (possible endommagement de la base de donn�es)");
define ("_AM_MYXBACKUP_FILECHECKERROR",	"Erreur ! (possible changement des fichiers SQL)");
define ("_AM_MYXBACKUP_RESTOREERROR",	"<div style=\"color:#ff0000; font-size:larger; margin-left:20px;\">Erreur ! (possible changement des fichiers SQL)</div>");

//	Index (Menu)
define ("_AM_MYXBACKUP_NOTICEONINDEX",	"Ne cliquez pas deux fois !");
define ("_AM_MYXBACKUP_REPORT_TITLE",	"Rapport");
define ("_AM_MYXBACKUP_REPORT_DESC",	"Affiche un rapport des tables de la base de donn�es.");
define ("_AM_MYXBACKUP_OPTIMIZE_TITLE",	"Optimiser");
define ("_AM_MYXBACKUP_OPTIMIZE_DESC",	"Optimisation des tables de la base de donn�es de XOOPS Cube Legacy.");
define ("_AM_MYXBACKUP_CHECK_TITLE",	"V�rifier");
define ("_AM_MYXBACKUP_CHECK_DESC",	"V�rification des tables de la base de donn�es de XOOPS Cube Legacy.");
define ("_AM_MYXBACKUP_CLEANUP_TITLE",	"Supprimer");
define ("_AM_MYXBACKUP_CLEANUP_DESC",	"Suppression des tables inutiles.");
define ("_AM_MYXBACKUP_BACKUP_TITLE",	"Sauvegarde de la base de donn�es");
define ("_AM_MYXBACKUP_BACKUP_DESC",	"Cr�er une copie de sauvegarde de la base de donn�es. T�l�chargement de fichier SQL compress�.");
define ("_AM_MYXBACKUP_BACKUPMOD_TITLE","Sauvegarde par Module");
define ("_AM_MYXBACKUP_BACKUPMOD_DESC",	"Cr�er une copie de sauvegarde par module. T�l�chargement de fichier SQL compress�.");
define ("_AM_MYXBACKUP_DUMP_TITLE",	"Dump/Exporter");
define ("_AM_MYXBACKUP_DUMP_DESC",	"Cr�er une copie de sauvegarde des tables au format text)");
define ("_AM_MYXBACKUP_EXPORT_TITLE",	"Exporter");
define ("_AM_MYXBACKUP_EXPORT_DESC",	"Exporter tables sel�ctionn�es au format CSV");
define ("_AM_MYXBACKUP_RESTORE_TITLE",	"Restaurer");
define ("_AM_MYXBACKUP_RESTORE_DESC",	"utiliser une copie de sauvegarde pour restaurer les tables de la base de donn�es. Placer les fichiers SQL dans le rep�rtoire 'sql'.");
define ("_AM_MYXBACKUP_CONFIG_TITLE",	"Param�tres");
define ("_AM_MYXBACKUP_CONFIG_DESC",	"Pr�f�rences G�n�rales.");
define ("_AM_MYXBACKUP_SQLFILE_EXSITS",	"Il y a des fichiers dans le r�pertoire SQL. <br /> Si vous n'avez pas l'intention de restaurer, veuillez supprimer ces fichiers.");

//	Report / Check
define ("_AM_MYXBACKUP_LIST_Prefix",		"PREFIXE");
define ("_AM_MYXBACKUP_LIST_Name",		"NOM");
define ("_AM_MYXBACKUP_LIST_Table",		"TABLE");
define ("_AM_MYXBACKUP_LIST_ModName",		"MODULE");
define ("_AM_MYXBACKUP_LIST_Rows",		"LIGNES");
define ("_AM_MYXBACKUP_LIST_Data_length",	"LONGUEUR");
define ("_AM_MYXBACKUP_LIST_Avg_row_length",	"Moy. LONGUEUR");
define ("_AM_MYXBACKUP_LIST_Data_free",		"Donn�es libres");
define ("_AM_MYXBACKUP_LIST_Update_time",	"MISE � JOUR");
define ("_AM_MYXBACKUP_LIST_Status",		"STATUT");
define ("_AM_MYXBACKUP_LIST_Command",		"OPTION");

//	Optimize
define ("_AM_MYXBACKUP_OPTIMIZED",		"<span style=\"color:#00ff00;\"> optimis�</span>");
define ("_AM_MYXBACKUP_NOTOPTIMIZED",		"<span style=\"color:#ff0000;\"> non optimis�</span>");
define ("_AM_MYXBACKUP_NONEEDOPTIMIZED",	"<span style=\"color:#000000;\"> Table est d�j� � jour</span>");
define ("_AM_MYXBACKUP_NOTABLE_OPTIMIZED",	"Toutes les tables sont d�j� � jour");

//	Delete
define ("_AM_MYXBACKUP_NOTABLES_TO_DELETE",	"Pas de tables trouv�es � supprimer");
define ("_AM_MYXBACKUP_TABLE_DELETED",		"supprim�");
define ("_AM_MYXBACKUP_TABLE_NOTDELETED",	"non supprim�");
define ("_AM_MYXBACKUP_CHECK_TO_DELETE",	"OPTION");

//	Restore
define ("_AM_MYXBACKUP_NOSQLFILES",		"fichiers SQL non trouv�s");
define ("_AM_MYXBACKUP_SQL_NAME",		"fichier SQL");
define ("_AM_MYXBACKUP_SQL_PREFIX",		"PREFIXE dans les fichiers SQL");
define ("_AM_MYXBACKUP_SQL_DATE",		"DATE FICHIER");
define ("_AM_MYXBACKUP_SQLPREFIX",		"Ajouter PREFIX dans les fichiers SQL");
define ("_AM_MYXBACKUP_MYPREFIX",		"PREFIXE");
define ("_AM_MYXBACKUP_GO_RESTORE",		"START");
define ("_AM_MYXBACKUP_GO_RESTORE_NOTE",	"Initier  la restauration (impossible d'annuler l'op�ration)");
define ("_AM_MYXBACKUP_RESTORE_DONE",		"Restauration termin�. Veuillez supprimer les fichiers SQL.");

//	Clean Up
define ("_AM_MYXBACKUP_CAUTIONTODEL",		"<span style=\"color:#ff0000;\">Des Tables n�cessaires pourraient �tre affich�es, par exemple, dans le cas de modules Duplicables.<br />NE SUPPRIMEZ PAS les tables en cas de doute.<br />Faites une copie de sauvegarde avant cette op�ration.</span>");
define ("_AM_MYXBACKUP_TAKERISK",		"PRENDRE LE RISQUE");
?>
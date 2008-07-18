<?php
// $Id$

define('_TOKEN_ERROR', 'Attention ! Ceci vous emp�che d\'ex�cuter une requ�te ou envoi mal form�. S\'il vous pla�t, veuillez recommencer pour confirmer!');
define('_SYSTEM_MODULE_ERROR', 'Les modules suivants ne sont pas install�s.');
define('_INSTALL','Installer');
define('_UNINSTALL','D�sinstaller');
define('_SYS_MODULE_UNINSTALLED','Requit (Non Install�)');
define('_SYS_MODULE_DISABLED','Requit (D�sactiv�)');
define('_SYS_RECOMMENDED_MODULES','Module Recommend�');
define('_SYS_OPTION_MODULES','Module Optionnel');
define('_UNINSTALL_CONFIRM','Voulez-vous d�sinstaller le module System?');

//%%%%%%	File Name mainfile.php 	%%%%%
define("_PLEASEWAIT","Veuillez patienter");
define("_FETCHING","Chargement...");
define("_TAKINGBACK","Retour � l� page pr�c�dente...");
define("_LOGOUT","D�connexion");
define("_SUBJECT","Sujet");
define("_MESSAGEICON","Ic�ne de message");
define("_COMMENTS","Commentaires");
define("_POSTANON","Poster en anonyme");
define("_DISABLESMILEY","D�sactiver les �motic�nes");
define("_DISABLEHTML","D�sactiver le html");
define("_PREVIEW","Pr�visualiser");

define("_GO","Ok !");
define("_NESTED","Embo�t�");
define("_NOCOMMENTS","Sans commentaires");
define("_FLAT","A plat");
define("_THREADED","Par conversation");
define("_OLDESTFIRST","Les anciens en premier");
define("_NEWESTFIRST","Les r�cents en premier");
define("_MORE","plus...");
define("_MULTIPAGE","Pour avoir votre article sur des pages multiples, ins�rer le mot <font color=red>[pagebreak]</font> (avec les crochets) dans l'article.");
define("_IFNOTRELOAD","Si la page ne se recharge pas automatiquement, merci de cliquer <a href=%s>ici</a>");
define("_WARNINSTALL2","ATTENTION: Le rep�rtoire %s existe sur votre serveur. <br />Veuillez supprimer ce rep�rtoire pour des raisons de s�curit�.");
define("_WARNINWRITEABLE","ATTENTION : Veillez Changer les permissions du fichier %s pour des raisons de s�curit�.<br /> sous Unix (444), sous Win32 (lecture seule)");
define('_WARNPHPENV','ATTENTION : param�tres php.ini "%s" est r�gl� "%s". %s');
define('_WARNSECURITY','(Ceci peut causer des probl� de s�curit�)');

//%%%%%%	File Name themeuserpost.php 	%%%%%
define("_PROFILE","Profil");
define("_POSTEDBY","Post� par");
define("_VISITWEBSITE","Visiter le site Web");
define("_SENDPMTO","Envoyer un message priv� � %s");
define("_SENDEMAILTO","Envoyer un E-mail � %s");
define("_ADD","Ajouter");
define("_REPLY","R�pondre");
define("_DATE","Date");   // Posted date

//%%%%%%	File Name admin_functions.php 	%%%%%
define("_MAIN","Principal");
define("_MANUAL","Manuel");
define("_INFO","Info");
define("_CPHOME","Panneau de contr�le");
define("_YOURHOME","Page d'accueil");

//%%%%%%	File Name misc.php (who's-online popup)	%%%%%
define("_WHOSONLINE","Qui est en ligne");
define('_GUESTS', 'Invit�(s)');
define('_MEMBERS', 'Membre(s)');
define("_ONLINEPHRASE","<b>%s</b> utilisateur(s) en ligne");
define("_ONLINEPHRASEX","dont <b>%s</b> sur <b>%s</b>");
define("_CLOSE","Fermer");  // Close window

//%%%%%%	File Name module.textsanitizer.php 	%%%%%
define("_QUOTEC","Citation :");

//%%%%%%	File Name admin.php 	%%%%%
define("_NOPERM","D�sol�, vous n'avez pas les droits pour acc�der � cette zone.");

//%%%%%		Common Phrases		%%%%%
define("_NO","Non");
define("_YES","Oui");
define("_EDIT","Editer");
define("_DELETE","Effacer");
define("_VIEW","Visualiser");
define("_SUBMIT","Valider");
define("_MODULENOEXIST","Le module s�lectionn� n'existe pas !");
define("_ALIGN","Alignement");
define("_LEFT","Gauche");
define("_CENTER","Centre");
define("_RIGHT","Droite");
define("_FORM_ENTER", "Merci d'entrer %s");

// %s represents file name
define("_MUSTWABLE","Le fichier %s doit �tre accessible en �criture sur le serveur !");
// Module info
define('_PREFERENCES', 'Pr�f�rences');
define("_VERSION", "Version");
define("_DESCRIPTION", "Description");
define("_ERRORS", "Erreurs");
define("_NONE", "Aucun");
define('_ON','le');
define('_READS','lectures');
define('_WELCOMETO','Bienvenue sur %s');
define('_SEARCH','Chercher');
define('_ALL', 'Tous');
define('_TITLE', 'Titre');
define('_OPTIONS', 'Options');
define('_QUOTE', 'Citation');
define('_LIST', 'Liste');
define('_LOGIN','Connexion');
define('_USERNAME','Pseudo :&nbsp;');
define('_PASSWORD','Mot de passe :&nbsp;');
define("_SELECT","S�lectionner");
define("_IMAGE","Image");
define("_SEND","Envoyer");
define("_CANCEL","Annuler");
define("_ASCENDING","Ordre ascendant");
define("_DESCENDING","Ordre d�scendant");
define('_BACK', 'Retour');
define('_NOTITLE', 'Aucun titre');
define('_RETURN_TOP', 'Retour haut de la page');

/* Image manager */
define('_IMGMANAGER',"Gestionnaire d'images");
define('_NUMIMAGES', '%s images');
define('_ADDIMAGE','Ajouter un fichier image');
define('_IMAGENAME','Nom :');
define('_IMGMAXSIZE','Taille maxi autoris�e (ko) :');
define('_IMGMAXWIDTH','Largeur maxi autoris�e (pixels) :');
define('_IMGMAXHEIGHT','Hauteur maxi autoris�e (pixels) :');
define('_IMAGECAT','Cat�gorie :');
define('_IMAGEFILE','Fichier image ');
define('_IMGWEIGHT',"Ordre d'affichage dans le gestionnaire d'images :");
define('_IMGDISPLAY','Afficher cette image ?');
define('_IMAGEMIME','Type MIME :');
define('_FAILFETCHIMG', "Impossible d'uploader le fichier %s");
define('_FAILSAVEIMG', "Impossible de stocker l'image %s dans la base de donn�es");
define('_NOCACHE', 'Pas de Cache');
define('_CLONE', 'Cloner');

//%%%%%	File Name class/xoopsform/formmatchoption.php 	%%%%%
define("_STARTSWITH", "Commen�ant par");
define("_ENDSWITH", "Finissant par");
define("_MATCHES", "Correspondant �");
define("_CONTAINS", "Contenant");

//%%%%%%	File Name commentform.php 	%%%%%
define("_REGISTER","Enregistrement");

//%%%%%%	File Name xoopscodes.php 	%%%%%
define("_SIZE","TAILLE");  // font size
define("_FONT","POLICE");  // font family
define("_COLOR","COULEUR");  // font color
define("_EXAMPLE","EXEMPLE");
define("_ENTERURL","Entrez l'URL du lien que vous voulez ajouter :");
define("_ENTERWEBTITLE","Entrez le titre du site web :");
define("_ENTERIMGURL","Entrez l'URL de l'image que vous voulez ajouter.");
define("_ENTERIMGPOS","Maintenant, entrez la position de l'image.");
define("_IMGPOSRORL","'R' ou 'r' pour droite, 'L' ou 'l' pour gauche, ou laisser vide.");
define("_ERRORIMGPOS","ERREUR ! Entrez la position de l'image.");
define("_ENTEREMAIL","Entrez l'adresse e-mail que vous voulez ajouter.");
define("_ENTERCODE","Entrez les codes que vous voulez ajouter.");
define("_ENTERQUOTE","Entrez le texte que vous voulez citer.");
define("_ENTERTEXTBOX","Merci de saisir le texte dans la bo�te.");
define("_ALLOWEDCHAR","Longueur maximum autoris�e de caract�res :&nbsp;");
define("_CURRCHAR","Longueur de caract�res actuelle :&nbsp;");
define("_PLZCOMPLETE","Merci de compl�ter le sujet et le champ message.");
define("_MESSAGETOOLONG","Votre message est trop long.");

//%%%%%		TIME FORMAT SETTINGS   %%%%%
define('_SECOND', '1 seconde');
define('_SECONDS', '%s secondes');
define('_MINUTE', '1 minute');
define('_MINUTES', '%s minutes');
define('_HOUR', '1 heure');
define('_HOURS', '%s heures');
define('_DAY', '1 jour');
define('_DAYS', '%s jours');
define('_WEEK', '1 semaine');
define('_MONTH', '1 mois');

define('_HELP', "Aide");

define("_DATESTRING","j/n/Y G:i:s");
define("_MEDIUMDATESTRING","j/n/Y G:i");
define("_SHORTDATESTRING","j/n/Y");
/*
The following characters are recognized in the format string:
a - "am" or "pm"
A - "AM" or "PM"
d - day of the month, 2 digits with leading zeros; i.e. "01" to "31"
D - day of the week, textual, 3 letters; i.e. "Fri"
F - month, textual, long; i.e. "January"
h - hour, 12-hour format; i.e. "01" to "12"
H - hour, 24-hour format; i.e. "00" to "23"
g - hour, 12-hour format without leading zeros; i.e. "1" to "12"
G - hour, 24-hour format without leading zeros; i.e. "0" to "23"
i - minutes; i.e. "00" to "59"
j - day of the month without leading zeros; i.e. "1" to "31"
l (lowercase 'L') - day of the week, textual, long; i.e. "Friday"
L - boolean for whether it is a leap year; i.e. "0" or "1"
m - month; i.e. "01" to "12"
n - month without leading zeros; i.e. "1" to "12"
M - month, textual, 3 letters; i.e. "Jan"
s - seconds; i.e. "00" to "59"
S - English ordinal suffix, textual, 2 characters; i.e. "th", "nd"
t - number of days in the given month; i.e. "28" to "31"
T - Timezone setting of this machine; i.e. "MDT"
U - seconds since the epoch
w - day of the week, numeric, i.e. "0" (Sunday) to "6" (Saturday)
Y - year, 4 digits; i.e. "1999"
y - year, 2 digits; i.e. "99"
z - day of the year; i.e. "0" to "365"
Z - timezone offset in seconds (i.e. "-43200" to "43200")
*/


//%%%%%		LANGUAGE SPECIFIC SETTINGS   %%%%%
if (!defined('_CHARSET')) {
	define('_CHARSET', 'ISO-8859-1');
	//define('_CHARSET', 'utf-8');
}

if (!defined('_LANGCODE')) {
	define('_LANGCODE', 'fr');
}

// change 0 to 1 if this language is a multi-bytes language
define("XOOPS_USE_MULTIBYTES", "0");
?>

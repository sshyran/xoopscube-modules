<?php
/* Translated by stranger @ www.impresscms.ir since version : 3.16
   Voltan had made another translation for version : 3.02 but this work is totally different (due to too many translating mistakes of him ...)
*/

// mymenu
define('_MD_A_MYMENU_MYTPLSADMIN','');
define('_MD_A_MYMENU_MYBLOCKSADMIN','دسترسی ها');
define('_MD_A_MYMENU_MYPREFERENCES','تنظیمات');

// index.php
define("_AM_TH_DATETIME","زمان");
define("_AM_TH_USER","کاربر");
define("_AM_TH_IP","IP");
define("_AM_TH_AGENT","مهاجم");
define("_AM_TH_TYPE","نوع تهاجم");
define("_AM_TH_DESCRIPTION","توضیحات");

define( "_AM_TH_BADIPS" , 'IP های غیرمجاز <br /><br /><span style="font-weight:normal;">هر کدام IP هایی که باید غیرمجاز محسوب شوند را در یک خط جدید در کادر زیر بنویسید <br />کادر خالی به معنای مجاز بودن تمام IP ها می باشد</span>' ) ;

define( "_AM_TH_GROUP1IPS" , 'IP های مجاز برای گروه اول (Group=1)<br /><br /><span style="font-weight:normal;">هر کدام از IP ها را در یک خط جدید در کادر زیر بنویسید .<br />192.168. به معنای 192.168.* نیز می باشد<br />کادر خالی به معنای مجاز بودن تمام IP ها می باشد</span>' ) ;

define( "_AM_LABEL_COMPACTLOG" , "گزارش فشرده" ) ;
define( "_AM_BUTTON_COMPACTLOG" , "فشرده ساز!" ) ;
define( "_AM_JS_COMPACTLOGCONFIRM" , "گزارشات IP و Type های دوگانه حذف می شوند" ) ;
define( "_AM_LABEL_REMOVEALL" , "حذف تمام گزارش ها" ) ;
define( "_AM_BUTTON_REMOVEALL" , "حذف همه!" ) ;
define( "_AM_JS_REMOVEALLCONFIRM" , "تمامی گزارشات با موفقیت حذف شدند. آیا همه چیز روبراهه؟" ) ;
define( "_AM_LABEL_REMOVE" , "حذف گزارشات کنترل شده:" ) ;
define( "_AM_BUTTON_REMOVE" , "حذف!" ) ;
define( "_AM_JS_REMOVECONFIRM" , "آیا حذف شود؟" ) ;
define( "_AM_MSG_IPFILESUPDATED" , "پرونده مربوط به IP ها بروز شد" ) ;
define( "_AM_MSG_BADIPSCANTOPEN" , "پرونده مربوط به ip های غیرمجاز باز نمی شود" ) ;
define( "_AM_MSG_GROUP1IPSCANTOPEN" , "پرونده مربوط به اجازه دادن به گروه اول (گردانندان سایت یا group=1) باز نمی شود" ) ;
define( "_AM_MSG_REMOVED" , "گزارشات حذف شدند" ) ;
define( "_AM_FMT_CONFIGSNOTWRITABLE" , "لطفا به شاخه تنظیمات دسترسی نوشتاری بدهید: %s" ) ;


// prefix_manager.php
define( "_AM_H3_PREFIXMAN" , "مدیریت پیشوندهای پایگاه داده" ) ;
define( "_AM_MSG_DBUPDATED" , "پایگاه داده با موفقیت بروز گردید!" ) ;
define( "_AM_CONFIRM_DELETE" , "تمام اطلاعات حذف می شوند. ادامه می دهید؟" ) ;
define( "_AM_TXT_HOWTOCHANGEDB" , "اگر می خواهید پیشوند پایگاه داده تان را عوض کنید,<br /> فایل %s/mainfile.php را دستی ویرایش کنید.<br /><br />define('XOOPS_DB_PREFIX', '<b>%s</b>');" ) ;


// advisory.php
define("_AM_ADV_NOTSECURE","نا امن");

define("_AM_ADV_REGISTERGLOBALS","این خاصیت باعث ایجاد حملات نفوذی متعددی می شود.<br />شما می توانید (در صورت داشتن دسترسی) اقدام به ایجاد، ویرایش و یا تغییر فایل .htaccess کنید...");
define("_AM_ADV_ALLOWURLFOPEN","این خاصیت به مهاجمان اجازه اجرا کردن اسکریپت های دلخواهشان از راه دور بروی سرور را می دهد.<br />فقط مدیر سرور می تواند این گزینه را تغییر دهد.<br />چنانچه دسترسی به مدیریت سرور دارید فایل php.ini یا httpd.conf را ویرایش کنید.<br /><b>نمونه ای از httpd.conf:<br /> &nbsp; php_admin_flag &nbsp; allow_url_fopen &nbsp; off</b><br />در غیر اینصورت این کار را به مدیران میزبان (سرور) بسپارید.");
define("_AM_ADV_USETRANSSID","شماره شناسه نشست شما در تگ های  anchor (تگ لینک دادن در نرم افزار های HTML) به نمایش درمی آید و غیره.<br />برای جلوگیری از دزدیدن نشست، باید یک خط به فایل .htaccess در XOOPS_ROOT_PATH اضافه کنید.<br /><b>php_flag session.use_trans_sid off</b>");
define("_AM_ADV_DBPREFIX","باعث ایجاد حملات 'نفوذ به SQL' می شود.<br />فراموش نکنید که قابلیت 'پاکسازی اجباری *' را در تنظیمات ماژول روشن کنید.");
define("_AM_ADV_LINK_TO_PREFIXMAN","مدیریت پیشوندهای پایگاه داده");
define("_AM_ADV_MAINUNPATCHED","شما باید فایل mainfile.php را همانطور که در فایل README نوشته شده، تغییر دهید.");

define("_AM_ADV_SUBTITLECHECK","از کارکردن محافظ اطمینان حاصل کنید:");
define("_AM_ADV_CHECKCONTAMI","پالایش");
define("_AM_ADV_CHECKISOCOM","کنترل امنیتی نظرات");



?>
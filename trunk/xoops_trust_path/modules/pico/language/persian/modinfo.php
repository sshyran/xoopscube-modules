<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) ) $mydirname = 'pico' ;
$constpref = '_MI_' . strtoupper( $mydirname ) ;

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( $constpref.'_LOADED' ) ) {

define( $constpref.'_LOADED' , 1 ) ;

// The name of this module
define($constpref."_NAME","پیکو");

// A brief description of this module
define($constpref."_DESC","ماژولی برای ساخت اسناد استاتیک");

// admin menus
define( $constpref.'_ADMENU_CONTENTSADMIN' , 'لیست اسناد' ) ;
define( $constpref.'_ADMENU_CATEGORYACCESS' , 'دسترسی شاخه ها' ) ;
define( $constpref.'_ADMENU_IMPORT' , 'وارد کردن / هم زمان کردن' ) ;
define($constpref.'_ADMENU_EXTRAS','اضافی');
define($constpref.'_ADMENU_MYLANGADMIN','تنظیمات زبان');
define($constpref.'_ADMENU_MYTPLSADMIN','تمپلیت ها');
define($constpref.'_ADMENU_MYBLOCKSADMIN','بلاک ها / دسترسی ها');
define($constpref.'_ADMENU_MYPREFERENCES','ویژگی ها');

// configurations
define($constpref.'_USE_WRAPSMODE','قرار گرفتن در ماژول منتظر ها برای تایید');
define($constpref.'_USE_REWRITE','فعال کردن روش mod_rewrite');
define($constpref.'_USE_REWRITEDSC','بستگی به محیط شما دارد. اگر این گزینه را فعال کنید, نام آدرس های .htaccess.rewrite_wraps(with wraps) یا htaccess.rewrite_normal(without wraps) یا .htaccess در XOOPS_ROOT_PATH/modules/(dirname)/ تغییر میکند');
define($constpref.'_WRAPSAUTOREGIST','فعال سازی ثبت خودکار صفحات HTML در پایگاه داده ها');
define($constpref.'_TOP_MESSAGE','توضیحات شاخه ی اصلی');
define($constpref.'_TOP_MESSAGEDEFAULT','');
define($constpref.'_MENUINMODULETOP','نمایش منو در صفحه ی اصلی ماژول');
define($constpref.'_LISTASINDEX',"نمایش فهرست اسناد در شاخه ی اصلی");
define($constpref.'_LISTASINDEXDSC','با انتخاب بله لیست  اسناد به صورت خودکار در شاخه ی اصلی قرار میگیرد.   اگر نه را انتخاب کنید اسناد  بر اساس اولیت خود نمایش داده میشوند');
define($constpref.'_SHOW_BREADCRUMBS','نمایش مسیر صفحه (breadcrumbs)');
define($constpref.'_SHOW_PAGENAVI','نمایش صفحه ی راهبری');
define($constpref.'_SHOW_PRINTICON','نمایش آیکن  چاپگر');
define($constpref.'_SHOW_TELLAFRIEND','نمایش آیکن تماس با دوستان');
define($constpref.'_SEARCHBYUID','فعال کردن صفحات ساخته شده برای سازنده');
define($constpref.'_SEARCHBYUIDDSC','قرار دادن لیست اسناد  در پروفایل سازنده ی سند. اگر از این  ماژول برای ساخت صفحات استاتیک استفاده میکنید این گزینه را خاموش کنید.');
define($constpref.'_USE_TAFMODULE','استفاده از ماژول تماس با دوستان ');
define($constpref.'_FILTERS','تنظیمات پیش فرض فیلتر');
define($constpref.'_FILTERSDSC','کلمات انتخابی را با | از هم جدا کنید(pipe)');
define($constpref.'_FILTERSDEFAULT','htmlspecialchars|smiley|xcode|nl2br');
define($constpref.'_FILTERSF','فیلتر های اجباری');
define($constpref.'_FILTERSFDSC','فیلتر های ورودی را به وسیله ی , ( کاما) از هم جدا کنید. فیلتر:LAST به این معنیست که در حالت آخرین فیلتر ها درست عمل شده است. مابقی فیلتر ها هم در فاز اول درست عمل کرده اند.');
define($constpref.'_FILTERSP','فیلتر های ممنوع');
define($constpref.'_FILTERSPDSC','فیلتر های ورودی را به وسیله ی , ( کاما) از هم جدا کنید');
define($constpref.'_SUBMENU_SC','نمایش اسناد در یک زیر منو ');
define($constpref.'_SUBMENU_SCDSC','به طور پیش فرض فقط شاخه ها نمایش داده میشوند. اگر این گزینه را فعال کنید سند های که گزینه ی"نمایش در منو" آن ها فعال است هم در  منو ی اصلی سایت نمایش داده میشوند');
define($constpref.'_SITEMAP_SC','نمایش اسناد در ماژول نقشه ی سایت');
define($constpref.'_USE_VOTE','فعال سازی قابلیت رای دادن');
define($constpref.'_GUESTVOTE_IVL','رای دادن مهمان ها');
define($constpref.'_GUESTVOTE_IVLDSC',' با انتخاب 0 امکان رای دادن مهمان ها را بگیرید. بقیه ی اعداد زمان(ثانیه) رای دادن هر ip میباشد');
define($constpref.'_HTMLHEADER','سرفصل HTML مشترک');
define($constpref.'_CSS_URI','آدرس فایل های CSS در ماژول');
define($constpref.'_CSS_URIDSC','مسیر داخلی( داخل ماژول) یا خارجی( از جای دیگر) قابل تنضیم است. مسیر پیش فرض: {mod_url}/index.php?page=main_css');
define($constpref.'_IMAGES_DIR','محل قرار گیری تصاویر');
define($constpref.'_IMAGES_DIRDSC','مسیر مورد نظر را در شاخه های ماژول تنظیم کنید. پیش فرض: images');
define($constpref.'_BODY_EDITOR','ادیتور متن اصلی( بدنه ی اصلی)');
define($constpref.'_HTMLPR_EXCEPT','گروه های که میتوانند از پالایش به وسیله پالایشگر HTML اجتناب کنند');
define($constpref.'_HTMLPR_EXCEPTDSC','پست های که به وسیله کاربرانی که جز گروه های مشخص شده رو به رو نیستند ارسال شده است باید  مطابق اصول امنیتی HTML به وسیله پالایشگر HTML  ، پالایش شود  در پروتکتو >=3.14. این ویرایشگر در PHP4 کار نمیکند');
define($constpref.'_HISTORY_P_C','چه تعداد اصلاح (سند) در پایگاه داده ها ذخیره شود');
define($constpref.'_MLT_HISTORY','کمترین عمر هر اصلاح ( ثانیه)');
define($constpref.'_BRCACHE','زمان نگاه داری فایل کش برای  فایل های تصویری (فقط در حالت wraps)');
define($constpref.'_BRCACHEDSC','فایل های به غیر از آن HTML توسط مرور گر شما در مدت زمان مشخص شده بر حسب ثانیه کش میشوند (0 به معنی غیر فعال است)');
define($constpref.'_COM_DIRNAME','یکسان سازی پیام ها: نام انجمن در d3forum');
define($constpref.'_COM_FORUM_ID','یکسان سازی پیام ها:ID انجمن ');
define($constpref.'_COM_VIEW','دیدن نظر های یکپارچه');

// blocks
define($constpref.'_BNAME_MENU','منو');
define($constpref.'_BNAME_CONTENT','سند');
define($constpref.'_BNAME_LIST','لیست');
define($constpref.'_BNAME_SUBCATEGORIES','زیر شاخه ها');
define($constpref.'_BNAME_MYWAITINGS','پست های منتظر تایید من');

// Notify Categories
define($constpref.'_NOTCAT_GLOBAL', 'سراسری');
define($constpref.'_NOTCAT_GLOBALDSC', 'اطلاع رساني درباره اين ماژول');

// Each Notifications
define($constpref.'_NOTIFY_GLOBAL_WAITINGCONTENT', 'منتظر ها برای تایید');
define($constpref.'_NOTIFY_GLOBAL_WAITINGCONTENTCAP', 'چنانچه تغيير و يا پستي منتظر تاييد است به من خبر بده(فقط براي اطلاع رساني مديران و وبمستران)');
define($constpref.'_NOTIFY_GLOBAL_WAITINGCONTENTSBJ', '[{X_SITENAME}] {X_MODULE}: waiting');
define($constpref.'_NOTIFY_GLOBAL_NEWCONTENT','سندی جدید');
define($constpref.'_NOTIFY_GLOBAL_NEWCONTENTCAP','اگر یک سند جدید ثبت شد اطلاع بده. (فقط برای سند ها مجاز باشد)');
define($constpref.'_NOTIFY_GLOBAL_NEWCONTENTSBJ','[{X_SITENAME}] {X_MODULE} : سندی جدید');

}

?>
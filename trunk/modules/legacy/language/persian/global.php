<?php
// $Id: global.php,v 1.1 2007/05/15 02:35:28 minahito Exp $

define('_TOKEN_ERROR', 'Alert ! This prevent you from instantiating a malformed request or post. Please, submit again to confirm!');
define('_SYSTEM_MODULE_ERROR', 'ماژول های زیر نصب نشده اند.');
define('_INSTALL','نصب');
define('_UNINSTALL','Uninstall');
define('_SYS_MODULE_UNINSTALLED','لازم(نصب نشده)');
define('_SYS_MODULE_DISABLED','لازم(نمایش بده)');
define('_SYS_RECOMMENDED_MODULES','ماژول پیشنهاد شده');
define('_SYS_OPTION_MODULES','ماژول انتخوابی');
define('_UNINSTALL_CONFIRM','آیا شما مطمئن هستید که میخواهید ماژول سیستم را حذف کنید؟>');

//%%%%%%	File Name mainfile.php 	%%%%%
define("_PLEASEWAIT","لطفا صبر کنيد");
define("_FETCHING","بارگزاری ...");
define("_TAKINGBACK","بازگشت به جایی که قبلا بودید");
define("_LOGOUT","خروج");
define("_SUBJECT","عنوان");
define("_MESSAGEICON","نشانه پيام");
define("_COMMENTS","نظر ها");
define("_POSTANON","فرستنده ناشناس");
define("_DISABLESMILEY","بستن شکلک");
define("_DISABLEHTML","HTML بستن");
define("_PREVIEW","پيش نمايش");

define("_GO","برو");
define("_NESTED","تو در تو");
define("_NOCOMMENTS","هيچ نظری نيست");
define("_FLAT","يک صفحه ای");
define("_THREADED","شاخه ای");
define("_OLDESTFIRST","اول قديمی ها");
define("_NEWESTFIRST","اول تازه ها");
define("_MORE","ادامه...");
define("_MULTIPAGE"," برای چند صفحه ای کردن نوشته خود در ابتدای آغاز صفحه بعدی کلمه  <font color=red>[pagebreak]</font> را قرار دهيد");
define("_IFNOTRELOAD","در صورتی که صفحه جديد نیامد <a href='%s'>اینجا</a> را کليک کنيد.");
define("_WARNINSTALL2","هشدار امنیتی: شاخه  %s بر روی سرور وجود دارد. <br />لطفا به دلیل مسایل امنیتی این شاخه را پاک کنید یا تغییر نام دهید.");
define("_WARNINWRITEABLE","هشدار امنیتی: فایل %s بر روی سرور قابل دسترسی برای نوشتن است لطفا به دلیل مسایل امنیتی سطح دسترسی (permission) این فایل را تغییر دهید در سیستم عامل یونیکس (unix) (444), در سیستم عامل Win32 (read-only) کنید");
define('_WARNPHPENV','اخطار: دسترسیphp.ini  "%s" است . آن را به "%s" تغییر دهید. %s');
define('_WARNSECURITY','(It may cause a security problem)');

//%%%%%%	File Name themeuserpost.php 	%%%%%
define("_PROFILE","ويژگی های فردی");
define("_POSTEDBY","فرستنده");
define("_VISITWEBSITE","نمایش سایت");
define("_SENDPMTO"," ارسال پيام شخصی به %s");
define("_SENDEMAILTO"," ارسال نامه به %s");
define("_ADD","اضافه");
define("_REPLY","پاسخ");
define("_DATE","تاريخ");   // Posted date

//%%%%%%	File Name admin_functions.php 	%%%%%
define("_MAIN","اصلی");
define("_MANUAL","راهنما");
define("_INFO","اطلاعات");
define("_CPHOME","صفحه کنترل");
define("_YOURHOME","صفحه اول");

//%%%%%%	File Name misc.php (who's-online popup)	%%%%%
define("_WHOSONLINE","چه کسانی در سايت هستند");
define('_GUESTS', 'مهمان');
define('_MEMBERS', 'عضو');
define("_ONLINEPHRASE","<b>%s</b> کاربر آن لاين است");
define("_ONLINEPHRASEX","<b>%s</b> کاربر در حال دیدن سایت <b>%s</b>");
define("_CLOSE","بستن");  // Close window

//%%%%%%	File Name module.textsanitizer.php 	%%%%%
define("_QUOTEC","نقل قول :");

//%%%%%%	File Name admin.php 	%%%%%
define("_NOPERM","متاسفانه شما به اين قسمت دسترسی نداريد.");

//%%%%%		Common Phrases		%%%%%
define("_NO","نه");
define("_YES","بله");
define("_EDIT","ويرايش");
define("_DELETE","حذف");
define("_VIEW","بازدید");
define("_SUBMIT","ارسال");
define("_MODULENOEXIST","ماژول انتخاب شده وجود ندارد");
define("_ALIGN","چينش");
define("_LEFT","چپ");
define("_CENTER","ميان");
define("_RIGHT","راست");
define("_FORM_ENTER", "لطفا %s را وارد کنيد");
// %s represents file name
define("_MUSTWABLE","فایل %s باید بر روی سرور قابل نوشتن (writeble) باشد!");
// Module info
define('_PREFERENCES', 'ويژگی ها');
define("_VERSION", "نسخه");
define("_DESCRIPTION", "توضيح");
define("_ERRORS", "خطاها");
define("_NONE", "هيچ يک");
define('_ON','در تاريخ');
define('_READS','بار خوانده شده');
define('_WELCOMETO','به %s خوش آمديد');
define('_SEARCH','جستجو');
define('_ALL', 'همه');
define('_TITLE', 'عنوان');
define('_OPTIONS', 'گزينه ها');
define('_QUOTE', 'نقل قول');
define('_LIST', 'فهرست');
define('_LOGIN','ورود کاربر');
define('_USERNAME','شناسه کاربری: ');
define('_PASSWORD','واژه رمز: ');
define("_SELECT","انتخاب");
define("_IMAGE","تصوير");
define("_SEND","بفرست");
define("_CANCEL","بازگشت");
define("_ASCENDING","مرتب سازی افزايشی");
define("_DESCENDING","مرتب سازی کاهشی");
define('_BACK', 'بازگشت');
define('_NOTITLE', 'بدون عنوان');
define('_RETURN_TOP', 'برو به بالا ی صفحه');

/* Image manager */
define('_IMGMANAGER','مدير تصاوير');
define('_NUMIMAGES', 'تصوير %s');
define('_ADDIMAGE','اضافه کردن فايل تصوير جديد');
define('_IMAGENAME','نام');
define('_IMGMAXSIZE','محدوديت حجم (kb)');
define('_IMGMAXWIDTH','محدوديت طول(pixel)');
define('_IMGMAXHEIGHT','محدوديت عرض (pixel)');
define('_IMAGECAT','دسته:');
define('_IMAGEFILE','نام فايل:');
define('_IMGWEIGHT','چگونگی نمايش ');
define('_IMGDISPLAY','تصوير نمايش داده شود؟');
define('_IMAGEMIME','MIME type:');
define('_FAILFETCHIMG', 'موفق به دريافت فايل فرستاده شده  %s نشديم');
define('_FAILSAVEIMG', 'ذخيره %s در پايگاه داده به مشکل بر خورد');
define('_NOCACHE', 'بدون ذخيره سازی');
define('_CLONE', 'کپی برداری');

//%%%%%	File Name class/xoopsform/formmatchoption.php 	%%%%%
define("_STARTSWITH", "آغاز با");
define("_ENDSWITH", "پايان با");
define("_MATCHES", "تطبيق");
define("_CONTAINS", "دارای");

//%%%%%%	File Name commentform.php 	%%%%%
define("_REGISTER","ثبت نام");

//%%%%%%	File Name xoopscodes.php 	%%%%%
define("_SIZE","اندازه");  // font size
define("_FONT","قلم");  // font family
define("_COLOR","رنگ");  // font color
define("_EXAMPLE","نمونه");
define("_ENTERURL","لطفا آدرس لینکی را که میخواهید به نوشته خود اظافه کنید وارد کنید:");
define("_ENTERWEBTITLE","لطفا نام لینک را وارد کنید:");
define("_ENTERIMGURL","لطفا آدرس عکسی را که میخواهید به نوشته خود اضافه کنید وارد کنید");
define("_ENTERIMGPOS","حالا مکانی را که میخواهید عکس در صفحه قرار بگیرد مشخص کنید");
define("_IMGPOSRORL","'R' یا 'r' برای راست , 'L' یا 'l' برای چپ, و برای اینکه عکس بدون تعین مکان قرار بگیرد این باکس را خالی رها کنید.");
define("_ERRORIMGPOS","خطا در وارد کردن مکان قرار گیری عکس");
define("_ENTEREMAIL","آدرس پست الکترونیکی را که میخواهید به نوشته خود اضافه کنید وارد کنید");
define("_ENTERCODE","کدی را که میخواهید به نوشته خود اضافه کنید وارد کنید.");
define("_ENTERQUOTE","متنی را که میخواهید به عنوان نقل قول به نوشته خود اضافه کنید وارد کنید");
define("_ENTERTEXTBOX","لطفا متن را داخل باکس وارد کنید");
define("_ALLOWEDCHAR","حداکثر مجاز طول کاراکتر ها: ");
define("_CURRCHAR","طول کاراکتر ها در حال حاضر: ");
define("_PLZCOMPLETE","لطفا عنوان نوشته و متن داخل نوشته را کامل کنید");
define("_MESSAGETOOLONG","نوشته شما طولانی است");

//%%%%%		TIME FORMAT SETTINGS   %%%%%
define('_SECOND', '1 ثانیه');
define('_SECONDS', 'ثانیه %s');
define('_MINUTE', '1 دقیقه');
define('_MINUTES', 'دقیقه%s');
define('_HOUR', ' 1 ساعت ');
define('_HOURS', 'ساعت %s');
define('_DAY', '1 روز');
define('_DAYS', 'روز %s');
define('_WEEK', '1 هفته');
define('_MONTH', ' 1 ماه ');

define('_HELP', "کمک");

define("_DATESTRING","Y/n/j G:i:s");
define("_MEDIUMDATESTRING","Y/n/j G:i");
define("_SHORTDATESTRING","Y/n/j");
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
	define('_CHARSET', 'utf-8');
}

if (!defined('_LANGCODE')) {
	define('_LANGCODE', 'fa');
}

// change 0 to 1 if this language is a multi-bytes language
define("XOOPS_USE_MULTIBYTES", "1");
?>
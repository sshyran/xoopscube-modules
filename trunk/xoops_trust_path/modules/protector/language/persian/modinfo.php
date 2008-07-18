<?php
/* Translated by stranger @ www.impresscms.ir since version : 3.16
   Voltan had made another translation for version : 3.02 but this work is totally different (due to too many translating mistakes of him ...)
*/

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) ) $mydirname = 'protector' ;
$constpref = '_MI_' . strtoupper( $mydirname ) ;

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( $constpref.'_LOADED' ) ) {

define( $constpref.'_LOADED' , 1 ) ;

// The name of this module
define($constpref."_NAME","محافظ سایت");

// A brief description of this module
define($constpref."_DESC","این ماژول سایت شما را در برابر حملات مختلف و پیچیده ای مانند DoS ، نفوذ SQL و سایر متغیر های آلوده محافظت می کند.");

// Menu
define($constpref."_ADMININDEX","منطقه حفاظتی");
define($constpref."_ADVISORY","مشاور امنیتی");
define($constpref."_PREFIXMANAGER","مدیریت پیشوندها");
define($constpref.'_ADMENU_MYBLOCKSADMIN','دسترسی ها') ;

// Configs
define($constpref.'_GLOBAL_DISBL','غیرفعال کردن موقت');
define($constpref.'_GLOBAL_DISBLDSC','تمامی فعالیت های حفاظتی موقتا غیرفعال می شوند.<br />فراموش نکنید که پس از رفع مشکل این گزینه را غیر فعال کنید');

define($constpref.'_RELIABLE_IPS','IP های معتبر');
define($constpref.'_RELIABLE_IPSDSC','IP های معتبر خود را با | از هم جدا کنید. دستور ^ ابتدای ریشه های همسان را پیدا می کند، دستور $ انتهای ریشه های همسان را پیدا می کند.');

define($constpref.'_LOG_LEVEL','میزان ثبت گزارشات');
define($constpref.'_LOG_LEVELDSC','');

define($constpref.'_BANIP_TIME0','مدت زمان تعلیق IP های غیر معتبر (ثانیه)');

define($constpref.'_LOGLEVEL0','هیچ');
define($constpref.'_LOGLEVEL15','آرام');
define($constpref.'_LOGLEVEL63','بی صدا');
define($constpref.'_LOGLEVEL255','کامل');

define($constpref.'_HIJACK_TOPBIT','تعداد بیت های IP ها برای هر نشست');
define($constpref.'_HIJACK_TOPBITDSC','مقابله با دزدی جلسه :<br />پیش فرض 32(بیت) می باشد. (تمام بیت ها حفاظت می شوند)br />وقتی IP شما پایدار نیست, محدوده ی IP خود را باعددی مشخص از بیت ها تنظیم کنید..<br />(برای مثال) اگر IP شما در محدوده ای بین 192.168.0.0 تا 192.168.0.255 میتواند تغییر کنید عدد 24 ( بیت) را بنویسید');
define($constpref.'_HIJACK_DENYGP','گروه هایی که IP آنها در یک نشست نباید تغییر کند');
define($constpref.'_HIJACK_DENYGPDSC','مقابله با دزدی جلسه :<br />گروه هایی را که IP آنها در یک نشست نباید تغییر کند را انتخاب کنید.<br />این نوع تهاجم در اصل ترکیب ماهرانه ی دو تهاجم: دزدیدن IP شما و استراق سمع اطلاعات شما می باشد، با این روش مهاجم خود را جای شما زده و اقدام به ربودن اطلاعات شما کرده و دسترسی به حساب کاربری را خواهد داشت. با این نوع حمله مهاجم می تواند تا آن حد که شما در سایت دسترسی دارید، در سایت شما اقدا به خرابکاری کند.<br />(پیشنهاد می کنم برای مدیران سایت روشن باشد.)');
define($constpref.'_SAN_NULLBYTE','پاکسازی بایت های خالی');
define($constpref.'_SAN_NULLBYTEDSC','اگر کاراکتر پایانی "\\0" باشد معمولا نوعی حمله محسوب می شود.<br />با روشن کردن این گزینه بایت های خالی به فاصله تغییر می یابند.<br />(به شدت توصیه می کنم که بگذارید روشن باشد)');
define($constpref.'_DIE_NULLBYTE','اگر بایت های خالی پیدا شد، کاربر از سایت بیرون انداخته شود');
define($constpref.'_DIE_NULLBYTEDSC','اگر کاراکتر پایانی "\\0" باشد معمولا نوعی حمله محسوب می شود.<br />(به شدت توصیه می کنم که بگذارید روشن باشد)');
define($constpref.'_DIE_BADEXT','اگر کاربر فایل غیرمجاز بارگذاری کرد از سایت بیرون انداخته شود');
define($constpref.'_DIE_BADEXTDSC','اگر کسی تلاش کند پرونده هایی با پیشوندهای غیر مجاز مانند .php را بارگذاری کند، این ماژول آن کاربر را از سایت بیرون می اندازد.<br />اگر شما از ماژول هایی مانند B-Wiki یا PukiWikiMod استفاده می کنید که نیاز به بارگذاری دایم فایل های php دارند، این گزینه را خاموش کنید.');
define($constpref.'_CONTAMI_ACTION','عملکرد در صورت یافتن آلودگی');
define($constpref.'_CONTAMI_ACTIONDS','لطفا عملی را کی می خواهید سیستم در مقابل کاربری که سعی در وارد کردن ارزش های آلوده به سیستم دارد را انتخاب کنید.<br />(گزینه پیشنهادی انتخاب صفحه سفید می باشد)');
define($constpref.'_ISOCOM_ACTION','عملکرد در صورت یافتن نظرات محافظت شده');
define($constpref.'_ISOCOM_ACTIONDSC','جلوگیری از نفوذ به SQL :<br />عمکلکردی را انتخاب کنید تا در صورتی که یک "/*" محافظت شده پیدا شد، اعمال شود.<br />"پاکسازی" یعنی اضافه کردن یک "*/" دیگر، در انتها.<br />(گزینه پیشنهادی انتخاب پاکسازی می باشد)');
define($constpref.'_UNION_ACTION','عملکرد در صورتی که یک UNION پیدا شد');
define($constpref.'_UNION_ACTIONDSC','جلوگیری از نفوذ به SQL :<br />عمکلکردی را انتخاب کنید تا در صورتی که یک ترکیب مانند UNION در SQL پیدا شد، اعمال شود.<br />"پاکسازی" یعنی تغییر "union" به "uni-on" برای حفاظت بیشتر.<br />(گزینه پیشنهادی انتخاب پاکسازی می باشد)');
define($constpref.'_ID_INTVAL','تغییر متغیر های عددی به ارزش هایی مانند شماره شناسه (id)');
define($constpref.'_ID_INTVALDSC','تمامی درخواست های نامگذاری شده با "*id" به صورت یک عدد لحاظ می شود.<br />این گزینه شما را از حمله هایی از نوع XSS یا نفوذ به SQL محافظت می کند<br />درست است که من پیشنهاد می کنم این گزینه روشن باشد،ولی ممکن است با بعضی ماژول ها ناسازگار باشد.');
define($constpref.'_FILE_DOTDOT','جلوگیری از پیمایش شاخه (پوشه) ها');
define($constpref.'_FILE_DOTDOTDSC','تمامی ".." ها را از درخواست هایی که شبیه به پیمایش شاخه (پوشه) ها باشد را حذف می کند');

define($constpref.'_BF_COUNT','جلوگیری از ورود بی رحمانه');
define($constpref.'_BF_COUNTDSC','لطفا تعداد دفعاتی که کاربران میهمان مجاز به تلاش برای ورود به سایت هستند را انتخاب کنید. اگر کسی بعد از این تعداد تلاش نتواند وارد سایت شود IP او بسته خواهد شد.');

define($constpref.'_DOS_SKIPMODS','ماژول هایی که می خواهید در برابر کنترل گر داس/خزنده ها (DoS/Crawlers) چک نشوند');
define($constpref.'_DOS_SKIPMODSDSC','نام ماژول ها را با یک | از هم جدا کنید. این گزینه به درد ماژول های گفتگو و چت می خورد.');

define($constpref.'_DOS_EXPIRE','مدت زمان مجاز برای بارگیری (لود) بیش از حدمجاز (ثانیه)');
define($constpref.'_DOS_EXPIREDSC','این ارزش مشخص کننده زمان صبر کردن محافظ برای لود شدن های بسیار بالا در آن واحد (تهاجم با F5) خزنده هایی با بارگیری بیش از حد مجاز می باشد.');

define($constpref.'_DOS_F5COUNT','شمارنده برای تهاجم با F5');
define($constpref.'_DOS_F5COUNTDSC','جلوگیری از حملات DoS.<br />این ارزش مشخص کننده تعداد دفعات باز بینی یا بارگیری (لود) مجاز مجدد صفحه می باشد.');
define($constpref.'_DOS_F5ACTION','عملکرد در مقابل تهاجم با F5');

define($constpref.'_DOS_CRCOUNT','حداکثر روبات های خزنده مجاز');
define($constpref.'_DOS_CRCOUNTDSC','جلوگیری از لود بیش از حد توسط روبات های خزنده<br />این ارزش مشخص کننده تعداد دفعات مجاز برای دسترسی روبات ها به سایتتان می باشد.');
define($constpref.'_DOS_CRACTION','عملکرد در مقابل بارگیری بیش از حد مجاز روبات های جستجوگر');

define($constpref.'_DOS_CRSAFE','روبات های خزنده مجاز');
define($constpref.'_DOS_CRSAFEDSC','الگویی بکار رفته برای جدا سازی روبات های خزنده.<br />اگرخزنده در لیست روبرو باشد، تحت هیچ شرایطی جزو روبات های با لود بیش از حد مجاز قرار نمی گیرد.<br />(مثال) /(msnbot|Googlebot|Yahoo! Slurp)/i');

define($constpref.'_OPT_NONE','هیچ کاری نکن (فقط ثبت گزارش)');
define($constpref.'_OPT_SAN','پاکسازی');
define($constpref.'_OPT_EXIT','صفحه سفید');
define($constpref.'_OPT_BIP','بستن IP (بی پایان)');
define($constpref.'_OPT_BIPTIME0','بستن IP (مدت دار)');

define($constpref.'_DOSOPT_NONE','هیچ کاری نکن (فقط ثبت گزارش)');
define($constpref.'_DOSOPT_SLEEP','خوابیدن');
define($constpref.'_DOSOPT_EXIT','صفحه سفید');
define($constpref.'_DOSOPT_BIP','بستن IP (بی پایان)');
define($constpref.'_DOSOPT_BIPTIME0','بستن IP (مدت دار)');
define($constpref.'_DOSOPT_HTA','دفع با .htaccess (آزمایشی)');

define($constpref.'_BIP_EXCEPT','گروهی که هیچ وقت در لیست IP های غیرمجاز قرار نمی گیرد');
define($constpref.'_BIP_EXCEPTDSC','کاربران گروه(های) انتخابی شما هیچ وقت دسترسیشان به سایت بسته نمی شود.<br />(پیشنهاد می کنم برای مدیران روشن باشد.)');

define($constpref.'_DISABLES','غیرفعال کردن خصوصیات خطرناک در سایت');

define($constpref.'_BIGUMBRELLA',' فعال کردن محافظت در برابر تهاجم با XSS (چتر بزرگ محافظت)');
define($constpref.'_BIGUMBRELLADSC','این گزینه از شما در برابر اکثر تهاجمات XSS محافظت می کند. اما 100% نمی تواند شما را تضمین کند.<br />تهاجمات XSS شبیه به تهاجم های تزیق اسکریپ میباشد و هدف اصلی از آن هک کردن سایت نیست بلکه حمله به کاربران است در این نوع حمله مهاجم کد های خطر ناکی را در صفحات سایت وارد میکند که این کد ها رایانه ی بازدیدکنندگان را آلوده میکند.');

define($constpref.'_SPAMURI4U','محافظ-هرزنامه : آدرس ها برای کاربران عضو');
define($constpref.'_SPAMURI4UDSC','اگر تعداد لینک هایی که در پیام های کاربر عضوی بغیر از مدیران سایت بیش از حد مجاز اعلام شده باشد، آن پیام به عنوان یک هرزنامه در نظر گرفته می شود. 0 به معنای غیر فعال کردن این گزینه می باشد.');
define($constpref.'_SPAMURI4G','محافظ-هرزنامه : آدرس ها برای کاربران میهمان');
define($constpref.'_SPAMURI4GDSC','اگر تعداد لینک هایی که در پیام های کاربر میهمانی بیش از حد مجاز اعلام شده باشد، آن پیام به عنوان یک هرزنامه در نظر گرفته می شود. 0 به معنای غیر فعال کردن این گزینه می باشد.');

}

?>
<?php
// $Id: notification.php,v 1.1 2007/05/15 02:34:43 minahito Exp $

// RMV-NOTIFY

// Text for various templates...

define ('_NOT_NOTIFICATIONOPTIONS', 'تنظیمات آگهی رسانی');
define ('_NOT_UPDATENOW', 'به روز کن');
define ('_NOT_UPDATEOPTIONS', 'تنظیمات به روز رسانی');

define ('_NOT_CANCEL', 'لغو کردن');
define ('_NOT_CLEAR', 'پاک سازی');
define ('_NOT_DELETE', 'حذف');
define ('_NOT_CHECKALL', 'گزینش همه');
define ('_NOT_MODULE', 'ماژول');
define ('_NOT_CATEGORY', 'شاخه');
define ('_NOT_ITEMID', 'ID');
define ('_NOT_ITEMNAME', 'نام');
define ('_NOT_EVENT', 'رویداد');
define ('_NOT_EVENTS', 'رویداد ها');
define ('_NOT_ACTIVENOTIFICATIONS', 'آگاه سازی های فعال');
define ('_NOT_NAMENOTAVAILABLE', 'نام در دسترس نیست');
// RMV-NEW : TODO: remove NAMENOTAVAILBLE above
define ('_NOT_ITEMNAMENOTAVAILABLE', 'نام این گزینه در دسترسی نیست');
define ('_NOT_ITEMTYPENOTAVAILABLE', 'نوع این گزینه در دسترس نیست');
define ('_NOT_ITEMURLNOTAVAILABLE', 'نشانی گزینه در دسترس نیست');
define ('_NOT_DELETINGNOTIFICATIONS', 'پاک سازی آگهی ها');
define ('_NOT_DELETESUCCESS', 'آگهی ها با موفقیت پاک شد');
define ('_NOT_UPDATEOK', 'تنظیمات آگهی ها به روز شد');
define ('_NOT_NOTIFICATIONMETHODIS', 'روش آگهی');
define ('_NOT_EMAIL', 'پست الکترونیکی');
define ('_NOT_PM', 'پیام شخصی');
define ('_NOT_DISABLE', 'بسته شده');
define ('_NOT_CHANGE', 'تغییر');
define ('_NOT_RUSUREDEL', 'آیا شما مطمئن هستید که میخواهید این آگاه سازی ها را پاک کنید');
define ('_NOT_NOACCESS', 'دسترسی شما به این صفحه بسته شده ');

// Text for module config options

define ('_NOT_ENABLE', 'باز کردن');
define ('_NOT_NOTIFICATION', 'آگهی رسانی');

define ('_NOT_CONFIG_ENABLED', 'فعال سازی آگهی رسانی');
define ('_NOT_CONFIG_ENABLEDDSC', 'این ماژول به کاربران امکان میدهد از رویدادهای سایت با خبر شوند , گزینه "بله" را برای فعال سازی این امکان انتخاب کنید');

define ('_NOT_CONFIG_EVENTS', 'فعال سازی رویداد های خاص');
define ('_NOT_CONFIG_EVENTSDSC', 'انتخاب کنید آگاهی از چه رویدادی برای کدام کاربران شما فعال باشد');

define ('_NOT_CONFIG_ENABLE', 'فعال سازی آگهی رسانی');
define ('_NOT_CONFIG_ENABLEDSC', 'این ماژول به کاربران امکان میدهد از رویدادهای سایت با خبر شوند , گزینه "بله" را برای فعال سازی این امکان انتخاب کنید');
define ('_NOT_CONFIG_DISABLE', 'غیر فعال کردن آگهی رسانی');
define ('_NOT_CONFIG_ENABLEBLOCK', 'فقط نوع بلوکی فعال شود');
define ('_NOT_CONFIG_ENABLEINLINE', 'فقط نوع خطی فعال شود');
define ('_NOT_CONFIG_ENABLEBOTH', 'هر دو نوع بلوکی و خطی فعال شود');

// For notification about comment events

define ('_NOT_COMMENT_NOTIFY', 'اضافه شدن نظر');
define ('_NOT_COMMENT_NOTIFYCAP', 'وقتی نظر جدیدی برای این موضوع داده شد مرا باخبر کن');
define ('_NOT_COMMENT_NOTIFYDSC', 'وقتی نظر جدیدی برای این موضوع داده شد به من ارسال کن');
define ('_NOT_COMMENT_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE}  اطلاع رسانی خودکار: نظر اضافه شده به{X_ITEM_TYPE}');

define ('_NOT_COMMENTSUBMIT_NOTIFY', 'نظر ثبت شد');
define ('_NOT_COMMENTSUBMIT_NOTIFYCAP', 'وقتی نظر جدیدی برای این موضوع ثبت شد مرا باخبر کن');
define ('_NOT_COMMENTSUBMIT_NOTIFYDSC', 'وقتی نظر جدیدی برای این موضوع ثبت شد به من ارسال کن');
define ('_NOT_COMMENTSUBMIT_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} اطلاع رسانی خودکار:نظرثبت شده برای {X_ITEM_TYPE}');

// For notification bookmark feature
// (Not really notification, but easy to do with this module)

define ('_NOT_BOOKMARK_NOTIFY', 'نشانه');
define ('_NOT_BOOKMARK_NOTIFYCAP', 'این گزینه را نشان کن ولی آگاهی نده');
define ('_NOT_BOOKMARK_NOTIFYDSC', 'پیگیری این گزینه بدون دریافت اگهی رویداد');

// For user profile
// FIXME: These should be reworded a little...

define ('_NOT_NOTIFYMETHOD', 'روش اگهی : هنگامی که انجمنی را  پیگیری میکنید به چه روشی میخواهید از رویدادهای آن با خبر شوید؟');
define ('_NOT_METHOD_EMAIL', 'پست الکترونیکی از نشانی وارد شده');
define ('_NOT_METHOD_PM', 'پیام شخصی');
define ('_NOT_METHOD_DISABLE', 'غیر فعال');

define ('_NOT_NOTIFYMODE', 'نوع آگهی از رویداد');
define ('_NOT_MODE_SENDALWAYS', 'آگهی از تمام رویدادهای انتخاب شده');
define ('_NOT_MODE_SENDONCE', 'یک بار آگهی بده');
define ('_NOT_MODE_SENDONCEPERLOGIN', 'یک بار آگهی بده و غیر فعال کن تا ورود بعدی من');

?>

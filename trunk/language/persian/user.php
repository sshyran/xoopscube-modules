<?php
// $Id: user.php,v 1.1 2007/05/15 02:34:43 minahito Exp $
//%%%%%%		File Name user.php 		%%%%%
define('_US_NOTREGISTERED','عضو نیستید ؟  <a href=register.php>اینجا</a> را کلیک کنید.');
define('_US_LOSTPASSWORD','واژه رمز را فراموش کرده اید ؟');
define('_US_NOPROBLEM','نگران نباشید , نشانی پست الکترونیکی خود را وارد کنید ما برای شما واژه رمز را میفرستیم.');
define('_US_YOUREMAIL','پست الکترونیکی شما ');
define('_US_SENDPASSWORD','فرستادن واژه رمز');
define('_US_LOGGEDOUT','شما خارج شدید');
define('_US_THANKYOUFORVISIT','برای بازدید از سایت ما از شما متشکریم');
define('_US_INCORRECTLOGIN','شناسه کاربری یا واژه رمز درست نیست');
define('_US_LOGGINGU','از ورود شما متشکریم %s.');

// 2001-11-17 ADD
define('_US_NOACTTPADM','دسترسی این کاربر یا بسته شده یا هنوز فعال نشده , با مدیر سایت تماس بگیرید');
define('_US_ACTKEYNOT','واژه رمز برای فعال سازی کاربر درست نیست');
define('_US_ACONTACT','این کاربر قبلا فعال شده است');
define('_US_ACTLOGIN','شناسه شما فعال شد با واژه رمز ثبت شده وارد شوید');
define('_US_NOPERMISS','متاسفانه شما دسترسی برای انجام این کار ندارید');
define('_US_SURETODEL','یقین دارید که میخواهید شناسه خود را پاک کنید ؟');
define('_US_REMOVEINFO','این کار تمامی اطلاعات شما را از پایگاه داده ما پاک خواهد کرد');
define('_US_BEENDELED','شناسه شما پاک شد');
//

//%%%%%%		File Name register.php 		%%%%%
define('_US_USERREG','توجه: پر کردن گزینه هایی که ستاره ندارند اختیاری است. در شناسه کاربری می توانید کلمات فارسی ،کاراکترهای خاص مانند فاصله و غیره را به کار ببرید.شناسه را با دقت انتخاب کنید چون برای عوض کردن آن باید با یکی از گردانندگان سایت تماس بگیرید.حداکثر اندازه برای شناسه های انگلیسی 25 و برای شناسه های فارسی 12 کاراکتر بدون در نظر گرفتن فاصله است. در پر کردن پست الکترونیکی دقت کنید چون اگر غلط نوشته شده باشد نامه فعال سازی به دست شما نمی رسد.ایمیل را به صورت مثال روبرو بدون www وارد کنید : ali@yahoo.com<br><br>ثبت کاربر');
define('_US_NICKNAME','شناسه کاربری*');
define('_US_EMAIL','پست الکترونیکی*');
define('_US_ALLOWVIEWEMAIL','نمایش پست الکترونیکی به دیگر کاربران');
define('_US_WEBSITE','سایت وب');
define('_US_TIMEZONE','منطقه زمانی');
define('_US_AVATAR','شکلک');
define('_US_VERIFYPASS','یکسانی واژه رمز*');
define('_US_SUBMIT','ارسال');
define('_US_USERNAME','شناسه کاربری*');
define('_US_FINISH','پایان');
define('_US_REGISTERNG','امکان ثبت کاربر جدید نیست');
define('_US_MAILOK','دریافت اگهی های جدید در مورد سایت');
define('_US_DISCLAIMER','شرایط عضویت*');
define('_US_IAGREE','شرایط بالا را قبول دارم');
define('_US_UNEEDAGREE', 'متاسفم ,شما باید شرایط ما را قبول کنید تا بتوانید به عضویت سایت در آیید');
define('_US_NOREGISTER','متاسفانه در حال حاضر امکان عضو گیری جدید نداریم');


// %s is username. This is a subject for email
define('_US_USERKEYFOR','نامه فعال سازی برای %s');

define('_US_YOURREGISTERED','ثبت نام شما با موفقیت انجام شد , نامه فعال سازی شناسه کاربری شما به آدرس پست الکترونیکی که وارد کردید فرستاده شد , لطفا به پست الکترونیکی خود بروید و متن نامه را پیگیری کنید ');
define('_US_YOURREGMAILNG','شما ثبت نام شدید , ولی متاسفانه فرستادن نامه فعال سازی برای شما با مشکل روبرو شد , این اشتباه را به مدیر سایت یاد آوری کنید.');
define('_US_YOURREGISTERED2','شما ثبت نام شدید , باید منتظر باشید که مدیر سایت شناسه شما را فعال کند که این کمی زمان نیاز دارد , خواهش میکنیم صبر داشته باشید.');

// %s is your site name
define('_US_NEWUSERREGAT','ثبت کاربر تازه در %s');
// %s is a username
define('_US_HASJUSTREG','%s ثبت شد');

define('_US_INVALIDMAIL','خطا : پست الکترونیکی نادرست است');
define('_US_EMAILNOSPACES','خطا : پست الکترونیکی دارای فاصله است');
define('_US_INVALIDNICKNAME','خظا: شناسه کاربری نادرست');
define('_US_NICKNAMETOOLONG','شناسه کاربری باید حد اکثر  %s نویسه باشد');
define('_US_NICKNAMETOOSHORT','شناسه کاربری باید حداقل %s نویسه باشد');
define('_US_NAMERESERVED','خطا : این شناسه  وجود دارد');
define('_US_NICKNAMENOSPACES','شناسه کاربری نمیتواند فاصله داشته باشد');
define('_US_NICKNAMETAKEN','خطا : این شناسه پیش از این گرفته شده است');
define('_US_EMAILTAKEN','خطا : این پست الکترونیکی پیش از این ثبت شده است');
define('_US_ENTERPWD','خطا : شما باید واژه رمزی داشته باشید');
define('_US_SORRYNOTFOUND','متاسفانه هیچ هماهنگی بین اطلاعات کاربر وجود ندارد');




// %s is your site name
define('_US_NEWPWDREQ','در خواست واژه رمز جدید در %s');
define('_US_YOURACCOUNT', 'شناسه کاربری شما در %s');

define('_US_MAILPWDNG','فرستادن واژه رمز با پست الکترونیکی : به روز رسانی در پایگاه داده با مشکل روبرو شد , به مدیر سایت خبر دهید.');

// %s is a username
define('_US_PWDMAILED','واژه رمز %s به نشانی پست الکترونیکی اش فرستاده شد');
define('_US_CONFMAIL','نامه تاییدیه برای %s فرستاده شد.');
define('_US_ACTVMAILNG', 'فرستادن نامه آگهی رسانی برای %s با مشکل روبرو شد.');
define('_US_ACTVMAILOK', 'نامه آگهی رسانی  به %s با موفقیت فرستاده شد.');

//%%%%%%		File Name userinfo.php 		%%%%%
define('_US_SELECTNG','کاربری انتخاب نشده , برگردید و دوباره تلاش کنید');
define('_US_PM','پیام شخصی');
define('_US_ICQ','ICQ');
define('_US_AIM','AIM');
define('_US_YIM','YIM');
define('_US_MSNM','MSNM');
define('_US_LOCATION','محل زندگی');
define('_US_OCCUPATION','شغل');
define('_US_INTEREST','علاقه مندی ها');
define('_US_SIGNATURE','امضا');
define('_US_EXTRAINFO','اطلاعات بیشتر');
define('_US_EDITPROFILE','ویرایش ویژگی های فردی');
define('_US_LOGOUT','خروج');
define('_US_INBOX','پیام شخصی');
define('_US_MEMBERSINCE','عضویت از');
define('_US_RANK','نشان');
define('_US_POSTS','پیام ها');
define('_US_LASTLOGIN','آخرین ورود');
define('_US_ALLABOUT','همه چیز در باره %s');
define('_US_STATISTICS','آمار');
define('_US_MYINFO','ویژگی های من');
define('_US_BASICINFO','اطلاعات پایه ای');
define('_US_MOREABOUT','بیشتر در باره من');
define('_US_SHOWALL','نمایش همه');

//%%%%%%		File Name edituser.php 		%%%%%
define('_US_PROFILE','ویژگی های فردی');
define('_US_REALNAME','نام واقعی');
define('_US_SHOWSIG','همیشه امضاء من را زیر پیام ها قرار بده');
define('_US_CDISPLAYMODE','نوع نمایش دیدگاه ها');
define('_US_CSORTORDER','مرتب سازی دیدگاه ها بر اساس');
define('_US_PASSWORD','واژه رمز');
define('_US_TYPEPASSTWICE','برای تغییر واژه رمز دوبار واژه رمز جدید را وارد کنید');
define('_US_SAVECHANGES','ذخیره تغییرات');
define('_US_NOEDITRIGHT','متاسفانه شما دسترسی برای تغییر ویژگی های فردی این کاربر را ندارید');
define('_US_PASSNOTSAME','دو واژه رمز با یکدیگر تفاوت دارند , هر دو باید یکی باشند');
define('_US_PWDTOOSHORT','متاسفم , طول واژه رمز باید حداقل<b>%s</b> نویسه باشد');
define('_US_PROFUPDATED','ویژگی های فردی شما به روز شد');
define('_US_USECOOKIE','شناسه کاربری من تا یک سال در Cookie نگه داری شود');
define('_US_NO','نه');
define('_US_DELACCOUNT','پاک کردن شناسه');
define('_US_MYAVATAR', 'تصویر من');
define('_US_UPLOADMYAVATAR', 'وارد کردن تصویر');
define('_US_MAXPIXEL','بیشترین طول');
define('_US_MAXIMGSZ','بیشترین حجم به بایت ');
define('_US_SELFILE','انتخاب فایل');
define('_US_OLDDELETED','تصویر قبلی شما پاک شد');
define('_US_CHOOSEAVT', 'تصویری از بین تصویر ها انتخاب کنید');

define('_US_PRESSLOGIN', 'کلید بالا را برای وارد شدن فشار دهید');

define('_US_ADMINNO', 'کاربری که عضو گروه گردانندگان سایت (وب مسترها)است را نمی توانید حذف کنید');
define('_US_GROUPS', 'گروه ها');
?>
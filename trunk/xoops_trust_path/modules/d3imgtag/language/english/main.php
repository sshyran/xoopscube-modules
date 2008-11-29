<?php
//%%%%%%		Module Name 'IMGTag D3'		%%%%%

// New in IMGTag D3

// only "Y/m/d" , "d M Y" , "M d Y" can be interpreted
define( "_MD_D3IMGTAG_DTFMT_YMDHI" , "d M Y H:i" ) ;

define( "_MD_D3IMGTAG_NEXT_BUTTON" , "Next" ) ;
define( "_MD_D3IMGTAG_REDOLOOPDONE" , "Done." ) ;

define( "_MD_D3IMGTAG_BTN_SELECTALL" , "Select All" ) ;
define( "_MD_D3IMGTAG_BTN_SELECTNONE" , "Select None" ) ;
define( "_MD_D3IMGTAG_BTN_SELECTRVS" , "Select Reverse" ) ;

define( "_MD_D3IMGTAG_FMT_PHOTONUM" , "%s every page" ) ;

define( "_MD_D3IMGTAG_AM_ADMISSION" , "Admit Images" ) ;
define( "_MD_D3IMGTAG_AM_ADMITTING" , "Admitted image(s)" ) ;
define( "_MD_D3IMGTAG_AM_LABEL_ADMIT" , "Admit the photos you checked" ) ;
define( "_MD_D3IMGTAG_AM_BUTTON_ADMIT" , "Admit" ) ;
define( "_MD_D3IMGTAG_AM_BUTTON_EXTRACT" , "Extract" ) ;

define( "_MD_D3IMGTAG_AM_PHOTOMANAGER" , "Image Manager" ) ;
define( "_MD_D3IMGTAG_AM_PHOTONAVINFO" , "Image No. %s-%s (out of %s photos hit)" ) ;
define( "_MD_D3IMGTAG_AM_LABEL_REMOVE" , "Remove the images checked" ) ;
define( "_MD_D3IMGTAG_AM_BUTTON_REMOVE" , "Remove!" ) ;
define( "_MD_D3IMGTAG_AM_JS_REMOVECONFIRM" , "Are you sure?" ) ;
define( "_MD_D3IMGTAG_AM_LABEL_MOVE" , "Change category of the checked photos" ) ;
define( "_MD_D3IMGTAG_AM_BUTTON_MOVE" , "Move" ) ;
define( "_MD_D3IMGTAG_AM_BUTTON_UPDATE" , "Modify" ) ;
define( "_MD_D3IMGTAG_AM_DEADLINKMAINPHOTO" , "The main image don't exist" ) ;

define( "_MD_D3IMGTAG_RADIO_ROTATETITLE" , "Image rotation" ) ;
define( "_MD_D3IMGTAG_RADIO_ROTATE0" , "No turn" ) ;
define( "_MD_D3IMGTAG_RADIO_ROTATE90" , "Turn right" ) ;
define( "_MD_D3IMGTAG_RADIO_ROTATE180" , "Turn 180 degree" ) ;
define( "_MD_D3IMGTAG_RADIO_ROTATE270" , "Turn left" ) ;


// New IMGTag 1.0.1 (and 1.2.0)
define("_MD_D3IMGTAG_MOREPHOTOS","More Images from %s");
define("_MD_D3IMGTAG_REDOTHUMBS","Redo Thumbnails (<a href='redothumbs.php'>re-start</a>)");
define("_MD_D3IMGTAG_REDOTHUMBS2","Rebuild Thumbnails");
define("_MD_D3IMGTAG_REDOTHUMBSINFO","Setting this too high will result in server time-out.");
define("_MD_D3IMGTAG_REDOTHUMBSNUMBER","Number of thumbs at a time");
define("_MD_D3IMGTAG_REDOING","Redoing: ");
define("_MD_D3IMGTAG_BACK","Return");
define("_MD_D3IMGTAG_ADDPHOTO","Add Image");


// New IMGTag 1.0.0
define("_MD_D3IMGTAG_PHOTOBATCHUPLOAD","Register images uploaded to the server already");
define("_MD_D3IMGTAG_PHOTOUPLOAD","Image Upload");
define("_MD_D3IMGTAG_PHOTOEDITUPLOAD","Image Edit and Re-upload");
define("_MD_D3IMGTAG_MAXPIXEL","Max pixel size");
define("_MD_D3IMGTAG_MAXSIZE","Max file size(byte)");
define("_MD_D3IMGTAG_PHOTOTITLE","Title");
define("_MD_D3IMGTAG_PHOTOPATH","Path");
define("_MD_D3IMGTAG_TEXT_DIRECTORY","Directory");
define("_MD_D3IMGTAG_DESC_PHOTOPATH","Type the full path of the directory including photos to be registered");
define("_MD_D3IMGTAG_MES_INVALIDDIRECTORY","Invalid directory is specified.");
define("_MD_D3IMGTAG_MES_BATCHDONE","%s image(s) have been registered.");
define("_MD_D3IMGTAG_MES_BATCHNONE","No image(s) was detected in the directory.");
define("_MD_D3IMGTAG_PHOTODESC","Description");
define("_MD_D3IMGTAG_PHOTOCAT","Category");
define("_MD_D3IMGTAG_SELECTFILE","Select image");
define("_MD_D3IMGTAG_NOIMAGESPECIFIED","Error: No image was uploaded");
define("_MD_D3IMGTAG_FILEERROR","Error: Image filesize was too big or there is a problem with the configuration");
define("_MD_D3IMGTAG_FILEREADERROR","Error: Images are not readable.");

define("_MD_D3IMGTAG_BATCHBLANK","Leave title blank to use file names as title");
define("_MD_D3IMGTAG_DELETEPHOTO","Delete");
define("_MD_D3IMGTAG_VALIDPHOTO","Valid");
define("_MD_D3IMGTAG_PHOTODEL","Delete image?");
define("_MD_D3IMGTAG_DELETINGPHOTO","Deleting image");
define("_MD_D3IMGTAG_MOVINGPHOTO","Moving image");

define("_MD_D3IMGTAG_STORETIMESTAMP","Don't touch timestamp");

define("_MD_D3IMGTAG_POSTERC","Poster: ");
define("_MD_D3IMGTAG_DATEC","Date: ");
define("_MD_D3IMGTAG_EDITNOTALLOWED","You're not allowed to edit this comment!");
define("_MD_D3IMGTAG_ANONNOTALLOWED","Anonymous users are not allowed to post.");
define("_MD_D3IMGTAG_THANKSFORPOST","Thanks for your submission!");
define("_MD_D3IMGTAG_DELNOTALLOWED","You're not allowed to delete this comment!");
define("_MD_D3IMGTAG_GOBACK","Go Back");
define("_MD_D3IMGTAG_AREYOUSURE","Are you sure you want to delete this comment and all comments under it?");
define("_MD_D3IMGTAG_COMMENTSDEL","Comment(s) Deleted Successfully!");

// End New

define("_MD_D3IMGTAG_THANKSFORINFO","Thank you for the information. We'll look into your request shortly.");
define("_MD_D3IMGTAG_BACKTOTOP","Back to Image Top");
define("_MD_D3IMGTAG_THANKSFORHELP","Thank you for helping to maintain this directory's integrity.");
define("_MD_D3IMGTAG_FORSECURITY","For security reasons your user name and IP address will also be temporarily recorded.");

define("_MD_D3IMGTAG_MATCH","Match");
define("_MD_D3IMGTAG_ALL","ALL");
define("_MD_D3IMGTAG_ANY","ANY");
define("_MD_D3IMGTAG_NAME","Name");
define("_MD_D3IMGTAG_DESCRIPTION","Description");

define("_MD_D3IMGTAG_MAIN","Main");
define("_MD_D3IMGTAG_NEW","New");
define("_MD_D3IMGTAG_UPDATED","Updated");
define("_MD_D3IMGTAG_POPULAR","Popular");
define("_MD_D3IMGTAG_TOPRATED","Top Rated");

define("_MD_D3IMGTAG_POPULARITYLTOM","Popularity (Least to Most Hits)");
define("_MD_D3IMGTAG_POPULARITYMTOL","Popularity (Most to Least Hits)");
define("_MD_D3IMGTAG_TITLEATOZ","Title (A to Z)");
define("_MD_D3IMGTAG_TITLEZTOA","Title (Z to A)");
define("_MD_D3IMGTAG_DATEOLD","Date (Old Photos Listed First)");
define("_MD_D3IMGTAG_DATENEW","Date (New Photos Listed First)");
define("_MD_D3IMGTAG_RATINGLTOH","Rating (Lowest Score to Highest Score)");
define("_MD_D3IMGTAG_RATINGHTOL","Rating (Highest Score to Lowest Score)");
define("_MD_D3IMGTAG_LIDASC","Record Number (Bigger is latter)");
define("_MD_D3IMGTAG_LIDDESC","Record Number (Smaller is latter)");

define("_MD_D3IMGTAG_NOSHOTS","No Screenshots Available");
define("_MD_D3IMGTAG_EDITTHISPHOTO","Edit This Image");

define("_MD_D3IMGTAG_DESCRIPTIONC","Description");
define("_MD_D3IMGTAG_EMAILC","Email");
define("_MD_D3IMGTAG_CATEGORYC","Category");
define("_MD_D3IMGTAG_SUBCATEGORY","Sub-categories");
define("_MD_D3IMGTAG_LASTUPDATEC","Last Update");
define("_MD_D3IMGTAG_TELLAFRIEND","Tell a friend");
define("_MD_D3IMGTAG_SUBJECT4TAF","A photo for you!");
define("_MD_D3IMGTAG_HITSC","Hits");
define("_MD_D3IMGTAG_RATINGC","Rating");
define("_MD_D3IMGTAG_ONEVOTE","1 vote");
define("_MD_D3IMGTAG_NUMVOTES","%s votes");
define("_MD_D3IMGTAG_ONEPOST","1 post");
define("_MD_D3IMGTAG_NUMPOSTS","%s posts");
define("_MD_D3IMGTAG_COMMENTSC","Comments");
define("_MD_D3IMGTAG_RATETHISPHOTO","Rate this image.");
define("_MD_D3IMGTAG_MODIFY","Modify");
define("_MD_D3IMGTAG_VSCOMMENTS","View & Share Comments");
define("_MD_D3IMGTAG_FILESIZE", "Image filesize");
define("_MD_D3IMGTAG_FILERES", "Image Resolution");

define("_MD_D3IMGTAG_DIRECTCATSEL","SELECT A CATEGORY");
define("_MD_D3IMGTAG_THEREARE","There are <b>%s</b> Images in our Database.");
define("_MD_D3IMGTAG_LATESTLIST","Latest Listings");

define("_MD_D3IMGTAG_VOTEAPPRE","Your vote is appreciated.");
define("_MD_D3IMGTAG_THANKURATE","Thank you for taking the time to rate a photo here at %s.");
define("_MD_D3IMGTAG_VOTEONCE","Please do not vote for the same resource more than once.");
define("_MD_D3IMGTAG_RATINGSCALE","The scale is 1 - 10, with 1 being poor and 10 being excellent.");
define("_MD_D3IMGTAG_BEOBJECTIVE","Please be objective, if everyone receives a 1 or a 10, the ratings aren't very useful.");
define("_MD_D3IMGTAG_DONOTVOTE","Do not vote for your own resource.");
define("_MD_D3IMGTAG_RATEIT","Rate this image!");

define("_MD_D3IMGTAG_RECEIVED","We received your Image. Thanks!");
define("_MD_D3IMGTAG_ALLPENDING","All images are posted pending verification.");

define("_MD_D3IMGTAG_RANK","Rank");
define("_MD_D3IMGTAG_CATEGORY","Category");
define("_MD_D3IMGTAG_HITS","Hits");
define("_MD_D3IMGTAG_RATING","Rating");
define("_MD_D3IMGTAG_VOTE","Vote");
define("_MD_D3IMGTAG_TOP10","%s Top 10"); // %s is a photo category title

define("_MD_D3IMGTAG_SORTBY","Sort by:");
define("_MD_D3IMGTAG_TITLE","Title");
define("_MD_D3IMGTAG_DATE","Date");
define("_MD_D3IMGTAG_POPULARITY","Popularity");
define("_MD_D3IMGTAG_CURSORTEDBY","Images currently sorted by: %s");
define("_MD_D3IMGTAG_FOUNDIN","Found in:");
define("_MD_D3IMGTAG_PREVIOUS","Previous");
define("_MD_D3IMGTAG_NEXT","Next");
define("_MD_D3IMGTAG_NOMATCH","No image matches your request");

define("_MD_D3IMGTAG_CATEGORIES","Categories");

define("_MD_D3IMGTAG_SUBMIT","Submit");
define("_MD_D3IMGTAG_CANCEL","Cancel");

define("_MD_D3IMGTAG_MUSTREGFIRST","Sorry, you don't have permission to perform this action.<br>Please register or login first!");
define("_MD_D3IMGTAG_MUSTADDCATFIRST","Sorry, there are no categories to add to yet.<br>Please create a category first!");
define("_MD_D3IMGTAG_NORATING","No rating selected.");
define("_MD_D3IMGTAG_CANTVOTEOWN","You cannot vote on the resource you submitted.<br>All votes are logged and reviewed.");
define("_MD_D3IMGTAG_VOTEONCE2","Vote for the selected resource only once.<br>All votes are logged and reviewed.");

//%%%%%%	Module Name 'IMGTag' (Admin)	  %%%%%

define("_MD_D3IMGTAG_PHOTOSWAITING","Images Waiting for Validation");
define("_MD_D3IMGTAG_PHOTOMANAGER","Image Management");
define("_MD_D3IMGTAG_CATEDIT","Add, Modify, and Delete Categories");
define("_MD_D3IMGTAG_GROUPPERM_GLOBAL","Global Permissions");
define("_MD_D3IMGTAG_CHECKCONFIGS","Check Configs & Environment");
define("_MD_D3IMGTAG_BATCHUPLOAD","Batch Register");
define("_MD_D3IMGTAG_GENERALSET","Preferences");

define("_MD_D3IMGTAG_SUBMITTER","Submitter");
define("_MD_D3IMGTAG_DELETE","Delete");
define("_MD_D3IMGTAG_NOSUBMITTED","No New Submitted Images.");
define("_MD_D3IMGTAG_ADDMAIN","Add a MAIN Category");
define("_MD_D3IMGTAG_IMGURL","Image URL (OPTIONAL Image height will be resized to 50): ");
define("_MD_D3IMGTAG_ADD","Add");
define("_MD_D3IMGTAG_ADDSUB","Add a SUB-Category");
define("_MD_D3IMGTAG_IN","in");
define("_MD_D3IMGTAG_MODCAT","Modify Category");
define("_MD_D3IMGTAG_DBUPDATED","Database Updated Successfully!");
define("_MD_D3IMGTAG_MODREQDELETED","Modification Request Deleted.");
define("_MD_D3IMGTAG_IMGURLMAIN","Image URL (OPTIONAL and Only valid for main categories. Image height will be resized to 50): ");
define("_MD_D3IMGTAG_PARENT","Parent Category:");
define("_MD_D3IMGTAG_SAVE","Save Changes");
define("_MD_D3IMGTAG_CATDELETED","Category Deleted.");
define("_MD_D3IMGTAG_CATDEL_WARNING","WARNING: Are you sure you want to delete this Category and ALL its Photos and Comments?");
define("_MD_D3IMGTAG_YES","Yes");
define("_MD_D3IMGTAG_NO","No");
define("_MD_D3IMGTAG_NEWCATADDED","New Category Added Successfully!");
define("_MD_D3IMGTAG_ERROREXIST","ERROR: The Photo you provided is already in the database!");
define("_MD_D3IMGTAG_ERRORTITLE","ERROR: You need to enter a TITLE!");
define("_MD_D3IMGTAG_ERRORDESC","ERROR: You need to enter a DESCRIPTION!");
define("_MD_D3IMGTAG_WEAPPROVED","We approved your link submission to the photo database.");
define("_MD_D3IMGTAG_THANKSSUBMIT","Thank you for your submission!");
define("_MD_D3IMGTAG_CONFUPDATED","Configuration Updated Successfully!");

define("_MD_D3IMGTAG_LANGINFO", "Image Information");
define("_MD_D3IMGTAG_SHAREIMG", "Share Image");
define("_MD_D3IMGTAG_SHAREIMGDESC", " Share this image.");
define("_MD_D3IMGTAG_SHAREDIRECT", "Direct Link");
define("_MD_D3IMGTAG_SHAREHTML", "HTML IMG Code");
define("_MD_D3IMGTAG_SHAREHTMLLINK", "HTML Link Code");

define("_MD_D3IMGTAG_TEXT_SMNAME4", "My Photos");


?>
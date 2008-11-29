<?php

if(defined('FOR_XOOPS_LANG_CHECKER') || ! defined('D3IMGTAG_CNST_LOADED')) {
	
define('D3IMGTAG_CNST_LOADED' , 1);
	
// System Constants (Don't Edit)
define("D3IMGTAG_GPERM_INSERTABLE" , 1);
define("D3IMGTAG_GPERM_SUPERINSERT" , 2);
define("D3IMGTAG_GPERM_EDITABLE" , 4);
define("D3IMGTAG_GPERM_SUPEREDIT" , 8);
define("D3IMGTAG_GPERM_DELETABLE" , 16);
define("D3IMGTAG_GPERM_SUPERDELETE" , 32);
define("D3IMGTAG_GPERM_TOUCHOTHERS" , 64);
define("D3IMGTAG_GPERM_SUPERTOUCHOTHERS" , 128);
define("D3IMGTAG_GPERM_RATEVIEW" , 256);
define("D3IMGTAG_GPERM_RATEVOTE" , 512);
define("D3IMGTAG_GPERM_TELLAFRIEND" , 1024) ;

// Global Group Permission
define("_D3IMGTAG_GPERM_G_INSERTABLE" , "Post (Need approval)");
define("_D3IMGTAG_GPERM_G_SUPERINSERT" , "Super Post");
define("_D3IMGTAG_GPERM_G_EDITABLE" , "Edit (Need approval)");
define("_D3IMGTAG_GPERM_G_SUPEREDIT" , "Super Edit");
define("_D3IMGTAG_GPERM_G_DELETABLE" , "Delete (Need approve)");
define("_D3IMGTAG_GPERM_G_SUPERDELETE" , "Super Delete");
define("_D3IMGTAG_GPERM_G_TOUCHOTHERS" , "View images posted by others");
define("_D3IMGTAG_GPERM_G_SUPERTOUCHOTHERS" , "Super View");
define("_D3IMGTAG_GPERM_G_RATEVIEW" , "View Rate");
define("_D3IMGTAG_GPERM_G_RATEVOTE" , "Vote");
define("_D3IMGTAG_GPERM_G_TELLAFRIEND" , "Tell a friend") ;

// Caption
define("_D3IMGTAG_CAPTION_TOTAL" , "Total:");
define("_D3IMGTAG_CAPTION_GUESTNAME" , "Guest");
define("_D3IMGTAG_CAPTION_REFRESH" , "Refresh");
define("_D3IMGTAG_CAPTION_IMAGEXYT" , "Size(Type)");
define("_D3IMGTAG_CAPTION_CATEGORY" , "Category");

}

?>
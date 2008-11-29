<?php

if(! defined('XOOPS_ROOT_PATH')) exit();

	$d3imgtag_assign_globals = array(
		'mydirname' => $mydirname,
		'lang_total' => _D3IMGTAG_CAPTION_TOTAL ,
		'mod_url' => $mod_url ,
		'logo_url' => $mod_url."/images/logo".rand(1, 4).".png",
		'mod_copyright' => $mod_copyright ,
		'enable_ajax' => $d3imgtag_enableajax,
		'd3imgtag_extendedinfo' => $d3imgtag_extendedinfo,
		'd3imgtag_share' => $d3imgtag_enableshare,
		'lang_imginfo' => _MD_D3IMGTAG_LANGINFO,
		'lang_latest_list' => _MD_D3IMGTAG_LATESTLIST,
		'lang_filesize' => _MD_D3IMGTAG_FILESIZE,
		'lang_fileres' => _MD_D3IMGTAG_FILERES,
		'lang_descriptionc' => _MD_D3IMGTAG_DESCRIPTIONC ,
		'lang_lastupdatec' => _MD_D3IMGTAG_LASTUPDATEC,
		'lang_submitter' => _MD_D3IMGTAG_SUBMITTER ,
		'lang_hitsc' => _MD_D3IMGTAG_HITSC ,
		'lang_commentsc' => _MD_D3IMGTAG_COMMENTSC ,
		'lang_new' => _MD_D3IMGTAG_NEW ,
		'lang_updated' => _MD_D3IMGTAG_UPDATED ,
		'lang_shareimg' => _MD_D3IMGTAG_SHAREIMG,
		'lang_sharedirect' => _MD_D3IMGTAG_SHAREDIRECT,
		'lang_sharehtml' => _MD_D3IMGTAG_SHAREHTML,
		'lang_sharehtmllink' => _MD_D3IMGTAG_SHAREHTMLLINK,
		'lang_popular' => _MD_D3IMGTAG_POPULAR ,
		'lang_ratethisphoto' => _MD_D3IMGTAG_RATETHISPHOTO ,
		'lang_editthisphoto' => _MD_D3IMGTAG_EDITTHISPHOTO ,
		'lang_guestname' => _D3IMGTAG_CAPTION_GUESTNAME ,
		'lang_category' => _D3IMGTAG_CAPTION_CATEGORY ,
		'lang_nomatch' => _MD_D3IMGTAG_NOMATCH ,
		'lang_directcatsel' => _MD_D3IMGTAG_DIRECTCATSEL ,
		'photos_url' => $photos_url ,
		'thumbs_url' => $thumbs_url ,
		'thumbsize' => $d3imgtag_thumbsize ,
		'colsoftableview' => $d3imgtag_colsoftableview ,
		'canrateview' => $global_perms & D3IMGTAG_GPERM_RATEVIEW ,
		'canratevote' => $global_perms & D3IMGTAG_GPERM_RATEVOTE ,
		'cantellafriend' => $global_perms & D3IMGTAG_GPERM_TELLAFRIEND
	);
?>
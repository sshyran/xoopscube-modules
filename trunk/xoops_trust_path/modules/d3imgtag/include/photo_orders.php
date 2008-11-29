<?php

if(! defined('XOOPS_ROOT_PATH')) exit();

$d3imgtag_orders = array(
	"lidA" => array("lid ASC" , _MD_D3IMGTAG_LIDASC) ,
	"titleA" => array("title ASC" , _MD_D3IMGTAG_TITLEATOZ) ,
	"dateA" => array("date ASC" , _MD_D3IMGTAG_DATEOLD) ,
	"hitsA" => array("hits ASC" , _MD_D3IMGTAG_POPULARITYLTOM) ,
	"ratingA" => array("rating ASC" , _MD_D3IMGTAG_RATINGLTOH) ,
	"lidD" => array("lid DESC" , _MD_D3IMGTAG_LIDDESC) ,
	"titleD" => array("title DESC" , _MD_D3IMGTAG_TITLEZTOA) ,
	"dateD" => array("date DESC" , _MD_D3IMGTAG_DATENEW) ,
	"hitsD" => array("hits DESC" , _MD_D3IMGTAG_POPULARITYMTOL) ,
	"ratingD" => array("rating DESC" , _MD_D3IMGTAG_RATINGHTOL) ,
);

?>
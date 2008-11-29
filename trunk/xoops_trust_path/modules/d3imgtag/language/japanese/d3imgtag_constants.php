<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( 'D3IMGTAG_CNST_LOADED' ) ) {

define( 'D3IMGTAG_CNST_LOADED' , 1 ) ;

// System Constants (Don't Edit)
define( "D3IMGTAG_GPERM_INSERTABLE" , 1 ) ;
define( "D3IMGTAG_GPERM_SUPERINSERT" , 2 ) ;
define( "D3IMGTAG_GPERM_EDITABLE" , 4 ) ;
define( "D3IMGTAG_GPERM_SUPEREDIT" , 8 ) ;
define( "D3IMGTAG_GPERM_DELETABLE" , 16 ) ;
define( "D3IMGTAG_GPERM_SUPERDELETE" , 32 ) ;
define( "D3IMGTAG_GPERM_TOUCHOTHERS" , 64 ) ;
define( "D3IMGTAG_GPERM_SUPERTOUCHOTHERS" , 128 ) ;
define( "D3IMGTAG_GPERM_RATEVIEW" , 256 ) ;
define( "D3IMGTAG_GPERM_RATEVOTE" , 512 ) ;
define( "D3IMGTAG_GPERM_TELLAFRIEND" , 1024 ) ;

// Global Group Permission
define( "_D3IMGTAG_GPERM_G_INSERTABLE" , "��Ʋġ��׾�ǧ��" ) ;
define( "_D3IMGTAG_GPERM_G_SUPERINSERT" , "��Ʋġʾ�ǧ���ס�" ) ;
define( "_D3IMGTAG_GPERM_G_EDITABLE" , "�Խ��ġ��׾�ǧ��" ) ;
define( "_D3IMGTAG_GPERM_G_SUPEREDIT" , "�Խ��ġʾ�ǧ���ס�" ) ;
define( "_D3IMGTAG_GPERM_G_DELETABLE" , "����ġ��׾�ǧ��" ) ;
define( "_D3IMGTAG_GPERM_G_SUPERDELETE" , "����ġʾ�ǧ���ס�" ) ;
define( "_D3IMGTAG_GPERM_G_TOUCHOTHERS" , "¾�桼���Υ��᡼�����Խ�������ġ��׾�ǧ��" ) ;
define( "_D3IMGTAG_GPERM_G_SUPERTOUCHOTHERS" , "¾�桼���Υ��᡼�����Խ�������ġʾ�ǧ���ס�" ) ;
define( "_D3IMGTAG_GPERM_G_RATEVIEW" , "��ɼ������" ) ;
define( "_D3IMGTAG_GPERM_G_RATEVOTE" , "��ɼ��" ) ;
define( "_D3IMGTAG_GPERM_G_TELLAFRIEND" , "ͧ�ͤ��Τ餻��" ) ;

// Caption
define( "_D3IMGTAG_CAPTION_TOTAL" , "Total:" ) ;
define( "_D3IMGTAG_CAPTION_GUESTNAME" , "������" ) ;
define( "_D3IMGTAG_CAPTION_REFRESH" , "����" ) ;
define( "_D3IMGTAG_CAPTION_IMAGEXYT" , "������" ) ;
define( "_D3IMGTAG_CAPTION_CATEGORY" , "���ƥ��꡼" ) ;

	// encoding conversion if possible and needed
	function d3imgtag_callback_after_stripslashes_local( $text )
	{
		if( function_exists( 'mb_convert_encoding' ) && mb_internal_encoding() !=  mb_http_output() ) {
			return mb_convert_encoding( $text , mb_internal_encoding() , mb_detect_order() ) ;
		} else {
			return $text ;
		}
	}

}

?>
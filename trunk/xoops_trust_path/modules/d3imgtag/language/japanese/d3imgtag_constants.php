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
define( "_D3IMGTAG_GPERM_G_INSERTABLE" , "投稿可（要承認）" ) ;
define( "_D3IMGTAG_GPERM_G_SUPERINSERT" , "投稿可（承認不要）" ) ;
define( "_D3IMGTAG_GPERM_G_EDITABLE" , "編集可（要承認）" ) ;
define( "_D3IMGTAG_GPERM_G_SUPEREDIT" , "編集可（承認不要）" ) ;
define( "_D3IMGTAG_GPERM_G_DELETABLE" , "削除可（要承認）" ) ;
define( "_D3IMGTAG_GPERM_G_SUPERDELETE" , "削除可（承認不要）" ) ;
define( "_D3IMGTAG_GPERM_G_TOUCHOTHERS" , "他ユーザのイメージを編集・削除可（要承認）" ) ;
define( "_D3IMGTAG_GPERM_G_SUPERTOUCHOTHERS" , "他ユーザのイメージを編集・削除可（承認不要）" ) ;
define( "_D3IMGTAG_GPERM_G_RATEVIEW" , "投票閲覧可" ) ;
define( "_D3IMGTAG_GPERM_G_RATEVOTE" , "投票可" ) ;
define( "_D3IMGTAG_GPERM_G_TELLAFRIEND" , "友人に知らせる" ) ;

// Caption
define( "_D3IMGTAG_CAPTION_TOTAL" , "Total:" ) ;
define( "_D3IMGTAG_CAPTION_GUESTNAME" , "ゲスト" ) ;
define( "_D3IMGTAG_CAPTION_REFRESH" , "更新" ) ;
define( "_D3IMGTAG_CAPTION_IMAGEXYT" , "サイズ" ) ;
define( "_D3IMGTAG_CAPTION_CATEGORY" , "カテゴリー" ) ;

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
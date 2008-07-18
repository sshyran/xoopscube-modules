<?php

if( ! class_exists( 'd3downloadsTextSanitizer' ) )
{
	include_once( XOOPS_ROOT_PATH . '/class/module.textsanitizer.php' ) ;

	class d3downloadsTextSanitizer extends MyTextSanitizer
	{
		var $nbsp = 0 ;

		function &getInstance()
		{
			static $instance ;
			if ( ! isset( $instance ) ) {
				$instance = new d3downloadsTextSanitizer() ;
			}
			return $instance ;
		}

		// override
		function &htmlSpecialChars( $text, $forEdit=false )
		{
			if ( ! $forEdit ) {
				$ret = $this->toShow( $text ) ;
			} else {
				$ret = $this->toEdit( $text ) ;
			}
			return $ret ;
		}

		// override
		function makeTboxData4Show( $text )
		{
			return $this->toShow( $text ) ;
		}

		// override
		function &displayTarea( $text, $html = 0, $smiley = 1, $xcode = 1, $image = 1, $br = 1 )
		{
			$text = $this->codePreConv( $text, $xcode ) ;
			if ( $html != 1 ) $text = $this->toShow( $text ) ;
			$text = $this->makeClickable( $text ) ;
			if ( $smiley != 0 ) $text = $this->smiley( $text ) ;
			if ( $xcode != 0 ) $text = $this->xoopsCodeDecode( $text, $image ) ;
			if ( $br != 0 ) $text = $this->nl2Br( $text ) ;
			$text = $this->codeConv( $text, $xcode, $image ) ;
			return $text ;
		}

		// override
		function makeTboxData4Edit( $text )
		{
			return $this->toEdit( $text ) ;
		}

		// override
		function makeTareaData4Edit( $text )
		{
			return $this->toEdit( $text ) ;
		}

		// Legacy_TextFilter からお借りしました
		function toShow( $text )
		{
			return preg_replace( "/&amp;(#[0-9]+|#x[0-9a-f]+|[a-z]+[0-9]*);/i", '&\\1;', htmlspecialchars( $text, ENT_QUOTES ) ) ;
		}

		// Legacy_TextFilter からお借りしました
		function toEdit( $text )
		{
			return preg_replace( "/&amp;(#0?[0-9]{4,6};)/i", '&$1', htmlspecialchars( $text, ENT_QUOTES ) ) ;
		}

		function MyhtmlSpecialChars( $value )
		{
			if ( is_array( $value ) ) {
				return array_map( array( &$this, 'MyhtmlSpecialChars' ), $value ) ;
			} else {
				return htmlspecialchars( $value, ENT_QUOTES ) ;
			}
		}

		function MyIntval( $value )
		{
			if ( is_array( $value ) ) {
				return array_map( array( &$this, 'MyIntval' ), $value ) ;
			} else {
				return intval( $value ) ;
			}
		}

		// override
		function &stripSlashesGPC( $text, $encode='' )
		{
			if ( get_magic_quotes_gpc() ) {
				$text = stripslashes( $text ) ;
			}
			if( $this->is_japanese() && extension_loaded( 'mbstring' ) && ! empty( $encode ) ){
				$text = mb_convert_encoding( $text , mb_internal_encoding() , $encode ) ;
			}
			return $text ;
		}

		function is_japanese()
		{
			global $xoopsConfig ;
			$language = $xoopsConfig['language'];
			if( $language == 'japanese' || $language == 'ja_utf8' ){
				return true ;
			} else {
				return false ;
			}
		}

		function MystripSlashesGPC( $value, $encode='' )
		{
			if ( is_array( $value ) ) {
				return array_map( array( &$this, 'MystripSlashesGPC' ), $value ) ;
			} else {
				return trim( $this->stripSlashesGPC( $value, $encode ) ) ;
			}
		}

		// PHP4 では htmLawed、PHP5 では HTMLPurifier を利用
		function myFilter( $text )
		{
			if( substr( PHP_VERSION , 0 , 1 ) != 4 ) {
				return $this->InputHTMLPurify( $text ) ;
			} else {
				return $this->InputMyHtmlFilter( $text ) ;
			}
		}

		function InputHTMLPurify( $text )
		{
			require_once dirname( dirname( __FILE__ ) ).'/class/HTMLPurifier/HTMLPurifier.standalone.php' ;
			$config = HTMLPurifier_Config::createDefault() ;
			$config->set( 'Cache', 'SerializerPath', XOOPS_ROOT_PATH.'/cache' ) ;
			$config->set( 'Core', 'Encoding', _CHARSET ) ;
			$config->set( 'Attr', 'AllowedFrameTargets', array( '_blank' , '_self' , '_target' , '_top' ) ) ;
			$purifier = new HTMLPurifier( $config ) ;
			return $purifier->purify( $text ) ;
		}

		function InputMyHtmlFilter( $text )
		{
			require_once dirname( dirname( __FILE__ ) ).'/class/MyHtmlFilter/htmLawed.php' ;
			$config = $this->SetMyConfig() ;
			$filter = new MyHtmlFilter( $config ) ;
			return $filter->htmLawed( $text ) ;
		}

		function SetMyConfig()
		{
			$config['cdata'] = $cf['comment'] = $cf['lc_std_val'] = $cf['make_tag_strict'] = $cf['no_deprecated_attr'] = $cf['unique_ids'] = $config['css_expression'] = $cf['keep_bad'] = 0 ;
			$allowed = $this->AllowedList() ;
			$config['elements'] = is_array( $allowed ) ? strtolower( implode(',', array_keys($allowed ) ) ) : '-*';
			$config['deny_attribute'] = 'on*' ;
			$config['scheme'] = 'href: aim, feed, file, ftp, gopher, http, https, irc, mailto, news, nntp, sftp, ssh, telnet; style: nil; *:file, http, https' ;
			$config['anti_link_spam'] = array(
				'/[\\0-\\31]/',
				'/( javascript|java script|vbscript|about|data ):/i'
			) ; 
			return $config ;
		}

		// PHP4 用のホワイトリスト
		function AllowedList()
		{
			return array(
				'a'=>1,
				'abbr'=>1,
				'acronym'=>1,
				'address'=>1,
				'area'=>1,
				'b'=>1,
				'bdo'=>1,
				'big'=>1,
				'blockquote'=>1,
				'br'=>1,
				'caption'=>1,
				'center'=>1,
				'cite'=>1,
				'code'=>1,
				'col'=>1,
				'colgroup'=>1,
				'dd'=>1,
				'del'=>1,
				'dfn'=>1,
				'dir'=>1,
				'div'=>1,
				'dl'=>1,
				'dt'=>1,
				'em'=>1,
				'font'=>1,
				'h1'=>1,
				'h2'=>1,
				'h3'=>1,
				'h4'=>1,
				'h5'=>1,
				'h6'=>1,
				'hr'=>1,
				'i'=>1,
				'img'=>1,
				'ins'=>1,
				'kbd'=>1,
				'li'=>1,
				'map'=>1,
				'menu'=>1,
				'ol'=>1,
				'p'=>1,
				'pre'=>1,
				'q'=>1,
				'rb'=>1,
				'rbc'=>1,
				'rp'=>1,
				'rt'=>1,
				'rtc'=>1,
				'ruby'=>1,
				's'=>1,
				'samp'=>1,
				'small'=>1,
				'span'=>1,
				'strike'=>1,
				'strong'=>1,
				'sub'=>1,
				'sup'=>1,
				'table'=>1,
				'tbody'=>1,
				'td'=>1,
				'tfoot'=>1,
				'th'=>1,
				'thead'=>1,
				'tr'=>1,
				'tt'=>1,
				'u'=>1,
				'ul'=>1,
				'var'=>1
			); 
		}

		function makeTboxData4URLShow( $text )
		{
			require_once dirname( dirname(__FILE__) ).'/class/post_check.php' ;
			$Post_Check = new Post_Check() ;
			if( $Post_Check->urlCheck( $text ) ){
				return preg_replace( "/&amp;/i", '&', htmlspecialchars( $text, ENT_QUOTES ) ) ;
			} else {
				return $this->url_filter( htmlspecialchars( $text, ENT_QUOTES ) ) ;
			}
		}

		function url_filter( $text )
		{
			// Delete control code
			$text = preg_replace( "/[\\0-\\31]/", '', $text ) ;
			// Delete black pattern( deprecated )
			$text = preg_replace( "/javascript:/i", '', $text ) ;
			$text = preg_replace( "/java script:/i", '', $text ) ;
			$text = preg_replace( "/about:/i", '', $text ) ;
			$text = preg_replace( "/vbscript:/i", '', $text ) ;
			return $text;
		}

		function Delete_Nullbyte( $value )
		{
			if( is_array( $value ) ){
				return array_map( array( &$this, 'Delete_Nullbyte' ), $value ) ;
			} else {
				return str_replace( "\0",'', $value ) ;
			}
		}
	}
}

?>
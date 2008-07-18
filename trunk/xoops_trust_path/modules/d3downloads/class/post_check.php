<?php

if( ! class_exists( 'Post_Check' ) )
{
	class Post_Check
	{
		var $error_count;
		var $error_message;

		function check( $params )
		{
			$this->error_count = 0;
			$this->error_message = array();
			$result = array();
			for( $loop = 0 ; $loop < count( $params ) ; $loop++ ) {
				$check_value = $params[$loop]["value"];
				$check_types = $params[$loop]["type"];
				for( $check_loop = 0 ; $check_loop < count( $check_types ) ; $check_loop++ ) {
					$check_type = $check_types[$check_loop];
					$check_result = $this->checkIndividual( $check_value, $check_type );
					if( ! $check_result ) {
						$this->error_count++;
						$this->error_message[] = $params[$loop]["message"];
					}
				}
				$result[] = array(
					'error' => $this->error_count ,
					'message' => $this->error_message ,
				) ;
			}
			return $result;
		}

		function getErrorCount()
		{
			return $this->error_count;
		}

		function getErrorMessege()
		{
			return $this->error_message;
		}

		function checkIndividual( $check_value, $check_type )
		{
			$result = false;
			switch( $check_type ) {
				case "void":
					$result = $this->voidCheck( $check_value );
					break;
				case "mail":
					$result = $this->mailCheck( $check_value );
					break;
				case "url":
					$result = $this->urlCheck( $check_value );
					break;
				case "alpha":
					$result = $this->alphaCheck( $check_value );
					break;
				case "alnum":
					$result = $this->alnumCheck( $check_value );
					break;
				case "numeric":
					$result = $this->numericCheck( $check_value );
					break;
				case "integer":
					$result = $this->integerCheck( $check_value );
					break;
				case "same":
					$result = $this->sameValueCheck( $check_value );
					break;
				case "equal":
					$result = $this->lengthEqualCheck( $check_value );
					break;
				case "max":
					$result = $this->lengthMaxCheck( $check_value );
					break;
				case "min":
					$result = $this->lengthMinCheck( $check_value );
					break;
				case "format":
					$result = $this->formatCheck( $check_value );
					break;
				case "file_exists":
					$result = $this->fileexistsCheck( $check_value );
					break;
				case "is_file":
					$result = $this->is_fileCheck( $check_value );
					break;
			}
			return $result;
		}

		// 空白
		function voidCheck( $value )
		{
			$result = ( $value != "" ) ? true : false;
			return $result;
		}

		// メールアドレス
		function mailCheck( $value )
		{
			$result = ( preg_match('`^([a-z0-9_]|\-|\.|\+)+@(([a-z0-9_]|\-)+\.)+[a-z]{2,6}$`i', $value ) ) ? true : false;
			return $result;
		}

		// URL
		function urlCheck( $value, $schemes = '' )
		{
			// Set initial data
			if ( ! is_array( $schemes ) ) $schemes = array( 'http', 'https', 'ftp' );
			$deprecated = array( 'javascript', 'java script', 'vbscript', 'about', 'data' );

			$allowed_schemes = implode( '|', $schemes );
			$black_pattern = implode( '|', $deprecated );

			// Check control code
			if ( preg_match("`[\\0-\\31]`", $value ) ) {
				return false;
			}

			// Check black pattern(deprecated)
			if ( preg_match("`(".$black_pattern."):`i", $value ) ) {
				return false;
			}

			// Check rfc2396 URI Characters
			if ( preg_match( "`[^-/?:#@&=+$,\w.!~*;'()%]`", $value ) ) {
				return FALSE;
			}

			// check scheme
			if ( ! preg_match(
				"`^(?:".$allowed_schemes.")://"  // allowed_schemes
				. "(?:\w+:\w+@)?"      // ( user:pass )?
				. "("
				. "(?:[-_0-9a-z]+\.)+(?:[a-z]+)\.?|"   // ( domain name | host name | IP Address )
				. "(?:[-_0-9a-z]+)|"
				. "\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}|"
				. ")"
				. "(?::\d{1,5})?(?:/|$)`iD",   // ( :Port )?
				$value )
			) {
				return false;
			}
			return true;
		}

		// アルファベット
		function alphaCheck( $value )
		{
			$result = ( ctype_alpha( $value ) ) ? true : false;
			return $result;
		}

		// アルファベット・数字
		function alnumCheck( $value )
		{
			$result = ( ctype_alnum( $value ) ) ? true : false;
			return $result;
		}

		// 数字
		function numericCheck( $value )
		{
			$result = ( is_numeric( $value ) ) ? true : false;
			return $result;
		}

		// 整数
		function integerCheck( $value )
		{
			$result = ( preg_match( '`^[0-9]+$`' , $value ) ) ? true : false;
			return $result;
		}

		// 同じ値
		function sameValueCheck( $values )
		{
			$result = ( $values[0] == $values[1] ) ? true : false;
			return $result;
		}

		// 長さ
		function lengthEqualCheck( $values )
		{
			$result = ( strlen( $values[0] ) == $values[1] ) ? true : false;
			return $result;
		}

		function lengthMaxCheck( $values )
		{
			$result = ( strlen( $values[0] ) <= $values[1] ) ? true : false;
			return $result;
		}

		function lengthMinCheck( $values ) {
			$result = ( strlen( $values[0] ) >= $values[1] ) ? true : false;
			return $result;
		}

		// 正規表現
		function formatCheck( $values )
		{
			$result = ( preg_match( $values[1] , $values[0] ) ) ? true : false;
			return $result;
		}

		// file_exists
		function fileexistsCheck( $value )
		{
			$result = ( file_exists( $value ) ) ? true : false;
			return $result;
		}

		// is_file
		function is_fileCheck( $value )
		{
			$result = ( is_file( $value ) ) ? true : false;
			return $result;
		}
	}
}

?>
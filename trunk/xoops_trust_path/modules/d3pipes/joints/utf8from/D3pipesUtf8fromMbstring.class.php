<?php

require_once dirname(dirname(__FILE__)).'/D3pipesUtf8fromAbstract.class.php' ;

class D3pipesUtf8fromMbstring extends D3pipesUtf8fromAbstract {

	function execute( $data , $max_entries = 10 )
	{
		if( empty( $this->src_encoding ) ) $this->src_encoding = 'auto' ;

		if( is_array( $data ) ) {
			return array_map( array( $this , 'execute' ) , $data ) ;
		} else {
			return mb_convert_encoding( $data , 'UTF-8' , $this->src_encoding ) ;
		}
	}

}

?>
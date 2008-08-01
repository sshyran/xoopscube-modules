<?php

require_once dirname(__FILE__).'/D3pipesJointAbstract.class.php' ;

class D3pipesUnionAbstract extends D3pipesJointAbstract {

	var $union_ids = array() ;
	var $default_num = 10 ;

	// constructor
	function D3pipesUnionAbstract( $mydirname , $pipe_id , $option = '' )
	{
		$options = explode( '|' , $option ) ;

		$this->mydirname = $mydirname ;
		$this->pipe_id = intval( $pipe_id ) ;
		if( trim( $options[0] ) == '' ) $union_idnums = array() ;
		else $union_idnums = array_map( 'trim' , explode( ',' , $options[0] ) ) ;
		if( empty( $options[1] ) ) $options[1] = 10 ;

		foreach( $union_idnums as $idnum ) {
			@list( $pipe_id , $num ) = explode( ':' , $idnum ) ;
			if( intval( @$pipe_id ) > 0 ) {
				$this->union_ids[] = array(
					'pipe_id' => intval( $pipe_id ) ,
					'num' => intval( @$num ) > 0 ? intval( $num ) : intval( $options[1] ) ,
				) ;
			}
		}
	}

	function execute( $entries , $max_entries = 10 ) {}

	function renderOptions( $index , $current_value = null )
	{
		$index = intval( $index ) ;
		$options = explode( '|' , $current_value ) ;

		// options[0]  (entries)
		$options[0] = preg_replace( '/[^0-9,:]/' , '' , @$options[0] ) ;
		$ret_0 = _MD_D3PIPES_N4J_UNION.'<br /><input type="text" name="joint_options['.$index.'][0]" value="'.htmlspecialchars($options[0],ENT_QUOTES).'" size="40" />' ;

		// options[1]  (default num)
		$options[1] = empty( $options[1] ) ? 10 : intval( @$options[1] ) ;
		$ret_1 = _MD_D3PIPES_N4J_EACHENTRIES.':<input type="text" name="joint_options['.$index.'][1]" value="'.@$options[1].'" size="4" style="text-align:right;" />' ;

		return '<input type="hidden" name="joint_option['.$index.']" id="joint_option_'.$index.'" value="" />'.$ret_0.' &nbsp; '.$ret_1 ;
	}
}


?>
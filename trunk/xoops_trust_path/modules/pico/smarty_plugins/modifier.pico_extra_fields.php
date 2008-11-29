<?php

/**
 * Smarty plugin
 */


/**
 * Smarty pico_extra_fields modifier plugin
 *
 * Type:     modifier
 * Name:     extra_fields
 * Usage:    {"(field_name)"|pico_extra_fields:$content}
 * @link 
 * @author   
 * @param string
 * @return string
 */

function smarty_modifier_pico_extra_fields( $key = '' , $content_row )
{
	$extra_fields = @unserialize( @$content_row['extra_fields'] ) ;
	return empty( $key ) ? $extra_fields : @$extra_fields[ $key ] ;
}

?>
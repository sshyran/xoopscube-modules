<?php

function myxcmodule_update_indexes( $mydirname , $base_path )
{
	global $xoopsModule ;

	$db =& Database::getInstance() ;

	// update config of 'index_last_updated'
	$db->queryF( "UPDATE ".$db->prefix("config")." SET conf_value=UNIX_TIMESTAMP() WHERE conf_name='index_last_updated' AND conf_modid=".intval($xoopsModule->getVar('mid')) ) ;

	// delete indexes first
	$db->queryF( "DELETE FROM ".$db->prefix($mydirname."_indexes") ) ;

	// crawl directories recursively
	$GLOBALS['myxcmodule_imported_count'] = 0 ;
	myxcmodule_register_searchable_files_recursive( $mydirname , $base_path , '' ) ;

	return $GLOBALS['myxcmodule_imported_count'] ;
}


function myxcmodule_register_searchable_files_recursive( $mydirname , $base_path , $path )
{
	$db =& Database::getInstance() ;

	if( $handler = @opendir( $base_path . '/' . $path ) ) {
		while( ( $file = readdir( $handler ) ) !== false ) {
			if( substr( $file , 0 , 1 ) == '.' ) continue ;
			$full_path = $base_path . '/' . $path . $file ;
			if( is_dir( $full_path ) ) {
				myxcmodule_register_searchable_files_recursive( $mydirname , $base_path , $path . $file . '/' ) ;
			} else if( in_array( strrchr( $file , '.' ) , array( '.html' , '.htm' , '.txt' ) ) ) {
				$mtime = intval( @filemtime( $full_path ) ) ;
				$body = file_get_contents( $full_path ) ;
				if( preg_match( '/\<title\>([^<>]+)\<\/title\>/is' , $body , $regs ) ) {
					$title = $regs[1] ;
				} else {
					$title = $file ;
				}

				$result = $db->queryF( "INSERT INTO ".$db->prefix($mydirname."_indexes")." SET `filename`='".addslashes($path.$file)."', `title`='".addslashes($title)."', `mtime`='$mtime', `body`='".addslashes(strip_tags($body))."'" ) ;
				if( $result ) $GLOBALS['myxcmodule_imported_count'] ++ ;
			}
		}
	}
}

?>
<?php

require_once dirname(dirname(__FILE__)).'/include/transact_functions.php' ;

//
// TRANSACTION STAGE
//

if( ! empty( $_POST['submit'] ) ) {
	$imported_count = myxcmodule_update_indexes( $mydirname , _MD_MYXCMODULE_BASEDIR ) ;
	redirect_header( XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php?page=index' , 3 , sprintf( _MD_A_MYXCMODULE_FMT_UPDATED_INDEXES , $imported_count ) ) ;
	exit ;
}

//
// FORM STAGE
//

xoops_cp_header() ;
$mymenu_fake_uri = 'admin/index.php?page=index' ;
include dirname(__FILE__).'/mymenu.php' ;

echo "
<h3>".$xoopsModule->getVar('name')."</h3>
<form action='?page=index' method='post'>
	<input type='submit' name='submit' value='"._MD_A_MYXCMODULE_BTN_UPDATE_INDEXES."' />
</form>
"._MD_A_MYXCMODULE_LABEL_INDEXLASTUPDATED.": ".formatTimestamp(@$xoopsModuleConfig['index_last_updated']) ;

xoops_cp_footer() ;

?>
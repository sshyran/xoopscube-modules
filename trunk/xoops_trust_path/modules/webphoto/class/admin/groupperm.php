<?php
// $Id: groupperm.php,v 1.1.1.1 2008/06/21 12:22:20 ohwada Exp $

//=========================================================
// webphoto module
// 2008-04-02 K.OHWADA
//=========================================================

if( ! defined( 'XOOPS_TRUST_PATH' ) ) die( 'not permit' ) ;

//=========================================================
// class webphoto_admin_groupperm
//=========================================================
class webphoto_admin_groupperm extends webphoto_base_this
{
	var $_PERM_ARRAY = array();

//---------------------------------------------------------
// constructor
//---------------------------------------------------------
function webphoto_admin_groupperm( $dirname , $trust_dirname )
{
	$this->webphoto_base_this( $dirname , $trust_dirname );
	$this->_init();
}

function &getInstance( $dirname , $trust_dirname )
{
	static $instance;
	if (!isset($instance)) {
		$instance = new webphoto_admin_groupperm( $dirname , $trust_dirname );
	}
	return $instance;
}

function _init()
{
	$this->_PERM_ARRAY = array(
		_B_WEBPHOTO_GPERM_INSERTABLE => _AM_WEBPHOTO_GPERM_INSERTABLE ,
		_B_WEBPHOTO_GPERM_SUPERINSERT | _B_WEBPHOTO_GPERM_INSERTABLE => _AM_WEBPHOTO_GPERM_SUPERINSERT ,
//		_B_WEBPHOTO_GPERM_EDITABLE => _AM_WEBPHOTO_GPERM_EDITABLE ,
		_B_WEBPHOTO_GPERM_SUPEREDIT | _B_WEBPHOTO_GPERM_EDITABLE => _AM_WEBPHOTO_GPERM_SUPEREDIT ,
//		_B_WEBPHOTO_GPERM_DELETABLE => _AM_WEBPHOTO_GPERM_DELETABLE ,
		_B_WEBPHOTO_GPERM_SUPERDELETE | _B_WEBPHOTO_GPERM_DELETABLE => _AM_WEBPHOTO_GPERM_SUPERDELETE ,
		_B_WEBPHOTO_GPERM_RATEVIEW => _AM_WEBPHOTO_GPERM_RATEVIEW ,
		_B_WEBPHOTO_GPERM_RATEVOTE | _B_WEBPHOTO_GPERM_RATEVIEW => _AM_WEBPHOTO_GPERM_RATEVOTE ,
		_B_WEBPHOTO_GPERM_TELLAFRIEND => _AM_WEBPHOTO_GPERM_TELLAFRIEND ,
		_B_WEBPHOTO_GPERM_TAGEDIT     => _AM_WEBPHOTO_GPERM_TAGEDIT ,
	) ;
}

//---------------------------------------------------------
// main
//---------------------------------------------------------
function main()
{
	xoops_cp_header() ;

	echo $this->build_admin_menu();
	echo $this->build_admin_title( 'GROUPPERM' );

	echo $this->_build_list_groups() ;

	xoops_cp_footer() ;
}

function _build_list_groups()
{
	$form = new MyXoopsGroupPermForm( '' , $this->_MODULE_ID , _C_WEBPHOTO_GPERM_NAME , _AM_WEBPHOTO_GROUPPERM_GLOBALDESC ) ;
	foreach( $this->_PERM_ARRAY as $perm_id => $perm_name ) {
		$form->addItem( $perm_id , $perm_name ) ;
	}
	return $form->render() ;
}

// --- class end ---
}

?>
<?php

if( file_exists( XOOPS_TRUST_PATH.'/modules/coupons/class/d3pipes.class.php' ) ) {
	require_once XOOPS_TRUST_PATH.'/modules/coupons/class/d3pipes.class.php' ;
	class D3pipesBlockCouponslist extends D3pipesBlockCouponslistSubstance {}
}

?>
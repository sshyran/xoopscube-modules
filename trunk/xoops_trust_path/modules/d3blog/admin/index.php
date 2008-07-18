<?php
/*
 * $Id: index.php 40 2007-07-21 06:21:54Z hodaka $
 */
 
xoops_cp_header();
include dirname(__FILE__).'/mymenu.php';
echo '<h3>'.$xoopsModule->getVar('name').'</h3>';
xoops_cp_footer();

?>
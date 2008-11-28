<?php

/**
 * @author $Author$ 
 * @version $Id$
 *
 */

include 'adminheader.php';

define( 'OMITMYMENU' , 1 );
include 'mymenu.php';

header( 'Location:'. $adminmenu[count($adminmenu)-1]['link'] );

?>
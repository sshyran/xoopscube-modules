<?php

define( 'OMITMYMENU' , 1);
include 'mymenu.php';

//ˆê”ÊÝ’è
header( 'Location:'. $adminmenu[count($adminmenu)-1]['link'] );

?>
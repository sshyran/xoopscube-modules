<?php

define( 'OMITMYMENU' , 1);
include 'mymenu.php';

//��ʐݒ�
header( 'Location:'. $adminmenu[count($adminmenu)-1]['link'] );

?>
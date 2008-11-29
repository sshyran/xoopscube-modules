<?php
//include "../../mainfile.php";

//$rq_input= $_POST['mq_input'];
if ( is_array($_POST['mq_input']) ) { $mq_input = $_POST['mq_input']; } else { $mq_input = array(); }

if (isset($mq_input))
        $_SESSION['mq_input'] = $mq_input;

redirect_header("".XOOPS_URL."/index.php",1,_MD_D3QUOTES_LOADING);

?>
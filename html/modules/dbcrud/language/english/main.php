<?php

$dirname = basename(dirname(dirname(dirname(__FILE__))));
$affix = strtoupper(strlen($dirname) >= 3 ? substr($dirname, 0, 3) : $dirname);

include_once 'common.php';

$main_consts = array(
    '_PAGENAVI_INFO' => 'Results All% s,% s from% s show up first of all',
    '_REQ_MARK' => '<font Color="red"> (required) </ font>',
    '_SEARCH'             => 'Search',
    '_SEARCH_RESULT' => 'Search results',
    '_ADD_DATE' => 'Registered',
    '_UNAME' => 'User name registration',
    '_FILE' => 'File',
    '_ADD' => 'Register',
    '_ADD_MSG' => 'Has been registered. ',
    '_UPDATE' => 'Updated',
    '_UPDATE_MSG' => 'Has been updated. ',
    '_DELETE' => 'Delete',
    '_DELETE_CONFIRM_MSG' => 'Do you want to delete this information true? ',
    '_DELETE_MSG' => 'Has been deleted. ',
    '_DETAIL' => 'Description',
    '_CANCEL' => 'Cancel',
    '_NOT_FOUND_MSG'      => 'Not Found Msg ',
    '_REQ_ERR_MSG' => ' "% S", please be sure to input or select. ',
    '_RANGE_ERR_MSG' => ' "% S" acceptable range of input values (% s) exceeded. ',
    '_INT_ERR_MSG' => ' "% S" has entered the non-integer values. ',
    '_FLOAT_ERR_MSG' => ' "% S" non-numeric input is small. ',
    '_FILE_TYPE_ERR_MSG' => 'File "% s" could not be uploaded. ',
    '_FILE_SIZE_ERR_MSG' => 'File "% s" is greater than the capacity limit. ',
    '_FILE_SAME_ERR_MSG' => 'File "% s" can not simultaneously uploading and deleting. ',
    '_DUPLICATE_ERR_MSG' => 'For the same information as is already registered, not registered. ',
    '_TOKEN_ERR_MSG' => 'Tokunera occurred. ',
    '_SYSTEM_ERR_MSG' => 'System error has occurred. ',
    '_PARAM_ERR_MSG' => 'Parameter is incorrect. ',
    '_PERM_ERR_MSG' => 'Do not have permission to perform this operation. ',
    '_NO_ERR_MSG' => 'Information is not specified. '
);

foreach ($main_consts as $key => $value) {
    if (!defined('_MD_' . $affix . $key)) {
        define('_MD_' . $affix . $key, $value);
    }
}

?>
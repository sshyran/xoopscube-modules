<?php

require_once 'header.php';

require_once 'include/db.php';
require_once('include/groupperm_function.php');
require_once('constants.php');

$mydirname = basename( dirname( __FILE__ ) ) ;
$movie = cinemaru_movie_get_one(@$_REQUEST['id']);
$constpref = strtoupper( $mydirname ) ;

if ($movie == false) {
    exit();
}

$list = cinemaru_tag_get($_REQUEST['id']);

if (isset($xoopsUser) && isset($_SESSION['xoopsUserId'])) {
    $uid = $xoopsUser->uid();
} else {
    $uid = 0;
}

$groupperm_tag_insertable = cinemaru_checkright(constant($constpref.'_GROUPPERM_TAGINSERTABLE'));
if (($groupperm_tag_insertable == 0 && $movie['id'] != $uid) || ($xoopsModuleConfig['num_of_tag'] <= count($list)) ) {
    $can_add = ' DISABLED ';
} else {
    $can_add = '';
}
$groupperm_tag_deletable = cinemaru_checkright(constant($constpref.'_GROUPPERM_TAGDELETABLE'));
if ($groupperm_tag_deletable == 0 && $movie['id'] != $uid) {
    $can_delete = ' DISABLED ';
} else {
    $can_delete = '';
}

header('Content-type: text/html; charset=' . $xoopsModuleConfig['tag_encoding']);

print "<table>";
print "<tr><td style='width:150px;'>";
print "<input type='text' id='new_tag' maxlength='" . $xoopsModuleConfig['tag_size'] . "'></td><td> ";
print "<input type='button' value='" . _MD_CINEMARU_ADD . "' onClick=\"javascript:add_tag();\"$can_add></td></tr>";
foreach ($list as $val) {
    print "<tr><td style='width:150px;'>" . htmlspecialchars($val['name']);
    print "</td><td><input type='button' value='" . _MD_CINEMARU_DELETE . "' onClick='javascript:delete_tag(" . intval($val['tags_movie_id']) . ")' $can_delete ></td></tr> ";
}
print "</table>";

print "<a href='javascript:onlick=end_edit()'>" . _MD_CINEMARU_END_EDIT_TAG . "</a><br>";



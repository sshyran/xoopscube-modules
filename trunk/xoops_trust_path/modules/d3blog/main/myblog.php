<?php
/**
 * @version $Id: myblog.php 74 2007-08-04 05:13:32Z hodaka $
 * @author  Takeshi Kuriyama <kuri@keynext.co.jp>
 */

if (is_object($xoopsUser)) {
    header('location: '.sprintf("%s/modules/%s/index.php?uid=%d", XOOPS_URL, $mydirname, $xoopsUser->uid()));
    exit;
} else {
    header('location: '.sprintf("%s/modules/%s/index.php", XOOPS_URL, $mydirname));
    exit;
}

?>
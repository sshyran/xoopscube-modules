<?php
/**
 * @version $Id: tbkey.php 642 2010-07-02 16:42:24Z hodaka $
 * @brief Generate trackback sending onetime ticket key
 * @author Takeshi Kuriyama <kuri@keynext.co.jp>
 */

// check if user has perm
if(!$currentUser->blog_perm()) {
    exit(responseMessage('Sorry, you can\'t access this blog', 1));
}

// get blog_id
$bid = isset($_POST['bid'])? intval($_POST['bid']) : null;
if(!$bid) {
    exit(responseMessage('You sent a invalid id.', 1));
}

$entry_handler =& $myModule->getHandler('entry');
$tb_handler =& $myModule->getHandler('trackback');

$entry =& $entry_handler->getEntry($bid);
if(!$entry)
    exit(responseMessage('No such an entry.', 1));

// is trackback permitted?
if(!$entry->isTrackbackAcceptable()) {
    exit(responseMessage('You can\'t post a trackback to this entry', 1));
}

// generate trackback ticket key
$tbkey = md5($_SERVER['REMOTE_ADDR'].time().rand());
$tbkey= substr(base_convert($tbkey, 16, 32),0,12);

// save trackback
$trackback =& $tb_handler->create();

$trackback->setVar('bid', $bid);
$trackback->setVar('tbkey', $tbkey);
$trackback->setVar('direction', D3BLOG_TRACKBACK_DIRECTION_TBKEY);
$trackback->setVar("`host`", $_SERVER['REMOTE_ADDR']);
//$trackback->setNew();
if( !$tb_handler->insert($trackback) ) {
    exit(responseMessage('Server error. Can\'t save the trackback key', 1));

} else {
    // garbage ticket key
    $percetage = 5;        // perform garbage at 5%(every 20 times)
    $expiration = 3600*24;  // default 1day
    $tb_handler->garbageTrackbackKey($percetage, $expiration);

    exit(responseMessage($tbkey));
}

// return key in xml format
function responseMessage($tbkey='', $code=0) {
    header('Content-type: text/xml; charset=utf-8');
    $res = <<<EOD
<?xml version="1.0" encoding="UTF-8" ?>
<data>
<tbkey>
<error>%d</error>
<key>%s</key>
</tbkey>
</data>
EOD;
    return sprintf($res, $code, $tbkey);
}

?>

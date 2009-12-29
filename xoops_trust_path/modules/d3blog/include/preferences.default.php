<?php
/**
 * @version $Id: preferences.default.php 620 2009-08-29 01:21:28Z hodaka $
 * @author  Takeshi Kuriyama <kuri@keynext.co.jp>
 */

if( ! defined( 'XOOPS_TRUST_PATH' ) ) die( 'set XOOPS_TRUST_PATH into mainfile.php' );

// these are added to $xoopsModuleConfig and act as if they are module config
// change these as you like
$modulePrefs = array(
    'dohtml_by_default' => 1,    // 1:yes only when html allowed, 0:always no even if html allowed
    'doxcode_by_default' => 1,  // 1:yes 0:no
    'dobr_by_default' => 0,     // 1:always yes even if html allowed, 0:no when html allowed
    'increment_userpost' => 1,  // 1:yes 0:no
    'increment_usercomment' => 1,  // 1:yes 0:no
    'increment_by_owner' => 0,  // 1:yes 0:no if current user is the blogger
    'realname_first' => 1,              // 1:yes 0:no if name var represents as a user name
    'thread_order' => 'DESC',   // thread order by which
    'cookie_lifetime' => 365,    // unit: day
    'ticket_lifetime' => 30,    // unit: minute
    'url_by_entry' => 0,        // 1:yes 0:no if user can choose update ping urls
    'max_urls' => 4,            // max update ping urls
    'excerpt_chars' => 255,      // the longest max length of excerpt
    'meta_cachetime' => 60,       // unit: minute
    'archive_numperpage' => 30,  // how many lines per page in archives.php
    'css_dir' => sprintf('%s/modules/%s/css', XOOPS_ROOT_PATH, $this->mydirname)
);
?>
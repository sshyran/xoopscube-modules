<?php
/**
 * @version $Id: config.inc.php 631 2010-06-23 04:36:31Z hodaka $
 * @author  Takeshi Kuriyama <kuri@keynext.co.jp>
 */

if( ! defined( 'XOOPS_TRUST_PATH' ) ) die( 'set XOOPS_TRUST_PATH into mainfile.php' );

/******************** DON'T REMOVE OR CHANGE LINES BENEATH *******************/
$gperm_config = array(
    'blog_perm_view' => '_MD_A_D3BLOG_PERMDESC_CAN_VIEW_BLOG',
    'blog_perm_edit' => '_MD_A_D3BLOG_PERMDESC_CAN_EDIT_BLOG',
    'blog_autoapprove' => '_MD_A_D3BLOG_PERMDESC_CAN_APPROVE_BLOG_SELF',
    'allow_html' => '_MD_A_D3BLOG_PERMDESC_ALLOW_HTML',
    'blog_editor' => '_MD_A_D3BLOG_PERMDESC_EDITOR'
);

if(!defined('D3BLOG_CONFIG_CONST_VALUE')) {
    define('D3BLOG_CONFIG_CONST_VALUE', 1);

    define('D3BLOG_NO_PERM', 0);
    define('D3BLOG_CAN_VIEW', 1);
    define('D3BLOG_CAN_EDIT', 2);

    define('D3BLOG_SEPARATOR', "\n[separator]\n");
    define('D3BLOG_TRACKBACK_DIRECTION_TBKEY', 0);
    define('D3BLOG_TRACKBACK_DIRECTION_SEND', 1);
    define('D3BLOG_TRACKBACK_DIRECTION_RECEIVED', 2);

    define('D3BLOG_COM_PENDING', 1);
    define('D3BLOG_COM_ACTIVE', 2);
    define('D3BLOG_COM_HIDDEN', 3);
    define('D3BLOG_COM_TYPE_COMMENT', 1);
    define('D3BLOG_COM_TYPE_TRACKBACK', 2);
}

?>

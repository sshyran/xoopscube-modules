<?php
/**
 * @version $Id: blocks_category_list.php 334 2008-03-07 08:15:44Z hodaka $
 * @author  Takeshi Kuriyama <kuri@keynext.co.jp>
 */

function b_d3blog_category_list_show($options) {
    $mydirname = empty( $options[0] ) ? basename(dirname(dirname( __FILE__ ))) : $options[0];
    if( preg_match( '/[^0-9a-zA-Z_-]/' , $mydirname ) ) die( 'Invalid dirname' );

    $include_children = intval($options[1]);

    // language prefix
    $constpref = '_MB_' . strtoupper( $mydirname );
    // block template
    $this_template = empty( $options[2] ) ? 'db:'.$mydirname.'_block_category_list.html' : trim( $options[2] );

    $myModule = call_user_func(array($mydirname, 'getInstance'));
    $mydirname4show = htmlspecialchars($mydirname, ENT_QUOTES);

    $cat_handler =& $myModule->getHandler('category');
    $block['categoryTree'] =& $cat_handler->renderCategoryTree($include_children);

    if(empty($options['disable_renderer'])) {
        require_once XOOPS_ROOT_PATH.'/class/template.php';
        $tpl = new XoopsTpl();
        $tpl->assign('block', $block);
        $ret['content'] = $tpl->fetch($this_template);
        return $ret ;
    } else {
        return $block ;
    }

}

function b_d3blog_category_list_edit($options) {
    $mydirname = empty( $options[0] ) ? basename(dirname(dirname( __FILE__ ))) : $options[0];
    if( preg_match( '/[^0-9a-zA-Z_-]/' , $mydirname ) ) die( 'Invalid dirname' );
    $checked_yes = !empty($options[1])? ' checked="checked"' : '';
    $checked_no = empty($options[1])? ' checked="checked"' : '';
    $form  = '<table>';
    $form .= "<input type='hidden' name='options[]' value='".htmlspecialchars($mydirname, ENT_QUOTES)."' />\n" ;
    $form .= sprintf('<tr><td><b>%s</b>:<span style="padding-left:.5em;"><input type="radio" name="options[]" value="1"%s id="radio_yes" /></span><label for="radio_yes">'._YES.'</label><input type="radio" name="options[]" value="0"%s id="radio_no" /><label for="radio_no">'._NO.'</label></td></tr>',
                     _MB_D3BLOG_EDIT_INCLUDE_CHILDREN, $checked_yes, $checked_no);
    $form .= '</table>';
    return $form;
}

?>
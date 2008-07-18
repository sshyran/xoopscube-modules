<?php
$language = empty($GLOBALS['xoopsConfig']['language']) ? 'english' : $GLOBALS['xoopsConfig']['language'];
$lang_dir = dirname(__FILE__) . '/language/';
if (file_exists($lang_file = $lang_dir . $language . '/blocks.php')
      || file_exists($lang_file = $lang_dir . 'english/blocks.php')) {
    include_once $lang_file;
}

function b_xigg_categories($options)
{
    $block = array();
    if ($module_dirname = $options[0]) {
        require dirname(__FILE__) . '/common.php';
        $model =& $xigg->locator->getService('Model');
        $r =& $model->getRepository('Category');
        $categories =& $r->fetchAll();
        $html = array();
        $entities = array();
        while ($category =& $categories->getNext()) {
            $parent_id = intval($category->getParentId());
            $entities[$parent_id]['children'][] =& $category;
            unset($category);
        }
        if (!empty($entities[0]['children'])) {
            foreach (array_keys($entities[0]['children']) as $i) {
                b_xigg_categories_render($html, $entities, $entities[0]['children'][$i], XOOPS_URL . '/modules/' . $module_dirname . '/index.php', $options[1]);
            }
        }
        $block['content'] = implode("<br />\n", $html);
    }
    return $block;
}

function b_xigg_categories_render(&$html, $categories, &$category, $script, $prefixOrig, $prefix = '')
{
    $id = $category->getId();
    array_push($html, sprintf('%s<a href="%s?category_id=%d">%s</a>', $prefix, $script, $id, h($category->getLabel())));
    if (!empty($categories[$id]['children'])) {
        foreach (array_keys($categories[$id]['children']) as $i) {
            b_xigg_categories_render($html, $categories, $categories[$id]['children'][$i], $script, $prefixOrig, $prefix . $prefixOrig);
        }
    }
}

function b_xigg_categories_edit($options)
{
    $form = sprintf('<input type="hidden" name="options[]" value="%s" />', $options[0]);
    $form .= sprintf('<dl><dt>%s</dt><dd><input type="text" name="options[1]" value="%s" /></dd>', _MB_XIGG_CPREFIX, empty($options[1]) ? ' - ' : $options[1]);
    return $form;
}

function b_xigg_tag_cloud($options)
{
    $block = array();
    if ($module_dirname = $options[0]) {
        require dirname(__FILE__) . '/common.php';
        $cacher =& $xigg->locator->getService('Cacher');
        $limit = intval($options[1]);
        $id = 'b_xigg_tag_cloud_' . $limit;
        $group = 'xoops b_xigg_tag_cloud';
        if ($data = $cacher->get($id, $group)) {
            $tags = unserialize($data);
        } else {
            $tags = _b_xigg_tag_cloud_build($xigg->locator->getService('Model'), $limit, XOOPS_URL . '/modules/' . $module_dirname . '/index.php');
            $cacher->save(serialize($tags), $id, $group);
        }
        $template =& SabaiXOOPS::getTemplate($xigg, 'Xigg', $module_dirname);
        $block['content'] = $template->render('xigg_xoops_block_tagcloud.tpl', array('module_dir' => $module_dirname, 'tags' => $tags));
    }
    return $block;
}

function _b_xigg_tag_cloud_build(&$model, $limit, $urlBase)
{
    $tag_cloud = array();
    $tag_gw =& $model->getGateway('Tag');
    if ($tags = $tag_gw->getTagsWithNodeCount($limit, 'tag_name')) {
        ksort($tags);
        require_once 'Sabai/Cloud.php';
        $cloud =& new Sabai_Cloud();
        foreach (array_keys($tags) as $i) {
            $cloud->addElement($tags[$i]['tag_name'],
                               $urlBase . '/tag/' . rawurlencode($tags[$i]['tag_name']),
                               $tags[$i]['node_count']);
        }
        $tag_cloud = $cloud->build();
    }
    return $tag_cloud;
}

function b_xigg_tag_cloud_edit($options)
{
    $form = sprintf('<input type="hidden" name="options[]" value="%s" />', $options[0]);
    $form .= sprintf('<dl><dt>%s</dt><dd><input type="text" name="options[]" value="%d" /></dd>', _MB_XIGG_TAGS_NUM, $options[1]);
    return $form;
}

function b_xigg_recent_nodes($options)
{
    $block = array();
    if ($module_dirname = $options[0]) {
        require dirname(__FILE__) . '/common.php';
        $model =& $xigg->locator->getService('Model');
        $r =& $model->getRepository('Node');
        $order = array('DESC', 'DESC');
        switch ($options[2]) {
            case 'views':
                $sort = array('node_views', 'node_published', 'node_priority');
                $order = array('DESC', 'DESC', 'DESC');
                break;
            case 'date':
                $sort = array('node_published', 'node_priority');
                break;
            case 'active':
                $sort = array('node_comment_lasttime', 'node_published');
                break;
            default:
                $sort = array('node_priority', 'node_published');
        }
        $nodes =& $r->fetchByCriteria(Sabai_Model_Criteria::createValue('node_hidden', 0), $options[1], 0, $sort, $order);
        if ($nodes->size() > 0) {
            $nodes =& $nodes->with('Category');
            $nodes =& $nodes->with('User');
            $template =& SabaiXOOPS::getTemplate($xigg, 'Xigg', $module_dirname);
            $block['content'] = $template->render('xigg_xoops_block_recentnodes.tpl', array('module_dir' => $module_dirname, 'nodes' => &$nodes));
        }
    }
    return $block;
}

function b_xigg_recent_nodes_edit($options)
{
    $form = sprintf('<input type="hidden" name="options[0]" value="%s" />', $options[0]);
    $form .= sprintf('<dl><dt>%s</dt><dd><input type="text" name="options[1]" value="%d" /></dd>', _MB_XIGG_RECENT_NUM, $options[1]);
    $form .= sprintf('<dl><dt>%s</dt><dd><ul style="list-style:none">', _MB_XIGG_RECENT_ORD);
    $options[2] = empty($options[2]) ? 'priority' : $options[2];
    foreach (array('date' => _MB_XIGG_RECENT_D1ST, 'active' => _MB_XIGG_RECENT_A1ST, 'priority' => _MB_XIGG_RECENT_P1ST, 'views' => _MB_XIGG_RECENT_V1ST) as $k => $v) {
        $form .= sprintf('<li style="list-style:none"><input type="radio" name="options[2]" value="%s"%s />%s</li>', $k, $options[2] == $k ? ' checked="checked"' : '', $v);
    }
    $form .= '</ul></dd></dl>';
    return $form;
}

function b_xigg_recent_comments($options)
{
    $block = array();
    if ($module_dirname = $options[0]) {
        require dirname(__FILE__) . '/common.php';
        $model =& $xigg->locator->getService('Model');
        $r =& $model->getRepository('Comment');
        $vars['comments'] =& $r->fetchAll($options[1], 0, 'comment_created', 'DESC');
        $vars['module_dir'] = $module_dirname;
        $template =& SabaiXOOPS::getTemplate($xigg, 'Xigg', $module_dirname);
        $block['content'] = $template->render('xigg_xoops_block_recentcomments.tpl', $vars);
    }
    return $block;
}

function b_xigg_recent_comments_edit($options)
{
    $form = sprintf('<input type="hidden" name="options[]" value="%s" />', $options[0]);
    $form .= sprintf('<dl><dt>%s</dt><dd><input type="text" name="options[]" value="%d" /></dd></dl>', _MB_XIGG_COMMENTS_NUM, $options[1]);
    return $form;
}

function b_xigg_recent_trackbacks($options)
{
    $block = array();
    if ($module_dirname = $options[0]) {
        require dirname(__FILE__) . '/common.php';
        $model =& $xigg->locator->getService('Model');
        $r =& $model->getRepository('Trackback');
        $vars['trackbacks'] =& $r->fetchAll($options[1], 0, 'trackback_created', 'DESC');
        $vars['module_dir'] = $module_dirname;
        $template =& SabaiXOOPS::getTemplate($xigg, 'Xigg', $module_dirname);
        $block['content'] = $template->render('xigg_xoops_block_recenttrackbacks.tpl', $vars);
    }
    return $block;
}

function b_xigg_recent_trackbacks_edit($options)
{
    $form = sprintf('<input type="hidden" name="options[]" value="%s" />', $options[0]);
    $form .= sprintf('<dl><dt>%s</dt><dd><input type="text" name="options[]" value="%d" /></dd></dl>', _MB_XIGG_TRACKBACKS_NUM, $options[1]);
    return $form;
}

function b_xigg_recent_votes($options)
{
    $block = array();
    if ($module_dirname = $options[0]) {
        require dirname(__FILE__) . '/common.php';
        $model =& $xigg->locator->getService('Model');
        $r =& $model->getRepository('Vote');
        $vars['votes'] =& $r->fetchAll($options[1], 0, 'vote_created', 'DESC');
        $vars['module_dir'] = $module_dirname;
        $template =& SabaiXOOPS::getTemplate($xigg, 'Xigg', $module_dirname);
        $block['content'] = $template->render('xigg_xoops_block_recentvotes.tpl', $vars);
    }
    return $block;
}

function b_xigg_recent_votes_edit($options)
{
    $form = sprintf('<input type="hidden" name="options[]" value="%s" />', $options[0]);
    $form .= sprintf('<dl><dt>%s</dt><dd><input type="text" name="options[]" value="%d" /></dd></dl>', _MB_XIGG_VOTES_NUM, $options[1]);
    return $form;
}

function b_xigg_recent_nodes2($options)
{
    $block = array();
    if ($module_dirname = $options[0]) {
        require dirname(__FILE__) . '/common.php';
        $model =& $xigg->locator->getService('Model');
        $r =& $model->getRepository('Node');
        $c =& Sabai_Model_Criteria::createValue('node_hidden', 0);
        $sort = !empty($options[5]) ? array('node_priority', 'node_published') : array('node_published', 'node_priority');
        $nodes =& $r->fetchByCriteria($c, $options[1], 0, $sort, array('DESC', 'DESC'));
        if ($nodes->size() > 0) {
            $nodes =& $nodes->with('Category'); $nodes =& $nodes->with('Tags'); $nodes =& $nodes->with('User');
            $top_nodes =& $r->fetchByCriteria($c, $options[2], 0, 'node_vote_count', 'DESC');
            $top_nodes =& $top_nodes->with('Tags'); $top_nodes =& $top_nodes->with('Category');
            $vars['module_dir'] = $module_dirname;
            $vars['nodes'] =& $nodes;
            $vars['top_nodes'] =& $top_nodes;
            $vars['xoops_script'] = XOOPS_URL . '/modules/' . $module_dirname . '/index.php';
            $vars['featured_nodes_count'] = isset($options[3]) ? intval($options[3]) : 1;
            $vars['show_screenshot'] = empty($options[4]) ? false : true;
            if (file_exists(XOOPS_ROOT_PATH . '/themes/' . $GLOBALS['xoopsConfig']['theme_set'] . '/modules/Xigg/css/screen.css')) {
                $vars['css_url'] = XOOPS_URL . '/themes/' . $GLOBALS['xoopsConfig']['theme_set'] . '/modules/Xigg/css/screen.css';
            } else {
                $vars['css_url'] = sprintf('%s/modules/%s/layouts/default/css/screen.css', XOOPS_URL, $module_dirname);
            }
            $template =& SabaiXOOPS::getTemplate($xigg, 'Xigg', $module_dirname);
            $block['content'] = $template->render('xigg_xoops_block_recentnodes2.tpl', $vars);
        }
    }
    return $block;
}

function b_xigg_recent_nodes2_edit($options)
{
    $form = sprintf('<input type="hidden" name="options[0]" value="%s" />', $options[0]);
    $form .= sprintf('<dl><dt>%s</dt><dd><input type="text" name="options[1]" value="%d" /></dd>', _MB_XIGG_RECENT_NUM, $options[1]);
    $form .= sprintf('<dt>%s</dt><dd><input type="text" name="options[2]" value="%d" /></dd>', _MB_XIGG_TOPVOTED_NUM, $options[2]);
    $form .= sprintf('<dt>%s</dt><dd><input type="text" name="options[3]" value="%d" /></dd></dl>', _MB_XIGG_RECENT_FNUM, $options[3]);
    $form .= sprintf('<dt>%s</dt><dd><input type="radio" name="options[4]" value="1"%s />%s<input type="radio" name="options[4]" value="0"%s />%s</dd></dl>', _MB_XIGG_RECENT_FSHOT, !empty($options[4]) ? ' checked="checked"' : '', _YES, empty($options[4]) ? ' checked="checked"' : '', _NO);
    $form .= sprintf('<dt>%s</dt><dd><input type="radio" name="options[5]" value="1"%s />%s<input type="radio" name="options[5]" value="0"%s />%s</dd></dl>', _MB_XIGG_RECENT_P1ST, !empty($options[5]) ? ' checked="checked"' : '', _YES, empty($options[5]) ? ' checked="checked"' : '', _NO);
    return $form;
}
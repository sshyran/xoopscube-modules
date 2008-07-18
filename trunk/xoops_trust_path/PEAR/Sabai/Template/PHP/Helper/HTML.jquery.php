<?php
/**
 * Short description for file
 *
 * Long description for file (if any)...
 *
 * LICENSE: LGPL
 *
 * @category   Sabai
 * @package    Sabai_Template
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      File available since Release 0.1.5
*/

function link_to($linkText, $urlParts, $attributes = array())
{
    echo create_link_to($linkText, $urlParts, $attributes);
}

function link_to_remote($linkText, $update, $linkUrl, $ajaxUrl = null, $options = array(), $attributes = array())
{
    echo create_link_to_remote($linkText, $update, $linkUrl, $ajaxUrl, $options, $attributes);
}

function create_link_to($linkText, $urlParts, $attributes = array())
{
    $attr = array();
    foreach ($attributes as $k => $v) {
        $attr[] = sprintf(' %s="%s"', $k, str_replace('"', '&quot;', $v));
    }
    return sprintf('<a href="%s"%s>%s</a>', Sabai_URL::getByArray($urlParts), implode('', $attr), $linkText);
}

function create_link_to_remote($linkText, $update, $linkUrl, $ajaxUrl = null, $options = array(), $attributes = array())
{
    static $count = 0;
    $ajaxUrl = !isset($ajaxUrl) ? $linkUrl : $ajaxUrl;
	$ajaxUrl['params'][SABAI_REQUEST_WEB_PARTIAL_PARAM] = 1;
    $html = array();
    $ajax_options[] = sprintf('dataType: "html", url: "%s"', Sabai_URL::getByArray($ajaxUrl));
    $ajax_options[]  = !empty($options['post']) ? 'type: "post"' : 'type: "get"';
    $toggle = $replace = '';
    if (!empty($options['toggle'])) {
        $ajax_options[] = sprintf('success: function(data){jQuery("#%1$s").hide().html(data).slideDown("slow");new Effect.ScrollTo("%1$s", {offset: -20});}', $update);
        $toggle = sprintf('jQuery("#%1$s-remote%2$d").css("display", "none");jQuery("#%1$s-toggle%2$d").css("display", "");', $update, $count);
        $toggle_onclick = sprintf('if(jQuery("#%1$s").is(":hidden")){jQuery("#%1$s").slideDown("slow");new Effect.ScrollTo("%1$s", {offset: -20});}else{jQuery("#%1$s").slideUp("slow");}return false;', $update);
        $html[] = sprintf("<a href='' id='%1\$s-toggle%3\$d' style='display:none;' onclick='%4\$s'>%2\$s</a>", $update, $linkText, $count, $toggle_onclick);
    } else {
        $ajax_options[] = sprintf('success: function(data){jQuery("#%1$s").html(data);new Effect.ScrollTo("%1$s", {offset: -20});}', $update);
    }
    if (!empty($options['failure'])) {
        $ajax_options[] = sprintf('error: function(request, status, error){jQuery("#%s").text(error);}', $options['failure']);
    }
    if (!empty($options['replace'])) {
        $replace = sprintf('jQuery(this).parent().html("%s");', $options['replace']);
    }
    $html[] = sprintf("<a href='%3\$s' id='%1\$s-remote%7\$d' onclick='jQuery.ajax({%4\$s});%5\$s%6\$sreturn false;});'>%2\$s</a>", $update, $linkText, Sabai_URL::getByArray($linkUrl), implode(',', $ajax_options), $toggle, $replace, $count);
    ++$count;
    return implode('', $html);
}

function select_to_remote($name, $value, $update, $options, $actionUrl, $submit, $formId = null, $ajaxUrl = null, $attributes = array())
{
    echo create_select_to_remote($name, $value, $update, $options, $actionUrl, $submit, $formId, $ajaxUrl, $attributes);
}

function create_select_to_remote($name, $value, $update, $options, $actionUrl, $submit, $formId = null, $ajaxUrl = null, $attributes = array())
{
    $form_id = !isset($formId) ? md5(uniqid(rand(), true)) : h($formId);
    $ajaxUrl = !isset($ajaxUrl) ? $actionUrl : $ajaxUrl;
	$ajaxUrl['params'][SABAI_REQUEST_WEB_PARTIAL_PARAM] = 1;
    $html[] = sprintf('<form style="display:inline; margin:0; padding:0;" method="get" action="%2$s">
<select id="%3$s" name="%1$s">', h($name), Sabai_URL::getByArray($actionUrl), $form_id);
    foreach (array_keys($options) as $v) {
        if ($v == $value) {
            $html[] = sprintf('<option value="%s" selected="selected">%s</option>', h($v), h($options[$v]));
        } else {
            $html[] = sprintf('<option value="%s">%s</option>', h($v), h($options[$v]));
        }
    }
    $html[] = sprintf('</select> <input id="%s-submit" type="submit" value="%s" />', $form_id, h($submit));
    foreach ((array)@$actionUrl['params'] as $param_k => $param_v) {
        $html[] = sprintf('<input type="hidden" name="%s" value="%s" />', h($param_k), h($param_v));
    }
    $html[] = sprintf('</form>
<script type="text/javascript">
jQuery("input#%3$s-submit").css("display", "none");
jQuery("select#%3$s").change(function(){
  jQuery.ajax({url: "%2$s", type: "get", dataType: "html", data: this.serialize(), success: function(data){
    alert(data);jQuery("#%1$s").html(data); new Effect.ScrollTo("%1$s", {offset: -20});}}
  );
});
</script>', $update, Sabai_URL::getByArray($ajaxUrl), $form_id);
    return implode("\n", $html);
}

function form_tag($method = 'post', $action = null, $attributes = array())
{
    $method = strcasecmp($method, 'get') == 0 ? 'get' : 'post';
    if (isset($action)) {
    	$attributes['action'] = $action;
    }
    $attr = array();
    foreach ($attributes as $k => $v) {
        $attr[] = sprintf(' %s="%s"', $k, str_replace('"', '&quot;', $v));
    }
    printf('<form method="%s"%s>', $method, implode('', $attr));
}

function form_tag_end()
{
    print('</form>');
}

function link_to_toggle($toggle, $hidden = false, $hideText = '[-]', $showText = '[+]')
{
    // set display to none so that the toggle link will not show if JS disabled
    printf('<a href="" id="%s-toggle" style="display:none;">%s</a>', $toggle, $hidden ? $showText : $hideText);
    printf('<script type="text/javascript">
jQuery("#%1$s-toggle").css("display", "").click(function() {
  if (jQuery("#%1$s").is(":hidden")) {
    jQuery("#%1$s").slideDown("slow"); jQuery("#%1$s-toggle").text("%3$s");
  } else {
    jQuery("#%1$s").slideUp("slow"); jQuery("#%1$s-toggle").text("%2$s");
  }
  return false;
});
</script>', $toggle, $showText, $hideText);
}

function link_to_hide_class($class, $hideText = '[-]', $showText = '[+]', $toggleSelector = null)
{
    $toggle_js = isset($toggleSelector) ?
                   sprintf('jQuery("%s").text("%s");', $toggleSelector, $showText) :
                   '';
    // set display to none so that the toggle link will not show if JS disabled
    printf('<a href="" id="%1$s-hide" style="display:none;">%2$s</a>
<script type="text/javascript">
jQuery("#%1$s-hide").css("display", "").click(
  function () {
    jQuery(".%1$s").slideUp("slow");%3$s
    return false;
  }
);
</script>', $class, h($hideText), $toggle_js);
}

function link_to_show_class($class, $showText = '[+]', $hideText = '[-]', $toggleSelector = null)
{
    $toggle_js = isset($toggleSelector) ?
                   sprintf('jQuery("%s").text("%s");', $toggleSelector, $hideText) :
                   '';
    // set display to none so that the toggle link will not show if JS disabled
    printf('<a href="" id="%1$s-show" style="display:none;">%2$s</a>
<script type="text/javascript">
jQuery("#%1$s-show").css("display", "").click(
  function () {
    jQuery(".%1$s").slideDown("slow");%3$s
    return false;
  }
);
</script>', $class, h($showText), $toggle_js);
}
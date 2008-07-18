<?php
class Sabai_Template_PHP_Helper_HTML extends Sabai_Template_PHP_Helper
{
    function linkTo($linkText, $urlParts, $attributes = array())
    {
        echo $this->createLinkTo($linkText, $urlParts, $attributes);
    }

    function linkToRemote($linkText, $update, $linkUrl, $ajaxUrl = array(), $options = array(), $attributes = array())
    {
        echo $this->createLinkToRemote($linkText, $update, $linkUrl, $ajaxUrl, $options, $attributes);
    }

    function createLinkTo($linkText, $urlParts, $attributes = array())
    {
        $attr = array();
        foreach ($attributes as $k => $v) {
            $attr[] = sprintf(' %s="%s"', $k, str_replace('"', '&quot;', $v));
        }
        return sprintf('<a href="%s"%s>%s</a>', $this->_tpl->Request->createUri($urlParts), implode('', $attr), $linkText);
    }

    function createLinkToRemote($linkText, $update, $linkUrl, $ajaxUrl = array(), $options = array(), $attributes = array())
    {
        $ajaxUrl = array_merge($linkUrl, $ajaxUrl);
        $html = array();
        $ajax_options[] = !empty($options['post']) ? "method:'post'" : "method:'get'";
        $toggle = $replace = '';
        if (!empty($options['toggle'])) {
            $attributes['id'] = $update . '-show';
            $attributes['class'] = !empty($attributes['class']) ? $attributes['class'] . ' toggleClosed' : 'toggleClosed';
            $toggle = sprintf("\$('%1\$s-show').hide(); \$('%1\$s-hide').show();", $update);
            $html[] = sprintf('<a href="" id="%1$s-hide" style="display:none;" class="toggleOpen">%2$s</a>
<script type="text/javascript">
Event.observe("%1$s-hide", "click", function(evt) {
  Effect.toggle("%1$s", "blind");
  Event.stop(evt);
});
</script>', $update, $linkText);
            $ajax_options[] = sprintf("evalScripts:true, onLoading:function(req){\$('%1\$s').update('<div>Loading...</div>');}, onSuccess:function(req){\$('%1\$s').hide().update(req.responseText);
Effect.toggle('%1\$s', 'blind');}", $update);
        } else {
            $ajax_options[] = "evalScripts:true, onSuccess:function(req){\$('$update').update(req.responseText);}";
        }
        if ($failure = @$options['failure']) {
            $ajax_options[] = "onFailure:function(req){\$('$failure').update(req.responseText);}";
        }
        if (!empty($options['replace'])) {
            $replace = sprintf("this.up().update('%s');", $options['replace']);
        }
        $attributes['onclick'] = sprintf("
new Ajax.Request('%2\$s', {%3\$s});%4\$s%5\$s new Effect.ScrollTo('%1\$s', {offset:-20}); return false;", $update, $this->_tpl->Request->createUri($ajaxUrl), implode(', ', $ajax_options), $toggle, $replace);
        $html[] = $this->createLinkTo($linkText, $linkUrl, $attributes);
        return implode("\n", $html);
    }

    function selectToRemote($name, $value, $update, $options, $actionUrl, $submit, $ajaxUrl = array(), $formId = null, $attributes = array())
    {
        echo $this->createSelectToRemote($name, $value, $update, $options, $actionUrl, $submit, $ajaxUrl, $formId, $attributes);
    }

    function createSelectToRemote($name, $value, $update, $options, $actionUrl, $submit, $ajaxUrl = array(), $formId = null, $disableSelf = false, $attributes = array())
    {
        $form_id = !isset($formId) ? md5(uniqid(rand(), true)) : h($formId);
        $ajaxUrl = array_merge($actionUrl, $ajaxUrl);
        if ($disableSelf) {
            $onchange[] = sprintf("if (this.value == '%s') return;", $value);
        }
        $onchange[] = sprintf("
new Ajax.Request(
  '%2\$s',
  {onSuccess: function(req){\$('%1\$s').update(req.responseText);},
   method: 'get',
   evalScripts: true,
   parameters: Form.serialize(\$('%3\$s'), true)
  });
new Effect.ScrollTo('%1\$s', {offset: -20});
return false;", $update, $this->_tpl->Request->createUri($ajaxUrl), $form_id);
        $html[] = sprintf('<form style="display:inline; margin:0; padding:0;" id="%4$s" method="get" action="%2$s"><select name="%1$s" onchange="%3$s">', h($name), $this->_tpl->Request->createUri($actionUrl), implode("\n", $onchange), $form_id);
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

        $html[] = sprintf('<input type="hidden" name="%1$s" value="%2$s" />
</form>
<script type="text/javascript">
$("%3$s-submit").hide();
</script>', $this->_tpl->Request->getRouteParam(), $actionUrl['base'], $form_id);
        return implode("\n", $html);
    }

    function formTag($method = 'post', $actionUrl = array(), $attributes = array())
    {
        $route_html = '';
        if (strcasecmp($method, 'get') == 0) {
            $method = 'get';
            // embed route parameter if method is get and route is not an empty string
            if (!empty($actionUrl['base'])) {
                $route_html = sprintf('<input type="hidden" name="%1$s" value="%2$s" />', $this->_tpl->Request->getRouteParam(), @$actionUrl['base']);
            }
        } else {
            $method = 'post';
        }
        if (!empty($actionUrl)) {
            $attributes['action'] = $this->_tpl->Request->createUri($actionUrl);
        }
        $attr = array();
        foreach ($attributes as $k => $v) {
            $attr[] = sprintf(' %s="%s"', $k, str_replace('"', '&quot;', $v));
        }
        printf('<form method="%s"%s>%s', $method, implode('', $attr), $route_html);
    }

    function formTagEnd()
    {
        print('</form>');
    }

    function linkToToggle($toggle, $hidden = false, $hideText = '[-]', $showText = '[+]')
    {
        // set display to none so that the toggle link will not show if JS disabled
        printf('<a href="" id="%s-toggle" style="display:none;">%s</a>', $toggle, $hidden ? $showText : $hideText);
        $hide_toggle = $hidden ? sprintf('document.observe("dom:loaded", function() {$("%1$s").hide()}); Ajax.Responders.register({onComplete: function() {$("%1$s").hide()}});', $toggle) : '';
        printf('<script type="text/javascript">%4$s
$("%1$s-toggle").show();
$("%1$s-toggle").observe("click", function(evt) {
  Effect.toggle("%1$s", "blind");
  Event.stop(evt);
  if ($("%1$s").visible()) {
    $("%1$s-toggle").update("%3$s");
  }else {
    $("%1$s-toggle").update("%2$s");
  }
});
</script>', $toggle, $hideText, $showText, $hide_toggle);
    }

    function linkToHideClass($class, $hideText = '[-]', $showText = '[+]')
    {
        // set display to none so that the toggle link will not show if JS disabled
        printf('<a href="" id="%1$s-hide" style="display:none;">%2$s</a>
<script type="text/javascript">
$("%1$s-hide").show();
$("%1$s-hide").observe("click", function(evt) {
  $$("div.%1$s").each(function(ele) {
    if (ele.visible()) {
      Effect.BlindUp(ele);
      $(ele.id + "-toggle").update("%3$s");
    }
  });
  Event.stop(evt);
});
</script>', $class, $hideText, $showText);
    }

    function linkToShowClass($class, $showText = '[+]', $hideText = '[-]')
    {
        // set display to none so that the toggle link will not show if JS disabled
        printf('<a href="" id="%1$s-show" style="display:none;">%2$s</a>
<script type="text/javascript">
$("%1$s-show").show();
$("%1$s-show").observe("click", function(evt) {
  $$("div.%1$s").each(function(ele) {
    if (!ele.visible()) {
      Effect.BlindDown(ele);
      $(ele.id + "-toggle").update("%3$s");
    }
  });
  Event.stop(evt);
});
</script>', $class, $showText, $hideText);
    }
}
<?php
if (!class_exists('Sabai')) exit();

class Xigg_Plugin_TinyMCE extends Xigg_Plugin
{
    function onShowNodeForm(&$form, $isEdit, &$context)
    {
        if (!$context->user->hasPermission('tinymce use')) {
            return;
        }
        $syntax =& $form->getElement('content_syntax');
        $syntax->addOption('TinyMCE', 'TinyMCE');
        if ($syntax->getValue() == 'TinyMCE') {
            require_once dirname(__FILE__) . '/ShowNodeFormTextarea.php';
            $form->addElement(new Xigg_Plugin_TinyMCE_ShowNodeFormTextarea($form->getElement('teaser'), 'tinymce_teaser', $this->_params['cols'], $this->_params['rows']),
                              $form->getElementLabel('teaser'));
            $form->addElement(new Xigg_Plugin_TinyMCE_ShowNodeFormTextarea($form->getElement('body'), 'tinymce_body', $this->_params['cols'], $this->_params['rows']),
                              $form->getElementLabel('body'));
        }
    }

    function onMainExecute($controllerName, &$context)
    {
        if (!$context->user->hasPermission('tinymce use')) {
            return;
        }
        if (in_array($controllerName, array('SubmitNodeForm', 'EditNodeForm'))) {
            $context->response->addJSFile($context->request->getScriptUriDir() . '/plugins/TinyMCE/js/tiny_mce.js');
            $lang = Sabai_I18N::lang();
            if ($pos = strpos($lang, '-')) {
                $lang = substr($lang, 0, $pos);
            }
            $js = sprintf('tinyMCE.init({
	mode : "exact",
	elements: "tinymce_teaser,tinymce_body",
	button_tile_map : true,
	plugins : "table,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,zoom,searchreplace,contextmenu",
	theme_advanced_buttons1_add : "fontselect,fontsizeselect",
	theme_advanced_buttons2_add : "separator,insertdate,inserttime,preview,zoom,separator,forecolor,backcolor",
	theme_advanced_buttons2_add_before: "cut,copy,paste,separator,search,replace,separator",
	theme_advanced_buttons3_add_before : "tablecontrols,separator",
	theme_advanced_buttons3_add : "emotions,iespell,advhr",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_path_location : "bottom",
	cleanup: false,
	plugin_insertdate_dateFormat : "%%Y-%%m-%%d",
	plugin_insertdate_timeFormat : "%%H:%%M:%%S",
	extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]"
});', $context->request->getScriptUriDir(), $lang);
            $context->response->addJSFoot($js);
            $context->response->addJSHeadAjax("if ($('tinymce_body')) { tinyMCE.execCommand('mceAddControl', false, 'tinymce_body'); tinyMCE.execCommand('mceFocus', false, 'tinymce_body');}
if ($('tinymce_teaser')) tinyMCE.execCommand('mceAddControl', false, 'tinymce_teaser');");
        }
    }

    function onRolePermissions(&$permissions, &$context)
    {
        $permissions[$this->_name] = array(
                                      'tinymce use' => $this->_('Use TinyMCE editor'),
                                    );
    }
}
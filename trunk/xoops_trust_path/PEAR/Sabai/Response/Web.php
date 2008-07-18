<?php
/**
 * Short description for file
 *
 * Long description for file (if any)...
 *
 * LICENSE: LGPL
 *
 * @category   Sabai
 * @package    Sabai_Response
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      File available since Release 0.1.1
*/

/**
 * Sabai_Response
 */
require 'Sabai/Response.php';

/**
 * Short description for class
 *
 * Long description for class (if any)...
 *
 * @category   Sabai
 * @package    Sabai_Response
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @author     Kazumi Ono <onokazu@gmail.com>
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      Class available since Release 0.1.1
 */
class Sabai_Response_Web extends Sabai_Response
{
    var $_tpl;
    var $_tplExtension = '.tpl';
    var $_contentType = 'text/html';
    var $_charset = SABAI_CHARSET;
    var $_redirect = true;
    var $_layout = false;
    var $_layoutURL;
    var $_layoutDir;
    var $_layoutFile;
    var $_jsHead;
    var $_jsFoot;
    var $_jsFiles;
    var $_css;
    var $_cssFiles;
    var $_htmlHead;
    var $_pageTitle;

    function Sabai_Response_Web(&$tpl)
    {
        $this->_tpl =& $tpl;
    }

    function setLayout($layoutURL, $layoutDir, $layoutFile = null)
    {
        $this->_layout = true;
        $this->_layoutURL = $layoutURL;
        $this->_layoutDir = $layoutDir;
        $this->_layoutFile = $layoutFile;
        $this->addCSSFile($this->_layoutURL . '/css/screen.css');
        $this->addCSSFile($this->_layoutURL . '/css/print.css', 'print');
    }

    function noLayout()
    {
        $this->_layout = false;
    }

    function &getTemplate()
    {
        return $this->_tpl;
    }

    function setContentType($contentType)
    {
        $this->_contentType = $contentType;
    }

    function setCharset($charset)
    {
        $this->_charset = $charset;
    }

    function setTplExtension($extension)
    {
        $this->_tplExtension = $extension;
    }

    function setRedirect($flag = true)
    {
        $this->_redirect = (bool)$flag;
    }

    function send(&$request)
    {
        header(sprintf('Content-type: %s; charset=%s', $this->_contentType, $this->_charset));
        if ($this->_charset != SABAI_CHARSET) {
            ob_start();
            parent::send($request);
            echo mb_convert_encoding(ob_get_clean(), $this->_charset, SABAI_CHARSET);
        } else {
            parent::send($request);
        }
    }

    function _sendError(&$request, $message, $uriArray)
    {
        if (!$this->_redirect) {
            header('status: 400');
            header('HTTP/1.0 400 Bad Request');
            _h($message);
        } else {
            if (!empty($message)) {
                $this->addFlash($message, true);
            }
            $url = !empty($uriArray) ? $request->createUri($uriArray) : $request->getScriptUri();
            header('Location: ' . str_replace(array('&amp;', "\r", "\n"), array('&'), $url));
        }
    }

    function _sendSuccess(&$request, $message, $uriArray)
    {
        if (!$this->_redirect) {
            _h($message);
        } else {
            if (!empty($message)) {
                $this->addFlash($message);
            }
            $url = !empty($uriArray) ? $request->createUri($uriArray) : $request->getScriptUri();
            header('Location: ' . str_replace(array('&amp;', "\r", "\n"), array('&'), $url));
        }
    }

    function _sendContent(&$request, $contentNames, $vars)
    {
        $vars['LAYOUT_URL'] = $this->_layoutURL;
        if (!$this->_layout) {
            $this->_sendTemplateContent($contentNames, $vars);
        } else {
            $layout_file = !empty($this->_layoutFile) ? $this->_layoutFile : basename($request->getScriptUri(), '.php') . '.html';
            $vars['CSS'] = $this->_getCSSHTML();
            list($vars['JS'], $vars['JS_HEAD'], $vars['JS_FOOT']) = $this->_getJSHTML();
            $vars['HTML_HEAD'] = !empty($this->_htmlHead) ? implode("\n", $this->_htmlHead) : '';
            $vars['PAGE_TITLE'] = !empty($this->_pageTitle) ? $this->_pageTitle : '';
            $this->_sendLayoutContent($contentNames, $vars, $layout_file);
        }
    }

    function _sendTemplateContent($contentNames, $vars)
    {
        // only display the template file that was found first
        foreach ($contentNames as $content_name) {
            foreach ((array)$content_name as $_content_name) {
                Sabai_Log::info(sprintf('Fetching template file for %s', $_content_name));
                if ($this->_tpl->display($_content_name . $this->_tplExtension, $vars)) {
                    Sabai_Log::info(sprintf('Rendering template file for %s', $_content_name));
                    return;
                }
            }
        }
    }

    function _sendLayoutContent($contentNames, $vars, $layoutFile)
    {
        foreach ($contentNames as $content_name) {
            foreach ((array)$content_name as $_content_name) {
                Sabai_Log::info(sprintf('Fetching template file for %s', $_content_name));
                if ($content = $this->_tpl->render($_content_name . $this->_tplExtension, $vars)) {
                    Sabai_Log::info(sprintf('Rendering template file for %s', $_content_name));
                    if ($last_slash_pos = strrpos($_content_name, '/')) {
                        $_content_name = substr($_content_name, $last_slash_pos + 1);
                    }
                    $vars['CONTENT'] = sprintf("<div id=\"%s\">\n%s\n</div>\n", h(str_replace('_', '-', $_content_name)), $content);
                    break;
                }
            }
        }
        $this->_tpl->_doDisplay($this->_layoutDir . '/' . $layoutFile, $vars);
    }

    function addJSHead($js)
    {
        $this->_jsHead[0][] = $js;
    }

    function addJSHeadAjax($js)
    {
        $this->_jsHead[1][] = $js;
    }

    function addJSFoot($js)
    {
        $this->_jsFoot[] = $js;
    }

    function addJSFile($path, $foot = false)
    {
        $this->_jsFiles[$foot ? 'foot' : 'head'][$path] = $path;
    }

    function _getJSHTML()
    {
        $html = array('head' => array(), 'foot' => array());
        foreach ((array)@$this->_jsFiles as $js_where => $js_paths) {
            foreach ($js_paths as $js_path) {
                $html[$js_where][] = sprintf('<script type="text/javascript" src="%s"></script>', $js_path);
            }
        }
        if (!empty($this->_jsHead)) {
            $html['head'][] = '<script type="text/javascript">';
            if (!empty($this->_jsHead[1])) {
                $html['head'][] = 'Ajax.Responders.register({onComplete: function() {';
                foreach ($this->_jsHead['1'] as $js) {
                    $html['head'][] = $js;
                }
                $html['head'][] = '}})';
            }
            $html['head'][] = 'document.observe("dom:loaded", function() {';
            foreach ((array)@$this->_jsHead[0] as $js) {
                $html['head'][] = $js;
            }
            $html['head'][] = '});
</script>';
        }
        if (!empty($this->_jsFoot)) {
            $html['foot'][] = '<script type="text/javascript">';
            foreach ($this->_jsFoot as $js) {
                $html['foot'][] = $js;
            }
            $html['foot'][] = '</script>';
        }
        $html_head = implode("\n", $html['head']);
        $html_foot = implode("\n", $html['foot']);
        return array($html_head . $html_foot, $html_head, $html_foot);
    }

    function addCSS($css)
    {
        $this->_css[] = $css;
    }

    function addCSSFile($path, $media = 'screen')
    {
        $this->_cssFiles[$media][$path] = $path;
    }

    function _getCSSHTML()
    {
        $html = array();
        foreach ($this->_cssFiles as $css_media => $css_paths) {
            foreach ($css_paths as $css_path) {
                $html[] = sprintf('<link rel="stylesheet" type="text/css" media="%s" href="%s" />', $css_media, $css_path);
            }
        }
        if (!empty($this->_css)) {
            $html[] = '<style type="text/css">';
            foreach ($this->_css as $css) {
                $html[] = $css;
            }
            $html[] = '</style>';
        }
        return implode("\n", $html);
    }

    function addHTMLHead($head)
    {
        $this->_htmlHead[] = $head;
    }

    function setPageTitle($pageTitle)
    {
        $this->_pageTitle = $pageTitle;
    }
}
<?php
/**
 * @author Marijuana
 * @license http://creativecommons.org/licenses/by-nc/3.0/
 */
if (!defined('XOOPS_ROOT_PATH')) exit();

define('THEME_RENDER_TARGET_TYPE_BUFFER', null);
define('THEME_RENDER_TARGET_TYPE_THEME', 'theme');
define('THEME_RENDER_TARGET_TYPE_BLOCK', 'block');
define('THEME_RENDER_TARGET_TYPE_MAIN', 'main');

abstract class themeRender_AbstractThemeRenderTarget extends XCube_RenderTarget
{
  public function __construct()
  {
    parent::XCube_RenderTarget();
    $this->setAttribute('legacy_buffertype', THEME_RENDER_TARGET_TYPE_THEME);
  }

  public function sendHeader()
  {
    header('Content-Type:text/html; charset='._CHARSET);
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
    header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
    header('Cache-Control: no-store, no-cache, must-revalidate');
    header('Cache-Control: post-check=0, pre-check=0', false);
    header('Pragma: no-cache');
  }

  public function setResult($result)
  {
    parent::setResult($result);
    if (!headers_sent()) {
      $this->sendHeader();
    }
    echo $result;
  }
}

class themeRender_ThemeRenderTarget extends themeRender_AbstractThemeRenderTarget
{
  public function __construct()
  {
    parent::__construct();
    $this->setAttribute('isFileTheme', true);
  }
}

class themeRender_DialogRenderTarget extends themeRender_AbstractThemeRenderTarget
{
  public function __construct()
  {
    parent::__construct();
    $this->setAttribute('isFileTheme', false);
  }
  
  public function getTemplateName()
  {
    return 'legacy_render_dialog.html';
  }
}

class themeRender_RenderTargetMain extends XCube_RenderTarget
{
  public function __construct()
  {
    parent::XCube_RenderTarget();
    $this->setAttribute('legacy_buffertype', THEME_RENDER_TARGET_TYPE_MAIN);
  }
}
?>
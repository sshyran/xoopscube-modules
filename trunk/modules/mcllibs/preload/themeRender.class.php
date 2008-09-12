<?php
/**
 * @author Marijuana
 * @license http://creativecommons.org/licenses/by-nc/3.0/
 */
class Mcllibs_themeRender extends XCube_ActionFilter
{
  public function preBlockFilter()
  {
    if ( $this->chk_mobile() ) {
      $this->set_config();
      $this->mRoot->mContext->setThemeName('mobile');
    }
  }
  
  private function chk_mobile()
  {
    return false;
    $hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
    $match = "/\.(docomo\.ne\.jp|jp-[kcqt]\.ne\.jp|ezweb\.ne\.jp|vodafone\.ne\.jp|softbank\.ne\.jp)$/";
    return preg_match($match, $hostname);
  }
  
  private function set_config()
  {
    $this->mRoot->mDelegateManager->add('Legacy_ThemeSelect.IsSelectableTheme', 'Mcllibs_themeRender::isSelectableTheme');
    $this->mRoot->mDelegateManager->add('LegacyThemeHandler.GetInstalledThemes', 'Mcllibs_themeRender::getInstalledThemes', XCUBE_DELEGATE_PRIORITY_1);

    $this->mRoot->mSiteConfig['RenderSystems']['themeRender_RenderSystem'] = 'themeRender_RenderSystem';
    $this->mRoot->mSiteConfig['themeRender_RenderSystem']['class'] = 'themeRender_RenderSystem';
    $this->mRoot->mSiteConfig['themeRender_RenderSystem']['path'] = '/modules/mcllibs/kernel';

    $this->mRoot->mSiteConfig['RenderSystems']['Legacy_RenderSystem'] = 'themeRender_RenderSystem';
    $this->mRoot->mSiteConfig['Legacy_RenderSystem']['class'] = 'themeRender_RenderSystem';
    $this->mRoot->mSiteConfig['Legacy_RenderSystem']['path'] = '/modules/mcllibs/kernel';
    
    require_once XOOPS_ROOT_PATH.'/core/XCube_Theme.class.php';
  }
  
  public static function isSelectableTheme(&$flag, $theme_name)
  {
    if (!$flag) {
      $theme = Mcllibs_themeRender::getThemeObj($theme_name);
      $flag = is_object($theme);
    }
  }
  
  public static function getInstalledThemes(&$results)
  {
    if ($handler = opendir(XOOPS_THEME_PATH)) {
      while (($dirname = readdir($handler)) !== false) {
        if ($dirname == '.' || $dirname == '..') {
          continue;
        }
        $theme = Mcllibs_themeRender::getThemeObj($dirname);
        if ( is_object($theme) ) {
          $results[] = $theme;
        }
        unset($theme);
      }
      closedir($handler);
    }
  }
  
  private static function getThemeObj($theme_name)
  {
    $themeDir = XOOPS_THEME_PATH.'/'.$theme_name;
    if (is_dir($themeDir)) {
      $theme = new XCube_Theme();
      $theme->mDirname = $theme_name;
      if ($theme->loadManifesto($themeDir.'/manifesto.ini.php')) {
        if ($theme->mRenderSystemName == 'themeRender_RenderSystem') {
          return $theme;
        }
      }
    }
    return false;
  }
}
?>
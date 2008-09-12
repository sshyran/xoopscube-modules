<?php
/**
 * @author Marijuana
 * @license http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE Version 2
 */
if (!defined('XOOPS_ROOT_PATH')) exit();
require_once XOOPS_MODULE_PATH.'/legacyRender/kernel/Legacy_RenderSystem.class.php';
require _MCL_LIBS_BASE_PATH.'kernel/themeRender_RenderTarget.class.php';

class themeRender_XoopsTpl extends XoopsTpl
{
  private $_mContextReserve = array();
  private $mRoot = null;
  
  public function __construct()
  {
    $this->_mContextReserve = array ('xoops_pagetitle' => 'legacy_pagetitle');
    parent::XoopsTpl();
    $this->mRoot = XCube_Root::getSingleton();
  }
  
  public function assign($tpl_var, $value = null)
  {
    if (is_array($tpl_var)) {
      foreach ($tpl_var as $key => $val) {
        if ($key != '') {
          $this->assign($key, $val);
        }
      }
    } else {
      if ($tpl_var != '') {
        if (isset($this->_mContextReserve[$tpl_var])) {
          $this->mRoot->mContext->setAttribute($this->_mContextReserve[$tpl_var], htmlspecialchars_decode($value));
        }
        $this->_tpl_vars[$tpl_var] = $value;
      }
    }
  }
  
  public function assign_by_ref($tpl_var, &$value)
  {
    if ($tpl_var != '') {
      if (isset($this->_mContextReserve[$tpl_var])) {
        $this->mRoot->mContext->setAttribute($this->_mContextReserve[$tpl_var], htmlspecialchars_decode($value));
      }
      $this->_tpl_vars[$tpl_var] =& $value;
    }
  }
  
  public function get_template_vars($name = null)
  {
    if (!isset($name)) {
      foreach ($this->_mContextReserve as $t_key => $t_value) {
        if (isset($this->_mContextReserve[$t_value])) {
          $this->_tpl_vars[$t_key] = htmlspecialchars($this->mRoot->mContext->getAttribute($this->_mContextReserve[$t_value]), ENT_QUOTES);
        }
      }
      return parent::get_template_vars($name);
    } elseif (isset($this->_mContextReserve[$name])) {
      return htmlspecialchars($this->mRoot->mContext->getAttribute($this->_mContextReserve[$name]), ENT_QUOTES);
    } else {
      return parent::get_template_vars($name);
    }
  }
}

class themeRender_RenderSystem extends Legacy_RenderSystem
{
  private $_commonAssign = null;
  public function __construct()
  {
    parent::XCube_RenderSystem();
  }

  public function prepare(&$controller)
  {
    XCube_RenderSystem::prepare($controller);
    
    $root = $this->mController->mRoot;
    $context = $root->getContext();
    $textFilter = $root->getTextFilter();
    
    // XoopsTpl default setup
    $this->mXoopsTpl = new themeRender_XoopsTpl();
    $this->mXoopsTpl->register_function('legacy_notifications_select', 'themeRender_smartyfunction_notifications_select');
    XCube_DelegateUtils::raiseEvent('Legacy_RenderSystem.SetupXoopsTpl', new XCube_Ref($this->mXoopsTpl));

    // compatible
    $GLOBALS['xoopsTpl'] = $this->mXoopsTpl;
    
    $this->mXoopsTpl->xoops_setCaching(0);

    // If debugger request debugging to me, send debug mode signal by any methods.
    if ($controller->mDebugger->isDebugRenderSystem()) {
      $this->mXoopsTpl->xoops_setDebugging(true);
    }
    
    $this->mXoopsTpl->assign(array('xoops_requesturi' => htmlspecialchars($GLOBALS['xoopsRequestUri'], ENT_QUOTES),  //@todo ?????????????
              // set JavaScript/Weird, but need extra <script> tags for 2.0.x themes
              'xoops_js' => '//--></script><script type="text/javascript" src="'.XOOPS_URL.'/include/xoops.js"></script><script type="text/javascript"><!--'
            ));
    $this->mXoopsTpl->assign('xoops_sitename', $textFilter->toShow($context->getAttribute('legacy_sitename')));
    $this->mXoopsTpl->assign('xoops_pagetitle', $textFilter->toShow($context->getAttribute('legacy_pagetitle')));
    $this->mXoopsTpl->assign('xoops_slogan', $textFilter->toShow($context->getAttribute('legacy_slogan')));

    // --------------------------------------
    // Meta tags
    // --------------------------------------
    $moduleHandler = xoops_gethandler('module');
    $legacyRender = $moduleHandler->getByDirname('legacyRender');
    if (is_object($legacyRender)) {
      $configHandler = xoops_gethandler('config');
      $configs = $configHandler->getConfigsByCat(0, $legacyRender->get('mid'));
      
      $this->mXoopsTpl->assign('xoops_meta_keywords', $textFilter->toShow($configs['meta_keywords']));
      $this->mXoopsTpl->assign('xoops_meta_description', $textFilter->toShow($configs['meta_description']));
      $this->mXoopsTpl->assign('xoops_meta_robots', $textFilter->toShow($configs['meta_robots']));
      $this->mXoopsTpl->assign('xoops_meta_rating', $textFilter->toShow($configs['meta_rating']));
      $this->mXoopsTpl->assign('xoops_meta_author', $textFilter->toShow($configs['meta_author']));
      $this->mXoopsTpl->assign('xoops_meta_copyright', $textFilter->toShow($configs['meta_copyright']));
      $this->mXoopsTpl->assign('xoops_footer', $configs['footer']); // footer may be raw HTML text.
      
      
      //
      // If this site has the setting of banner.
      // TODO this process depends on XOOPS 2.0.x.
      //
      $this->_mIsActiveBanner = $configs['banners'];
      if (LEGACY_RENDERSYSTEM_BANNERSETUP_BEFORE == true) {
        if ($configs['banners'] == 1) {
          $this->mXoopsTpl->assign('xoops_banner',xoops_getbanner());
        } else {
          $this->mXoopsTpl->assign('xoops_banner','&nbsp;');
        }
      }
    } else {
      $this->mXoopsTpl->assign('xoops_banner','&nbsp;');
    }
    
    // --------------------------------------
    // Add User
    // --------------------------------------
    $arr = null;
    if (is_object($context->mXoopsUser)) {
      $arr = array(
        'xoops_isuser' => true,
        'xoops_userid' => $context->mXoopsUser->getShow('uid'),
        'xoops_uname' => $context->mXoopsUser->getShow('uname')
      );
    } else {
      $arr = array(
        'xoops_isuser' => false
      );
    }
    $this->mXoopsTpl->assign($arr);
  }

  private function _commonPrepareRender()
  {
    if ( !is_array($this->_commonAssign) ) {
      $root = $this->mController->mRoot;
      $context = $root->getContext();
      $textFilter = $root->getTextFilter();

      $themeName = $context->getThemeName();
      $this->_commonAssign = array(
        'xoops_theme' => $themeName,
        'xoops_imageurl' => XOOPS_THEME_URL.'/'.$themeName.'/',
        'xoops_themecss' => xoops_getcss($themeName),
        'xoops_sitename' => $textFilter->toShow($context->getAttribute('legacy_sitename')),
        'xoops_pagetitle' => $textFilter->toShow($context->getAttribute('legacy_pagetitle')),
        'xoops_slogan' => $textFilter->toShow($context->getAttribute('legacy_slogan'),
      );
      
      if ($context->mModule != null) {
        $xoopsModule = $context->mXoopsModule;
        $this->_commonAssign['xoops_modulename'] = $xoopsModule->getShow('name');
        $this->_commonAssign['xoops_dirname'] = $xoopsModule->getShow('dirname');
      }
      
      if (isset($GLOBALS['xoopsUserIsAdmin'])) {
        $this->_commonAssign['xoops_isadmin'] = $GLOBALS['xoopsUserIsAdmin'];
      }
      XCube_DelegateUtils::raiseEvent('themeRender.theme.common', new XCube_Ref($this->_commonAssign));
    }
    $this->mXoopsTpl->assign($this->_commonAssign);
  }
  
  public function renderBlock(&$target)
  {
    $result = null;
    $this->_commonPrepareRender();
    
    $this->mXoopsTpl->xoops_setCaching(0);

    foreach ($target->getAttributes() as $key => $value) {
      $this->mXoopsTpl->assign($key,$value);
    }
    
    $modhandler = xoops_gethandler('block');
    $thisblk = $modhandler->get($target->getAttribute('bid'));
    
    if ( is_object($thisblk) ) {
      $moddir = $thisblk->getVar('dirname');
    } else {
      $moddir = 'legacy';
    }
    $blktmplatepath = XOOPS_THEME_PATH.'/'.$GLOBALS['xoopsConfig']['theme_set'].'/modules/'.$moddir.'/templates/blocks/';
    $blkmodpath = XOOPS_MODULE_PATH.'/'.$moddir.'/templates/blocks/';
    if ( is_file($blktmplatepath.$target->getTemplateName()) ) {
      $result = $this->mXoopsTpl->fetch($blktmplatepath.$target->getTemplateName(), $target->getAttribute('bid'));
    } elseif ( is_file($blkmodpath.$target->getTemplateName()) ) {
      $result = $this->mXoopsTpl->fetch($blkmodpath.$target->getTemplateName(), $target->getAttribute('bid'));
    } elseif ( defined('_MCL_DB_TEMPLATE') ) {
      $result = $this->mXoopsTpl->fetchBlock($target->getTemplateName(), $target->getAttribute('bid'));
    }
    $target->setResult($result);
    
    foreach ($target->getAttributes() as $key => $value) {
      $this->mXoopsTpl->clear_assign($key);
    }
  }

  public function renderMain(&$target)
  {
    $this->_commonPrepareRender();
    
    $cachedTemplateId = isset($GLOBLAS['xoopsCachedTemplateId']) ? $GLOBLAS['xoopsCachedTemplateId'] : null;

    foreach ($target->getAttributes() as $key => $value) {
      $this->mXoopsTpl->assign($key,$value);
    }
    
    $root = XCube_Root::getSingleton();
    $legtmplatepath = XOOPS_THEME_PATH.'/'.$GLOBALS['xoopsConfig']['theme_set'].'/modules/legacy/templates/';
    
    if ( isset($root->mContext->mXoopsModule) ) {
      $modtmplatepath = XOOPS_THEME_PATH.'/'.$GLOBALS['xoopsConfig']['theme_set'].'/modules/'.$root->mContext->mXoopsModule->dirname().'/templates/';
      $modtplpath = XOOPS_MODULE_PATH.'/'.$root->mContext->mXoopsModule->dirname().'/templates/';
    } else {
      $modtmplatepath = $legtmplatepath;
      $modtplpath = XOOPS_MODULE_PATH.'/legacy/templates/';
    }
    if ($target->getTemplateName()) {
      $tplfile = "";
      $tplname = $target->getTemplateName();
      if ( is_file($modtmplatepath.$tplname) ) {
        $tplfile = $modtmplatepath.$tplname;
      } elseif ( is_file($legtmplatepath.$tplname) ) {
        $tplfile = $legtmplatepath.$tplname;
      } elseif ( is_file($modtplpath.$tplname) ) {
        $tplfile = $modtplpath.$tplname;
      }
      
      if ( $tplfile != "" ) {
        if ($cachedTemplateId !== null) {
          $contents = $this->mXoopsTpl->fetch($tplfile, $xoopsCachedTemplateId);
        } else {
          $contents = $this->mXoopsTpl->fetch($tplfile);
        }
      } elseif ( defined('_MCL_DB_TEMPLATE') ) {
        if ($cachedTemplateId !== null) {
          $contents = $this->mXoopsTpl->fetch('db:'.$target->getTemplateName(), $xoopsCachedTemplateId);
        } else {
          $contents = $this->mXoopsTpl->fetch('db:'.$target->getTemplateName());
        }
      } else {
        $contents = "";
      }
    } else {
      if ($cachedTemplateId!==null) {
        $this->mXoopsTpl->assign('dummy_content', $target->getAttribute('stdout_buffer'));
        $contents = $this->mXoopsTpl->fetch($GLOBALS['xoopsCachedTemplate'], $xoopsCachedTemplateId);
      } else {
        $contents = $target->getAttribute('stdout_buffer');
      }
    }
    
    if ( $contents != "" ) {
      $target->setResult($contents);
    }
  }

  public function createRenderTarget($type = THEME_RENDER_TARGET_TYPE_MAIN, $option = null)
  {
    $renderTarget = null;
    switch ($type) {
      case XCUBE_RENDER_TARGET_TYPE_MAIN:
        $renderTarget = new themeRender_RenderTargetMain();
        break;
        
      case THEME_RENDER_TARGET_TYPE_BLOCK:
        $renderTarget = new XCube_RenderTarget();
        $renderTarget->setAttribute('legacy_buffertype', THEME_RENDER_TARGET_TYPE_BLOCK);
        break;
        
      default:
        $renderTarget = new XCube_RenderTarget();
        break;
    }

    return $renderTarget;
  }
  
  public function renderTheme(&$target)
  {
    $this->_commonPrepareRender();
    
    $mBefor = new XCube_Delegate();
    $mBefor->register('themeRender.theme.Befor');
    $mBefor->call(new XCube_Ref($this->mXoopsTpl), new XCube_Ref($target));

    if (LEGACY_RENDERSYSTEM_BANNERSETUP_BEFORE == false) {
      if ($this->_mIsActiveBanner == 1) {
        $this->mXoopsTpl->assign('xoops_banner',xoops_getbanner());
      } else {
        $this->mXoopsTpl->assign('xoops_banner','&nbsp;');
      }
    }
    
    foreach ($target->getAttributes() as $key => $value) {
      $this->mXoopsTpl->assign($key, $value);
    }
    
    $assignNameMap = array(
        XOOPS_SIDEBLOCK_LEFT     => array('showflag' => 'xoops_showlblock', 'block' => 'xoops_lblocks'),
        XOOPS_CENTERBLOCK_LEFT   => array('showflag' => 'xoops_showcblock', 'block' => 'xoops_clblocks'),
        XOOPS_CENTERBLOCK_RIGHT  => array('showflag' => 'xoops_showcblock', 'block' => 'xoops_crblocks'),
        XOOPS_CENTERBLOCK_CENTER => array('showflag' => 'xoops_showcblock', 'block' => 'xoops_ccblocks'),
        XOOPS_SIDEBLOCK_RIGHT    => array('showflag' => 'xoops_showrblock', 'block' => 'xoops_rblocks')
      );

    foreach ($assignNameMap as $key => $val) {
      $this->mXoopsTpl->assign($val['showflag'],$this->_getBlockShowFlag($val['showflag']));
      if (isset($this->mController->mRoot->mContext->mAttributes['legacy_BlockContents'][$key])) {
        foreach ($this->mController->mRoot->mContext->mAttributes['legacy_BlockContents'][$key] as $result) {
          $this->mXoopsTpl->append($val['block'], $result);
        }
      }
    }
    
    if ($target->getAttribute('isFileTheme')) {
      $tplname = $target->getTemplateName().'/theme.html';
    } else {
      $tplname = $target->getTemplateName();
    }
    $result = null;
    $result = $this->mXoopsTpl->fetch($tplname);
    $result .= $this->mXoopsTpl->fetchDebugConsole();
    
    $mGetHeader = new XCube_Delegate();
    $mGetHeader->register('themeRender.theme.Header');
    $mGetHeader->call(new XCube_Ref($_header));
    if ( count($_header) > 0 ) {
      $_header[] = '</head>';
      $tpl_source = str_replace('</head>', implode("\n", $_header), $result);
    }
    
    $mGetFooter = new XCube_Delegate();
    $mGetFooter->register('themeRender.theme.Footer');
    $mGetFooter->call(new XCube_Ref($_footer));
    if ( count($_footer) > 0 ) {
      $_footer[] = '</body>';
      $tpl_source = str_replace('</body>', implode("\n", $_footer), $result);
    }
    
    $target->setResult($result);
    
    $mAfter = new XCube_Delegate();
    $mAfter->register('themeRender.theme.After');
    $mAfter->call(new XCube_Ref($this->mXoopsTpl), new XCube_Ref($target));
  }
  
  /**
   * @TODO This function is not cool!
   */
  public function getThemeRenderTarget($isDialog = false)
  {
    return $isDialog ? new themeRender_DialogRenderTarget() : new themeRender_ThemeRenderTarget();
  }
}

function themeRender_smartyfunction_notifications_select($params, &$smarty)
{
  $root = XCube_Root::getSingleton();
  $renderSystem = $root->getRenderSystem('themeRender_RenderSystem');
  
  $renderTarget = $renderSystem->createRenderTarget('main');
  $renderTarget->setTemplateName('legacy_notification_select_form.html');

  XCube_DelegateUtils::call('Legacyfunction.Notifications.Select', new XCube_Ref($renderTarget));

  $renderSystem->render($renderTarget);
  
  return $renderTarget->getResult();
}
?>
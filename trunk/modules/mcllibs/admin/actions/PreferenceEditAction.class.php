<?php
/**
 * @author Marijuana
 * @license http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE Version 2
 */
if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH.'/legacy/admin/actions/PreferenceEditAction.class.php';

class MCLadmin_PreferenceEditAction extends Legacy_PreferenceEditAction
{
  public function executeViewInput(&$controller, &$xoopsUser, &$render)
  {
    $render->setTemplateName(XOOPS_ROOT_PATH.'/modules/'._MCLLIBS_PATH.'/admin/templates/mcladmin_preference_edit.html');
    $render->setAttribute('actionForm', $this->mActionForm);
    $render->setAttribute('objectArr', $this->mObjects);
    
    $render->setAttribute('category', $this->mCategory);
    $render->setAttribute('module', $this->mModule);
    
    $formtypeArr = array();
    foreach ($this->mObjects as $object) {
      $formtypeArr[] = $object->get('conf_formtype');
    }
    $formtypeArr = array_unique($formtypeArr);
    
    //
    // Make the array of timezone object
    //
    if (in_array('timezone', $formtypeArr)) {
      $handler = xoops_gethandler('timezone');
      $timezoneArr = $handler->getObjects();
      $render->setAttribute('timezoneArr', $timezoneArr);
    }
    
    //
    // Make the array of group object
    //
    if (in_array('group', $formtypeArr) || in_array('group_multi', $formtypeArr)) {
      $handler = xoops_gethandler('group');
      $groupArr = $handler->getObjects();
      $render->setAttribute('groupArr', $groupArr);
    }

    //
    // Make the array of tplset object
    //
    if (in_array('tplset', $formtypeArr)) {
      $handler = xoops_gethandler('tplset');
      $tplsetArr = $handler->getObjects();
      $render->setAttribute('tplsetArr', $tplsetArr);
    }
    
    //
    // Make the list of installed languages.
    //
    if (in_array('language', $formtypeArr)) {
      $languageArr = array();
      $dirHandler = opendir(XOOPS_ROOT_PATH.'/language/');
      while ($file = readdir($dirHandler)) {
        if (is_dir(XOOPS_ROOT_PATH . "/language/" . $file) && preg_match("/^[a-z][0-9a-z_\-]+$/", $file)) {
          $languageArr[$file] = $file;
        }
      }
      closedir($dirHandler);
      $render->setAttribute('languageArr', $languageArr);
    }
    
    //
    // Make the array of module object for selecting startpage.
    //
    if (in_array('startpage', $formtypeArr) || in_array('module_cache', $formtypeArr)) {
      $handler = xoops_gethandler('module');
      $criteria = new CriteriaCompo();
      $criteria->add(new Criteria('hasmain', 1));
      $criteria->add(new Criteria('isactive', 1));
      $moduleArr = $handler->getObjects($criteria);
      $render->setAttribute('moduleArr', $moduleArr);
    }
    
    //
    // Make the list of theme.
    //
    if (in_array('theme', $formtypeArr) || in_array('theme_multi', $formtypeArr)) {
      $handler = xoops_getmodulehandler('theme');
      $themeArr = $handler->getObjects();
      $render->setAttribute('themeArr', $themeArr);
    }
    
    //
    // Make the array of cachetime.
    //
    if (in_array('module_cache', $formtypeArr)) {
      $handler = xoops_gethandler('cachetime');
      $cachetimeArr = $handler->getObjects();
      $render->setAttribute('cachetimeArr', $cachetimeArr);
    }

    //
    // Make the list of user
    //
    if (in_array('user', $formtypeArr) || in_array('user_multi', $formtypeArr)) {
      $handler = xoops_gethandler('member');
      $userArr = $handler->getUserList();
      $render->setAttribute('userArr', $userArr);
    }
    
    //
    // Make the list of theme.
    //
    if (in_array('admintheme', $formtypeArr)) {
      $admarray = array();
      if ($handler = opendir(_ADMIN_THME_PATH)) {
        while (($dirname = readdir($handler)) !== false) {
          if ($dirname == '.' || $dirname == '..') {
            continue;
          }
          $themeDir = _ADMIN_THME_PATH.'/'.$dirname;
          if (is_file($themeDir.'/admin_theme.html')) {
            $admarray[$dirname] = $dirname;
          }
        }
        closedir($handler);
      }
      $render->setAttribute('admthemeArr', $admarray);
    }
  }
}
?>

<?php
/**
 * @version 1.0.1
 */
//
// [EN]
// This site preload reflects updated templates automatically for LegacyRender.
// (Altsys has the same feature. You should install Altsys!)
//
// [JA]
// ���������ä��ƥ�ץ졼�ȥե������ưŪ��ȿ�Ǥ���ץ����(altsys��Ʊ��ǽ���ꡢ����Ȥ��󤵤���) ... LegacyRender ��
//

if (!defined('XOOPS_ROOT_PATH')) exit();

//
// Specify a dirname of the target module. When it is "", this preload targets all of active modules.
//
// [JA]
// �������åȤΥ⥸�塼��� dirname ����ꤷ�ޤ���̵����ΤȤ����������ƥ��֥⥸�塼�뤬�о�
//
define('TEMPLATEAUTOUPDATE_TARGET_DIRNAME', "");

//
// Specify a name of the target tplset. When it is "", this preload uses the current tplset.
// But, it doesn't update default tplset, if you specify "default" directly.
//
// [JA]
// �������åȤ� TPLSET ��̵����ΤȤ������ߤΥƥ�ץ졼�ȥ��åȤ�Ȥ��ޤ����� default �ΤȤ���̵�뤷�ޤ��� default �������������Τ߽񤭴����ޤ���
//
define('TEMPLATEAUTOUPDATE_TARGET_TPLSET', "");

class TemplateAutoUpdate extends XCube_ActionFilter
{
	function preBlockFilter()	
	{
		$modulelist = array();
		if (TEMPLATEAUTOUPDATE_TARGET_DIRNAME == "") {
			$handler =& xoops_gethandler('module');
			$criteria =& new Criteria('isactive',1);
			$modules =& $handler->getObjects($criteria);
			foreach ($modules as $module) {
				$modulelist[] = $module->get('dirname');
			}
		}
		else {
			$modulelist[] = TEMPLATEAUTOUPDATE_TARGET_DIRNAME;
		}

		foreach ($modulelist as $dirname) {
			$handler =& xoops_getmodulehandler('tplfile', 'legacyRender');
			$criteria =& new CriteriaCompo();
			if (TEMPLATEAUTOUPDATE_TARGET_TPLSET == "") {
				if ($this->mRoot->mContext->mXoopsConfig['template_set'] == 'default')
					return;

				$criteria->add(new Criteria('tpl_tplset', $this->mRoot->mContext->mXoopsConfig['template_set']));
			}
			else {
				$criteria->add(new Criteria('tpl_tplset', TEMPLATEAUTOUPDATE_TARGET_TPLSET));
			}
			
			$criteria->add(new Criteria('tpl_module', $dirname));
			
			$tplfiles =& $handler->getObjects($criteria);
			foreach ($tplfiles as $tplfile)
			{
				$file = "";
				if ($tplfile->get('tpl_type') == 'module') {
					$file = XOOPS_MODULE_PATH . "/" . $dirname . "/templates/" . $tplfile->get('tpl_file');
				}
				elseif ($tplfile->get('tpl_type') == 'block') {
					$file = XOOPS_MODULE_PATH . "/" . $dirname . "/templates/blocks/" . $tplfile->get('tpl_file');
				}
				else {
					continue;
				}
				
				if (!file_exists($file))
					continue;
	
				$mtime = filemtime($file);
				
				if ($mtime > $tplfile->get('tpl_lastmodified') && $mtime > $tplfile->get('tpl_lastimported')) {
					$tplfile->loadSource();
					$tplfile->set('tpl_lastmodified', $mtime);
					$tplfile->Source->set('tpl_source', file_get_contents($file));
					if ($handler->insert($tplfile, true)) {
						require_once XOOPS_ROOT_PATH . "/class/template.php";
						$xoopsTpl =& new XoopsTpl();
						$xoopsTpl->clear_cache('db:' . $tplfile->get('tpl_file'));
						$xoopsTpl->clear_compiled_tpl('db:' . $tplfile->get('tpl_file'));
					}
				}
			}
		}

	}
}


?>
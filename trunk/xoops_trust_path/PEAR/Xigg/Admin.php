<?php
require_once 'Sabai/Controller/Front.php';

class Xigg_Admin extends Sabai_Controller_Front
{
    function Xigg_Admin()
    {
        parent::Sabai_Controller_Front('Category', 'Xigg_Admin_', dirname(__FILE__) . '/Admin');
        $this->setFilters(array('_global', '_isAuthenticated', '_isAdmin'));
    }

    function _getRoutes(&$context)
    {
        $routes['category'] = array('controller' => 'Category');
        $routes['node'] = array('controller' => 'Node');
        $routes['tag'] = array('controller' => 'Tag');
        $routes['plugin'] = array('controller' => 'Plugin');
        $routes['role'] = array('controller' => 'Role');
        $routes['user'] = array('controller' => 'User');
        return $routes;
    }

    /**
	 * Override the parent method to invoke plugins
	 *
	 * @param string $controllerName
	 * @param Sabai_Context $context
	 * @param array $controllerArgs
	 * @param string $controllerFile
	 */
	function _doExecuteController($controllerName, &$context, $controllerArgs, $controllerFile)
	{
	    $plugin_manager =& $context->application->locator->getService('PluginManager');
        $plugin_manager->dispatch('AdminExecute', array($controllerName));
        parent::_doExecuteController($controllerName, $context, $controllerArgs, $controllerFile);
	}

    function _globalBeforeFilter(&$context)
    {
        $plugin_manager =& $context->application->locator->getService('PluginManager');
        $plugin_manager->dispatch('AdminEnter');
    }

    function _globalAfterFilter(&$context)
    {
        $plugin_manager =& $context->application->locator->getService('PluginManager');
        $plugin_manager->dispatch('AdminExit');
    }

    function _isAuthenticatedBeforeFilter(&$context)
    {
        if (!$context->user->isAuthenticated()) {
            $context->response->setError(_('You must login to perform this operation'), array('script' => dirname($context->request->getScriptUri()) . '/index.php', 'base' => '/login'));
            $context->response->send($context->request);
            exit;
        }
    }

    function _isAdminBeforeFilter(&$context)
    {
        if (!$context->user->hasPermission('admin access')) {
            $context->response->setError(_('Access denied'), array('script' => dirname($context->request->getScriptUri()) . '/index.php'));
            $context->response->send($context->request);
            exit;
        }
    }

    function isValidEntityRequestedBeforeFilter($entityName, &$context)
    {
        $name_lc = strtolower($entityName);
        $id_var = $name_lc . '_id';
        if (0 < $id = $context->request->getAsInt($id_var)) {
            $model =& $context->application->locator->getService('Model');
            $repository =& $model->getRepository($entityName);
            if (false !== $entity =& $repository->fetchById($id)) {
                $repository->cacheEntity($entity);
                $context->response->setVars(
                                      array(
                                        $id_var  => $id,
                                        $name_lc => &$entity,
                                      )
                                    );
                return;
            }
        }
        $context->response->setError(_('Invalid request'), array('base' => '/' . $name_lc));
        $context->response->send($context->request);
        exit;
    }
}
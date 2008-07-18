<?php
require_once 'Sabai/Controller/ModelEntityCreate.php';

class Xigg_Admin_Role_Member_Create extends Sabai_Controller_ModelEntityCreate
{
    function Xigg_Admin_Role_Member_Create()
    {
        parent::Sabai_Controller_ModelEntityCreate('Member', array('autoAssignUser' => false));
    }

    function _onCreateEntity(&$entity, &$context)
    {
        $entity->setVar('role_id', $context->request->getAsInt('role_id'));
        $context->response->setVar('breadcrumb_current', _('Add member'));
        return true;
    }

    function _onEntityCreated(&$entity, &$context)
    {
        $this->_successURL = array('base' => '/role/' . $entity->getVar('role_id'));
    }

    function &_getEntityForm(&$entity, &$context)
    {
        $form =& $entity->toForm();
        $form->removeElement('Role');
        $form->validatesPresenceOf('userid', _('User ID cannot be empty'), _(' '));
        $form->validatesWithCallback('userid', _('User with the specified id does not exist'), array(&$this, '_validateUser'), array(&$context));
        return $form;
    }

    function _validateUser($userid, &$context)
    {
        $identity_fetcher =& $context->application->locator->getService('UserIdentityFetcher');
        if ($user = $identity_fetcher->fetchUserIdentities(array($userid))) {
            if (isset($user[$userid]) && ($user[$userid]->getId() != '')) {
                return true;
            }
        }
        return false;
    }

    function &_getModel(&$context)
    {
        $model =& $context->application->locator->getService('Model');
        return $model;
    }
}
<?php
$permissions = array();
$plugin_manager =& $context->application->locator->getService('PluginManager');
$plugin_manager->dispatch('RolePermissions', array(&$permissions));
$permissions = array_merge($permissions, array(
                 'Article' => array(
                             'article post' => _('Post article'),
                             'article publish own' => _('Publish own article'),
                             'article publish any' => _('Publish any article'),
                             'article edit own unpublished' => _('Edit own unpublished article'),
                             'article edit any unpublished' => _('Edit any unpublished article'),
                             'article edit own published' => _('Edit own published article'),
                             'article edit any published' => _('Edit any published article'),
                             'article delete own unpublished' => _('Delete own unpublished article'),
                             'article delete any unpublished' => _('Delete any unpublished article'),
                             'article delete own published' => _('Delete own published article'),
                             'article delete any published' => _('Delete any published article'),
                             'article edit source title' => _('Edit source title'),
                             'article edit priority' => _('Edit article priority'),
                             'article edit views' => _('Edit article view count'),
                             'article edit published' => _('Edit published date'),
                             'article allow edit' => _('Allow or disallow edit'),
                             'article allow comments' => _('Allow or disallow comments'),
                             'article allow trackbacks' => _('Allow or disallow trackbacks'),
                             'article edit html' => _('Edit raw HTML'),
                             'article hide' => _('Hide article'),
                             'article view hidden' => _('View hidden article'),
                           ),
                 'Comment' => array(
                             'comment post' => _('Post comment'),
                             'comment move own' => _('Move own comment'),
                             'comment move any' => _('Move any comment'),
                             'comment edit own' => _('Edit own comment'),
                             'comment edit any' => _('Edit any comment'),
                             'comment delete own' => _('Delete own comment'),
                             'comment delete any' => _('Delete any comment'),
                             'comment allow edit' => _('Allow or disallow edit'),
                             'comment edit html' => _('Edit raw HTML'),
                           ),
                 'Trackback' => array(
                             'trackback edit' => _('Edit any trackback'),
                             'trackback delete' => _('Delete any trackback'),
                           ),
                 'Vote' => array('vote submit' => _('Subumit vote')),
                 'XML-RPC' => array(),
                 'Admin' => array('admin access' => _('Access admin section'))
               ));
ksort($permissions, SORT_LOCALE_STRING);
<?php $this->loadHelpers(array('HTML', 'PageNavRemote')); // not required in PHP5 ?>
<h3><?php echo _('Installed Plugins');?></h3>
<div class="nodesSort">
<?php foreach (array('all' => _('List all'), 'active' => _('List active')) as $select_key => $select_label):?>
<?php   if ($select_key == @$requested_select):?>
  <span class="nodesSortCurrent"><?php _h($select_label);?></span> |
<?php   else:?>
<?php     $this->HTML->linkToRemote($select_label, 'xigg-admin-plugin-list', array('base' => '/plugin/list', 'params' => array('select' => $select_key)), array('params' => array('select' => $select_key, XIGG_REQUEST_AJAX_PARAM => 1)));?>
  |
<?php   endif;?>
<?php endforeach;?>
<?php echo _('Sort by ');$this->HTML->selectToRemote('sortby', $requested_sortby, 'xigg-admin-plugin-list', array('priority,DESC' => _('Priority'), 'name,ASC' => _('Plugin name, ascending'), 'name,DESC' => _('Plugin name, descending')), array('base' => '/plugin/list', 'params' => array('select' => $requested_select)), _('Go'), array('params' => array('select' => $requested_select, XIGG_REQUEST_AJAX_PARAM => 1)), 'xigg-admin-plugin-list-select');?>
</div>
<table>
  <thead>
    <tr>
      <th>&nbsp;</th>
      <th><?php echo _('Name');?></th>
      <th width="40%"><?php echo _('Summary');?></th>
      <th><?php echo _('Installed');?></th>
      <th><?php echo _('Local');?></th>
      <th><?php echo _('Priority');?></th>
      <th><?php echo _('Action');?></th>
    </tr>
  </thead>
  <tfoot>
    <tr>
      <td colspan="7" class="right"><?php $this->PageNavRemote->write('xigg-admin-plugin-list', $entity_pages, $entity_page_requested, array('base' => '/plugin/list', 'params' => array('sortby' => $requested_sortby, 'select' => $requested_select)), array('params' => array('sortby' => $requested_sortby, 'select' => $requested_select, XIGG_REQUEST_AJAX_PARAM => 1)));?></td>
    </tr>
  </tfoot>
  <tbody>
<?php if ($entity_objects->size() > 0):?>
<?php   $entity_objects->rewind(); while ($e =& $entity_objects->getNext()):?>
    <tr>
<?php   $local_data = @$installed_plugins[$e->get('name')]; $version = $e->get('version'); $local_version = $local_data['version']; $can_upgrade = version_compare($version, $local_version, '<');?>
<?php     if ($error = ($e->get('active') && !empty($version) && empty($local_version))):?>
      <td><img src="<?php echo $LAYOUT_URL;?>/images/plugin_error.gif" alt="<?php echo _('Error');?>" /></td>
<?php     else:?>
<?php       if ($e->get('active')):?>
      <td><img src="<?php echo $LAYOUT_URL;?>/images/plugin.gif" alt="<?php echo _('Active');?>" /></td>
<?php       else:?>
      <td><img src="<?php echo $LAYOUT_URL;?>/images/plugin_disabled.gif" alt="<?php echo _('Disabled');?>" /></td>
<?php       endif;?>
<?php     endif;?>
      <td><?php _h($e->getLabel());?></td>
      <td><?php _h($local_data['summary']);?><?php if(!empty($plugins_dependency[$e->get('name')])):?><br /><span class="pluginDependency"><?php _h($this->__('required by %s', array(implode(', ', $plugins_dependency[$e->get('name')]))));?></span><?php endif;?></td>
      <td><?php _h($version);?></td>
      <td><?php _h($local_version);?></td>
      <td><?php echo $e->get('priority');?></td>
      <td>
<?php   /*if ($e->canUninstall())*/ $this->HTML->linkTo/*Remote*/(_('Uninstall'), /*'xigg-admin-plugin-list-update',*/ array('base' => '/plugin/' . $e->getId() . '/uninstall'));?>
<?php     if ($can_upgrade):?>&nbsp;
<?php       $this->HTML->linkTo/*Remote*/(_('Upgrade'), /*'xigg-admin-plugin-list-update',*/ array('base' => '/plugin/upgrade/' . $e->getLabel()));?>&nbsp;
<?php     elseif (!$error):?>&nbsp;
<?php       $this->HTML->linkTo/*Remote*/(_('Configure'), /*'xigg-admin-plugin-list-update',*/ array('base' => '/plugin/configure/' . $e->getLabel()));?>
<?php     endif;?>
      </td>
    </tr>
<?php   endwhile;
      else:?>
    <tr><td colspan="7"></td></tr>
<?php endif;?>
  </tbody>
</table>
<div id="xigg-admin-plugin-list-update">
</div>

<h3><?php echo _('Installable Plugins');?></h3>
<div class="nodesSort">
<?php $this->HTML->linkToRemote(_('Refresh'), 'xigg-admin-plugin-list', array('base' => '/plugin/list', 'params' => array('refresh' => 1)), array('params' => array('refresh' => 1, XIGG_REQUEST_AJAX_PARAM => 1)));?>
</div>
<table>
  <thead>
    <tr>
      <th>&nbsp;</th>
      <th><?php echo _('Name');?></th>
      <th width="40%"><?php echo _('Summary');?></th>
      <th><?php echo _('Version');?></th>
      <th><?php echo _('Action');?></th>
    </tr>
  </thead>
  <tfoot>
    <tr><td colspan="5">&nbsp;</td></tr>
  </tfoot>
<?php foreach($local_plugins as $local_name => $local_data):
        $plugins_required_str = '';
        if ($plugins_required = $local_data['dependencies']['plugins']):
          $plugins_required_arr = array();
          foreach ($plugins_required as $p_required):
            $plugins_required_arr[] = $p_required['version'] ? $p_required['name'] . ' ' . $p_required['version'] : $p_required['name'];
          endforeach;
          $plugins_required_str = implode(', ', $plugins_required_arr);
        endif;?>
    <tr>
      <td><img src="<?php echo $LAYOUT_URL;?>/images/plugin_disabled.gif" alt="<?php echo _('Disabled');?>" /></td>
      <td><?php _h($local_name);?></td>
      <td><?php _h($local_data['summary']);?><?php if($plugins_required_str != ''):?><br /><span class="pluginDependency"><?php echo $this->__('requires %s', $plugins_required_str);?></span><?php endif;?></td>
      <td><?php _h($local_data['version']);?></td>
      <td><?php $this->HTML->linkTo/*Remote*/(_('Install'), /*'xigg-admin-plugin-list-update2',*/ array('base' => '/plugin/install/' . $local_name));?></td>
    </tr>
<?php endforeach;?>
  </tbody>
</table>
<div id="xigg-admin-plugin-list-update2">
</div>
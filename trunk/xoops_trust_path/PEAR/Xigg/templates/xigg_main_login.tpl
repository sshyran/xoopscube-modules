<?php $this->loadHelpers(array('HTML')); // not required in PHP5 ?>
<h3><?php echo _('Login');?></h3>
<?php $this->HTML->formTag('post', array('base' => '/login'));?>
<table>
  <tr>
    <td><?php echo _('Username: ');?></td>
    <td><input type="text" name="<?php echo $uname_field;?>" value="<?php _h($uname);?>" size="50" /></td>
  </tr>
  <tr>
    <td><?php echo _('Password: ');?></td>
    <td><input type="password" name="<?php echo $pwd_field;?>" size="50" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" value="<?php echo _('Send');?>" /></td>
  </tr>
</table>
<?php $this->HTML->formTagEnd();?>
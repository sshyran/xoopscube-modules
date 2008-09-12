<?php
/*
 * @author Marijuana
 * @license http://creativecommons.org/licenses/by-nc/3.0/
 */
require_once SMARTY_DIR.'Smarty.class.php';

class AdminCssSmarty extends Smarty
{
  public function __construct($theme)
  {
    parent::Smarty();
    $this->compile_id = $theme;
    $this->_canUpdateFromFile = true;
    $this->compile_check = true;
    $this->compile_dir = XOOPS_COMPILE_PATH;
    $this->left_delimiter = '<{';
    $this->right_delimiter = '}>';
    $this->force_compile = false;
    
    $this->register_modifier('theme', 'admincss_modifier_theme');
  }
}

function admincss_modifier_theme($string)
{
  return _ADMIN_THME_URL.'/'.$string;
}
?>
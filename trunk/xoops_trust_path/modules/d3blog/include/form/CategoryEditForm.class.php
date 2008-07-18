<?php
/**
 * @version $Id: CategoryEditForm.class.php 315 2008-02-29 16:04:55Z hodaka $
 * @author Takeshi Kuriyama <kuri@keynext.co.jp>
 */

require_once dirname(dirname(dirname(__FILE__))).'/lib/Form.php';

class CategoryEditForm extends myActionFormEx
{
    var $cid_;
    var $pid_;
    var $name_;
    var $imgurl_;
    var $weight_;
    var $mydirname_;

    function CategoryEditForm($dirname) {
    	$this->mydirname_ = $dirname;
    }

    function fetch(&$master) {
        global $xoopsGTicket;
        $myModule = call_user_func(array($this->mydirname_, 'getInstance'));
        $handler =& $myModule->getHandler('category');
        if ( ! $xoopsGTicket->check(true,'d3blog_admin') ) {
            redirect_header(XOOPS_URL.'/', 3, $xoopsGTicket->getErrors());
            exit;
        }

        $this->pid_ = intval($_POST['pid']);
        // check if pid exists
        if($this->pid_) {
            $obj = $handler->get($this->pid_);
            if(!is_object($obj)) {
                redirect_header(XOOPS_URL.'/modules/'.$this->mydirname_.'/admin/category_manager.php', 2, _MD_A_D3BLOG_ERROR_NO_SUCH_CATEGORY);
                exit;
            }
            unset($obj);
        }
            

        $this->name_ = trim($_POST['name']);
        if(!$this->name_) {
            $this->addError(_MD_A_D3BLOG_ERROR_NAME_REQUIRED);
        }
        if(!$this->validateMaxLength($this->name_, 255)) {
            $this->addError(sprintf(_MD_A_D3BLOG_ERROR_NAME_SIZEOVER, 255));
        }

        $this->imgurl_ = $_POST['imgurl'];
        if(!empty($this->imgurl_)) {
            $imagepath = preg_replace("|^(.+)/$|", "$1", $myModule->getConfig('categoryicon_path'));
            $imagepath = $imagepath .'/'.$this->imgurl_ ;
            if( !file_exists($imagepath) || !$this->validateMimeImage($imagepath) ) {
                $this->addError(_MD_A_D3BLOG_ERROR_WRONG_IMGURL);
            }
        }
        
        $this->weight_ = intval( $_POST['weight'] ) ;
    }

    function load(&$master) {
        $this->cid_ = $master->getVar ( 'cid', 'e' );
        $this->pid_ = $master->getVar ( 'pid', 'e' );
        $this->name_ = $master->getVar ( 'name', 'e' );
        $this->weight_ = $master->getVar ( 'weight', 'e' );
        $this->imgurl_ = $master->getVar ( 'imgurl', 'e' );
    }

    function update(&$master) {
        $master->setVar ( 'pid', $this->pid_ );
        $master->setVar ( 'name', $this->name_ );
        $master->setVar ( 'weight', $this->weight_ );
        $master->setVar ( 'imgurl', $this->imgurl_ );
    }
}


?>

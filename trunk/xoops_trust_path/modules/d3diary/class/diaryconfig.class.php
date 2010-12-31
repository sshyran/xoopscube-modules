<?php
include_once XOOPS_ROOT_PATH."/class/xoopstree.php";

class DiaryConfig
{
	var $uid;
	var $blogtype;
	var $blogurl;
	var $rss;
	var $openarea;
	

	function DiaryConfig(){
	}

    function &getInstance()
    {
        static $instance;
        if (!isset($instance)) {
            $instance = new DiaryConfig();
        }
        return $instance;
    }

	function readdb($mydirname){
		global $xoopsDB;
	
		$sql = "SELECT *
				  FROM ".$xoopsDB->prefix($mydirname.'_config')."
		          WHERE uid='".$this->uid."'";

		$result = $xoopsDB->query($sql);
		$num_rows = $xoopsDB->getRowsNum($result);
		
		while ( $dbdat = $xoopsDB->fetchArray($result) ) {
			$this->blogtype   = $dbdat['blogtype'];
			$this->blogurl    = $dbdat['blogurl'];
			$this->rss        = $dbdat['rss'];
			$this->openarea   = $dbdat['openarea'];
		}
		return $num_rows;
	}

	function deletedb($mydirname){
		global $xoopsDB;

		$sql = "DELETE FROM ".$xoopsDB->prefix($mydirname.'_config')." WHERE uid='".$this->uid."'";
		$result = $xoopsDB->query($sql);
		return $this->uid;
	}

	function insertdb(){
		global $xoopsDB, $mydirname;

        if (!get_magic_quotes_gpc()) {
			$sql = "INSERT INTO ".$xoopsDB->prefix($mydirname.'_config')."
					(uid, blogtype, blogurl, rss, openarea)
					VALUES (
					'".addslashes($this->uid)."',
					'".addslashes($this->blogtype)."',
					'".addslashes($this->blogurl)."',
					'".addslashes($this->rss)."',
					'".addslashes($this->openarea)."'
					)";
		} else {
			$sql = "INSERT INTO ".$xoopsDB->prefix($mydirname.'_config')."
					(uid, blogtype, blogurl, rss, openarea)
					VALUES (
					'".$this->uid."',
					'".$this->blogtype."',
					'".$this->blogurl."',
					'".$this->rss."',
					'".$this->openarea."'
					)";
		}
		$result = $xoopsDB->query($sql);
		return $xoopsDB->getInsertId();
	}

	function updatedb($mydirname){
		global $xoopsDB;

        if (!get_magic_quotes_gpc()) {
			$sql = "UPDATE ".$xoopsDB->prefix($mydirname.'_config')." SET
					blogtype='".addslashes($this->blogtype)."',
					blogurl='".addslashes($this->blogurl)."',
					rss='".addslashes($this->rss)."',
					openarea='".addslashes($this->openarea)."'
					WHERE uid='".addslashes($this->uid)."'";
		} else {
			$sql = "UPDATE ".$xoopsDB->prefix($mydirname.'_config')." SET
					blogtype='".$this->blogtype."',
					blogurl='".$this->blogurl."',
					rss='".$this->rss."',
					openarea='".$this->openarea."'
					WHERE uid='".$this->uid."'";
		}
		$result = $xoopsDB->query($sql);
		return $this->uid;
	}

}
?>

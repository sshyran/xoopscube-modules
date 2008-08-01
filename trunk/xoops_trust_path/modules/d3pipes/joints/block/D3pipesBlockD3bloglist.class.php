<?php
/**
 * @version $Id: D3pipesBlockD3bloglist.class.php 431 2008-03-09 02:32:57Z hodaka $
 * @brief d3pipes plugin for d3blog module
 * @@author Takeshi Kuriyama <kuri@keynext.co.jp>
 */

if( ! defined( 'XOOPS_TRUST_PATH' ) ) die( 'set XOOPS_TRUST_PATH into mainfile.php' );

require_once dirname(dirname(dirname(__FILE__))).'/joints/D3pipesBlockAbstract.class.php' ;

class D3pipesBlockD3bloglist extends D3pipesBlockAbstract {

    var $target_dirname = '';
    var $trustdirname = 'd3blog';

    function init()
    {
        // parse and check option for this class
        $params = array_map( 'trim' , explode( '|' , $this->option ));
        if( empty( $params[0] ) ) {
            $this->errors[] = _MD_D3PIPES_ERR_INVALIDDIRNAMEINBLOCK."\n($this->pipe_id)" ;
            return false ;
        }
        $mydirname = $this->target_dirname = preg_replace( '/[^0-9a-zA-Z_-]/' , '' , $params[0] );
       	$this->trustdirname = 'd3blog';

        if(!class_exists($this->target_dirname)) {
        	require XOOPS_TRUST_PATH.'/modules/'.$this->trustdirname.'/class/global.class.php';
    	}

		// module constant configuration
		require XOOPS_TRUST_PATH.'/modules/'.$this->trustdirname.'/include/config.inc.php';

		// GET MODULE INFORMATION
		$myModule =& call_user_func(array($mydirname, 'getInstance'));

		// CURRENT USER'S INFO
		require XOOPS_TRUST_PATH.'/modules/'.$this->trustdirname.'/lib/user.php';
		if(!isset($GLOBALS['currentUser'])) {
    		global $xoopsUser;
    		$GLOBALS['currentUser'] = new myXoopsUserObject($xoopsUser);
            $GLOBALS['currentUser']->_groups_ = $GLOBALS['currentUser']->getGroups();
		}

		// USER'S PRIVILEGES ON THIS MODULE
		if(!isset($GLOBALS['currentUser']->_userPerm[$myModule->module_id])) {
    		$GLOBALS['currentUser']->_userPerm[$myModule->module_id] = new myXoopsUserPermission($GLOBALS['currentUser'], $myModule);
		}

		// PERMISSION
		if(!$GLOBALS['currentUser']->blog_perm($myModule->module_id)) {
    		$this->errors[] = 'Sorry, you don\'t have a permission to read'."\n($this->pipe_id)";
            return false ;
    	}

        // configurations (file, name, block_options)
        $this->func_file = XOOPS_ROOT_PATH.'/modules/'.$this->target_dirname.'/blocks/blocks.php' ;
        $this->func_name = 'b_'.$this->trustdirname.'_latest_entries_show';
        $this->block_options = array(
            'disable_renderer' => true,
            0 => $this->target_dirname, // mydirname of d3blog
            1 => empty( $params[1] ) ? 10 : intval( $params[1] ), // number of entries to show
            2 => 25, // max length of the title
            3 => 'Y/m/d', // date format
            4 => 2, // type (1=list, 2=table)
            5 => 1,   // show entry content(0:no, 1:excerpt, 2:whole contents)
            6 => 0,   // show contents of the latest entry only(0:no 1:yes)
            7 => 0, // max length of entry.(0:no limits)
			8 => '',	// template
            9 => 1 // return data(1:yes 0:no) 
        ) ;

        return true ;
    }

    function reassign( $data )
    {
        $entries = array();
        if(is_array($data)) {
        	foreach( $data['entries'] as $item ) {
            	$entry = array(
                	'pubtime' => $item['published'], // unix timestamp
                	'link' => XOOPS_URL.'/modules/'.$data['mydirname'].'/details.php?bid='.$item['bid'],
                	'headline' => $this->unhtmlspecialchars( $item['title'] ),
                	'description' => $this->unhtmlspecialchars( $item['contents'] ),
                	'allow_html' => true,
            	);
            	$entry['fingerprint'] = $entry['link'] ;
            	$entries[] = $entry ;
        	}
        }
        return $entries ;
    }

}

?>
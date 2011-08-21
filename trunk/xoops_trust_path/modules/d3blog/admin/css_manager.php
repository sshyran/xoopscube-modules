<?php
/**
 * @version $Id: css_manager.php 311 2008-02-28 15:13:00Z hodaka $
 * @author Takeshi Kuriyama <kuri@keynext.co.jp>
 */

require_once dirname(dirname(__FILE__)).'/include/gticket.php';

$myts =& MyTextSanitizer::getInstance();
$db =& Database::getInstance() ;

// check css directory 
$check_dir = array(); 
$css_dir = preg_replace("|^(.+)/?$|", "$1", $myModule->getConfig('css_dir')); 
if (!is_dir($css_dir)) { 
    $check_dir[] = sprintf(_MD_A_D3BLOG_MESSAGE_CANNOT_OPEN_CSS_DIR, htmlspecialchars($css_dir, ENT_QUOTES)); 
} 
elseif (!is_writable($css_dir)) { 
    $check_dir[] = sprintf(_MD_A_D3BLOG_MESSAGE_CANNOT_WRITE_CSS_DIR, htmlspecialchars($css_dir, ENT_QUOTES)); 
} 
elseif( $handler = @opendir( $css_dir . '/' ) ) { 
    while( ( $file = readdir( $handler ) ) !== false ) { 
        if( substr( $file , 0 , 1 ) == '.' ) continue ; 
        $file_path = $css_dir . '/' . $file ; 
        if(is_file( $file_path ) && substr( $file , -4 ) != '.css') { 
            $check_dir[] = sprintf(_MD_A_D3BLOG_MESSAGE_NOT_CSS_FILE, htmlspecialchars($file, ENT_QUOTES)); 
//            break; 
        } elseif( is_file( $file_path ) && substr( $file , -4 ) == '.css' ) {
        	if($file == 'main_style.css' || $file == 'main_styleIE.css' || $file == 'block_style.css' || $file == 'block_styleIE.css') {
            	if(!is_writable($file_path)) { 
                	$check_dir[] = sprintf(_MD_A_D3BLOG_MESSAGE_CANNOT_WRITE_CSS_FILE, htmlspecialchars($file, ENT_QUOTES)); 
            	}
        	} 
        } 
    } 
} 

// get tplsets
$tplset_handler =& xoops_gethandler( 'tplset' );
$tplsets = array_keys( $tplset_handler->getList() );

$sql = "SELECT distinct tpl_tplset FROM ".$db->prefix("tplfile")." ORDER BY tpl_tplset='default' DESC,tpl_tplset";
$srs = $db->query($sql);
while( list( $tplset ) = $db->fetchRow( $srs ) ) {
    if( ! in_array( $tplset , $tplsets ) ) $tplsets[] = $tplset;
    $num_by_tplset[$tplset] = 0;
}

// get css tpl_file belonged to the module
$sql = "SELECT tpl_file,tpl_desc,tpl_type,COUNT(tpl_id) FROM ".$db->prefix("tplfile")." WHERE tpl_module='".addslashes($mydirname)."' AND right(tpl_file, 4) = '.css' GROUP BY tpl_file ORDER BY tpl_type, tpl_file" ;
$frs = $db->query($sql);
$tpl_files = array();
while( list( $tpl_file , $tpl_desc , $type , $count ) = $db->fetchRow( $frs ) ) {
    // information about the template
    $tpl_files[] = $tpl_file;
}

// ACTION OVER-WRITE CSS FILES
if( !empty( $_POST['do_write'] ) ) {
    if(count($check_dir)) { 
        redirect_header(XOOPS_URL."/modules/$mydirname/admin/index.php?page=css_manager", 1, _MD_A_D3BLOG_MESSAGE_YOU_MUST_PREPARE_CSS_DIRECTORY); 
        exit; 
    } 

    if ( ! $xoopsGTicket->check( true , 'd3blog_admin' ) ) {
        redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
    }
    
    $tplset = implode('', array_keys($_POST['do_write']));
    if(!in_array($tplset, $tplsets)) {
        redirect_header(XOOPS_URL."/modules/$mydirname/admin/index.php?page=css_manager", 1, _MD_A_D3BLOG_ERROR_NO_SUCH_TEMPLATE_SET);
        exit;        
    }
    if(isset($_POST[$tplset.'_check'])) {
        $css_tpls = array_keys($_POST[$tplset.'_check']);
        foreach($css_tpls as $css_tpl) {
            if(!in_array($css_tpl, $tpl_files)) {
                redirect_header(XOOPS_URL."/modules/$mydirname/admin/index.php?page=css_manager", 1, sprintf(_MD_A_D3BLOG_ERROR_NO_SUCH_TEMPLATE_FILE, htmlspecialchars($css_tpl, ENT_QUOTES)));
                exit;
            }                     
            $tpl = new XoopsTpl();
            $tpl->assign(array(
                'mydirname' => $mydirname4show,
                'xoops_url' => XOOPS_URL,
                'xoops_upload_url' =>  XOOPS_URL.'/uploads',
                'mod_url' => XOOPS_URL.'/modules/'.$mydirname4show
            ));
            $data = $tpl->fetch( 'db:'.$css_tpl );
            
            $cssfilepath = $css_dir.'/'.substr($css_tpl, strlen($mydirname)+1);
            if(!is_writable($cssfilepath)) { 
                exit(sprintf(_MD_A_D3BLOG_MESSAGE_CANNOT_WRITE_CSS_FILE, htmlspecialchars($cssfilepath, ENT_QUOTES)));     
            }
            $fp = fopen($cssfilepath, 'w');
            fwrite($fp, $data);
            fclose($fp);
            unset( $tpl );
        }
        redirect_header(XOOPS_URL."/modules/$mydirname/admin/index.php?page=css_manager", 1, _MD_A_D3BLOG_MESSAGE_CSS_FILES_SUCCESSFULLY_WRITTEN);
        exit;
    }
}

// ACTION DISPLAY
$fingerprint_styles = array( '' , 'background-color:#00FF00' , 'background-color:#00CC88' , 'background-color:#00FFFF' , 'background-color:#0088FF' , 'background-color:#FF8800' , 'background-color:#0000FF' , 'background-color:#FFFFFF' ) ;
$cssfiles = array();
// get css tpl_file belonged to the module
$frs = $db->query($sql);
while( list( $tpl_file , $tpl_desc , $type , $count ) = $db->fetchRow( $frs ) ) {
    $fingerprint_style_count = 0 ;

    $cssfile = array();
    // information about the template
    $cssfile['file_name'] = htmlspecialchars($tpl_file,ENT_QUOTES);
    $cssfile['file_description'] = htmlspecialchars($tpl_desc,ENT_QUOTES);
    $cssfile['type'] = htmlspecialchars($type, ENT_QUOTES);
    $cssfile['count'] = intval($count);

    // the base file template column
    $basefilepath = $mytrustdirpath.'/templates/'.substr($tpl_file, strlen($mydirname)+1);
    if( file_exists( $basefilepath ) ) {
        $str = '' ;
        $lines = file( $basefilepath );
        foreach( $lines as $line ) {
            if( trim( $line ) ) {
                $str .= md5( trim( $line ) ) ;
            }
        }
        $fingerprint = md5( $str ) ;

        $fingerprints[ $fingerprint ] = 1 ;
        $cssfile['file_last_modified'] = formatTimestamp(filemtime($basefilepath),'m');
        $cssfile['file_fingerprint'] = substr($fingerprint,0,16);
    }

    // css files column
    $cssfilepath = $mydirpath.'/css/'.substr($tpl_file, strlen($mydirname)+1);
    if( file_exists( $cssfilepath ) ) {
        $str = '' ;
        $lines = file( $cssfilepath );
        foreach( $lines as $line ) {
            if( trim( $line ) ) {
                $str .= md5( trim( $line ) ) ;
            }
        }
        $fingerprint = md5( $str ) ;

        $fingerprints[ $fingerprint ] = 1 ;
        $cssfile['css_file_name'] = substr($tpl_file, strlen($mydirname)+1);
        $cssfile['css_lastmodified'] = intval(filemtime($cssfilepath));
        $cssfile['css_last_modified'] = formatTimestamp(filemtime($cssfilepath),'m');
        $cssfile['css_fingerprint'] = substr($fingerprint,0,16);
    }
    
    // db template columns
    foreach( $tplsets as $tplset ) {
        $tplset4disp = htmlspecialchars( $tplset , ENT_QUOTES ) ;

        // query for templates in db
        $drs = $db->query( "SELECT * FROM ".$db->prefix("tplfile")." f NATURAL LEFT JOIN ".$db->prefix("tplsource")." s WHERE tpl_file='".addslashes($tpl_file)."' AND tpl_tplset='".addslashes($tplset)."'" ) ;
        $numrows = $db->getRowsNum( $drs ) ;
        $tpl = $db->fetchArray( $drs ) ;
        $db_tpls = array();
        $db_tpls['numrows'] = $numrows;
        $num_by_tplset[$tplset] += $numrows;
        if( !empty( $tpl['tpl_id'] ) ) {
            $str = '' ;
            $lines = explode( "\n" , $tpl['tpl_source']);
            foreach( $lines as $line ) {
                if( trim( $line ) ) {
                    $str .= md5( trim( $line ) ) ;
                }
            }
            $fingerprint = md5( $str ) ;

            if( isset( $fingerprints[ $fingerprint ] ) ) {
                $style = $fingerprints[ $fingerprint ] ;
            } else {
                $fingerprint_style_count ++ ;
                $style = $fingerprint_styles[$fingerprint_style_count] ;
                $fingerprints[ $fingerprint ] = $style ;
            }

            $db_tpls['style'] = $style;
            $db_tpls['tpl_tplset'] = htmlspecialchars($tpl['tpl_tplset'],ENT_QUOTES);
            $db_tpls['tpl_file'] = htmlspecialchars($tpl['tpl_file'],ENT_QUOTES);
            $db_tpls['tpl_lastmodified'] = intval($tpl['tpl_lastmodified']);
            $db_tpls['tpl_last_modified'] = formatTimestamp($tpl['tpl_lastmodified'],'m');
            $db_tpls['tpl_fingerprint'] = substr($fingerprint,0,16);
        }
        $cssfile['db_tpls'][] = $db_tpls;
        $num_by_tplset[$tplset] += $numrows;
    }    
    $cssfiles[] = $cssfile; 
}

xoops_cp_header();
include dirname(__FILE__).'/mymenu.php' ;
$tpl = new XoopsTpl();
$tpl->assign( array(
    'mymid' => $myModule->module_id,
    'mydirname' => $mydirname4show,
    'mod_url' => XOOPS_URL.'/modules/'.$mydirname4show,
    'xoopsModuleConfig' => $myModule->module_config,
    'xoopsConfig' => $xoopsConfig,
    'tplsets' => $tplsets,
    'cssfiles' => $cssfiles,
    'css_dir' => htmlspecialchars($myModule->getConfig('css_dir'), ENT_QUOTES),
    'num_by_tplset' => $num_by_tplset,
    'gticket_hidden' => $xoopsGTicket->getTicketHtml( __LINE__ , 1800 , 'd3blog_admin'),
    'check_dir' => $check_dir
) );

$tpl->display( 'db:'.$mydirname.'_admin_css_manager.html' ) ;
xoops_cp_footer();

?>

<?php
$module_handler =& xoops_gethandler('module');
$module =& $module_handler->getByDirname($mydirname);

if( $module->getVar('isactive') )
{


  eval('
    function '.$mydirname.'_new( $limit=0, $offset=0)
    {
      return coupons_new_base( "'.$mydirname.'" , $limit, $offset );
    }
  ');



//--------------------------------------------------------------------
  if( ! function_exists( 'coupons_new_base' ) ) 
  {

    function coupons_new_base($mydirname, $limit=0, $offset=0)
    {
      global $xoopsDB ;

      $MOD_URL  = XOOPS_URL .'/modules/'. $mydirname ;

      //DB table
      $table_coupons = $xoopsDB->prefix( $mydirname."_coupons" ) ;
      $sql = "SELECT * FROM $table_coupons WHERE status>0 AND starttime<".time()." AND endtime>".time()." ORDER BY regidate DESC";
      $result = $xoopsDB->query( $sql , $limit , $offset ) ;
      $ret = array() ;
      while( $row = $xoopsDB->fetchArray($result) ) 
      {
        $ret[] = array(
          'link'  => $MOD_URL .'/index.php?lid='. $row['lid'] ,
          'title' => htmlspecialchars($row['title'],ENT_QUOTES) ,
          'hits'  => $row['hits'] ,
          'time'  => $row['regidate'] ,
          'id'    => $row['lid'] ,
          'uid'   => $row['uid'] ,
        ) ;
      }

      return $ret;
    }

  }
//--------------------------------------------------------------------


} //END of if( $module->getVar('isactive') )
?>
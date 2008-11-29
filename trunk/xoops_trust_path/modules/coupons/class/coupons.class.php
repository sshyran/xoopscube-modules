<?php
if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;

require_once XOOPS_ROOT_PATH.'/kernel/object.php';


//---------------------------------------------------------------------
class CouponsObject extends XoopsObject
{
  function CouponsObject()
  {
    //DB_coupons
    $this->initVar('lid',         XOBJ_DTYPE_INT,     null, false);
    $this->initVar('cid',         XOBJ_DTYPE_INT,     null, true);
    $this->initVar('title',       XOBJ_DTYPE_TXTBOX,  null, true, 255);
    $this->initVar('starttime',   XOBJ_DTYPE_INT,     null, false);
    $this->initVar('endtime',     XOBJ_DTYPE_INT,     null, false);
    $this->initVar('uid',         XOBJ_DTYPE_INT,     null, false);
    $this->initVar('status',      XOBJ_DTYPE_INT,     null, false);
    $this->initVar('regidate',    XOBJ_DTYPE_INT,     null, false);
    $this->initVar('hits',        XOBJ_DTYPE_INT,     null, false);
    $this->initVar('embed',       XOBJ_DTYPE_TXTBOX,  null, false, 255);
    //DB_text
    $this->initVar('description', XOBJ_DTYPE_TXTAREA, null, false);
    //POST DATA
    $this->initVar('startdate',   XOBJ_DTYPE_TXTBOX,  null, true, 15);
    $this->initVar('enddate',     XOBJ_DTYPE_TXTBOX,  null, true, 15);
    $this->initVar('starthour',   XOBJ_DTYPE_INT,     null, false);
    $this->initVar('startmin',    XOBJ_DTYPE_INT,     null, false);
    $this->initVar('startsec',    XOBJ_DTYPE_INT,     null, false);
    $this->initVar('endhour',     XOBJ_DTYPE_INT,     null, false);
    $this->initVar('endmin',      XOBJ_DTYPE_INT,     null, false);
    $this->initVar('endsec',      XOBJ_DTYPE_INT,     null, false);
    $this->initVar('fieldtitle',  XOBJ_DTYPE_ARRAY,   null, false);
    $this->initVar('fielddesc',   XOBJ_DTYPE_ARRAY,   null, false);
    //EMBED
    $this->initVar('embed_dir',   XOBJ_DTYPE_TXTBOX,  null, false, 30);
    $this->initVar('item_field',  XOBJ_DTYPE_TXTBOX,  null, false, 20);
    $this->initVar('item_id',     XOBJ_DTYPE_INT,     null, false );
    $this->initVar('filequery',   XOBJ_DTYPE_TXTBOX,  null, false, 50);
  }

  function unserializeCleanArray()
  {
    $myts =& MyTextSanitizer::getInstance();
    foreach( $this->vars as $k=>$v ){
      if( $v['data_type'] == XOBJ_DTYPE_ARRAY ){
        $this->cleanVars[$k] = unserialize($myts->stripSlashesGPC($this->cleanVars[$k]));
      }
    }
  }

}

//---------------------------------------------------------------------
class Coupons
{
  //DB
  var $db ;
  var $table_coupons ;
  var $table_text ;
  var $table_cat ;

  var $mydirurl ;
  var $mytrustpath ;
  var $mydirname ;

  //USER
  var $myPostperm ;
  var $myPost_app ;
  var $myEditperm ;
  var $myEdit_app ;
  var $myDelperm ;
  var $myDel_app ;
  var $myUid ;
  var $isadmin ;

  var $addfield ;
  var $saveData ;

  //default index SQL
  var $order = " ORDER BY l.regidate DESC " ;
  var $where = " l.status>0 AND l.starttime<%u AND l.endtime>%u AND " ;

  function Coupons($mydirname)
  {
    $this->db =& Database::getInstance();
    $this->table_coupons = $this->db->prefix( $mydirname ."_coupons" ) ;
    $this->table_text = $this->db->prefix( $mydirname ."_text" ) ;
    $this->table_cat = $this->db->prefix( $mydirname ."_cat" ) ;
    $this->mydirurl = XOOPS_URL .'/modules/'. $mydirname ;
    $this->mytrustpath = XOOPS_TRUST_PATH .'/modules/'. $mydirname ;
    $this->mydirname = $mydirname ;
  }

  function getCount( $cid=0 , $linkuid=0 , $limit=0 , $offset=0 )
  {
     $sql =& $this->getSql( $cid , $linkuid );
     //var_dump($sql);
     $result = $this->db->query( $sql , $limit , $offset );
     $count = $this->db->getRowsNum($result) ;
     return $count ;
  }
  
  function &getSql( $cid=0, $linkuid=0, $lid=0 )
  {
    $whrCid = ( $cid > 0 ) ? " l.cid=". intval($cid) ." AND " : "" ;
    $whrUid = ( $linkuid > 0 ) ? " l.uid=". intval($linkuid) ." AND " : "" ;
    $whrLid = ( $lid > 0 ) ? " l.lid=". intval($lid) ." AND " : "" ;
    $sql = "SELECT * FROM ". $this->table_coupons ." l, ". $this->table_text ." t WHERE 
      $whrCid $whrUid $whrLid ". $this->getWhere() ." 
      l.lid=t.lid ".
      $this->getOrder() ;
    return $sql ;
  }

  //sql other wheres
  function setWhere( $whr )
  {
    $this->where = $whr ;
  }
  function getWhere()
  {
    $otherWhere = $this->where ;
    if( $otherWhere == " l.status>0 AND l.starttime<%u AND l.endtime>%u AND " ){
      $otherWhere = sprintf($otherWhere,time(),time()) ;
    }
    return $otherWhere ;
  }

  //sql order
  function setOrder( $odr )
  {
    $this->order = $odr ;
  }
  function getOrder()
  {
    return $this->order ;
  }

  function getCoupon( $lid=0 , $edit='s' )
  {
    $sql =& $this->getSql( 0 , 0 , $lid );
    $result = $this->db->query( $sql );
    $row = $this->db->fetchArray($result) ;
    $cobj = new CouponsObject() ;
    $cobj->assignVars($row) ;
    $ret = $this->arrangeArray($cobj,$edit) ;
    return $ret ;
  }

  function getCoupons( $cid=0 , $linkuid=0 , $limit=10 , $offset=0 )
  {
    $ret = array();
    $sql =& $this->getSql($cid,$linkuid);
    $result = $this->db->query( $sql , $limit , $offset );
    while( $row = $this->db->fetchArray($result)) {
      $cobj = new CouponsObject() ;
      $cobj->assignVars($row) ;
      $ret[] = $this->arrangeArray($cobj) ;
    }
    return $ret;
  }

  function arrangeArray( $d , $edit='s' )
  {
    $edit_f = ($edit=='edit') ? 'e' : 's' ;
    $desc = $d->getVar( 'description' , $edit_f ) ;
    list( $desc , $addfields ) = $this->splitDescription( $desc ) ;
    $uid = $d->getVar('uid') ;

    $emb = $d->getVar('embed') ;
    $embed_url = empty($emb) ? '' : $this->createEmbedUrl( $emb ) ;

    $ret = array(
      'lid'           => $d->getVar('lid') ,
      'cid'           => $d->getVar('cid') ,
      'title'         => strip_tags($d->getVar('title',$edit_f)) ,
      'embed'         => $d->getVar('embed') ,
      'starttime'     => formatTimestamp($d->getVar('starttime'),"m") ,
      'starttime_STP' => $d->getVar('starttime') ,
      'endtime'       => formatTimestamp($d->getVar('endtime'),"m") ,
      'endtime_STP'   => $d->getVar('endtime') ,
      'description'   => $desc ,
      'editlink'      => $this->checkEditor( $uid ) ,
      'uid'           => $uid ,
      'hits'          => $d->getVar('hits') ,
      'uname'         => $this->getUnameFromUid($uid) ,
      'status'        => $d->getVar('status') ,
      'regidate'      => formatTimestamp($d->getVar('regidate'),"m") ,
      'regidate_STP'  => $d->getVar('regidate') ,
      'addfields'     => $addfields ,
      'embed_url'     => $embed_url ,
      'qr_url'        => $this->makeUrlForQR( $d->getVar('lid') ) ,
    );
    return $ret ;
  }

  function makeUrlForQR( $lid ){
    $url = $this->mydirurl ."/index.php?page=mobile&lid=". $lid ;
    $url = rawurlencode($url);
    //$url = ereg_replace( "%20" , "+" , $url );
    $url = str_replace( "%20" , "+" , $url );
    return $url ;
  }

  function createEmbedUrl( $embed )
  {
    $rtn = '' ;
    if( !empty($embed) ){
      $arr = explode('][',$embed) ;
      $arr[0] = str_replace('[','',$arr[0]) ;
      $arr[3] = str_replace(']','',$arr[3]) ;
      if( is_dir(XOOPS_ROOT_PATH."/modules/".$arr[0]) ){
        require_once $this->mytrustpath ."/include/functions.php" ;
        $rtn = coupons_urlCheckReplace( XOOPS_URL ."/modules/". $arr[0] ."/". $arr[3] ) ;
      }
    }
    return $rtn ;
  }

  function getUnameFromUid( $uid )
  {
    global $xoopsConfig ;
    if( $uid > 0 ) {
      $member_handler =& xoops_gethandler('member') ;
      $poster =& $member_handler->getUser($uid) ;
      if( is_object( $poster ) ) {
        $name = htmlspecialchars( $poster->uname() , ENT_QUOTES ) ;
      } else {
        $name = htmlspecialchars($xoopsConfig['anonymous'],ENT_QUOTES) ;
      }
    } else {
      $name = htmlspecialchars($xoopsConfig['anonymous'],ENT_QUOTES) ;
    }
    return $name ;
  }

  function setPerm( $postperm , $post_approval , $editperm , $edit_approval , $delperm , $del_approval , $uid , $isadmin )
  {
    $this->myPostperm = $postperm ;
    $this->myPost_app = $post_approval ;
    $this->myEditperm = $editperm ;
    $this->myEdit_app = $edit_approval ;
    $this->myDelperm  = $delperm ;
    $this->myDel_app  = $del_approval ;
    $this->myUid      = $uid ;
    $this->isadmin    = $isadmin ;
  }

  function checkEditor( $checkUid )
  {
    $adminlink =  ( ($this->myEditperm && $checkUid==$this->myUid) || $this->isadmin ) ? true : false ;
    return $adminlink ;
  }

  function splitDescription( $desc )
  {
    $addfields = '' ;
    if( $this->addfield ){
      preg_match( "/\[addfield\](.*)\[\/addfield\]/" , $desc , $regs );
      if(isset($regs[0])){
        $desc = str_replace($regs[0],'',$desc) ;

        preg_match_all( "/\[ft\](.*)\[\/ft\]\[fd\](.*)\[\/fd\]/U" , $regs[1] , $regs2 );
        if( count($regs2[1]) == count($regs2[2]) ){
          for($i=0; $i<count($regs2[1]); $i++){
            $addfields[] = array( 
              'title' => $regs2[1][$i] ,
              'desc'  => $regs2[2][$i] 
            ) ;
          }
        }
      }
    }
    return array( $desc , $addfields ) ;
  }

  //USE addfield
  function setAddField( $addfield ) 
  {
    $this->addfield = $addfield ;
  }

  function insert()
  {
    $this->getPOSTdata() ;

    $sql = sprintf("INSERT INTO %s 
      (lid, cid, title, starttime, endtime, uid, status, regidate, hits, embed ) VALUES 
      (%u, %u, '%s', %u, %u, %u, %d, %u, %u, '%s')", 
        $this->table_coupons , 
        $this->saveData['lid'] ,
        $this->saveData['cid'] ,
        addslashes($this->saveData['title']),
        $this->saveData['starttime'],
        $this->saveData['endtime'],
        $this->saveData['uid'],
        $this->saveData['status'],
        $this->saveData['regidate'],
        $this->saveData['hits'],
        addslashes($this->saveData['embed'])
    );
    $this->db->query($sql) or die( "DB Error: INSERT coupon" );
    $newid = $this->saveData['lid'] ;
    if ( $newid == 0 ) {
      $newid = $this->db->getInsertId();
    }
    $sql = sprintf("INSERT INTO %s (lid, description) VALUES (%u, '%s')", 
      $this->table_text, 
      $newid, 
      addslashes($this->saveData['description'])
    );
    $this->db->query($sql) or die( "DB Error: INSERT link description" );
    return ;
  }

  function update( $lid , $status=false )
  {
    $this->getPOSTdata( $lid ) ;

    if( $this->myEdit_app ){
      if( $this->isadmin ){
        $status = ( $status == 0 ) ? 1 : 2 ;
      }else{
        if( $status == 1 || $status == 2 ) $status = 2 ;
      }
    }else{
      if( $status == 1 || $status == 2 ) $status = -1 ;
    }
    if( $status===false ){
      redirect_header($mydirurl."/",3,_NOPERM);
      exit;
    }
    //regidate
    $regidate = '' ;
    if( isset($_POST['age']) && $_POST['age']==1 ){
      if( isset($_POST['modage']) && $_POST['modage']==1 ){
        $newdate = $this->adminMakeDate() ;
        if( !empty($newdate) ){
          $regidate = " , regidate=". $newdate ;
        }
      }else{
        $regidate = " , regidate=". time() ;
      }
    }

    $sql = sprintf("UPDATE %s SET cid=%u, title='%s', starttime=%u, endtime=%u, status=%d $regidate WHERE lid=%u",
      $this->table_coupons ,
      $this->saveData['cid'] ,
      addslashes($this->saveData['title']) ,
      $this->saveData['starttime'] ,
      $this->saveData['endtime'] ,
      $status ,
      $lid 
    ) ;
    $this->db->query($sql) or die( "DB Error: UPDATE coupon" );
    $sql = sprintf("UPDATE %s SET description='%s' where lid=%u" ,
      $this->table_text, 
      addslashes($this->saveData['description']),
      $lid
    ) ;
    $this->db->query($sql) or die( "DB Error: UPDATE coupon text" ) ;
  }

  function adminMakeDate()
  {
    $newdate = '' ;
    if( $this->isadmin ){
      $now = getdate();
      $year    = isset($_POST['year'])    ? intval($_POST['year'])    : $now['year'] ;
      $month   = isset($_POST['month'])   ? intval($_POST['month'])   : $now['mon'] ;
      $day     = isset($_POST['day'])     ? intval($_POST['day'])     : $now['mday'] ;
      $hours   = isset($_POST['hours'])   ? intval($_POST['hours'])   : $now['hours'] ;
      $minutes = isset($_POST['minutes']) ? intval($_POST['minutes']) : $now['minutes'] ;
      $seconds = isset($_POST['seconds']) ? intval($_POST['seconds']) : $now['seconds'] ;
      $newdate = mktime( $hours , $minutes , $seconds , $month , $day , $year ) ;
    }
    return $newdate ;
  }

  function dateProcess( $data )
  {
    //nen , tuki , hi
    list( $year_s , $month_s , $day_s ) = $this->dateCheck( $data['startdate'] ) ;
    list( $year_e , $month_e , $day_e ) = $this->dateCheck( $data['enddate'] ) ;
    //hour : min
    $startsec = $endsec = 0 ;
    if( $data['starthour']==100 || $data['startmin']==100 ){
      $data['starthour'] = $data['startmin'] = $data['startsec'] = 0;
    }
    if( $data['endhour']==100 || $data['endmin']==100 ){
      $data['endhour'] = 23;
      $data['endmin'] = 59;
      $data['endsec'] = 59;
    }
    if( !( $data['starthour']>=0 && $data['starthour']<=23 ) || 
        !( $data['startmin']>=0 && $data['startmin']<=59 ) || 
        !( $data['startsec']>=0 && $data['startsec']<=59 ) || 
        !( $data['endhour']>=0 && $data['endhour']<=23 ) || 
        !( $data['endmin']>=0 && $data['endmin']<=59 ) || 
        !( $data['endsec']>=0 && $data['endsec']<=59 ) ){
      redirect_header($this->mydirurl."/",3, _MD_HOUR_FAILED );
      exit();
    }
    $s_timestamp = mktime( $data['starthour'], $data['startmin'], $data['startsec'], $month_s, $day_s, $year_s ) ;
    $e_timestamp = mktime( $data['endhour'], $data['endmin'], $data['endsec'], $month_e, $day_e, $year_e ) ;
    return array($s_timestamp,$e_timestamp);
  }



  function getPOSTdata( $lid=0 )
  {
    $myts = & MyTextSanitizer::getInstance();

    $data = array();
    if( isset($_POST['cid']) )        $data['cid']         = $_POST['cid'] ;
    if( isset($_POST['title']) )      $data['title']       = $_POST['title'] ;
    if( isset($_POST['desc']) )       $data['description'] = $_POST['desc'] ;
    if( isset($_POST['startdate']) )  $data['startdate']   = $_POST['startdate'] ;
    if( isset($_POST['enddate']) )    $data['enddate']     = $_POST['enddate'] ;
    if( isset($_POST['starthour']) )  $data['starthour']   = $_POST['starthour'] ;
    if( isset($_POST['startmin']) )   $data['startmin']    = $_POST['startmin'] ;
    if( isset($_POST['startsec']) )   $data['startsec']    = $_POST['startsec'] ;
    if( isset($_POST['endhour']) )    $data['endhour']     = $_POST['endhour'] ;
    if( isset($_POST['endmin']) )     $data['endmin']      = $_POST['endmin'] ;
    if( isset($_POST['endsec']) )     $data['endsec']      = $_POST['endsec'] ;
    if( isset($_POST['fieldtitle']) ) $data['fieldtitle']  = $_POST['fieldtitle'] ;
    if( isset($_POST['fielddesc']) )  $data['fielddesc']   = $_POST['fielddesc'] ;
    if( isset($_POST['embed_dir']) )  $data['embed_dir']   = $_POST['embed_dir'] ;
    if( isset($_POST['item_field']) ) $data['item_field']  = $_POST['item_field'] ;
    if( isset($_POST['item_id']) )    $data['item_id']     = $_POST['item_id'] ;
    if( isset($_POST['filequery']) )  $data['filequery']   = $_POST['filequery'] ;

    $cobj = new CouponsObject() ;
    $cobj->setVars($data) ;
    $cobj->cleanVars() ;
    if($cobj->getErrors()){
      $err = array_map( 'htmlspecialchars',$cobj->getErrors());
      $msg = implode('<br />',$err) ;
      redirect_header( $this->mydirurl."/index.php?page=submit" , 3 , $msg );
      exit();
    }
    if( isset($_POST['fieldtitle']) && isset($_POST['fielddesc']) ){
      $cobj->unserializeCleanArray() ;
    }

    list($s_timestamp,$e_timestamp) = $this->dateProcess($cobj->cleanVars) ;

    //description + addfield
    if( $this->addfield ){
      //$cobj->cleanVars['description'] .=  $this->getPOSTaddfield($cobj->cleanVars['fieldtitle'],$cobj->cleanVars['fielddesc']) ;
      $cobj->cleanVars['description'] .=  $this->getPOSTaddfield( $cobj->cleanVars ) ;
    }
    //status
    $status = ( $this->myPost_app ) ? 1 : 0 ;	//NEW POST
    //new lid
    if( empty($lid) ){
      $lid = $this->db->genId($this->table_coupons."_lid_seq");
    }

    //embed strings
    $embed = '' ;
    if( !empty($cobj->cleanVars['embed_dir']) && !empty($cobj->cleanVars['item_field']) && !empty($cobj->cleanVars['item_id']) && !empty($cobj->cleanVars['filequery']) ){
      $embed = '['. $cobj->cleanVars['embed_dir'] .']['. $cobj->cleanVars['item_field'] .']['. $cobj->cleanVars['item_id'] .']['. $cobj->cleanVars['filequery'] .']' ;
    }

    $this->saveData = array(
      'lid'         => $lid ,
      'cid'         => $cobj->cleanVars['cid'] ,
      'title'       => $cobj->cleanVars['title'] ,
      'starttime'   => $s_timestamp ,
      'endtime'     => $e_timestamp ,
      'uid'         => $this->myUid ,
      'status'      => $status ,
      'regidate'    => time() ,
      'hits'        => 0 ,
      'embed'       => $embed ,
      'description' => $cobj->cleanVars['description'] ,
    );
  }

  function dateCheck( $date )
  {
    global $xoopsModuleConfig ;

    $date = preg_replace( '/\.|\/|,/' ,'-',$date);
    if( $xoopsModuleConfig['datetype']==1 ){
      list( $year , $month , $day ) = explode( '-' , $date );
    }elseif( $xoopsModuleConfig['datetype']==2 ){
      list( $month , $day , $year ) = explode( '-' , $date );
    }elseif( $xoopsModuleConfig['datetype']==3 ){
      list( $day , $month , $year ) = explode( '-' , $date );
    }

    $y_check = $m_check = $d_check = false ;
    if( $year>2000 ) $y_check=true;
    if( $month>=1 && $month<=12 ) $m_check=true;
    $d = $d = 30 ;
    if( $month==2 ){
      $d = ( $year%4!=0 || ($year%4==0 && $year%100==0) ) ? 28 : 29 ;
    }elseif( $month==1 || $month==3 || $month==5 || $month==7 || $month==8 || $month==10 || $month==12 ){
      $d = 31 ;
    }
    if( $day>=1 && $day<=$d ) $d_check=true;

    if( ! $y_check || ! $m_check || ! $d_check ){
      redirect_header($this->mydirurl."/index.php?page=submit",3,_MD_DATE_FAILED);
      exit();
    }

    return array( $year , $month , $day );
  }

  function getPOSTaddfield( $data )
  {
    $ftitle_ss = $data['fieldtitle'] ;
    $fdesc_ss = $data['fielddesc'] ;
    $return_text = "" ;
    if( count($ftitle_ss) == count($fdesc_ss) && count($ftitle_ss)>0 ){
      for( $i=0; $i<count($ftitle_ss); $i++ ){
        if( !empty($ftitle_ss[$i]) || !empty($fdesc_ss[$i]) ){
          $return_text .= "[ft]". $ftitle_ss[$i] ."[/ft][fd]". $fdesc_ss[$i] ."[/fd]" ;
        }
      }
      if( !empty($return_text) ){
        $return_text = "\n[addfield]". $return_text ."[/addfield]" ;
      }
    }
    return $return_text ;
  }

  function countup( $lid=0 )
  {
    global $xoopsUser ;
    if( is_object($xoopsUser) ) return ;
    $rtn = false ;
    if( $lid>0 ){
      $sql = sprintf("UPDATE %s SET hits=hits+1 WHERE lid=%u" ,
        $this->table_coupons ,
        intval($lid) 
      ) ;
      $this->db->queryF($sql) or die( "DB Error: COUNTUP " );
      $rtn = true ;
    }
    return $rtn ;
  }

  function delete( $lid )
  {
    if( $this->myDelperm ){
      $sql = "DELETE FROM ". $this->table_coupons ." WHERE lid=".intval($lid) ;
      $this->db->query($sql) or die( "DB Error: DELETE coupon" );
      $sql = "DELETE FROM ". $this->table_text ." WHERE lid=".intval($lid) ;
      $this->db->query($sql) or die( "DB Error: DELETE coupon description" );
      //TODO delete integrated comments
      //notification?
    }
  }

  function deleteByCid( $cids )
  {
    $count = 0 ;
    if( count($cids)>0 ){
      $wherecid  = 'l.cid=' ;
      $wherecid .= implode( ' OR l.cid=' , $cids ) ;
      $this->setWhere( " ( $wherecid ) AND " ) ;
      $count = $this->getCount() ;

      $wherecid  = 'cid=' ;
      $wherecid .= implode( ' OR cid=' , $cids ) ;
      $sql = "DELETE FROM ". $this->table_coupons ." WHERE $wherecid " ;
      $this->db->query($sql) or die( "DB Error: DELETE coupon by cid" );
      //TODO delete integrated comments
      //notification?
    }
    return $count ;
  }

  function deleteReq( $lid )
  {
    if( !$this->myDel_app ){
      $sql = "UPDATE ". $this->table_coupons ." SET status=-2, regidate=".time()." WHERE lid=". intval($lid) ;
      $this->db->query($sql) or die( "DB Error: change status for delete request" );
    }
  }

  function statusChange( $lid )
  {
    $this->setWhere('');
    $cp = $this->getCoupon($lid);
    $present_status = $cp['status'] ;
    $statuswhere = '' ;
    if( $present_status==0 ){
      $statuswhere = " status=1 " ;
    }elseif( $present_status==-1 ){
      $statuswhere = " status=2 " ;
    }
    if( !empty($statuswhere) ){
      $sql = "UPDATE ". $this->table_coupons ." SET $statuswhere WHERE lid=".intval($lid) ;
      $this->db->query($sql) or die( "DB Error: UPDATE approve" ) ;
    }
  }


}
?>
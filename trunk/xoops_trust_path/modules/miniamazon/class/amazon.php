<?php
include_once XOOPS_ROOT_PATH . '/class/snoopy.php';


class miniAmazon
{
	var $_aid;
	var $_qurl;
	var $_accesskey = '19CKW00MA9WDMDEV0PG2';	//wye's accesskeyid
	var $_version = '2008-06-23';	// © 2007-05-14 © 2006-05-17 © 2005-10-05

	function miniAmazon( $aid )
	{
		$this->_aid = addslashes($aid);
		$this->_qurl =	"http://webservices.amazon.co.jp/onca/xml?" .
				"Service=AWSECommerceService".
				"&AWSAccessKeyId=". $this->_accesskey .
				"&AssociateTag=" . $this->_aid .
				"&Version=". $this->_version .
				"&ResponseGroup=Large".//ItemAttributes".
				"&Operation=ItemLookup".
				"&ContentType=text/xml".
				"&IdType=ASIN";
	}

	function query( $asin )
	{
		$url = $this->_qurl . "&ItemId=" . addslashes($asin) ;
		$snoopy = New Snoopy;
		//var_dump($url);
		$snoopy->fetch( $url );
		$xml = $snoopy->results;
		$data = XML_unserialize($xml);
		mb_convert_variables( _CHARSET , 'auto' , $data );
		$error = $sdata = $title = $creator = $manufacturer = $pgroup = $img_m = $dpURL = $isadult = '';
		$error = @$data['ItemLookupResponse']['Items']['Request']['Errors']['Error']['Code'];
		if( ! $error ){
			$sdata = @$data['ItemLookupResponse']['Items']['Item'];
			$title = @$sdata['ItemAttributes']['Title'];
			$cr    = @$sdata['ItemAttributes']['Creator'];
			if( empty($cr) ) $cr = @$sdata['ItemAttributes']['Author'];
			if( empty($cr) ) {
				$cr1 = @$sdata['ItemAttributes']['Actor'] ;
				$cr2 = @$sdata['ItemAttributes']['Director'] ;
				if( !empty($cr1) ){
					$cr = !empty($cr2) ? array_merge((array)$cr1,(array)$cr2) : (array)$cr1 ;
				}else{
					$cr = !empty($cr2) ? (array)$cr2 : '' ;
				}
			}
			if( is_array($cr) && count($cr) > 0 ){
				for( $i=0; $i<count($cr); $i++ ){
					if( isset($cr[$i]) ) $crtemp[] = $cr[$i];
				}
				$creator = implode( ', ' , $crtemp );
			} else {
				$creator = $cr;
			}
			$manufacturer = @$sdata['ItemAttributes']['Manufacturer'];
			$pgroup       = @$sdata['ItemAttributes']['ProductGroup'];
			$img_m        = @$sdata['MediumImage']['URL'];
			$dpURL        = @$sdata['DetailPageURL'];
			$isadult      = @$sdata['ItemAttributes']['IsAdultProduct'];
		}
		$query_arr = array( $error, $title, $creator, $manufacturer, $img_m , $pgroup, $dpURL, $isadult );
		return $query_arr;
	}

}

?>
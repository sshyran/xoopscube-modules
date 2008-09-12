<?php

if (!defined('XOOPS_ROOT_PATH')) exit();

//http://prism-perfect.net/archive/php-tag-cloud-tutorial/
// connect to database at some point

// In the SQL below, change these three things:
// thing is the column name that you are making a tag cloud for
// id is the primary key
// my_table is the name of the database table

//$where : url or uid

function getTagCloud($where = null, $min = 80, $max = 200)
{
	$wh = "";
	$ret = "";
	$tags = array();
	$max_qty = 0;
	$min_qty = 0;

	$db =& Database::getInstance() ;
	$myts =& MyTextsanitizer::getInstance() ;
	if($where){
		$wh = " WHERE ". $where;
	}
	
	$sql = "SELECT tag_name AS tag, COUNT(tag_id) AS quantity
	  FROM ". $db->prefix("cubookmarken_tag") .$wh. "
	  GROUP BY tag_name
	  ORDER BY tag_name ASC";
	$result = $db->query( $sql ) ;

	// here we loop through the results and put them into a simple array:
	// $tag['thing1'] = 12;
	// $tag['thing2'] = 25;
	// etc. so we can use all the nifty array functions
	// to calculate the font-size of each tag

	while ($row = $db->fetchRow($result)) {
	    $tags[$myts->makeTboxData4Show($row['0'])] = $row[1];
	}

	// change these font sizes if you will
	$max_size = $max; // max font size in %
	$min_size = $min; // min font size in %

	// get the largest and smallest array values
	if($tags){
		$max_qty = max(array_values($tags));
		$min_qty = min(array_values($tags));
	}

	// find the range of values
	$spread = $max_qty - $min_qty;
	if (0 == $spread) { // we don't want to divide by zero
	    $spread = 1;
	}

	// determine the font-size increment
	// this is the increase per tag quantity (times used)
	$step = ($max_size - $min_size)/($spread);

	// loop through our tag array
	foreach ($tags as $key => $value) {

	    // calculate CSS font-size
	    // find the $value in excess of $min_qty
	    // multiply by the font-size increment ($size)
	    // and add the $min_size set above
	    $size = $min_size + (($value - $min_qty) * $step);
	    // uncomment if you want sizes in whole %:
	    // $size = ceil($size);

	    // you'll need to put the link destination in place of the #
	    // (assuming your tag links to some sort of details page)
	    $ret = $ret .'<a href="'. XOOPS_URL .'/modules/cubookmarken/index.php?action=TagList&tag_name='. urlencode($key) .'" style="font-size: '.$size.'%">'.$key.'</a> ';
	    // notice the space at the end of the link
	}
    return $ret;
}
?>
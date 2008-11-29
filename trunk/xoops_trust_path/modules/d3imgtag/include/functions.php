<?php
// ------------------------------------------------------------------------- //
//                      IMGTag - XOOPS photo album                           //
//                        <http://www.kickassamd.com/>                       //
// ------------------------------------------------------------------------- //
//                      IMGTag D3                                            //
//                        <http://xoops.oceanblue-site.com/>                 //
// ------------------------------------------------------------------------- //

// constants
define('PIPEID_GD' , 0);
define( 'PIPEID_IMAGICK' , 1 ) ;
define( 'PIPEID_NETPBM' , 2 ) ;

function createFileName($min, $max, $type)
{
	// Get Character Values For Random Value Creation
	switch ($type)
	{
		case 0:
			$keyType = "a A b B c C d D e E f F g G h H i I j J k K l L m M n N o O p P q Q r R s S t T u U v V w W x X y Y z Z";
		break;
		
		case 1:
			$keyType = "0 1 2 3 4 5 6 7 8 9";
		break;
		
		case 2:
			$keyType = "a A b B c C d D e E f F g G h H i I j J k K l L m M n N o O p P q Q r R s S t T u U v V w W x X y Y z Z 0 1 2 3 4 5 6 7 8 9";
		break;
		
		case 3:
			$keyType = "a A b B c C d D e E f F g G h H i I j J k K l L m M n N o O p P q Q r R s S t T u U v V w W x X y Y z Z 0 1 2 3 4 5 6 7 8 9 _ - ~ @";
	}
	
	$keyType = explode(" ", $keyType);
	
	$len = rand($min, $max);
	
	for ($i = 0; $i < $len; $i++)
	{
		@$key .= $keyType[rand(0, count($keyType))];
	}
	
	return $key;
}

function convert_from_bytes($bytes)  
{ 
    $size = $bytes / 1024; 
    if($size < 1024) 
        { 
        $size = number_format($size, 2); 
        $size .= ' KB'; 
        }  
    else  
        { 
        if($size / 1024 < 1024)  
            { 
            $size = number_format($size / 1024, 2); 
            $size .= ' MB'; 
            }  
        else if ($size / 1024 / 1024 < 1024)   
            { 
            $size = number_format($size / 1024 / 1024, 2); 
            $size .= ' GB'; 
            }  
        } 
    return $size; 
}

function d3imgtag_get_thumbnail_wh($width , $height)
{
	global $d3imgtag_thumbsize , $d3imgtag_thumbrule ;

	switch($d3imgtag_thumbrule) {
		case 'w' :
			$new_w = $d3imgtag_thumbsize ;
			$scale = $width / $new_w ;
			$new_h = intval(round($height / $scale));
			break ;
		case 'h' :
			$new_h = $d3imgtag_thumbsize ;
			$scale = $height / $new_h ;
			$new_w = intval(round($width / $scale));
			break ;
		case 'b' :
			if($width > $height) {
				$new_w = $d3imgtag_thumbsize ;
				$scale = $width / $new_w ; 
				$new_h = intval(round($height / $scale));
			} else {
				$new_h = $d3imgtag_thumbsize ;
				$scale = $height / $new_h ; 
				$new_w = intval(round($width / $scale));
			}
			break ;
		default :
			$new_w = $d3imgtag_thumbsize ;
			$new_h = $d3imgtag_thumbsize ;
			break ;
	}

	return array($new_w , $new_h);
}

function d3imgtag_get_preview_wh($width , $height)
{
	global $d3imgtag_previewsize , $d3imgtag_previewrule;

	switch($d3imgtag_previewrule) {
		case 'w' :
			$new_w = $d3imgtag_previewsize ;
			$scale = $width / $new_w ;
			$new_h = intval(round($height / $scale));
			break ;
		case 'h' :
			$new_h = $d3imgtag_previewsize ;
			$scale = $height / $new_h ;
			$new_w = intval(round($width / $scale));
			break ;
		case 'b' :
			if($width > $height) {
				$new_w = $d3imgtag_previewsize ;
				$scale = $width / $new_w ; 
				$new_h = intval(round($height / $scale));
			} else {
				$new_h = $d3imgtag_previewsize ;
				$scale = $height / $new_h ; 
				$new_w = intval(round($width / $scale));
			}
			break ;
		default :
			$new_w = $d3imgtag_previewsize;
			$new_h = $d3imgtag_previewsize;
			break ;
	}

	return array($new_w , $new_h);
}

function d3imgtag_create_thumb($src_path , $node , $ext)
{
	global $d3imgtag_imagingpipe , $d3imgtag_makethumb , $d3imgtag_normal_exts ;

	if(! in_array(strtolower($ext) , $d3imgtag_normal_exts)) {
		return d3imgtag_copy_thumb_from_icons($src_path , $node , $ext);
	}

	if(! $d3imgtag_makethumb) return 3 ;

	if( $d3imgtag_imagingpipe == PIPEID_IMAGICK ) {
		return d3imgtag_create_thumb_by_imagick( $src_path , $node , $ext ) ;
	} else if( $d3imgtag_imagingpipe == PIPEID_NETPBM ) {
		return d3imgtag_create_thumb_by_netpbm( $src_path , $node , $ext ) ;
	} else {
		return d3imgtag_create_thumb_by_gd( $src_path , $node, $ext ) ;
	}
}

function d3imgtag_create_preview($src_path , $node , $ext)
{
	global $d3imgtag_imagingpipe , $d3imgtag_makepreview , $d3imgtag_normal_exts ;

	if(! in_array(strtolower($ext) , $d3imgtag_normal_exts)) {
		return d3imgtag_copy_thumb_from_icons($src_path , $node , $ext);
	}

	if(! $d3imgtag_makepreview) return 3 ;

	if( $d3imgtag_imagingpipe == PIPEID_IMAGICK ) {
		return d3imgtag_create_preview_by_imagick( $src_path , $node , $ext ) ;
	} else if( $d3imgtag_imagingpipe == PIPEID_NETPBM ) {
		return d3imgtag_create_preview_by_netpbm( $src_path , $node , $ext ) ;
	} else {
		return d3imgtag_create_preview_by_gd( $src_path , $node, $ext ) ;
	}
}

// Copy Thumbnail from directory of icons
function d3imgtag_copy_thumb_from_icons($src_path , $node , $ext)
{
	global $mod_path , $thumbs_dir ;

	@unlink("$thumbs_dir/$node.gif");
	if(file_exists("$mod_path/icons/$ext.gif")) {
		$copy_success = copy("$mod_path/icons/$ext.gif" , "$thumbs_dir/$node.gif");
	}
	if(empty($copy_success)) {
		@copy("$mod_path/icons/default.gif" , "$thumbs_dir/$node.gif");
	}

	return 4 ;
}

// Creating Preview by GD
function d3imgtag_create_preview_by_gd($src_path , $node , $ext)
{
	global $d3imgtag_forcegd2 , $previews_dir ;

	$bundled_2 = false ;
	if(! $d3imgtag_forcegd2 && function_exists('gd_info')) {
		$gd_info = gd_info();
		if(substr($gd_info['GD Version'] , 0 , 10) == 'bundled (2') $bundled_2 = true ;
	}

	if(! is_readable($src_path)) return 0 ;
	@unlink("$previews_dir/$node.$ext");
	list($width , $height , $type) = getimagesize($src_path);
	switch($type) {
		case 1 :
			// GIF
			$src_img = imagecreatefromgif($src_path);
		break;
		case 2 :
			// JPEG
			$src_img = imagecreatefromjpeg($src_path);
		break ;
		
		case 3 :
			// PNG
			$src_img = imagecreatefrompng($src_path);
		break ;
		
		default :
			@copy($src_path , "$previews_dir/$node.$ext");
			return 2 ;
	}
	list($new_w , $new_h) = d3imgtag_get_preview_wh($width , $height);

	if($width <= $new_w && $height <= $new_h) {
		// only copy when small enough
		copy($src_path , "$previews_dir/$node.$ext");
		return 2 ;
	}

	if($bundled_2) {
		$dst_img = imagecreate($new_w , $new_h);
		imagecopyresampled($dst_img , $src_img , 0 , 0 , 0 , 0 , $new_w , $new_h , $width , $height);
	} else {
		$dst_img = @imagecreatetruecolor($new_w , $new_h);
		if(! $dst_img) {
			$dst_img = imagecreate($new_w , $new_h);
			imagecopyresized($dst_img , $src_img , 0 , 0 , 0 , 0 , $new_w , $new_h , $width , $height);
		} else {
			imagecopyresampled($dst_img , $src_img , 0 , 0 , 0 , 0 , $new_w , $new_h , $width , $height);
		}
	}

	switch($type) {
		case 1:
			imagegif($dst_img, "$previews_dir/$node.$ext");
			imagedestroy($dst_img);
		break;
		
		case 2 :
			// JPEG
			imagejpeg($dst_img, "$previews_dir/$node.$ext");
			imagedestroy($dst_img);
		break ;
		
		case 3 :
			// PNG
			imagepng($dst_img, "$previews_dir/$node.$ext");
			imagedestroy($dst_img);
		break ;
	}

	imagedestroy($src_img);
	return 1 ;
}

// Creating Preview by ImageMagick
function d3imgtag_create_preview_by_imagick( $src_path , $node , $ext )
{
	global $d3imgtag_imagickpath , $previews_dir ;

	// Check the path to binaries of imaging packages
	if( trim( $d3imgtag_imagickpath ) != '' && substr( $d3imgtag_imagickpath , -1 ) != DIRECTORY_SEPARATOR ) {
		$d3imgtag_imagickpath .= DIRECTORY_SEPARATOR ;
	}

	if( ! is_readable( $src_path ) ) return 0 ;
	@unlink( "$previews_dir/$node.$ext" ) ;
	list( $width , $height , $type ) = getimagesize( $src_path ) ;

	list( $new_w , $new_h ) = d3imgtag_get_preview_wh( $width , $height ) ;

	if( $width <= $new_w && $height <= $new_h ) {
		// only copy when small enough
		copy( $src_path , "$previews_dir/$node.$ext" ) ;
		return 2 ;
	}

	// Make Thumb and check success
	exec( "{$d3imgtag_imagickpath}convert -geometry {$new_w}x{$new_h} $src_path $previews_dir/$node.$ext" ) ;
	if( ! is_readable( "$previews_dir/$node.$ext" ) ) {
		// can't exec convert, big thumbs!
		copy( $src_path , "$previews_dir/$node.$ext" ) ;
		return 2 ;
	}

	return 1 ;
}

// Creating Preview by NetPBM
function d3imgtag_create_preview_by_netpbm( $src_path , $node , $ext )
{
	global $d3imgtag_netpbmpath , $previews_dir ;

	// Check the path to binaries of imaging packages
	if( trim( $d3imgtag_netpbmpath ) != '' && substr( $d3imgtag_netpbmpath , -1 ) != DIRECTORY_SEPARATOR ) {
		$d3imgtag_netpbmpath .= DIRECTORY_SEPARATOR ;
	}

	if( ! is_readable( $src_path ) ) return 0 ;
	@unlink( "$previews_dir/$node.$ext" ) ;
	list( $width , $height , $type ) = getimagesize( $src_path ) ;
	switch( $type ) {
		case 1 :
			// GIF
			$pipe0 = "{$d3imgtag_netpbmpath}giftopnm" ;
			$pipe2 = "{$d3imgtag_netpbmpath}ppmquant 256 | {$d3imgtag_netpbmpath}ppmtogif" ;
			break ;
		case 2 :
			// JPEG
			$pipe0 = "{$d3imgtag_netpbmpath}jpegtopnm" ;
			$pipe2 = "{$d3imgtag_netpbmpath}pnmtojpeg" ;
			break ;
		case 3 :
			// PNG
			$pipe0 = "{$d3imgtag_netpbmpath}pngtopnm" ;
			$pipe2 = "{$d3imgtag_netpbmpath}pnmtopng" ;
			break ;
		default :
			@copy( $src_path , "$previews_dir/$node.$ext" ) ;
			return 2 ;
	}

	list( $new_w , $new_h ) = d3imgtag_get_preview_wh( $width , $height ) ;

	if( $width <= $new_w && $height <= $new_h ) {
		// only copy when small enough
		copy( $src_path , "$previews_dir/$node.$ext" ) ;
		return 2 ;
	}

	$pipe1 = "{$d3imgtag_netpbmpath}pnmscale -xysize $new_w $new_h" ;

	// Make Thumb and check success
	exec( "$pipe0 < $src_path | $pipe1 | $pipe2 > $previews_dir/$node.$ext" ) ;
	if( ! is_readable( "$previews_dir/$node.$ext" ) ) {
		// can't exec convert, big previews!
		copy( $src_path , "$previews_dir/$node.$ext" ) ;
		return 2 ;
	}

	return 1 ;
}

// Creating Thumbnail by GD
function d3imgtag_create_thumb_by_gd($src_path , $node , $ext)
{
	global $d3imgtag_forcegd2 , $thumbs_dir ;

	$bundled_2 = false ;
	if(! $d3imgtag_forcegd2 && function_exists('gd_info'))
	{
		$gd_info = gd_info();
		if(substr($gd_info['GD Version'] , 0 , 10) == 'bundled (2') $bundled_2 = true ;
	}

	if(! is_readable($src_path)) return 0 ;
	@unlink("$thumbs_dir/$node.$ext");
	list($width , $height , $type) = getimagesize($src_path);
	switch($type)
	{
		case 1 :
			// GIF
			$src_img = imagecreatefromgif($src_path);
		break;
		
		case 2 :
			// JPEG
			$src_img = imagecreatefromjpeg($src_path);
		break ;
		
		case 3 :
			// PNG
			$src_img = imagecreatefrompng($src_path);
			imagesavealpha($src_img, true);
		break ;
		
		default :
			@copy($src_path , "$thumbs_dir/$node.$ext");
		return 2;
	}

	list($new_w , $new_h) = d3imgtag_get_thumbnail_wh($width , $height);

	if($width <= $new_w && $height <= $new_h)
	{
		// only copy when small enough
		copy($src_path , "$thumbs_dir/$node.$ext");
		return 2 ;
	}

	if($bundled_2)
	{
		$dst_img = imagecreate($new_w , $new_h);
		imagecopyresampled($dst_img , $src_img , 0 , 0 , 0 , 0 , $new_w , $new_h , $width , $height);
	} 
	else
	{
		$dst_img = @imagecreatetruecolor($new_w , $new_h);
		if(! $dst_img)
		{
			$dst_img = imagecreate($new_w , $new_h);
			imagecopyresized($dst_img , $src_img , 0 , 0 , 0 , 0 , $new_w , $new_h , $width , $height);
		}
		else
		{
			imagecopyresampled($dst_img , $src_img , 0 , 0 , 0 , 0 , $new_w , $new_h , $width , $height);
		}
	}

	switch($type)
	{
		// GIF
		case 1:
			imagegif($dst_img, "$thumbs_dir/$node.$ext");
			imagedestroy($dst_img);
		break;
		
		case 2 :
			// JPEG
			imagejpeg($dst_img, "$thumbs_dir/$node.$ext");
			imagedestroy($dst_img);
		break ;
		
		case 3 :
			// PNG
			imagepng($dst_img, "$thumbs_dir/$node.$ext");
			imagedestroy($dst_img);
		break ;
	}

	imagedestroy($src_img);
	return 1 ;
}

// Creating Thumbnail by ImageMagick
function d3imgtag_create_thumb_by_imagick( $src_path , $node , $ext )
{
	global $d3imgtag_imagickpath , $thumbs_dir ;

	// Check the path to binaries of imaging packages
	if( trim( $d3imgtag_imagickpath ) != '' && substr( $d3imgtag_imagickpath , -1 ) != DIRECTORY_SEPARATOR ) {
		$d3imgtag_imagickpath .= DIRECTORY_SEPARATOR ;
	}

	if( ! is_readable( $src_path ) ) return 0 ;
	@unlink( "$thumbs_dir/$node.$ext" ) ;
	list( $width , $height , $type ) = getimagesize( $src_path ) ;

	list( $new_w , $new_h ) = d3imgtag_get_thumbnail_wh( $width , $height ) ;

	if( $width <= $new_w && $height <= $new_h ) {
		// only copy when small enough
		copy( $src_path , "$thumbs_dir/$node.$ext" ) ;
		return 2 ;
	}

	// Make Thumb and check success
	exec( "{$d3imgtag_imagickpath}convert -geometry {$new_w}x{$new_h} $src_path $thumbs_dir/$node.$ext" ) ;
	if( ! is_readable( "$thumbs_dir/$node.$ext" ) ) {
		// can't exec convert, big thumbs!
		copy( $src_path , "$thumbs_dir/$node.$ext" ) ;
		return 2 ;
	}

	return 1 ;
}

// Creating Thumbnail by NetPBM
function d3imgtag_create_thumb_by_netpbm( $src_path , $node , $ext )
{
	global $d3imgtag_netpbmpath , $thumbs_dir ;

	// Check the path to binaries of imaging packages
	if( trim( $d3imgtag_netpbmpath ) != '' && substr( $d3imgtag_netpbmpath , -1 ) != DIRECTORY_SEPARATOR ) {
		$d3imgtag_netpbmpath .= DIRECTORY_SEPARATOR ;
	}

	if( ! is_readable( $src_path ) ) return 0 ;
	@unlink( "$thumbs_dir/$node.$ext" ) ;
	list( $width , $height , $type ) = getimagesize( $src_path ) ;
	switch( $type ) {
		case 1 :
			// GIF
			$pipe0 = "{$d3imgtag_netpbmpath}giftopnm" ;
			$pipe2 = "{$d3imgtag_netpbmpath}ppmquant 256 | {$d3imgtag_netpbmpath}ppmtogif" ;
			break ;
		case 2 :
			// JPEG
			$pipe0 = "{$d3imgtag_netpbmpath}jpegtopnm" ;
			$pipe2 = "{$d3imgtag_netpbmpath}pnmtojpeg" ;
			break ;
		case 3 :
			// PNG
			$pipe0 = "{$d3imgtag_netpbmpath}pngtopnm" ;
			$pipe2 = "{$d3imgtag_netpbmpath}pnmtopng" ;
			break ;
		default :
			@copy( $src_path , "$thumbs_dir/$node.$ext" ) ;
			return 2 ;
	}

	list( $new_w , $new_h ) = d3imgtag_get_thumbnail_wh( $width , $height ) ;

	if( $width <= $new_w && $height <= $new_h ) {
		// only copy when small enough
		copy( $src_path , "$thumbs_dir/$node.$ext" ) ;
		return 2 ;
	}

	$pipe1 = "{$d3imgtag_netpbmpath}pnmscale -xysize $new_w $new_h" ;

	// Make Thumb and check success
	exec( "$pipe0 < $src_path | $pipe1 | $pipe2 > $thumbs_dir/$node.$ext" ) ;
	if( ! is_readable( "$thumbs_dir/$node.$ext" ) ) {
		// can't exec convert, big thumbs!
		copy( $src_path , "$thumbs_dir/$node.$ext" ) ;
		return 2 ;
	}

	return 1 ;
}

// modifyPhoto Wrapper
function d3imgtag_modify_photo($src_path , $dst_path)
{
	global $d3imgtag_imagingpipe , $d3imgtag_forcegd2 , $d3imgtag_normal_exts ;

	$ext = substr(strrchr($dst_path , '.') , 1);

	if(! in_array(strtolower($ext) , $d3imgtag_normal_exts)) {
		rename($src_path , $dst_path);
	}

	if( $d3imgtag_imagingpipe == PIPEID_IMAGICK ) {
		d3imgtag_modify_photo_by_imagick( $src_path , $dst_path ) ;
	} else if( $d3imgtag_imagingpipe == PIPEID_NETPBM ) {
		d3imgtag_modify_photo_by_netpbm( $src_path , $dst_path ) ;
	} else {
		if( $d3imgtag_forcegd2 ) d3imgtag_modify_photo_by_gd( $src_path , $dst_path ) ;
		else rename( $src_path , $dst_path ) ;
	}
}

// Modifying Original Photo by GD
function d3imgtag_modify_photo_by_gd($src_path , $dst_path)
{
	global $d3imgtag_width , $d3imgtag_height ;

	if(! is_readable($src_path)) return 0 ;

	list($width , $height , $type) = getimagesize($src_path);

	switch($type) {
		case 1 :
			// GIF
			$src_img = imagecreatefromgif($src_path);
			break;
		
		case 2 :
			// JPEG
			$src_img = imagecreatefromjpeg($src_path);
			break ;
		case 3 :
			// PNG
			$src_img = imagecreatefrompng($src_path);
			break ;
		
		default :
			@rename($src_path, $dst_path);
			return 2 ;
	}

	if($width > $d3imgtag_width || $height > $d3imgtag_height) {
		if($width / $d3imgtag_width > $height / $d3imgtag_height) {
			$new_w = $d3imgtag_width ;
			$scale = $width / $new_w ; 
			$new_h = intval(round($height / $scale));
		} else {
			$new_h = $d3imgtag_height ;
			$scale = $height / $new_h ; 
			$new_w = intval(round($width / $scale));
		}
		$dst_img = imagecreatetruecolor($new_w , $new_h);
		imagecopyresampled($dst_img , $src_img , 0 , 0 , 0 , 0 , $new_w , $new_h , $width , $height);
	}

	if(isset($_POST['rotate']) && function_exists('imagerotate')) switch($_POST['rotate']) {
		case 'rot270' :
			if(! isset($dst_img) || ! is_resource($dst_img)) $dst_img = $src_img ;
			// patch for 4.3.1 bug
			$dst_img = imagerotate($dst_img , 270 , 0);
			$dst_img = imagerotate($dst_img , 180 , 0);
			break ;
		case 'rot180' :
			if(! isset($dst_img) || ! is_resource($dst_img)) $dst_img = $src_img ;
			$dst_img = imagerotate($dst_img , 180 , 0);
			break ;
		case 'rot90' :
			if(! isset($dst_img) || ! is_resource($dst_img)) $dst_img = $src_img ;
			$dst_img = imagerotate($dst_img , 270 , 0);
			break ;
		default :
		case 'rot0' :
			break ;
	}

	if(isset($dst_img) && is_resource($dst_img)) switch($type) {
		case 1:
			imagegif($dst_img, $dst_path);
			imagedestroy($dst_img);
		break;
		
		case 2 :
			// JPEG
			imagejpeg($dst_img , $dst_path);
			imagedestroy($dst_img);
			break ;
		case 3 :
			// PNG
			imagepng($dst_img , $dst_path);
			imagedestroy($dst_img);
			break ;
	}

	imagedestroy($src_img);
	if(! is_readable($dst_path)) {
		// didn't exec convert, rename it.
		@rename($src_path , $dst_path);
		return 2 ;
	} else {
		@unlink($src_path);
		return 1 ;
	}
}

// Modifying Original Photo by ImageMagick
function d3imgtag_modify_photo_by_imagick( $src_path , $dst_path )
{
	global $d3imgtag_width , $d3imgtag_height , $d3imgtag_imagickpath ;

	// Check the path to binaries of imaging packages
	if( trim( $d3imgtag_imagickpath ) != '' && substr( $d3imgtag_imagickpath , -1 ) != DIRECTORY_SEPARATOR ) {
		$d3imgtag_imagickpath .= DIRECTORY_SEPARATOR ;
	}

	if( ! is_readable( $src_path ) ) return 0 ;

	// Make options for imagick
	$option = "" ;
	$image_stats = getimagesize( $src_path ) ;
	if( $image_stats[0] > $d3imgtag_width || $image_stats[1] > $d3imgtag_height ) {
		$option .= " -geometry {$d3imgtag_width}x{$d3imgtag_height}" ;
	}
	if( isset( $_POST['rotate'] ) ) switch( $_POST['rotate'] ) {
		case 'rot270' :
			$option .= " -rotate 270" ;
			break ;
		case 'rot180' :
			$option .= " -rotate 180" ;
			break ;
		case 'rot90' :
			$option .= " -rotate 90" ;
			break ;
		default :
		case 'rot0' :
			break ;
	}

	// Do Modify and check success
	if( $option != "" ) exec( "{$d3imgtag_imagickpath}convert $option $src_path $dst_path" ) ;

	if( ! is_readable( $dst_path ) ) {
		// didn't exec convert, rename it.
		@rename( $src_path , $dst_path ) ;
		$ret = 2 ;
	} else {
		@unlink( $src_path ) ;
		$ret = 1 ;
	}

	// water mark
	$wmfile = dirname( dirname( __FILE__ ) ) . '/images/watermark.gif' ;
	if( file_exists( $wmfile ) ) {
		exec( "{$d3imgtag_imagickpath}composite -compose plus $wmfile $dst_path $dst_path" ) ;
	}

	return $ret ;
}

// Modifying Original Photo by NetPBM
function d3imgtag_modify_photo_by_netpbm( $src_path , $dst_path )
{
	global $d3imgtag_width , $d3imgtag_height , $d3imgtag_netpbmpath ;

	// Check the path to binaries of imaging packages
	if( trim( $d3imgtag_netpbmpath ) != '' && substr( $d3imgtag_netpbmpath , -1 ) != DIRECTORY_SEPARATOR ) {
		$d3imgtag_netpbmpath .= DIRECTORY_SEPARATOR ;
	}

	if( ! is_readable( $src_path ) ) return 0 ;

	list( $width , $height , $type ) = getimagesize( $src_path ) ;

	$pipe1 = '' ;
	switch( $type ) {
		case 1 :
			// GIF
			$pipe0 = "{$d3imgtag_netpbmpath}giftopnm" ;
			$pipe2 = "{$d3imgtag_netpbmpath}ppmquant 256 | {$d3imgtag_netpbmpath}ppmtogif" ;
			break ;
		case 2 :
			// JPEG
			$pipe0 = "{$d3imgtag_netpbmpath}jpegtopnm" ;
			$pipe2 = "{$d3imgtag_netpbmpath}pnmtojpeg" ;
			break ;
		case 3 :
			// PNG
			$pipe0 = "{$d3imgtag_netpbmpath}pngtopnm" ;
			$pipe2 = "{$d3imgtag_netpbmpath}pnmtopng" ;
			break ;
		default :
			@rename( $src_path, $dst_path ) ;
			return 2 ;
	}

	if( $width > $d3imgtag_width || $height > $d3imgtag_height ) {
		if( $width / $d3imgtag_width > $height / $d3imgtag_height ) {
			$new_w = $d3imgtag_width ;
			$scale = $width / $new_w ; 
			$new_h = intval( round( $height / $scale ) ) ;
		} else {
			$new_h = $d3imgtag_height ;
			$scale = $height / $new_h ; 
			$new_w = intval( round( $width / $scale ) ) ;
		}
		$pipe1 .= "{$d3imgtag_netpbmpath}pnmscale -xysize $new_w $new_h |" ;
	}

	if( isset( $_POST['rotate'] ) ) switch( $_POST['rotate'] ) {
		case 'rot270' :
			$pipe1 .= "{$d3imgtag_netpbmpath}pnmflip -r90 |" ;
			break ;
		case 'rot180' :
			$pipe1 .= "{$d3imgtag_netpbmpath}pnmflip -r180 |" ;
			break ;
		case 'rot90' :
			$pipe1 .= "{$d3imgtag_netpbmpath}pnmflip -r270 |" ;
			break ;
		default :
		case 'rot0' :
			break ;
	}

	// Do Modify and check success
	if( $pipe1 ) {
		$pipe1 = substr( $pipe1 , 0 , -1 ) ;
		exec( "$pipe0 < $src_path | $pipe1 | $pipe2 > $dst_path" ) ;
	}

	if( ! is_readable( $dst_path ) ) {
		// didn't exec convert, rename it.
		@rename( $src_path , $dst_path ) ;
		return 2 ;
	} else {
		@unlink( $src_path ) ;
		return 1 ;
	}
}

// Clear templorary files
function d3imgtag_clear_tmp_files($dir_path , $prefix = 'tmp_')
{
	// return if directory can't be opened
	if(! ($dir = @opendir($dir_path))) {
		return 0 ;
	}

	$ret = 0 ;
	$prefix_len = strlen($prefix);
	while(($file = readdir($dir)) !== false) {
		if(strncmp($file , $prefix , $prefix_len) === 0) {
			if(@unlink("$dir_path/$file")) $ret ++ ;
		}
	}
	closedir($dir);

	return $ret ;
}


//updates rating data in itemtable for a given item
function d3imgtag_updaterating($lid)
{
	global $xoopsDB , $table_votedata , $table_photos ;

	$query = "SELECT rating FROM $table_votedata WHERE lid='$lid'";
	$voteresult = $xoopsDB->query($query);
	$votesDB = $xoopsDB->getRowsNum($voteresult);
	$totalrating = 0 ;
	while(list($rating) = $xoopsDB->fetchRow($voteresult)) {
		$totalrating += $rating ;
	}
	$finalrating = number_format($totalrating / $votesDB , 4);
	$query = "UPDATE $table_photos SET rating=$finalrating, votes=$votesDB WHERE lid = '$lid'";

	$xoopsDB->query($query) or die("Error: DB update rating.");
}


// Returns the number of photos included in a Category
function d3imgtag_get_photo_small_sum_from_cat($cid , $whr_append = "")
{
	global $xoopsDB , $table_photos ;

	if($whr_append) $whr_append = "AND ($whr_append)";

	$sql = "SELECT COUNT(lid) FROM $table_photos WHERE cid=$cid $whr_append";
	$rs = $xoopsDB->query($sql);
	list($numrows) = $xoopsDB->fetchRow($rs);

	return $numrows ;
}


// Returns the number of whole photos included in a Category
function d3imgtag_get_photo_total_sum_from_cats($cids , $whr_append = "")
{
	global $xoopsDB , $table_photos ;

	if($whr_append) $whr_append = "AND ($whr_append)";

	$whr = "cid IN (";
	foreach($cids as $cid) {
		$whr .= "$cid,";
	}
	$whr = "$whr 0)";

	$sql = "SELECT COUNT(lid) FROM $table_photos WHERE $whr $whr_append";
	$rs = $xoopsDB->query($sql);
	list($numrows) = $xoopsDB->fetchRow($rs);

	return $numrows ;
}


// Update a photo 
function d3imgtag_update_photo($lid , $cid , $title , $desc , $valid = null , $ext = "" , $x = "" , $y = "")
{
	global $xoopsDB, $xoopsConfig, $xoopsModule;
	global $table_photos , $table_text , $table_cat , $mod_url , $isadmin ;

	if(isset($valid)) {
		$set_status = ",status='$valid'";

		// Trigger Notification
		if($valid == 1) {
			$notification_handler =& xoops_gethandler('notification');

			// Global Notification
			$notification_handler->triggerEvent('global' , 0 , 'new_photo' , array('PHOTO_TITLE' => $title , 'PHOTO_URI' => "$mod_url/index.php?page=photo&lid=$lid&cid=$cid"));

			// Category Notification
			$rs = $xoopsDB->query("SELECT title FROM $table_cat WHERE cid=$cid");
			list($cat_title) = $xoopsDB->fetchRow($rs);
			$notification_handler->triggerEvent('category' , $cid , 'new_photo' , array('PHOTO_TITLE' => $title , 'CATEGORY_TITLE' => $cat_title , 'PHOTO_URI' => "$mod_url/index.php?page=photo&lid=$lid&cid=$cid"));
		}
	} else {
		$set_status = '' ;
	}

	$set_date = empty($_POST['store_timestamp']) ? ",date=UNIX_TIMESTAMP()" : "";

	// not admin can only touch photos status>0
	$whr_status = $isadmin ? '' : 'AND status>0' ;

	if($ext == "") {
		// modify only text
		$xoopsDB->query("UPDATE $table_photos SET cid='$cid',title='".addslashes($title)."' $set_status $set_date WHERE lid='$lid' $whr_status");
	} else {
		// modify text and image
		$xoopsDB->query("UPDATE $table_photos SET cid='$cid',title='".addslashes($title)."', ext='$ext',res_x='$x',res_y='$y' $set_status $set_date WHERE lid='$lid' $whr_status");
	}

	$xoopsDB->query("UPDATE $table_text SET description='".addslashes($desc)."' WHERE lid='$lid'");

	redirect_header("index.php?page=editphoto&lid=$lid" , 0 , _MD_D3IMGTAG_DBUPDATED);
}


// Delete photos hit by the $whr clause
function d3imgtag_delete_photos($whr)
{
	global $xoopsDB ;
	global $photos_dir , $thumbs_dir , $previews_dir, $d3imgtag_mid, $d3imgtag_addposts;
	global $table_photos , $table_text , $table_votedata ;

	$prs = $xoopsDB->query("SELECT lid, img, ext, submitter FROM $table_photos WHERE $whr");
	while(list($lid , $img, $ext, $submitter) = $xoopsDB->fetchRow($prs)) {

		xoops_comment_delete($d3imgtag_mid , $lid);
		xoops_notification_deletebyitem($d3imgtag_mid , 'photo' , $lid);

		$xoopsDB->query("DELETE FROM $table_votedata WHERE lid='$lid'") or die("DB error: DELETE votedata table.");
		$xoopsDB->query("DELETE FROM $table_text WHERE lid='$lid'") or die("DB error: DELETE text table.");
		$xoopsDB->query("DELETE FROM $table_photos WHERE lid='$lid'") or die("DB error: DELETE photo table.");
		$xoopsDB->query("UPDATE ".$xoopsDB->prefix('users')." SET `posts` = `posts` - '$d3imgtag_addposts' WHERE uid='$submitter'") or die("DB error: DELETE User Count.");
	
		@unlink("$photos_dir/$img.$ext");
		@unlink("$photos_dir/$img.gif");
		@unlink("$thumbs_dir/$img.$ext");
		@unlink("$thumbs_dir/$img.gif");
		@unlink("$previews_dir/$img.$ext");
		@unlink("$previews_dir/$img.gif");
	}
}


// Substitution of opentable()
function d3imgtag_opentable()
{
	echo "<div style='border: 2px solid #2F5376;padding:8px;width:95%;' class='bg4'>\n";
}


// Substitution of closetable()
function d3imgtag_closetable()
{
	echo "</div>\n";
}


// returns extracted string for options from table with xoops tree
function d3imgtag_get_cat_options($order = 'title' , $preset = 0 , $prefix = '--' , $none = null , $table_name_cat = null , $table_name_photos = null)
{
	global $xoopsDB ;

	$myts =& MyTextSanitizer::getInstance();

	if(empty($table_name_cat)) $table_name_cat = $GLOBALS['table_cat'] ;
	if(empty($table_name_photos)) $table_name_photos = $GLOBALS['table_photos'] ;

	$cats[0] = array('cid' => 0 , 'pid' => -1 , 'next_key' => -1 , 'depth' => 0 , 'title' => '' , 'num' => 0);

	$rs = $xoopsDB->query("SELECT c.title,c.cid,c.pid,COUNT(p.lid) AS num FROM $table_name_cat c LEFT JOIN $table_name_photos p ON c.cid=p.cid GROUP BY c.cid ORDER BY pid ASC,$order DESC");

	$key = 1 ;
	while(list($title , $cid , $pid , $num) = $xoopsDB->fetchRow($rs)) {
		$cats[ $key ] = array('cid' => intval($cid) , 'pid' => intval($pid) , 'next_key' => $key + 1 , 'depth' => 0 , 'title' => $myts->makeTboxData4Show($title) , 'num' => intval($num));
		$key ++ ;
	}
	$sizeofcats = $key ;

	$loop_check_for_key = 1024 ;
	for($key = 1 ; $key < $sizeofcats ; $key ++) {
		$cat =& $cats[ $key ] ;
		$target =& $cats[ 0 ] ;
		if(-- $loop_check_for_key < 0) $loop_check = -1 ;
		else $loop_check = 4096 ;

		while(1) {
			if($cat['pid'] == $target['cid']) {
				$cat['depth'] = $target['depth'] + 1 ;
				$cat['next_key'] = $target['next_key'] ;
				$target['next_key'] = $key ;
				break ;
			} else if(-- $loop_check < 0) {
				$cat['depth'] = 1 ;
				$cat['next_key'] = $target['next_key'] ;
				$target['next_key'] = $key ;
				break ;
			} else if($target['next_key'] < 0) {
				$cat_backup = $cat ;
				array_splice($cats , $key , 1);
				array_push($cats , $cat_backup);
				-- $key ;
				break ;
			}
			$target =& $cats[ $target['next_key'] ] ;
		}
	}

	if(isset($none)) $ret = "<option value=''>$none</option>\n";
	else $ret = '' ;
	$cat =& $cats[ 0 ]  ;
	for($weight = 1 ; $weight < $sizeofcats ; $weight ++) {
		$cat =& $cats[ $cat['next_key'] ] ;
		$pref = str_repeat($prefix , $cat['depth'] - 1);
		$selected = $preset == $cat['cid'] ? "selected='selected'" : '' ;
		$ret .= "<option value='{$cat['cid']}' $selected>$pref {$cat['title']} ({$cat['num']})</option>\n";
	}

	return $ret ;
}

?>
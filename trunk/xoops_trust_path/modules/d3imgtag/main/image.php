<?
/*******************************************************************************
 *                         IMGTag Image Display System
 *******************************************************************************
 *      Author:     Chris York (KickassAMD)
 *      Email:      admin@kickassamd.com
 *      Website:    http://www.kickassamd.com
 *
 *      File:       image.php
 *      Version:    v1.0.1
 *      Copyright:  (c) 2007 - KickassAMD
 *                  You are free to use, distribute, and modify this software
 *                  under the terms of the GNU General Public License.
 *
 *******************************************************************************
 *                         IMGTagD3 Image Display System
 *******************************************************************************
 *      Modified:	manta (http://xoops.oceanblue-site.com/)
 *      History:	v0.20 --- 2008/04/24
 ******************************************************************************/

// Include IMGTagD3 Header & Display Class
require("header.php");
require(dirname(dirname(__FILE__)).'/class/d3imgtag.displayer.php');

// Lets get the Images ID from the requested URL :)
$lid = addslashes($_GET['id']);
$size = addslashes($_GET['sz']);

// Create new Image Display Object
$d3imgtagImage = new d3imgTagDisplaySystem();

// Check Image Referal If Enabled
if ($d3imgtag_checkreferer)
{
	$d3imgtagImage->checkReferal();
}

// Set Needed Configuration Values
$d3imgtagImage->assignImageId($lid);
$d3imgtagImage->assignImageSize($size);
$d3imgtagImage->assignImagePath($thumbs_dir, $photos_dir, $previews_dir);
$d3imgtagImage->assignImageData();

// Add WaterMark
if ($size == 2)
{
	$d3imgtagImage->assignImageTextEnable($d3imgtag_enablewater);
	$d3imgtagImage->assignImageTextString($d3imgtag_watervalue);
	$d3imgtagImage->assignImageFontType($d3imgtag_waterfont);
	$d3imgtagImage->assignImageTextSize($d3imgtag_watersize);
	$d3imgtagImage->assignImageTextPos($d3imgtag_waterpos);
}
$d3imgtagImage->assignHeaders();
$d3imgtagImage->assignImageToBrowser();
?>
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

// Include Display Class
require("../../mainfile.php");
require(dirname(dirname(__FILE__)).'/class/d3imgtag.displayer.php');

// Get Module ID To Check If Sharing Is Enabled
$module_handler =& xoops_gethandler('module');
$module =& $module_handler->getByDirname($mydirname);
$config_handler =& xoops_gethandler('config');
$config = $config_handler->getConfigsByCat(0, $module->getVar('mid'));

if ($config['d3imgtag_enableshare'] == 1)
{
	
	// Lets get the Images ID from the requested URL :)
	$lid = addslashes($_GET['id']);
	$size = '1';
	$table_photos = $xoopsDB->prefix("{$mydirname}_photos");
	
	// Create new Image Display Object
	$d3imgtagImage = new d3imgTagDisplaySystem();
	
	// Set Needed Configuration Values
	$d3imgtagImage->assignImageId($lid);
	$d3imgtagImage->assignImageSize($size);
	$d3imgtagImage->assignImagePath('', '', XOOPS_ROOT_PATH.$config['d3imgtag_photospath']);
	$d3imgtagImage->assignImageTextEnable($config['d3imgtag_enablewater']);
	$d3imgtagImage->assignImageTextString($config['d3imgtag_watervalue']);
	$d3imgtagImage->assignImageFontType($config['d3imgtag_waterfont']);
	$d3imgtagImage->assignImageTextSize($config['d3imgtag_watersize']);
	$d3imgtagImage->assignImageTextPos($config['d3imgtag_waterpos']);
	
	// Set To True To Enable Sharing Check
	$d3imgtagImage->assignImageData(true);
	$d3imgtagImage->assignHeaders();
	$d3imgtagImage->assignImageToBrowser();
}
else
{
	echo "Image Sharing Is Disabled By Administration";
	exit();
}
?>
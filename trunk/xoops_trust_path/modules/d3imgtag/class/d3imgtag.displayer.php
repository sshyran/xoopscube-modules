<?
/*******************************************************************************
 *                         IMGTag Image Display System
 *******************************************************************************
 *      Author:     Chris York (KickassAMD)
 *      Email:      admin@kickassamd.com
 *      Website:    http://www.kickassamd.com
 *
 *      File:       imgtag.displayer.php
 *      Version:    v1.0.1
 *      Copyright:  (c) 2007 - KickassAMD
 *                  You are free to use, distribute, and modify this software
 *                  under the terms of the GNU General Public License.
 *
 *******************************************************************************
 *                         IMGTagD3 Image Display System
 *******************************************************************************
 *      Modified:	manta (http://xoops.oceanblue-site.com/)
 *      History:	v0.20 --- 2008/04/23
 ******************************************************************************/

class d3imgTagDisplaySystem
{
	private
			/**
			 * Image ID From Requested URL
			 * @param int
			 */
			$_imgID,
			
			/**
			 * Image Size From Requested URL
			 * @param int
			 */
			$_imgSize,
			
			/**
			 * Image Path Based on $_imgSize
			 * @param string
			 */
			$_imgPath,
			
			/**
			 * Image Data Based on $_imgID
			 * @param array()
			 */
			$_imgDataArray = array(),
			
			/**
			 * Text String To Add To Image
			 * @param string
			 */
			$_imgString,
			
			/**
			 * Font Type
			 * @param string
			 */
			$_imgFont,
			
			/**
			 * Font Size
			 * @param int
			 */
			$_imgFontSize,
			
			/**
			 * String Posisition
			 * @param int
			 */
			$_imgStringPos,
			
			/**
			 * Write String To Image
			 * @param boolean
			 */
			$_imgStringEnable = false;
			

	/**
	 * Assign Requested ID To Class ID
	 *
	 * @param int $id
	 */
	public function assignImageId($id)
	{
		if (!ctype_digit($id))
		{
			$this->assignErrorImage("Invalid ID. Possible Hack Attempt!");
			exit();
		}
		else
		{
			$this->_imgID = $id;
		}
	}
	
	/**
	 * Assign Requested Size To Class Size
	 * 
	 * @param int $size
	 */
	public function assignImageSize($size)
	{
		if (!ctype_digit($size) || $size > 2)
		{
			$this->assignErrorImage("Invalid Size. 0 - 2 Only.");
			exit();
		}
		else
		{
			$this->_imgSize = $size;
		}
	}
	
	/**
	 * Font Type
	 *
	 * @param string $font
	 */
	public function assignImageFontType($font)
	{
		$this->_imgFont = XOOPS_TRUST_PATH."/modules/d3imgtag/fonts/$font.ttf";
	}
	
	/**
	 * Set String
	 * 
	 * @param string $text
	 */
	public function assignImageTextString($text)
	{
		$this->_imgString = $text;
	}
	
	/**
	 * Enable \ Disable Txt On Image
	 * 
	 * @param boolean $enable
	 */
	public function assignImageTextEnable($enable)
	{
		$this->_imgStringEnable = $enable;
	}
	
	/**
	 * Font Size
	 * @param int $size
	 */
	public function assignImageTextSize($size)
	{
		$this->_imgFontSize = $size;
	}
	
	/**
	 * Set String Posistion
	 * @param string $pos
	 */
	public function assignImageTextPos($pos)
	{
		$this->_imgStringPos = $pos;
	}
	
	/**
	 * Assign Image Path based on $_imgSize
	 *
	 * @param string $thumbPath
	 * @param string $fullPath
	 */
	public function assignImagePath($thumbPath, $fullPath, $previewPath = '')
	{
		switch ($this->_imgSize)
		{
			case 0:
				$this->_imgPath = $thumbPath;
			break;
			
			case 1:
				$this->_imgPath = $previewPath;
			break;
			
			case 2:
				$this->_imgPath = $fullPath;
			break;
		}
	}
	
	/**
	 * Assign Image Data based on $_imgID
	 */
	public function assignImageData($share = false)
	{
		global $xoopsDB, $table_photos;
		
		$res = $xoopsDB->query("SELECT `img`, `ext`, `share` FROM `$table_photos` WHERE `lid` = '$this->_imgID'");
		
		if ($xoopsDB->getRowsNum($res) != 1)
		{
			$this->assignErrorImage("Invalid ID. Image ID $this->_imgID has no data.");
			exit();
		}
		
		while ($img = $xoopsDB->fetchArray($res))
		{
			$data[] = $img;
		}
		
		if ($share)
		{
			if ($data[0]['share'] == 0)
			{
				$this->assignErrorImage("Image $this->_imgID marked private.");
				exit();
			}
		}
		
		$this->_imgDataArray = $data;
	}
	
	/**
	 * Assign Headers :)
	 */
	public function assignHeaders()
	{
		switch ($this->_imgDataArray[0]['ext'])
		{
			case 'jpeg':
			case 'jpg':
				header("Content-type: image/jpeg");
			break;
			
			case 'png':
				header("Content-type: image/png");
			break;
			
			case 'gif':
				header("Content-type: image/gif");
			break;
			
			case 'bmp':
				header("Content-type: image/bmp");
			break;
		}
		
		$filesize = filesize($this->_imgPath."/".$this->_imgDataArray[0]['img'].'.'.$this->_imgDataArray[0]['ext']);
		
		header("Content-length: $filesize");
	}
	
	/**
	 * Read File To Browser
	 */
	public function assignImageToBrowser()
	{
		if (!$this->_imgStringEnable)
		{
			@readfile($this->_imgPath."/".$this->_imgDataArray[0]['img'].'.'.$this->_imgDataArray[0]['ext']);
		}
		else
		{
			$this->addStringToImage();
		}
	}
	
	/**
	 * Assign Error To Image
	 *
	 * @param string $text
	 */
	private function assignErrorImage($text)
	{
		header("Content-type: image/png");
		
		$im = @imagecreate (250, 25);
		$background_color = imagecolorallocate ($im, 255, 255, 255);
		$text_color = imagecolorallocate ($im, 0,0,0);
		imagestring ($im, 2, 5, 5,  $text, $text_color);
		imagepng ($im);
		imagedestroy($im);
	}
	
	/**
	 * Check For Hotlinks
	 */
	public function checkReferal()
	{
		global $d3imgtag_allowedreferers, $d3imgtag_badrefcheck, $d3imgtag_badreftxt;
		
		$allowedRef = unserialize($d3imgtag_allowedreferers);
		
		$goodhost = 0;
        $referer = parse_url(xoops_getenv('HTTP_REFERER'));
        $referer_host = $referer['host'];
        foreach ($allowedRef as $ref)
        {
            if (!empty($ref) && preg_match("/$reg/i", $referer_host))
            {
                $goodhost = 1;
                break;
            }
        }
        if (!$goodhost)
        {
        	switch ($d3imgtag_badrefcheck)
        	{
        		// Blank
        		case 0:
        			exit();
        		break;
        		
        		// Redirect Notice
        		case 1:
        			redirect_header(XOOPS_URL, 10, $d3imgtag_badreftxt);
        		break;
        		
        		// Image Notice
        		case 2:
        			$this->assignErrorImage($d3imgtag_badreftxt);
				break;
        			
        	}
        }
	}
	
	/**
	 * Add Text To Image
	 */
	public function addStringToImage()
	{
		// Make Sure we use the right function for each image type :)
		switch ($this->_imgDataArray[0]['ext'])
		{
			case 'jpg':
			case 'jpeg':
				$image = imagecreatefromjpeg($this->_imgPath."/".$this->_imgDataArray[0]['img'].'.'.$this->_imgDataArray[0]['ext']);
			break;
			
			case 'png':
				$image = imagecreatefrompng($this->_imgPath."/".$this->_imgDataArray[0]['img'].'.'.$this->_imgDataArray[0]['ext']);
			break;
			
			case 'gif':
				$image = imagecreatefromgif($this->_imgPath."/".$this->_imgDataArray[0]['img'].'.'.$this->_imgDataArray[0]['ext']);
			break;
		}
		
		// Get Width \ Height
		$width = imagesx($image);
		$height = imagesy($image);
		
		// Font Color (Black)
		$fontColor = imagecolorallocate($image, 255, 255, 255);
		$fontColorShadow = imagecolorallocate($image, 0, 0, 0);
		
		// Copy Image To Memory
		$copyOriginal = imagecreatetruecolor($width, $height);
		imagecopy($copyOriginal, $image, 0, 0, 0, 0, $width, $height);
		
		// Crank Font Size Up To Fit Image
		$fontSize = $this->_imgFontSize;
		$box = imagettfbbox($fontSize, 0, $this->_imgFont, $this->_imgString);
		$txtWidth = abs($box[4] - $box[0]);
		$txtHeight = abs($box[5] - $box[1]);
		
		
		// All the Math equations to align text
		switch ($this->_imgStringPos)
		{
			// Middle
			case 0:
				$x = ($width / 2) - ($txtWidth / 2);
				$y = ($height / 2) + ($txtHeight / 2);
			break;
			
			// Top
			case 1:
				$x = ($width / 2) - ($txtWidth / 2);
				$y = ($height / 40) + ($txtHeight / 2);
			break;
			
			// Bottom
			case 2:
				$x = ($width / 2) - ($txtWidth / 2);
				$y = $height - ($txtHeight / 2);
			break;
			
			// Bottom Right
			case 3:
				$x = $width - ($txtWidth + ($width / 40));
				$y = ($height - 25) - ($txtHeight / 2);
			break;
			
			// Top Left
			case 4:
				$x = ($width / 75);
				$y = ($height / 40) + ($txtHeight / 2);
			break;
				
		}
		
		// Add Text To Image
		// Shadow Text
		imagettftext($image, $fontSize, 0, $x + 2, $y + 2, $fontColorShadow, $this->_imgFont, $this->_imgString);
		// Main Text
		imagettftext($image, $fontSize, 0, $x, $y, $fontColor, $this->_imgFont, $this->_imgString);
		
		// Merge Images Together
		imagecopymerge($image, $copyOriginal, 0, 0, 0, 0, $width, $height, 50);
		
		// Make Sure We Display The Correct Type
		switch ($this->_imgDataArray[0]['ext'])
		{
			case 'jpg':
			case 'jpeg':
				imagejpeg($image);
			break;
			
			case 'png':
				imagepng($image);
			break;
			
			case 'gif':
				imagegif($image);
			break;
		}
	} 
}
?>
<?php
/*
 * @author Marijuana
 * @license http://creativecommons.org/licenses/by-nc/3.0/
 */
abstract class imagetext
{
  protected $fontsize = 14;
  protected $font;
  protected $img_height = 20;
  protected $img_width = 120;
  protected $value = 'TEXT';
  protected $imgfile;
  protected $color = array('r' => 0, 'g' => 0, 'b' => 0);
  
  protected $Image;
  
  
  public function set_imgfile($imgfile = "")
  {
    $this->imgfile = $imgfile;
  }
  
  public function set_imgsize($imgh, $imgw)
  {
    $this->img_height = $imgh;
    $this->img_width = $imgw;
  }
  
  public function set_font($ffile)
  {
    $this->font = $ffile;
  }
  
  public function set_fontsize($fsize)
  {
    $this->fontsize = $fsize;
  }
  
  public function set_value($value)
  {
    $this->value = $value;
  }
  
  public function set_color($r, $g ,$b)
  {
    $this->color['r'] = $r;
    $this->color['g'] = $g;
    $this->color['b'] = $b;
  }
  
  protected function image_create()
  {
    $this->_create();
    $this->_settext();
  }
  
  protected function _create()
  {
    if ( $this->imgfile == "" ) {
      $this->Image = imagecreatetruecolor($this->img_width, $this->img_height);
      $_color = imagecolorallocate($this->Image, 255, 255, 0);
      imagefill($this->Image, 0, 0, $_color);
    } else {
      $this->Image = imagecreatefrompng($this->imgfile);
    }
  }
  
  protected function get_color()
  {
    return imagecolorallocate($this->Image, $this->color['r'], $this->color['g'], $this->color['b']);
  }
  
  protected function get_positionx()
  {
    if ( $this->font == "" ) {
      return (imagesx($this->Image) - 10 * strlen($this->value)) / 2;
    } else {
      return (imagesx($this->Image) - $this->_get_usefontsize()) / 2;
    }
  }
  
  protected function get_positiony()
  {
    if ( $this->font == "" ) {
      return (imagesy($this->Image) - 16 ) / 2;
    } else {
      $height = $this->_get_usefontsize(false);
      return (imagesy($this->Image) - $height) / 2 + $height;
    }
  }
  
  protected function _get_usefontsize($w = true)
  {
    $posi = imagettfbbox($this->fontsize, 0, $this->font, $this->value);
    $x1 = ( $posi[0] < $posi[6] ) ? $posi[0] : $posi[6];
    $x2 = ( $posi[2] > $posi[4] ) ? $posi[2] : $posi[4];
    $y1 = ( $posi[5] < $posi[7] ) ? $posi[5] : $posi[7];
    $y2 = ( $posi[1] > $posi[3] ) ? $posi[1] : $posi[3];
    $width = 0 - $x1 + $x2;
    $height = 0 - $y1 + $y2;
    return ( $w ) ? $width : $height;
  }
  
  protected function _settext()
  {
    $color = $this->get_color();
    $x = $this->get_positionx();
    $y = $this->get_positiony();
    
    if ( $this->font == "" ) {
      imagestring($this->Image, 5, $x, $y, $this->value, $color);
    } else {
      imagettftext($this->Image, $this->fontsize, 0, $x, $y, $color, $this->font, $this->value);
    }
  }
}

class pngimagetext extends imagetext
{
  public function view_image()
  {
    $this->image_create();
    header('Content-type: image/png');
    imagepng($this->Image);
    imagedestroy($this->Image);
  }
  
  public function put_image($file)
  {
    $this->image_create();
    imagepng($this->Image, $file);
  }
}

class gifimagetext extends imagetext
{
  public function view_image()
  {
    $this->image_create();
    header('Content-type: image/gif');
    imagegif($this->Image);
    imagedestroy($this->Image);
  }
  
  public function put_image($file)
  {
    $this->image_create();
    imagegif($this->Image, $file);
  }
}
?>
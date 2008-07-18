<?php
require_once 'HTMLPurifier/Filter/YouTube.php';

class Xigg_Plugin_YouTube_HTMLPurifierFilter extends HTMLPurifier_Filter_YouTube
{
    var $_width;
    var $_height;
    var $_showRelatedVideos;

    function Xigg_Plugin_YouTube_HTMLPurifierFilter($width = 425, $height = 350, $showRelatedVideos = 0)
    {
        $this->_width = intval($width);
        $this->_height = intval($height);
        $this->_showRelatedVideos = intval($showRelatedVideos);
    }

    function postFilter($html, $config, &$context) {
        $post_regex = '#<span class="youtube-embed">([A-Za-z0-9\-_]+)</span>#';
        $post_replace = '<object width="' . $this->_width . '" height="' . $this->_height . '" '.
            'data="http://www.youtube.com/v/\1&rel=' . $this->_showRelatedVideos . '">'.
            '<param name="movie" value="http://www.youtube.com/v/\1"></param>'.
            '<param name="wmode" value="transparent"></param>'.
            '<!--[if IE]>'.
            '<embed src="http://www.youtube.com/v/\1&rel=' . $this->_showRelatedVideos . '"'.
            'type="application/x-shockwave-flash"'.
            'wmode="transparent" width="' . $this->_width . '" height="' . $this->_height . '" />'.
            '<![endif]-->'.
            '</object>';
        return preg_replace($post_regex, $post_replace, $html);
    }

}
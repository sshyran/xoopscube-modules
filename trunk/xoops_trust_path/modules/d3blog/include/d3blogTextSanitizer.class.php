<?php
/**
 * $Id: d3blogTextSanitizer.class.php 467 2008-06-09 03:48:09Z hodaka $
 * @author      Takeshi Kuriyama <kuri@keynext.co.jp>
 */
if(! class_exists('d3blogTextSanitizer')) {

require_once XOOPS_ROOT_PATH.'/class/module.textsanitizer.php';

class d3blogTextSanitizer extends MyTextSanitizer
{
    /*
    * Constructor of this class
    *
    * Gets allowed html tags from admin config settings
    * <br> should not be allowed since nl2br will be used
    * when storing data.
    *
    * @access   private
    *
    * @todo Sofar, this does nuttin' ;-)
    */
    function d3blogTextSanitizer()
    {
        parent::MyTextSanitizer();
    }

    /**
     * Access the only instance of this class
     *
     * @return  object
     *
     * @static
     * @staticvar   object
     */
    function &getInstance()
    {
        static $instance;
        if (!isset($instance)) {
            $instance = new d3blogTextSanitizer();
        }
        return $instance;
    }

    function &displayTarea( $text, $html=0, $smiley=1, $xcode=1, $image=1, $br=1 )
    {
        if( empty( $xcode ) ) {
            if( empty( $html ) ) $text = htmlspecialchars( $text, ENT_QUOTES );
            if( ! empty( $br ) ) $text = nl2br( $text );
            return $text;
        } else {
            $text = $this->prepareXcode( $text );
            $text = $this->postCodeDecode( parent::displayTarea( $text, $html, $smiley, 1, $image, $br ), $image );
            return  $text;
        }
    }

    function prepareXcode( $text )
    {
        $patterns = array(
            '#\n?\[code\]\r?\n?#' ,
            '#\n?\[\/code\]\r?\n?#' ,
            '#\n?\[quote\]\r?\n?#' ,
            '#\n?\[\/quote\]\r?\n?#' ,
        ) ;
        $replacements = array(
            '[code]' ,
            '[/code]' ,
            '[quote]' ,
            '[/quote]' ,
        ) ;
        return preg_replace( $patterns, $replacements, $text );
    }

    function postCodeDecode( $text, $image )
    {
        $patterns = array();
        $replacements = array();

        // [siteimg]
        $patterns[] = "/\[siteimg align=(['\"]?)(left|center|right)\\1]([^\"\(\)\?\&'<>]*)\[\/siteimg\]/sU";
        $patterns[] = "/\[siteimg]([^\"\(\)\?\&'<>]*)\[\/siteimg\]/sU";
        if( $image ) {
            $replacements[] = '<img src="'.XOOPS_URL.'/\\3" align="\\2" alt="" />';

            $replacements[] = '<img src="'.XOOPS_URL.'/\\1" alt="" />';
        } else {
            $replacements[] = '<a href="'.XOOPS_URL.'/\\3">'.XOOPS_URL.'/\\3</a>';
            $replacements[] = '<a href="'.XOOPS_URL.'/\\1">'.XOOPS_URL.'/\\1</a>';
        }

        $text = preg_replace($patterns, $replacements, $text);
        
        // markup figure layout        
        $pattern = "/\[fig(.*)]([^\"\(\)\?\&'<>]*)\[\/fig\]/sU";
        if($image) {
            return preg_replace_callback($pattern, array($this, 'figMarkupByAttr'), $text);
        } else {
            return preg_replace_callback($pattern, array($this, 'linkMarkupByAttr'), $text);
        }        
    }

    function figMarkupByAttr($matches) {
        $attrs_array = $this->getFigAttr($matches);
        if(!$attrs_array) {
            return $matches[0];
        }

        $markup = sprintf('<div class="figure%s">', isset($attrs_array['align'])? ' fig'.$attrs_array['align'] : "");

        if(in_array('url', array_keys($attrs_array))) {
            $markup .= sprintf('<a href="%s"><img src="%s" alt="%s" /></a>', $attrs_array['url'], $matches[2], @$attrs_array['alt']);
        } else {
            $markup .= sprintf('<img src="%s" alt="%s" />', $matches[2], @$attrs_array['alt']);
        }

        if(in_array('credit', array_keys($attrs_array))) {
            $markup .= sprintf('<p class="credit"><abbr class="type" title="Photograph">Photo</abbr> by <cite>%s</cite></p>', $attrs_array['credit']);
        }
        
        if(in_array('title', array_keys($attrs_array)) && in_array('caption', array_keys($attrs_array))) {
            $markup .= sprintf('<p class="caption"><em class="title">%s</em>%s</p>', $attrs_array['title'], $attrs_array['caption']);
        } elseif(in_array('title', array_keys($attrs_array))) {
            $markup .= sprintf('<p class="caption"><em class="title">%s</em></p>', $attrs_array['title']);
        } elseif(in_array('caption', array_keys($attrs_array))) {
            $markup .= sprintf('<p class="caption">%s</p>', $attrs_array['caption']);
        }
        
        $markup .= '</div>';
        return $markup;
    }

    function linkMarkupByAttr($matches) {
        $attrs_array = $this->getFigAttr($matches);
        if(!$attrs_array) {
            return $matches[0];
        }
        
        $title = isset($attrs_array['title'])? $attrs_array['title'] : (isset($attrs_array['alt'])? $attrs_array['alt'] : (isset($attrs_array['caption'])? $attrs_array['caption'] : ''));
        $markup = sprintf('<a href="%s" title="%s" rel="nofollow">%s</a>', $matches[2], $title, $matches[2]);

        return $markup;
    }

    function getFigAttr($matches) {
        if(!$matches[1]) {
            return false;
        }
        $attrs = explode(" ", trim($matches[1]));
        $attrs_array = array();
        foreach($attrs as $attr) {
            if(preg_match("#^(url|align|caption|alt|credit|title)=#", $attr)) {
                $at = explode('=', $attr);
                if(preg_match("/^([\"']??)(.*)\\1$/sU", $at[1], $attrmatches)) {
                    $attrs_array[$at[0]] = $attrmatches[2];
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
        if(!count(array_intersect(array_keys($attrs_array), array('align', 'caption', 'alt', 'credit', 'title')))) {
            return false;
        }
        return $attrs_array;
    }

    /**
     * Replace XoopsCodes with their equivalent HTML formatting
     *
     * @param   string  $text
     * @param   bool    $allowimage Allow images in the text?
     *                              On FALSE, uses links to images.
     * @return  string
     **/
    function xoopsCodeDecode(&$text, $allowimage=1)
    {
        $imgCallbackPattern = "/\[img( align=\w+)]([^\"\(\)\?\&'<>]*)\[\/img\]/sU";
        $text = preg_replace_callback($imgCallbackPattern, array($this, '_filterImgUrl'), $text);

        // [sitefig]=>[fig], [siteurl][fig]=>[url][fig], [url][fig]=>[fig url=xxxx]
        $imgCallbackPattern = "/\[fig(.*)]([^\"\(\)\?\&'<>]*)\[\/fig\]/sU";
        $text = preg_replace_callback($imgCallbackPattern, array($this, '_filterImgUrl'), $text);
        
        $imgCallbackPattern = "/\[fig(.*) url=([^\"\(\)\?\&'<>]*)]([^\"\(\)\?\&'<>]*)\[\/fig\]/sU";
        $text = preg_replace_callback($imgCallbackPattern, array($this, '_filterImgUrl'), $text);

        // sitefig doesn't need check own url
        $figurePattern = "/\[sitefig(.*)](.*)\[\/sitefig\]/sU";
        $text = preg_replace($figurePattern, '[fig\\1]'.XOOPS_URL.'/\\2[/fig]', $text);
        
        $figurePattern = "/\[siteurl=(['\"]?)([^\"'<>]*)\\1]\[fig(.*)\](.*)\[\/fig\]\[\/siteurl\]/sU";
        $text = preg_replace($figurePattern, '[fig\\3 url='.XOOPS_URL.'/\\2]\\4[/fig]', $text);
        
        $figurePattern = "/\[url=(['\"]?)(http[s]?:\/\/[^\"'<>]*)\\1]\[fig(.*)\](.*)\[\/fig\]\[\/url\]/sU";
        $text = preg_replace($figurePattern, '[fig\\3 url=\\2]\\4[/fig]', $text);

        $patterns = array();
        $replacements = array();
        // [body]
        $patterns[] = "/\[body](.*)\[\/body\]/sU";
        $replacements[] = '<div class="blogBody">\\1</div>';
        // RMV: added new markup for intrasite url (allows easier site moves)
        // TODO: automatically convert other URLs to this format if XOOPS_URL matches??
        $patterns[] = "/\[siteurl=(['\"]?)([^\"'<>]*)\\1](.*)\[\/siteurl\]/sU";
        $replacements[] = '<a href="'.XOOPS_URL.'/\\2">\\3</a>';    // without target
        $patterns[] = "/\[url=(['\"]?)(http[s]?:\/\/[^\"'<>]*)\\1](.*)\[\/url\]/sU";
        $replacements[] = '<a href="\\2">\\3</a>';
        $patterns[] = "/\[url=(['\"]?)(ftp?:\/\/[^\"'<>]*)\\1](.*)\[\/url\]/sU";
        $replacements[] = '<a href="\\2">\\3</a>';
        $patterns[] = "/\[url=(['\"]?)([^\"'<>]*)\\1](.*)\[\/url\]/sU";
        $replacements[] = '<a href="http://\\2">\\3</a>';
        $patterns[] = "/\[color=(['\"]?)([a-zA-Z0-9]*)\\1](.*)\[\/color\]/sU";
        $replacements[] = '<span style="color: #\\2;">\\3</span>';
        $patterns[] = "/\[size=(['\"]?)([a-z0-9-]*)\\1](.*)\[\/size\]/sU";
        $replacements[] = '<span style="font-size: \\2;">\\3</span>';
        $patterns[] = "/\[font=(['\"]?)([^;<>\*\(\)\"']*)\\1](.*)\[\/font\]/sU";
        $replacements[] = '<span style="font-family: \\2;">\\3</span>';
        $patterns[] = "/\[email]([^;<>\*\(\)\"']*)\[\/email\]/sU";
        $replacements[] = '<a href="mailto:\\1">\\1</a>';
        $patterns[] = "/\[b](.*)\[\/b\]/sU";
        $replacements[] = '<strong style="font-weight:bold">\\1</strong>';  // strong
        $patterns[] = "/\[i](.*)\[\/i\]/sU";
        $replacements[] = '<span style="font-style:italic">\\1</span>'; // i -> span
        $patterns[] = "/\[u](.*)\[\/u\]/sU";
        $replacements[] = '<span style="text-decoration:underline">\\1</span>'; // u -> span
        $patterns[] = "/\[em](.*)\[\/em\]/sU";
        $replacements[] = '<em>\\1</em>';
        $patterns[] = "/\[em=(['\"]?)([0-9A-Za-z]*)\\1](.*)\[\/em\]/sU";
        $replacements[] = '<span style="color:#\\2;">\\3</span>';
        $patterns[] = "/\[d](.*)\[\/d\]/sU";
        $replacements[] = '<del>\\1</del>';
        //$patterns[] = "/\[li](.*)\[\/li\]/sU";
        //$replacements[] = '<li>\\1</li>';
        $patterns[] = "/\[img align=(['\"]?)(left|center|right)\\1]([^\"\(\)\?\&'<>]*)\[\/img\]/sU";
        $patterns[] = "/\[img]([^\"\(\)\?\&'<>]*)\[\/img\]/sU";
        $patterns[] = "/\[img align=(['\"]?)(left|right|center)\\1 alt=(['\"]?)(.*)\\3]([^\"\(\)\?\&'<>]*)\[\/img\]/sU";
        $patterns[] = "/\[img alt=(['\"]?)(.*)\\1]([^\"\(\)\?\&'<>]*)\[\/img\]/sU";
        $patterns[] = "/\[img align=(['\"]?)(left|right|center)\\1 id=(['\"]?)([0-9]*)\\3]([^\"\(\)\?\&'<>]*)\[\/img\]/sU";
        $patterns[] = "/\[img id=(['\"]?)([0-9]*)\\1]([^\"\(\)\?\&'<>]*)\[\/img\]/sU";
        if ($allowimage != 1) {
            $replacements[] = '<a href="\\3" rel="nofollow">\\3</a>';
            $replacements[] = '<a href="\\1" rel="nofollow">\\1</a>';
            $replacements[] = '<a href="\\5" title="\\4" rel="nofollow">\\5</a>';
            $replacements[] = '<a href="\\3" title="\\2" rel="nofollow">\\3</a>';
            $replacements[] = '<a href="'.XOOPS_URL.'/image.php?id=\\4" rel="nofollow">\\5</a>';
            $replacements[] = '<a href="'.XOOPS_URL.'/image.php?id=\\2" rel="nofollow">\\3</a>';
        } else {
            $replacements[] = '<span class="blog\\2"><img src="\\3" alt="" /></span>';
            $replacements[] = '<img src="\\1" alt="" />';
            $replacements[] = '<span class="blog\\2"><img src="\\5" alt="\\4" /></span>';
            $replacements[] = '<img src="\\3" alt="\\2" />';
            $replacements[] = '<span class="blog\\2"><img src="'.XOOPS_URL.'/image.php?id=\\4" alt="\\5" /></span>';
            $replacements[] = '<img src="'.XOOPS_URL.'/image.php?id=\\2" alt="\\3" />';
        }

        $patterns[] = "/\[quote]/sU";
        $replacements[] = '<br />'._QUOTEC.'<span class="blogQuote">';   // div -> span(display block)
        $patterns[] = "/\[\/quote]/sU";
        $replacements[] = '</span>';    // /div -> /span
        $patterns[] = "/\[blockquote]/sU";
        $replacements[] = '<span class="blogQuote">';
        $patterns[] = "/\[\/blockquote]/sU";
        $replacements[] = '</span>';
        $patterns[] = "/javascript:/si";
        $replacements[] = "java script:";
        $patterns[] = "/about:/si";
        $replacements[] = "about :";
        return preg_replace($patterns, $replacements, $text);
    }

    function codeConv($text, $xcode = 1, $image = 1){
        if($xcode != 0){
            $patterns = "/\[code](.*)\[\/code\]/esU";
            if ($image != 0) {
                // image allowed
                $replacements = "'<pre class=\"blogCode\"><code>'.d3blogTextSanitizer::codeSanitizer('$1').'</code></pre>'";
                //$text =& $this->xoopsCodeDecode($text);
            } else {
                // image not allowed
                $replacements = "'<pre class=\"blogCode\"><code>'.d3blogTextSanitizer::codeSanitizer('$1', 0).'</code></pre>'";
                //$text =& $this->xoopsCodeDecode($text, 0);
            }
            $text =  preg_replace($patterns, $replacements, $text);
        }
        return $text;
    }

    function codeSanitizer($str, $image = 1){
        if($image != 0){
            $str = $this->xoopsCodeDecode(
                $this->htmlSpecialChars(str_replace('\"', '"', base64_decode($str)))
                );
        }else{
            $str = $this->xoopsCodeDecode(
                $this->htmlSpecialChars(str_replace('\"', '"', base64_decode($str))),0
                );
        }
        return $str;
    }
}

}

?>
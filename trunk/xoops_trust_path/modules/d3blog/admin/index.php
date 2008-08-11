<?php
/*
 * $Id: index.php 40 2007-07-21 06:21:54Z hodaka $
 */
 
xoops_cp_header();
include dirname(__FILE__).'/mymenu.php';
echo '<h3>'.$xoopsModule->getVar('name').'</h3>';
echo '
<h4>Module Features</h4>
<div class="tips">
<p>
- A brand-new and simple d3-typed blog module.<br />
- Simple, but an adequate permission system with entry-by controlling if you prefer.<br />
- Implimented with a blog entry approval function(also with a trackback approval).<br />
- Due day to publish a blog entry enabled.<br />
- With no imagemanager implimented, alternatives such as FCKeditor and myalbum imagemanager are supposed.<br />
- More semantic by an original text sanitizer. More details in include/d3blogTextSanitizer.class.php.<br />
  </p>
    <br />
</div>
	
<div class="return_top"><a href="#container">RETURN_TOP</a></div>
<hr />
<h4 class="admintitle">Text Sanitizer</h4>


<div class="tips">
<p>
  [code] to be converted to &lt;pre class=&quot;blogCode&quot;&gt;&lt;code&gt;, <br />
  [quote] to &lt;span class=&quot;blogQuote&quot;&gt; with diplay:block markups.<br />
  [blockquote] is added converting to &lt;span class=&quot;blogQuote&quot;&gt; with diplay:block markups.<br />
  [img align=left|center|right] to be converted to &lt;span class=&quot;blog\\1&quot;&gt;&lt;img... /&gt;&lt;/span&gt;<br />
  [b] to be converted to &lt;strong style=&quot;font-weight:bold&quot;&gt;<br />
  [em] is added to be converted to [em=rrggbb] -> &lt;em style=&quot;color:#rrggbb;&quot;&gt;<br />
  [fig] and [sitefig] are added, for figure layout markups,<br />
   to be converted to<br />
    &lt;div class=&quot;figure&quot;&gt;&lt;img src=&quot;...&quot; /&gt;&lt;p class=&quot;credit&quot;&gt;..&lt;/p&gt;&lt;p class=&quot;caption&quot;&gt;... &lt;/p&gt;&lt;/div&gt;
	</p>
</div>
<br />

<div class="return_top"><a href="#container">RETURN TOP</a></div>
<hr />
<h4 class="admintitle">More Options</h4>


<div class="tips">
<p>
- Simple comment posting with more semantic comments form.<br />
- Easy setup of d3forum comment integration.<br />
- Various options available against trackback SPAMS, tight or loose.<br />
- Database is importable, both from weblog1.42 and weblogD3 modules, and from xeblog.<br />
- IE Styles, v6 or lower, are re-definitioned in main_styleIE.css and block_styleIE.css.<br />
  Each styles are created from templates by a css manager in the admin section.<br />
  Also dynamic css enabled.<br />
- Enables to synchronize with d3pipes.<br />
- Xmobile plugin file available.<br />
- piCal plugin with a category selection option available.<br />
- FCKeditor set by default.<br />
- [fig] and [sitefig] tags make figure markups pretty.<br />
</p>
</div>';
xoops_cp_footer();

?>
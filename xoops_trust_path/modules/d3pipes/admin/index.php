<?php

xoops_cp_header();
include dirname(__FILE__).'/mymenu.php' ;
if (function_exists('Legacy_function_stylesheet')) {
    echo "<link href=\"".XOOPS_URL."/modules/legacyRender/admin/css.php?file=module.css&dirname=legacy\" media=\"all\" type=\"text/css\" rel=\"stylesheet\" />\n";
}
echo '<h3>'.$xoopsModule->getVar('name').'</h3>' ;

echo '<div class="help"><h4> synthetic module for site syndications.</h4>


<h5>SUMMARY</h5>

<ul>
<li>- Outer RSS/ATOMs can be displayed with any aggregation
<li>- Outer RSS/ATOMs can be imported/deleted automatically
<li>- Outer RSS/ATOMs can be marked/commented
<li>- Inside "what\'s new" information can be displayed with any aggregation
<li>- Both informations of inside/ouside can be treated seamlessly
<li>- Both informations of inside/ouside can be output by the format of RSS1/2/ATOM
<li>- Full customizable "Joint Model"
<li>- Entry extraction
<li>- Asynchronous blocks which never make your site heavy (Of course, clonable)
<li>- As D3 module, free dirname, duplicate, and easy maintenance.


<h5>USAGES</h5>

<p>Install altsys>=0.55 also. [b](essential)[/b]
<br>
Copy "common/lib" (JavaScript Libraries) under XOOPS_ROOT_PATH
<br>http://xoops.peak.ne.jp/md/mydownloads/singlefile.php?lid=104
<br>
<br>Be sure smarty plugins (d3comment_*) are copied into class/smarty/plugins/
<br>Install it as normal D3 module.
<br>
(If you did not)
<br>Make a directory XOOPS_TRUST_PATH/cache and change the mode writable.
<br>
<br>add pipes in "pipe" admin.
<br>You\'d better use "Wizard" till you become familiar with the pipe structure.
<br>
<br>Notice: Async block requires the privileges of not only "block access" but also "module access".
</p>

<h5>SITEMAPS</h5>

<p>If you want Sitemaps feature for google etc., just copy html/sitemap.php of the archive into XOOPS_ROOT_PATH/
<br>
<br>All you have to do is just specify the URL (URL/sitemap.php) as the sitemap of your site to "Google Webmasters" etc.
<br>
<br>You can get the URLs for Sitemaps easily just by accessing the top of d3pipes as the administrator of the site.
<br>
<br>Note: This feature named "Sitemap" is irrelevant from "sitemap module" I had maintained a long time ago.</p></div>';

xoops_cp_footer();

?>

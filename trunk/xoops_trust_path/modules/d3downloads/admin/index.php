<?php

xoops_cp_header();
include dirname(__FILE__).'/mymenu.php' ;
echo '<h3>'.$xoopsModule->getVar('name').'</h3>' ;
echo '
<hr />
<br />

<h4>Module Description</h4>
<div class="tips">
<p>D3downloads is a Duplicatable V3 (D3) module to manage your downloads.</p>
<p>
D3downloads is also based on MyDownloads+ (by Marijuana).<br /> This version is released with significant improvements</p>
</div>
<br />

<hr />
<br />

<h4 class="admintitle">Module Options</h4>
<div class="tips">
<p>
- Set View and Post privileges by category<br />
- File upload feature (available only site administrator)<br />
- Cumbersome to manage screen redesigned mydownloads<br />
- Import from mydownloads, wfdownloads v3.10, d3downloads<br />
- D3 module, rename the module directory and install multiple instances<br />
- Live Validation<br />
- HTML Purifier<br />
- Integrate and manage comments with D3Forum<br />
<br />
Extra archive folder, if necessary:<br />
- piCal - Plug-ins for piCal<br />
- d3pipes - For joint d3pipes<br />
- Mydownloads compatible with a URL. Htaccess<br />
<br />
URL: either you can access.<br />
XOOPS_URL/modules/(dirname)/index.php?Singlefilepage=1&lid=&cid=1 <br />
XOOPS_URL/modules/(dirname)/singlefile.php?cid=1&lid=1<br />
</p>
</div>

<br />	
<div class="return_top"><a href="#container">Return to the Top</a></div>
<hr />
<br />

<h4 class="admintitle">Languages</h4>
<div class="tips">
<p>You can easily edit and custom your language catalog</p>
<p>To edit and personalize your language variables<br />
<a href="index.php?mode=admin&lib=altsys&page=mylangadmin">Click  here</a>!</p>
</div>

<br />	
<div class="return_top"><a href="#container">Return to the Top</a></div>
<hr />
<br />

<h4 class="admintitle">Templates</h4>
<div class="tips">
<p>You can easily duplicate and custom your Templates</p>
<br />
<p>To start editing your module templates<br />
<a href="index.php?mode=admin&lib=altsys&page=mytplsadmin">Click  here</a>!</p>
</div>

<br />	
<div class="return_top"><a href="#container">Return to the Top</a></div>
<hr />
<br />

<h4 class="admintitle">Blocks/Permissions</h4>
<div class="tips">
<p>Install the Theme Editor blocks to override selected modules with your stylesheet, scripts and meta tags.</p>
<p>To install blocks and set permissions<br />
<a href="index.php?mode=admin&lib=altsys&page=myblocksadmin">Click  here</a>!</p>
</div>
';

xoops_cp_footer();

?>
<?php

xoops_cp_header();
include dirname(__FILE__).'/mymenu.php' ;
echo '<h3>'.$xoopsModule->getVar('name').'</h3>' ;
echo '<div class="tips"><p>
<h6>Module Description</h6>

<p>D3downloads is a Duplicatable V3 (D3) module to manage your downloads.</p>
<p>
D3downloads is also based on MyDownloads+ (by Marijuana).<br /> This version is released with significant improvements</p>

<br />
<h6>Module Options</h6>

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
</div>';

xoops_cp_footer();

?>
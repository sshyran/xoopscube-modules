<?php

xoops_cp_header();
include dirname(__FILE__)."/mymenu.php" ;
echo "<h3>".$xoopsModule->getVar('name')."</h3>"; 
echo "<h4>The module for static contents</h4>

<p>This a module for static contents based on Duplicatable V3 (D3).
<br />
Don't forget updating this module after overwritting older version.<br />
And you have to 'sync' once on upgrading from 1.5x/1.6x<br />

Though functionally pico looks a successor to TinyD, pico is made as full-scratched module.<br />

TinyD became a deprecated module because pico has been marked as stable.<br />
Of course, you can upgrade your contents from TinyD to pico easily.</p>


<h4>SPEC:</h4>

<p>- hierarchical category<br />
- breadcrumbs<br />
- page navigation<br />
- XOOPS_TRUST_PATH/wraps/(dirname) files manual page-wrapping<br />
- XOOPS_TRUST_PATH/wraps/(dirname) files automatic page-wrapping/transfer<br />
- static URI (same as wraps)<br />
- overridable options at each categories<br />
- body filter system (smarty, wiki, php etc.)<br />
- better preview<br />
- contents cache<br />
- tell a friend link (tellafriend module supported natively)<br />
- printer friendly view<br />
- singlecontent view<br />
- html header customize per module/categories<br />
- html header customize per contents<br />
- search (with context)<br />
- counts views<br />
- list block (duplicatable)<br />
- menu block (duplicatable)<br />
- contents block (duplicatable)<br />
- contents controller for admin<br />
- dynamic submenu<br />
- native d3forum comment-integration<br />
- Wysiwyg Editor (common/fckeditor only)<br />
- import from TinyD per a module<br />
- import from pico per a module<br />
- import from pico per a content<br />
- plugin for sitemap module<br />
- vote<br />
- automated menu page<br />
- approval system for creating contents<br />
- approval system for modifying contents<br />
- event notification for waiting approval<br />
- plugin for waiting module<br />
- RSS (both entire module and each categories)<br />
- auto-registering wrapped files into DB<br />
- xoops_breadcrumbs<br />
- static URI by mod_rewrite (both wraps mode and normal mode)<br />
- refer histories of contents<br />
- language constants override system<br />
- Xmobile plugin<br />
- any number of extra fields or images as you like<br />
- tag<br />
- hierarchical permission system (succeeding or independent as you like)<br />
- waiting/expiring contents</p>";
xoops_cp_footer();

?>
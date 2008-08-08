<?php

xoops_cp_header();
include dirname(__FILE__).'/mymenu.php' ;
echo '<h3>'.$xoopsModule->getVar('name').'</h3>' ;
echo '<div class="tips">

<p>Module descrition</p>

<p>A synthetic module for site syndications.</p>

<p>SUMMARY</p>
<p>
- Outer RSS/ATOMs can be displayed with any aggregation<br />
- Outer RSS/ATOMs can be imported/deleted automatically<br />
- Outer RSS/ATOMs can be marked/commented<br />
- Inside "what\'s new" information can be displayed with any aggregation<br />
- Both informations of inside/ouside can be treated seamlessly<br />
- Both informations of inside/ouside can be output by the format of RSS1/2/ATOM<br />
- Full customizable "Joint Model"<br />
- Entry extraction<br />
- Asynchronous blocks which never make your site heavy (Of course, clonable)<br />
- As D3 module, free dirname, duplicate, and easy maintenance.<br />
</p>

<p>USAGES</p>

<p>add pipes in "pipe" admin.<br />
You\'d better use "Wizard" till you become familiar with the pipe structure.<br />

Notice: Async block requires the privileges of not only "block access" but also "module access".<br />
</p>
</div>';

xoops_cp_footer();

?>
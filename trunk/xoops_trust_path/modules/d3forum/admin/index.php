<?php

xoops_cp_header();
include dirname(__FILE__).'/mymenu.php' ;
echo '<h3>'.$xoopsModule->getVar('name').'</h3>' ;
echo '<div class="tips">
<p>The REAL Innovative and Basic forum module for XOOPS.
I -GIJOE- release this module with convidence though this module might be still buggy.

Enjoy D3 World!
</p>

<p>How to use "comment-integration"<br />

== for conventional modules ==<br />

1. copy a plugin function.d3forum_comment of the archive into XOOPS_ROOT_PATH/class/smarty/plugins/<br />
2. make a new forum for integration under appropriate category.<br />
3. import from xoopscomments of a module into the forum.<br />
4. edit template like this.</p>
<p>original</p>
<pre>&lt;div style=&quot;text-align: center; padding: 3px; margin:3px;&quot;&gt;
&lt;{$commentsnav}&gt;    
&lt;{$lang_notice}&gt;
&lt;/div&gt;
&lt;div style=&quot;margin:3px; padding: 3px;&quot;&gt;  
&lt;!-- start comments loop --&gt;  
&lt;{if $comment_mode == &quot;flat&quot;}&gt;
&lt;{include file=&quot;db:system_comments_flat.html&quot;}&gt;
&lt;{elseif $comment_mode == &quot;thread&quot;}&gt;
&lt;{include file=&quot;db:system_comments_thread.html&quot;}&gt;
&lt;{elseif $comment_mode == &quot;nest&quot;}&gt;
&lt;{include file=&quot;db:system_comments_nest.html&quot;}&gt;
&lt;{/if}&gt;
&lt;!-- end comments loop --&gt;
&lt;/div&gt;</pre>
<p>modified:</p>
<pre>&lt;{d3forum_comment dirname=d3forum forum_id=<em>(number)</em> itemname=&quot;id&quot; subject=$title}&gt;</pre>
<p>You can find more exemples of old modules integration in author\'s <a href="http://xoops.peak.ne.jp/md/mydownloads/singlefile.php?lid=103&cid=1">web site</a></p>
</div>';
xoops_cp_footer();

?>
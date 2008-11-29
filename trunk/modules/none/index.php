<?php
require '../../mainfile.php';
include(XOOPS_ROOT_PATH . '/header.php');
?>


<h2>Hello, World, <?php echo _MI_NONE_NAME ?>.</h2>
<p>
<?php echo _MI_NONE_DESC ?>
</p>
<p>
This is &quot;<?php echo _MI_NONE_NAME ?>&quot; default page.
plese chage this one.
</p>
<pre>
<?php print(strftime("%Y-%m-%d %H:%M:%S")); ?>
</pre>


<?php
include(XOOPS_ROOT_PATH . '/footer.php');
?>
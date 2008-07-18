<div style="width:500px; margin:0 auto;">
<table align="center"><tr><td align="left">
<?php foreach($this->v('checks') as $check) { ?>
    <?php echo $check ?><br />
<?php } ?>
</td></tr></table>
<p align="center"><?php $this->e('message') ?></p>
</div>
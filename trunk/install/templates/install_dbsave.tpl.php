<div style="width:500px; margin:0 auto;">
<table>
<tr><td align="left">
<?php foreach($this->v('reports') as $report) { ?>
    <?php echo $report ?><br />
<?php } ?>
</td></tr>
</table>
<p align="center"><?php $this->e('message')?></p>
</div>
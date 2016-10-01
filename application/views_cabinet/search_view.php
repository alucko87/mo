<center>
	<div class="first_block">
		<div class="content">
		<h1 class='h1'>Общее описание препарата: <? if(isset($_GET['med_name'])) {echo $_GET['med_name'];} ?></h1>
		<table border='0' cellpadding='5' cellspacing='0' width='100%'>
		<tr><td valign='top' width='25%'>
		<? if(isset($model['medicament'])) {echo $model['medicament'];} ?>
		<br>
		<? if(isset($model['button'])) {echo $model['button'];} ?>
		</td>
		<td valign='top'class="description">
		<?php echo $model['data'];?>
		</td></tr></table>		
		</div>
	<br>
	</div>
	<br>
</center>
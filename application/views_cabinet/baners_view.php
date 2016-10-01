<center>
	<div class="first_block">
		<div class="content">	
		<table width="100%" cellspacing="0" cellpadding="5" border="0"><tr>
		<?php echo $model['head'];?>
		</tr></table>
		<table width="100%" cellspacing="0" cellpadding="5" border="0">
			<tr><td width="25%" valign="top">
			<?php echo $model['menu'];?>
			</td>
			<td valign="top">
			<h1 class="h1 med">Управление банерами</h1><br><br>
			<?php if(isset($model['messadge'])) {echo $model['messadge'];} ?>
				<form action="" name="baners" method="post">
					<table class="list_product" width="100%" cellpadding="3" border="0" cellspacing="0">
					<?php if(isset($model['table'])) {echo $model['table'];} ?>
					</table>
					<br><?php if(isset($model['button'])) {echo $model['button'];} ?><br><br><br>
					<table class="list_product" width="100%" cellpadding="3" border="0" cellspacing="0">
					<?php if(isset($model['table1'])) {echo $model['table1'];} ?>
					</table>
					<br><br>
					<?php if(isset($model['button1'])) {echo $model['button1'];} ?>
				</form>
				<?php echo $model['switch_num_string'];?>
			</td>
			</tr>
		</table>
		</div>
	<br>
	</div>
	<br>
</center>
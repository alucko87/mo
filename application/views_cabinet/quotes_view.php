<center>
	<div class="first_block">
		<div class="content">	
			<?php if(isset($model['messadge'])) echo $model['messadge'];?>
			<table width="100%" cellspacing="0" cellpadding="5" border="0"><tr>
				<?php if(isset($model['head'])) echo $model['head'];?>
			</tr></table>
			<form action='' name='quotes' method='post' autocomplete='off'>
			<table width="100%" cellspacing="0" cellpadding="5" border="0">
				<tr><td width="25%" valign="top" rowspan="3"><?php if(isset($model['menu'])) echo $model['menu'];?></td>
				<td valign="top"><h1 class="h1 med">Мои заявки</h1><?php if(isset($model['sys_messadge'])) echo $model['sys_messadge'];?></td>
				<td><div class="row toggle-demo">
						<div class="switch-toggle switch-3 switch-android large-9 columns">
							<?php if(isset($model['radio'])) echo $model['radio'];?>
						<a></a>
						</div>
					</div>
				</td></tr>				
				</tr>
				<tr><td valign="top" colspan="2">
					<table name='quotes_out' class='list_product' width='100%' cellspacing='0' cellpadding='5' border='0'>
						<?php if(isset($model['table'])) echo $model['table'];?>
					</table>
					</td></tr>
				<tr><td colspan="2"><?php if(isset($model['switch'])) echo $model['switch'];?></td></tr>
			</table>
			</form>
		</div>
	<br>
	</div>
	<br>
</center>
<center>
	<div class="first_block">
		<div class="content">	
			<?php if(isset($model['messadge'])) echo $model['messadge'];?>
			<table width="100%" cellspacing="0" cellpadding="5" border="0"><tr>
				<?php if(isset($model['head'])) echo $model['head'];?>
			</tr></table>
			<form action='' name='creat_quote' method='post' autocomplete='off'>
			<table width="100%" cellspacing="0" cellpadding="5" border="0">
				<tr><td width="25%" valign="top" rowspan="3"><?php if(isset($model['menu'])) echo $model['menu'];?></td>
				<td valign="top"><?php if(isset($model['title'])) echo $model['title'];?></td>
				<td><div class="row toggle-demo">
						<div class="switch-toggle switch-android large-9 columns">
							<?php if(isset($model['radio'])) echo $model['radio'];?>
						<a></a>
						</div>
					</div>
					<?php if(isset($model['sys_messadge'])) echo $model['sys_messadge'];?>
				</td></tr>
					<tr><td valign="top" width="25%">
						<?php if(isset($model['left_menu'])) echo $model['left_menu'];?>
					</td>
					<td valign="top">
						<table width="100%" cellspacing="0" cellpadding="5" border="0">
							<tr><td width='200px'>
								<input type='text' name='medical_name' placeholder='режим поиска' class='input_other' id='search_target' style='width:90%;' <? if(isset($_POST['medical_name'])) echo "value='".htmlspecialchars($_POST['medical_name'])."'" ?>>
							</td>
							<td width='100px'>
								<input type='text' style='width:100px;' name='quote_count' placeholder='количество' class='input_date_do' <? if(isset($_POST['quote_count'])) echo "value='".htmlspecialchars($_POST['quote_count'])."'" ?>>
							</td></tr>
						<?php if(isset($model['med_table'])) echo $model['med_table'];?>
						</table>
					</td></tr>
				<tr><td valign="top" colspan="2">
					<table name='reclama' class='list_product' width='100%' cellspacing='0' cellpadding='5' border='0'>
						<?php if(isset($model['reclama'])) echo $model['reclama'];?>
					</table>				
				</td></tr>
			</table>
			</form>
		</div>
	<br>
	</div>
	<br>
</center>
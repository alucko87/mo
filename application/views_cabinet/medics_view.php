<center>
	<div class="first_block">
		<div class="content">	
			<?php if(isset($model['messadge'])) echo $model['messadge'];?>
			<table width="100%" cellspacing="0" cellpadding="5" border="0"><tr>
				<?php if(isset($model['head'])) echo $model['head'];?>
			</tr></table>
			<table width="100%" cellspacing="0" cellpadding="5" border="0">
				<tr><td width="25%" valign="top">
					<?php if(isset($model['menu'])) echo $model['menu'];?>
				</td>
				<td valign="top">
					<h1 class="h1 med">Управление справочником медикоментов</h1><br><br>
					<?php if(isset($model['messadge'])) {echo $model['messadge'];}?>
					<?php if(isset($model['body'])) {echo $model['body'];}?>
				</td></tr>
				<tr><td colspan="2"><?php if(isset($model['switch'])) echo $model['switch'];?></td></tr>
			</table>
		</div>
	</div>
</center>
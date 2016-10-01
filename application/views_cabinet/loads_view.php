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
					<h1 class="h1 med">Загрузка фотографий и файлов на сайт</h1><br><br>
					<?php if(isset($model['messadge'])) {echo $model['messadge'];}?>
					<table width="100%" cellspacing="0" cellpadding="5" border="0">
						<tr>
							<td>
								<form action="" method="post" enctype="multipart/form-data">
									<input type="file" name="files[]" placeholder="Выберите фото" multiple="true">
									<input type="submit" name="choice_photo" value="OK">
								</form>
							</td>
						</tr>
						<tr>
							<td>
								<form name='delete_photo' action='' method='post'>
									<table class='list_product_left' width='100%' cellpadding='3' border='0' cellspacing='0'>
										<?php if(isset($model['body'])) {echo $model['body'];}?>
									</table>
									<?php if(isset($model['submit'])) {echo $model['submit'];}?>
								</form>
							</td>
						</tr>
					</table>
				<tr><td colspan="2"><?php if(isset($model['switch'])) echo $model['switch'];?></td></tr>
			</table>
		</div>
	<br>
	</div>
	<br>
</center>

<center>
	<div>
		<br><br>
		<table border="0" cellpadding="5" cellspacing="5" width="1000px" align="center">
			<tr>
				<td width="50%" valign="top">
					<div class="med_blok">
						<div class="title">Получить бесплатно лекарство</div>
						<form method="post" action="">
						<span>Название:</span><input placeholder="введите (режим поиска)" type="text" class="input" name="name_in" id="search_target2" autocomplete="off"><br><br>
						<span>Тип:</span> <input placeholder="введите (режим поиска)" type="text" class="input" name="group_in" id="search_target3" autocomplete="off"><br><br><br>
						<div style="text-align:right;padding:5px 5px 15px 5px;"><input value="найти" type="submit" class="submit" name="find_in"></div>
						</form>
					</div>
				</td>
				<td width="50%" valign="top">
					<div class="obmen_blok">
						<form method="post" action="">
						<div class="title">Предложить лекарство<br><br></div>
						<span>Название:</span> <input placeholder="введите (режим поиска)" type="text" class="input" name="name_out" id="search_target4" autocomplete="off"><br><br>
						<span>Тип:</span> <input placeholder="введите (режим поиска)" type="text" class="input" name="group_out" id="search_target5" autocomplete="off"><br><br><br>
						<div style="text-align:right;padding:5px 5px 15px 5px;"><input value="предложить" type="submit" class="submit" name="find_out"></div>
						</form>
					</div>
				</td>
			</tr>
		</table>
	</div>
	<br>
		<div>
		<div class="main_block">
			<br>
			<div class="first_block">
				<div class="content">
				<?php echo $template['text']; ?>
				</div>
			</div>	
		</div>
	</div>
	<br>
</center>


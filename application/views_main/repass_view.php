<center>
	<div class="main_block">
		<br>
		<table border="0" cellpadding="1" cellspacing="1" width="100%">
			<tr>
				<td width="230px"><div class="main_bottom_2 drive" id="out"><a href="#">Предложить лекарство</a></div></td>
				<td><div class="select_alfabet"><span id="alfabet_edit">Все предложения по алфавиту</span></div></td>
				<td align="right"><div class="main_bottom_1 drive" id="in"><a href="#">Получить лекарство</a></div></td>
			</tr>
		</table>
		<div class="first_block">
			<div class="content">
				<table border="0" cellpadding="5" cellspacing="0" width="100%">
					<tr><td><h1 class="h1 med">Востановление пароля</h1></td></tr>
					<tr><td><?php if(isset($model['messadge'])) echo $model['messadge'];?></td></tr>
					<tr><td>				
					<form name="inputmail" action="" method="post">
						<p><input type="text" class="input_other" name="mail" placeholder="адрес e-mail"></p>
						<p><input type="submit" name="repass" value="Восстановить пароль"><input type="submit" name="return" value="Назад"></p>
					</form></td></tr>
				</table>
			</div>
		</div>
	</div>
	<br>
</center>
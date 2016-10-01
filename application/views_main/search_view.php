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
			<table border='0' cellpadding='5' cellspacing='0' width='100%'>
				<tr><td valign='top' width='30%'>
					<form action="" method="post" id="search" autocomplete="off">
					<table border='0' cellpadding='5' cellspacing='0' width='100%'>
						<tr><td><div class="row toggle-demo">
									<div class="switch-toggle switch-3 switch-android large-9 columns">
										<?php if(isset($model['radio'])) echo $model['radio'];?>
									<a></a>
									</div>
								</div></td></tr>						
						<tr><td><div class="zagolovki_filtrov">Наименование</div><input type="text" name='medical_name' placeholder="Режим поиска" style="width:200px" class="input_other" id='search_target' <?if(isset($_POST['medical_name'])) echo "value='".$_POST['medical_name']."'";?>/></td></tr>
						<tr><td><div class="zagolovki_filtrov">Страна</div><input type="text" name="country" placeholder="Введите страну" style="width:200px" class="input_other" <?if(isset($_POST['country'])) echo "value='".$_POST['country']."'";?>/><div class="arrow"><span id="country">&#160;</span></div></td></tr>
						<tr><td><div class="zagolovki_filtrov">Город</div><input type="text" name="city" placeholder="Введите город" style="width:200px" class="input_other" <?if(isset($_POST['city'])) echo "value='".$_POST['city']."'";?>/><div class="arrow"><span id="city">&#160;</span></div></td></tr>
						<tr><td><div class="zagolovki_filtrov">Фармакологическая группа</div><input type="text" name="farm_group" placeholder="Введите фармакологическую группу" style="width:200px" class="input_other" <?if(isset($_POST['farm_group'])) echo "value='".$_POST['farm_group']."'";?>/><div class="arrow"><span id="farm_group">&#160;</span></div></td></tr>
			<!---		<tr><td><div class="zagolovki_filtrov">Годен до <input type="text" name="date_count" placeholder="01.09.2013" class="input_date_do" id="popupDatepicker2" if(isset($_POST['date_count'])) echo "value='".$_POST['date_count']."'"</div></td></tr>	
			-->			<tr><td><div class="zagolovki_filtrov">Лекарственная форма</div><input type="text" name="farm_form" style="width:200px" placeholder="Введите лекарственную форму" class="input_other" <?if(isset($_POST['farm_form'])) echo "value='".$_POST['farm_form']."'";?>/><div class="arrow"><span id="farm_form">&#160;</span></div></td></tr>
						<tr><td><div class="zagolovki_filtrov">Производитель</div><input type="text" name="manufacturer" placeholder="Введите производителя" style="width:200px" class="input_other" <?if(isset($_POST['manufacturer'])) echo "value='".$_POST['manufacturer']."'";?>/><div class="arrow"><span id="manufacturer">&#160;</span></div></td></tr>
						<tr><td><div class="zagolovki_filtrov">Глубина поиска</div><?php if(isset($model['select'])) echo $model['select'];?></td></tr>
					</table>
					<input type="submit" name="ok_search" value="Искать">
					</form>
					</td>
					<td valign='top'>
					<table class="main_list_product_left" border='0' cellpadding='5' cellspacing='0' width='100%'>
						<?php if(isset($model['data'])) echo $model['data'];?>
					</table>
					<br><p style="font-size:15px;">Если результаты поиска Вас не устраивают или они вовсе ничего не было найдено, то, вероятно, тактовых препаратов еще не сформировано. Вы можете ознакомиться со <a href="/directory.html">справочником препаратов</a>.</p>
					</td>
				</tr>
			</table>
			<?php if(isset($model['switch'])) echo $model['switch'];?>			
			</div>
		</div>
	</div>
	<br>
</center>
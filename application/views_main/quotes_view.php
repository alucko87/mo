<center>
	<br>
	<div class="first_block">
		<div class="content">	
		<h1 class="h1 med">Отдам даром лекарства (Расширенный поиск в базе)</h1>
		<table border='0' cellpadding='5' cellspacing='0' width='100%'>
		<tr><td valign='top' width='25%'>
			<form action="" method="post" id="search">
			<table border='0' cellpadding='5' cellspacing='0' width='100%'>
			<tr><td><div class="zagolovki_filtrov">Наименование</div><input type="text" name='medical_name' placeholder="Режим поиска" style="width:160px" class="input_other" id='search_target' <?if(isset($_POST['medical_name'])) echo "value='".$_POST['medical_name']."'";?>/></td></tr>
			<tr><td><div class="zagolovki_filtrov">Страна</div><input type="text" name="country" placeholder="Введите страну" style="width:160px" class="input_other" <?if(isset($_POST['country'])) echo "value='".$_POST['country']."'";?>/><div class="arrow"><span id="country">&#160;</span></div></td></tr>
			<tr><td><div class="zagolovki_filtrov">Город</div><input type="text" name="city" placeholder="Введите город" style="width:160px" class="input_other" <?if(isset($_POST['city'])) echo "value='".$_POST['city']."'";?>/><div class="arrow"><span id="city">&#160;</span></div></td></tr>
			<tr><td><div class="zagolovki_filtrov">Фармакологическая группа</div><input type="text" name="farm_group" placeholder="Введите фармакологическую группу" style="width:160px" class="input_other" <?if(isset($_POST['farm_group'])) echo "value='".$_POST['farm_group']."'";?>/><div class="arrow"><span id="farm_group">&#160;</span></div></td></tr>
<!---		<tr><td><div class="zagolovki_filtrov">Годен до <input type="text" name="date_count" placeholder="01.09.2013" class="input_date_do" id="popupDatepicker2" <?if(isset($_POST['date_count'])) echo "value='".$_POST['date_count']."'";?>/></td></tr>	
-->			<tr><td><div class="zagolovki_filtrov">Лекарственная форма</div><input type="text" name="farm_form" style="width:160px" placeholder="Введите лекарственную форму" class="input_other" <?if(isset($_POST['farm_form'])) echo "value='".$_POST['farm_form']."'";?>/><div class="arrow"><span id="farm_form">&#160;</span></div></td></tr>
			<tr><td><div class="zagolovki_filtrov">Производитель</div><input type="text" name="manufacturer" placeholder="Введите производителя" style="width:160px" class="input_other" <?if(isset($_POST['manufacturer'])) echo "value='".$_POST['manufacturer']."'";?>/><div class="arrow"><span id="manufacturer">&#160;</span></div></td></tr>
			<?php echo $model['checks'];?>
			<tr><td><div class="zagolovki_filtrov">Дата публикации</div>
			с <input type="text" placeholder="01.09.2013" class="input_date" id="popupDatepicker" name="data_start" <?if(isset($_POST['data_start'])) echo "value='".$_POST['data_start']."'";?>/> по <input type="text" placeholder="01.09.2013" class="input_date" id="popupDatepicker1" name="data_finish" <?if(isset($_POST['data_finish'])) echo "value='".$_POST['data_finish']."'";?>/></td></tr>
			</table>
			<input type="submit" name="ok_search" value="Искать">
			</form>
		</td>
		<td valign='top'>
		<table class="list_product_left" border='0' cellpadding='5' cellspacing='0' width='100%'>
		<?php echo $model['data'];?>
		</table></td></tr></table>
		<?php echo $model['switch'];?>			
		</div>
	</div>
	<br>
</center>
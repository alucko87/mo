<center>
	<div class="main_block">
		<br>
		<table border="0" cellpadding="1" cellspacing="1" width="100%">
			<tr>
				<td width="230px">
					<div class="main_bottom_2 drive" id="out">
						<a href="#">Предложить лекарство</a>
					</div>
				</td>
				<td>
					<div class="select_alfabet">
						<span id="alfabet_edit">Все предложения по алфавиту</span>
					</div>
				</td>
				<td align="right">
					<div class="main_bottom_1 drive" id="in">
						<a href="#">Получить лекарство</a>
					</div>
				</td>
			</tr>
		</table>
		<div class="first_block">
			<div class="content">
				<table border='0' cellpadding='5' cellspacing='0' width='100%'>
					<tr>
						<td valign='top'>
							<form
								enctype="multipart/form-data"
								action=""
								method="post"
								id="offer"
								autocomplete="off" />
								<p>* - обязательные поля</p>
								<table border='0' cellpadding='5' cellspacing='0' width='100%'>
									<tr>
										<td>
											<div class="zagolovki_filtrov_offer">Наименование*</div>
											<input
												type="hidden"
												name="id_medical_name"
												<?if (isset($_POST['id_medical_name']))
													echo "value='" . $_POST['id_medical_name'] . "'";
												?>/>
											<input
												type="text"
												name="medical_name"
												style="width:200px"
												placeholder="Введите название препарата"
												class="input_other"
												id="search_target6"
												<?if (isset($_POST['medical_name']))
													echo "value='" . $_POST['medical_name'] . "'";
												?>/>
											<?if (isset($error['city']))
												echo "<p>$error[city]</p>";?>
										</td>
									</tr>
						<!---		<tr><td><div class="zagolovki_filtrov_offer">Годен до <input type="text" name="date_count" placeholder="01.09.2013" class="input_date_do" id="popupDatepicker2" if(isset($_POST['date_count'])) echo "value='".$_POST['date_count']."'"</div></td></tr>	
						-->			<tr>
										<td>
											<div class="zagolovki_filtrov_offer">Лекарственная форма*</div>
											<input
												type="hidden"
												name="id_farm_form"
												<?if (isset($_POST['id_farm_form']))
													echo "value='" . $_POST['id_farm_form'] . "'";
												?>/>
											<input
												type="text"
												name="farm_form"
												style="width:200px"
												placeholder="Введите лекарственную форму"
												class="input_other"
												id="search_target10"
												<?if (isset($_POST['farm_form']))
													echo "value='" . $_POST['farm_form'] . "'";
												?>/>
											<?if (isset($error['farm_form']))
												echo "<p>$error[farm_form]</p>";?>
										</td>
									</tr>
									<tr>
										<td>
											<div class="zagolovki_filtrov_offer">Производитель</div>
											<input
												type="hidden"
												name="id_manufacturer"
												<?if (isset($_POST['id_manufacturer']))
													echo "value='" . $_POST['id_manufacturer'] . "'";
												?>/>
											<input
												type="text"
												name="manufacturer"
												placeholder="Введите производителя"
												style="width:200px"
												class="input_other"
												id="search_target9"
												<?if (isset($_POST['manufacturer']))
													echo "value='" . $_POST['manufacturer'] . "'";
												?>/>
											<?if (isset($error['manufacturer']))
												echo "<p>$error[manufacturer]</p>";?>
										</td>
									</tr>
									<tr>
										<td>
											<div class="zagolovki_filtrov_offer">Город*</div>
											<input
												type="hidden"
												name="id_city"
												<?if (isset($_POST['id_city']))
													echo "value='" . $_POST['id_city'] . "'";
												?>/>
											<input
												type="text"
												name="city"
												placeholder="Введите город"
												style="width:200px"
												class="input_other"
												id="search_target8"
												<?if (isset($_POST['city']))
													echo "value='" . $_POST['city'] . "'";
												?>/>
											<?if (isset($error['city']))
												echo "<p>$error[city]</p>";?>
										</td>
									</tr>
									<tr>
										<td>
											<?if (empty($_SESSION['data'])):?>
											<div class="zagolovki_filtrov_offer">E-mail*</div>
											<input
												name="mail"
												placeholder="e-mail"
												style="width:200px"
												class="input_other"
												<?if (isset($_POST['mail']))
													echo "value='" . $_POST['mail'] . "'";
												?>/>
											<?if (isset($error['mail']))
												echo "<p>$error[mail]</p>";?>
											<?endif;?>
										</td>
									</tr>
									<tr>
										<td>
											<div class="zagolovki_filtrov_offer">Изображение препарата</div>
											<input
												type="file"
												name="med_image"
												id="med_image"
												<?if (isset($_FILES['med_image']['name']))
													echo "value='" . $_FILES['med_image']['name'] . "'";
												?>/>
											<p style="width:150px; height:150px; line-hight: 150px;">
												<img
													id="file_preview"
													src="/img/no_photo.png"
													style="max-width:100%; height:auto;" />
											</p>
										</td>
									</tr>
								</table>
								<input type="submit" name="offer" value="Предложить">
							</form>
						</td>
					</tr>
				</table>
			</div><!---.content-->
		</div><!---.first_block-->
	</div><!---.main_block-->
	<br />
</center>
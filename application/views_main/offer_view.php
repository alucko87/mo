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
				<div class="offer_title">
					<h2>Предложить лекарство</h2>
					<p>* - обязательные поля</p>
				</div>
				<form
					enctype="multipart/form-data"
					action=""
					method="post"
					id="offer"
					autocomplete="off" />

					<div class="column">
						<div class="input_item">

							<div
								id="med_image"
								<?php if (!empty($error['med_image']))
										echo "class='invalidInput'"; ?> >
	 							<label>
		 							<input
										type="file"
										name="med_image" />
									<span>Добавить фото</span>

								</label>
							</div>
							<img id="del" src="/img/del.png" />

							<span class="error">
								<img class="error_icon" src="/img/error.png" />
								<span class="errMsg">
									<?php if (!empty($error['med_image']))
											echo $error['med_image']; ?>
								</span>
							</span>
					


							<div class="file_preview">
								<img id="file_preview" src="/img/no_image.png" />
							</div>
						</div>
					</div>

					<div class="column">
						<div class="input_item">
							<p class="zagolovki_filtrov_offer">Наименование*</p>
							<input
								type="hidden"
								name="id_name"
								<?if (isset($_POST['id_name']))
									echo "value='" . $_POST['id_name'] . "'";
								?>/>
							<input
								type="text"
								name="name"
								placeholder="Введите название препарата"
								id="search_target6"

								<?php if (!empty($error['name']))
									echo "class='invalidInput'";
								if (!empty($_POST['name']))
									echo "value='" . $_POST['name'] . "'"; ?> />

							<span class="error">
								<img class="error_icon" src="/img/error.png" />
								<span class="errMsg">
									<?php if (!empty($error['name']))
											echo $error['name']; ?>
								</span>
							</span>
						</div>

						<div class="input_item">
							<p class="zagolovki_filtrov_offer">Лекарственная форма*</p>
							<input
								type="hidden"
								name="id_farm_form"
								<?if (!empty($_POST['id_form']))
									echo "value='" . $_POST['id_form'] . "'";
								?>/>
							<input
								type="text"
								name="form"
								placeholder="Введите лекарственную форму"
								id="search_target10"

								<?php if (!empty($error['form']))
									echo "class='invalidInput'";
								if (!empty($_POST['form']))
									echo "value='" . $_POST['form'] . "'"; ?> />

							<span class="error">
								<img class="error_icon" src="/img/error.png" />
								<span class="errMsg">
									<?php if (!empty($error['form']))
											echo $error['form']; ?>
								</span>
							</span>
						</div>

						<div class="input_item">
							<p class="zagolovki_filtrov_offer">Производитель</p>
							<input
								type="hidden"
								name="id_manufacturer"
								<?if (!empty($_POST['id_manufacturer']))
									echo "value='" . $_POST['id_manufacturer'] . "'";
								?>/>
							<input
								type="text"
								name="manufacturer"
								placeholder="Введите производителя"
								id="search_target9"

								<?php if (!empty($error['manufacturer']))
									echo "class='invalidInput'";
								if (!empty($_POST['manufacturer']))
									echo "value='" . $_POST['manufacturer'] . "'"; ?> />

							<span class="error">
								<img class="error_icon" src="/img/error.png" />
								<span class="errMsg">
									<?php if (!empty($error['manufacturer']))
											echo $error['manufacturer']; ?>
								</span>
							</span>
						</div>
					</div><!--column-->

					<div class="column">
						<div class="input_item">
							<p class="zagolovki_filtrov_offer">Город*</p>
							<input
								type="hidden"
								name="id_city"
								<?if (!empty($_POST['id_city']))
									echo "value='" . $_POST['id_city'] . "'";
								?>/>
							<input
								type="text"
								name="city"
								placeholder="Введите город"
								id="search_target8"

								<?php if (!empty($error['city']))
									echo "class='invalidInput'";
								if (!empty($_POST['city']))
									echo "value='" . $_POST['city'] . "'"; ?> />

							<span class="error">
								<img class="error_icon" src="/img/error.png" />
								<span class="errMsg">
									<?php if (!empty($error['city']))
											echo $error['city']; ?>
								</span>
							</span>
						</div>

						<?if (empty($_SESSION['data'])):?>
						<div class="input_item">
							<p class="zagolovki_filtrov_offer">E-mail*</p>
							<input
								type="text"
								name="mail"
								placeholder="e-mail"

								<?php if (!empty($error['mail']))
									echo "class='invalidInput'";
								if (!empty($_POST['mail']))
									echo "value='" . $_POST['mail'] . "'"; ?> />

							<span class="error">
								<img class="error_icon" src="/img/error.png" />
								<span class="errMsg">
									<?php if (!empty($error['mail']))
											echo $error['mail']; ?>
								</span>
							</span>
						</div>
						<?endif;?>
					</div><!--column-->

					<div class="clearfix"><hr /></div>

					<div class="submit">
						<input type="submit" name="offer" value="Предложить">
					</div>
				</form>
			</div><!---.content-->
		</div><!---.first_block-->
	</div><!---.main_block-->
	<br />
</center>
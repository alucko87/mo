<center>
	<div class="first_block">
		<div class="content">
			<table border='0' cellpadding='5' cellspacing='0' width='100%'>
				<tr><td valign='middle' width='265px'><h1 class='h1 obmen'>Отдам даром</h1></td>
					<td class='namber_p_q obmen'>
						<? if(isset($model['top_menu'])) echo $model['top_menu']; ?>
					</td>
					<td valign='middle' class='namber_p_q' align='right'>
						<? if(isset($model['login_zone'])) echo $model['login_zone']; ?>
					</td>
				</tr>
			</table>
			<form action='' name='quote_out' method='post' autocomplete='off'>
				<table border='0' cellpadding='5' cellspacing='0' width='100%'>
					<tr>
						<td valign='top' width='265px' align='left'>
							<div class='zagolovki_filtrov_obmen'>Выбор места расположения препарата</div>
							<table border='0' cellpadding='0' cellspacing='0' width='100%' style='font-size:15px;' class='links_town'>
								<tr><td valign='top'>
									<? if(isset($model['left_menu'])) echo $model['left_menu']; ?>
								</td></tr>
							</table>
						</td>
						<td valign='top'>
							<table border='0' cellpadding='5' cellspacing='0' width='100%'>
								<tr><td>
									<? if(isset($model['messadge'])) echo $model['messadge']; ?>
									<div class='zagolovki_filtrov_obmen'>Внесение личных препаратов</div>
									<table border='0' cellpadding='5' cellspacing='0'>
										<tr>
											<td width='300px'>
												<input type='text' name='medical_name' placeholder='режим поиска' class='input_other' id='search_target' style='width:300px;' <? if(isset($_POST['medical_name'])) echo "value='".htmlspecialchars($_POST['medical_name'])."'" ?>>
											</td>
											<td width='100px'>
												<input type='text' style='width:100px;' name='quote_count' placeholder='количество' class='input_date_do' <? if(isset($_POST['quote_count'])) echo "value='".htmlspecialchars($_POST['quote_count'])."'" ?>>
											</td>
											<td>годен до</td>
											<td width='100px'>
												<input id='popupDatepicker' style='width:100px;' type='text' name='date_count' class='input_date_do' <? if(isset($_POST['date_count'])) echo "value='".htmlspecialchars($_POST['date_count'])."'" ?>>
											</td>
										</tr>
										<? if(isset($model['med_table'])) echo $model['med_table']; ?>
									</table><br><br>
									<? if(isset($model['button'])) echo $model['button']; ?>
								</td></tr>
								<tr><td>
									<? if(isset($model['reclama'])) echo $model['reclama']; ?>
								</td></tr>
							</table>
						</td>
					</tr>
				</table>
			</form>
		</div>
	</div>
	<br>
</center>
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
				<table border="0" cellpadding="4" cellspacing="3" width="100%">
					<tr>
						<td valign="middle" colspan="3"><h1 class="h1 med" style="padding-bottom:20px;">Возможности входа к сервисам сайта</h1></td>
					</tr>
					<tr>
						<td width="300px" valign="top" style="background:rgba(0, 0, 0, 0.2);border-radius:10px;">
								<p class="zagolovki_filtrov_reg" style="font-family: wf_SegoeUILight,wf_SegoeUI,Tahoma,Verdana,Arial,sans-serif;font-size: 25px;font-weight:300;line-height:0.9;margin:0px 0px 10px 0px;padding:0px;">Через социальные сети</p>
								<div class="sochial_net" style="background:rgba(58, 128, 41, 0.9);border-radius:10px;height:200px;padding:10px 0px;">
									<div class="s_web" style="margin:1px 1px 5px 1px;color:#fff;"><?php if(isset($template['link']['fb'])) echo $template['link']['fb'];?><img src="/images/swf/facebook.png"><br>Facebook<?php if(isset($template['link']['fb'])) echo "</a>";?></div>
									<div class="s_web" style="margin:1px 1px 5px 1px;color:#fff;"><?php if(isset($template['link']['li'])) echo $template['link']['li'];?><img src="/images/swf/linkedin.png"><br>Linkedin<?php if(isset($template['link']['li'])) echo "</a>";?></div>
									<div class="s_web" style="margin:1px 1px 5px 1px;color:#fff;"><?php if(isset($template['link']['od'])) echo $template['link']['od'];?><img src="/images/swf/odnoklassniki.png"><br>Odnoklassniki<?php if(isset($template['link']['od'])) echo "</a>";?></div>
									<div class="s_web" style="margin:1px 1px 5px 1px;color:#fff;"><?php if(isset($template['link']['tw'])) echo $template['link']['tw'];?><img src="/images/swf/twitter.png"><br>Twitter<?php if(isset($template['link']['tw'])) echo "</a>";?></div>
									<div class="s_web" style="margin:1px 1px 5px 1px;color:#fff;"><?php if(isset($template['link']['vk'])) echo $template['link']['vk'];?><img src="/images/swf/vkontakte.png"><br>Vkontakte<?php if(isset($template['link']['vk'])) echo "</a>";?></div>
									<div class="s_web" style="margin:1px 1px 5px 1px;color:#fff;"><?php if(isset($template['link']['go'])) echo $template['link']['go'];?><img src="/images/swf/g_plas.png"><br>Google+<?php if(isset($template['link']['go'])) echo "</a>";?></div>
								</div>
						</td>
						<td style="font-family: wf_SegoeUILight,wf_SegoeUI,Tahoma,Verdana,Arial,sans-serif;font-size: 25px;font-weight:300;">
							или
						</td>
						<td valign="top" align="center" style="background:rgba(0, 0, 0, 0.2);border-radius:10px;">
							<p class="zagolovki_filtrov_reg" style="font-family: wf_SegoeUILight,wf_SegoeUI,Tahoma,Verdana,Arial,sans-serif;font-size: 25px;font-weight:300;line-height:0.9;margin:0px 0px 10px 0px;padding:0px;">Через регистрационные данные на сайте</p>
							<div style="background:rgba(239, 138, 41, 0.9);border-radius:10px;padding:10px 0px;">
							
							<?php if(isset($model['messadge'])) echo $model['messadge'];?>
							<form name="inputLogin" action="" method="post">
								<p><input type="text" id="text" class="input_other" name="login" placeholder="Логин" style="padding:10px;font-size: 17px;"> <input type="password" id="text" class="input_other" name="pass" placeholder="Пароль" style="padding:10px;font-size: 17px;"> <input type="submit" name="input_user" value="Вход" style="font-family: wf_SegoeUILight,wf_SegoeUI,Tahoma,Verdana,Arial,sans-serif;font-size: 17px;font-weight:300;line-height:0.9;margin:0px;border-radius:8px;padding:9px 10px 12px 10px;border:0px;cursor:pointer;cursor:hand;"> <input type="reset" value="Очистить" style="font-family: wf_SegoeUILight,wf_SegoeUI,Tahoma,Verdana,Arial,sans-serif;font-size: 17px;font-weight:300;line-height:0.9;margin:0px;border-radius:8px;padding:9px 10px 12px 10px;border:0px;cursor:pointer;cursor:hand;"></p>
							</form>
							<br>
							<p class="zagolovki_filtrov_reg" style="font-family: wf_SegoeUILight,wf_SegoeUI,Tahoma,Verdana,Arial,sans-serif;font-size: 23px;font-weight:300;line-height:0.9;margin:0px;padding:0px;">&nbsp;Регистрация пользователя</p>
							<?php if(isset($model['messadge1'])) echo $model['messadge1'];?>
								<form name="registerUser" action="" method="post">
									<p><input name="login" class="input_other" placeholder="Логин" id="login_form2" style="width:180px;"> <input name="pass" type="password" class="input_other" placeholder="Пароль" id="pass_form2" style="width:180px;"> <input name="mail" class="input_other" placeholder="e-mail" id="mail_form2" style="width:180px;"></p>
									<p><input name="name" class="input_other" placeholder="Имя" style="width:180px;"> <input name="second_name" class="input_other" placeholder="Фамилия" style="width:180px;"> <input name="tel" class="input_other" placeholder="Телефон" style="width:180px;"></p>
									<p><input name="submit_registred" type="submit" value="Регистрация" onclick="if(!pole_err()) return false;" style="font-family: wf_SegoeUILight,wf_SegoeUI,Tahoma,Verdana,Arial,sans-serif;font-size: 17px;font-weight:300;line-height:0.9;margin:0px;border-radius:8px;padding:9px 10px 12px 10px;border:0px;cursor:pointer;cursor:hand;"> <input type="reset" value="Очистить" style="font-family: wf_SegoeUILight,wf_SegoeUI,Tahoma,Verdana,Arial,sans-serif;font-size: 17px;font-weight:300;line-height:0.9;margin:0px;border-radius:8px;padding:9px 10px 12px 10px;border:0px;cursor:pointer;cursor:hand;"></p>
								</form>
								<p style="text-align:right;margin:0px;"><a href="/repass.html" style="font-family: wf_SegoeUILight,wf_SegoeUI,Tahoma,Verdana,Arial,sans-serif;font-size: 20px;font-weight:300;line-height:0.9;margin:0px;padding:0px;color:#000;" target="_blank">Забыли пароль?</a></p>
								
    
								<script type="text/javascript">
									function pole_err()
										{ 
											if(document.getElementById("login_form2").value==\'\') {alert(\'Вы не указали желаемый логин!\'); return false;}
												else
													if(document.getElementById("pass_form2").value==\'\') {alert(\'Вы не указали желаемый пароль!\'); return false;}
														else
															if(document.getElementById("mail_form2").value==\'\') {alert(\'Вы не указали е-mail!\'); return false;}
																else return true;
										}
								</script>
								
							</div>
						</td>
					</tr>
				</table>
				<div style="font-family: wf_SegoeUILight,wf_SegoeUI,Tahoma,Verdana,Arial,sans-serif;font-size: 22px;font-weight:300;padding:10px;">Регистрируясь на сайте Вы соглашаетесь с <a style="border-bottom: 1px dotted #000;color:#000;" href="#">условиями пользования сайтом</a> их его сервисами на условиях разработчика сайта и обязуетесь их выполнять.</div>
			</div>
		</div>
	</div>
	<br>
</center>
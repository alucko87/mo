<center>
	<div class="first_block">
		<div class="content">
			<?php if(isset($model['messadge'])) echo $model['messadge'];?>
			<table width="100%" cellspacing="0" cellpadding="5" border="0"><tr>
				<?php if(isset($model['head'])) echo $model['head'];?>
			</tr></table>
			<table width="100%" cellspacing="0" cellpadding="5" border="0">
				<tr><td width="25%" valign="top" rowspan="3"><?php if(isset($model['menu'])) echo $model['menu'];?></td>
				<td valign="top" colspan="2"><h1 class="h1 med">Личный кабинет</h1></td></tr>
				<tr><td valign="top">
					<table name="User">
						<tr><td>Имя</td><td data="Name"><input name="name" class="pasted" <?php if(isset($_POST['name'])) echo "value='".$_POST['name']."'";?>></td></tr>
						<tr><td>Фамилия</td><td data="Second_name"><input name="Second_name" class="pasted" <?php if(isset($_POST['Second_name'])) echo "value='".$_POST['Second_name']."'";?>></td></tr>
						<tr><td>Логин</td><td data="Login"><input name="Login" class="pasted" <?php if(isset($_POST['Login'])) echo "value='".$_POST['Login']."'";?>></td></tr>
						<tr><td>e-mail</td><td data="e_mail"><input name="e_mail" class="pasted" <?php if(isset($_POST['e_mail'])) echo "value='".$_POST['e_mail']."'";?>></td></tr>
						<tr><td>Телефон</td><td data="tel"><input name="tel" class="pasted" <?php if(isset($_POST['tel'])) echo "value='".$_POST['tel']."'";?>></td></tr>
						<tr><td>Городской телефон</td><td data="tel_gor"><input name="tel_gor" class="pasted" <?php if(isset($_POST['tel_gor'])) echo "value='".$_POST['tel_gor']."'";?>></td></tr>
					</table>
				</td>
				<td valign="top">
					<form action="" id="replace_pass_form" method="post">
						<table>
                            <tr><td colspan="2" id="pass_errors"><?php if(isset($model['messadge_pass'])) echo $model['messadge_pass'];?></td></tr>
							<tr><td>Старый пароль</td><td><input type="password" id="pass" name="old_pass" <?php if(isset($_POST['pass'])) echo "value='".$_POST['pass']."'";?>></td></tr>
							<tr><td>Новый пароль</td><td><input type="password" id="pass1" name="new_pass" class="new_pass" <?php if(isset($_POST['pass1'])) echo "value='".$_POST['pass1']."'";?>></td></tr>
							<tr><td>Повтор нового пароля</td><td><input type="password" id="new_repass" name="new_repass" <?php if(isset($_POST['new_pass'])) echo "value='".$_POST['new_pass']."'";?>></td></tr>
						    <tr><td><input type="submit" id="replase_pass" name='replase_pass' value='Изменить пароль'></td><td><input id="pass_gen" name="pass_gen" type="button" value="Сгенерировать пароль" /></td></tr>
                        </table>
                     </form>
				</td></tr>
				<tr><td colspan="2">
					<p class="zagolovki_filtrov_reg" style="font-family: wf_SegoeUILight,wf_SegoeUI,Tahoma,Verdana,Arial,sans-serif;font-size: 25px;font-weight:300;line-height:0.9;margin:0px 0px 10px 0px;padding:0px;">Привязка аккаунта к страницам социальных сетей</p>
					<div class="sochial_net" style="background:none;border-radius:10px;padding:10px 0px;">
						<div class="s_web_a" style="margin:1px 1px 5px 1px;color:#333;"><?php if(isset($template['link']['fb'])) echo $template['link']['fb'];?><img style="width:32px; height:32px;" src="<?php if(isset($template['photo']['fb'])) echo $template['photo']['fb'];?>"><br>Facebook<?php if(isset($template['link']['fb'])) echo "</a>";?></div>
						<div class="s_web_a" style="margin:1px 1px 5px 1px;color:#333;"><?php if(isset($template['link']['li'])) echo $template['link']['li'];?><img style="width:32px; height:32px;" src="<?php if(isset($template['photo']['li'])) echo $template['photo']['li'];?>"><br>Linkedin<?php if(isset($template['link']['li'])) echo "</a>";?></div>
						<div class="s_web_a" style="margin:1px 1px 5px 1px;color:#333;"><?php if(isset($template['link']['od'])) echo $template['link']['od'];?><img style="width:32px; height:32px;" src="<?php if(isset($template['photo']['od'])) echo $template['photo']['od'];?>"><br>Odnoklassniki<?php if(isset($template['link']['od'])) echo "</a>";?></div>
						<div class="s_web_a" style="margin:1px 1px 5px 1px;color:#333;"><?php if(isset($template['link']['tw'])) echo $template['link']['tw'];?><img style="width:32px; height:32px;" src="<?php if(isset($template['photo']['tw'])) echo $template['photo']['tw'];?>"><br>Twitter<?php if(isset($template['link']['tw'])) echo "</a>";?></div>
						<div class="s_web_a" style="margin:1px 1px 5px 1px;color:#333;"><?php if(isset($template['link']['vk'])) echo $template['link']['vk'];?><img style="width:32px; height:32px;" src="<?php if(isset($template['photo']['vk'])) echo $template['photo']['vk'];?>"><br>Vkontakte<?php if(isset($template['link']['vk'])) echo "</a>";?></div>
						<div class="s_web_a" style="margin:1px 1px 5px 1px;color:#333;"><?php if(isset($template['link']['go'])) echo $template['link']['go'];?><img style="width:32px; height:32px;" src="<?php if(isset($template['photo']['go'])) echo $template['photo']['go'];?>"><br>Google+<?php if(isset($template['link']['go'])) echo "</a>";?></div>
					</div>
				</td></tr>
				</table>
		</div>
	<br>
	</div>
	<br>
</center>

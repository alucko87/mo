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
				<tr><td align='center' valign='top' style="font-size:16px;color:#ccc;"><?php if(isset($model['alfabet'])) echo $model['alfabet'];?></td></tr>
				<tr><td align='center' valign='top'>
					<table class="alfabet" border='0' cellpadding='5' cellspacing='0' width='100%'>
						<?php if(isset($model['data'])) echo $model['data'];?>
					</table></td></tr>
			</table>
			</div>
		</div>
	</div>
	<br>
</center>
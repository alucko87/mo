//подтверждение удаления
function confirm_action(action){
	if (confirm("Данное действие необратимо!! Подтверждаете?")) {
	    return true;
	}
	else {
	    return false;
	}
}
//конвертер
function uchar(s) {
   switch (s[0]) {case "А": return "\u0410"; case "Б": return "\u0411"; case "В": return "\u0412"; case "Г": return "\u0413"; case "Д": return "\u0414"; case "Е": return "\u0415"; case "Ж": return "\u0416"; case "З": return "\u0417"; case "И": return "\u0418"; case "Й": return "\u0419"; case "К": return "\u041a"; case "Л": return "\u041b"; case "М": return "\u041c"; case "Н": return "\u041d"; case "О": return "\u041e"; case "П": return "\u041f"; case "Р": return "\u0420"; case "С": return "\u0421"; case "Т": return "\u0422"; case "У": return "\u0423"; case "Ф": return "\u0424"; case "Х": return "\u0425"; case "Ц": return "\u0426"; case "Ч": return "\u0427"; case "Ш": return "\u0428"; case "Щ": return "\u0429"; case "Ъ": return "\u042a"; case "Ы": return "\u042b"; case "Ь": return "\u042c"; case "Э": return "\u042d"; case "Ю": return "\u042e"; case "Я": return "\u042f"; case "а": return "\u0430"; case "б": return "\u0431"; case "в": return "\u0432"; case "г": return "\u0433"; case "д": return "\u0434"; case "е": return "\u0435"; case "ж": return "\u0436"; case "з": return "\u0437"; case "и": return "\u0438"; case "й": return "\u0439"; case "к": return "\u043a"; case "л": return "\u043b"; case "м": return "\u043c"; case "н": return "\u043d"; case "о": return "\u043e"; case "п": return "\u043f"; case "р": return "\u0440"; case "с": return "\u0441"; case "т": return "\u0442"; case "у": return "\u0443"; case "ф": return "\u0444"; case "х": return "\u0445"; case "ц": return "\u0446"; case "ч": return "\u0447"; case "ш": return "\u0448"; case "щ": return "\u0449"; case "ъ": return "\u044a"; case "ы": return "\u044b"; case "ь": return "\u044c"; case "э": return "\u044d"; case "ю": return "\u044e"; case "я": return "\u044f"; case "Ё": return "\u0401"; case "ё": return "\u0451"; default: return s[0];}}
function ustring(s) {
    s = String(s);
	alert(s);
    var result = "";
    for (var i = 0; i < s.length; i++)
        result += uchar(s);
    return result;
}
//счетчик элементов массива
function count(obj) {
	var count = 0;
	for(var prs in obj)
	{
		if(obj.hasOwnProperty(prs)) count++;
	}
	return count;
}
//сканирование страницы
function scan_data(data){
	var data_search=$("input[name='view-d']:checked").val();
	var datatime=$("select[name='select_day']").val();
	var name=$("input[name='medical_name']").val();
	var country=$("input[name='country']").val();
	var city=$("input[name='city']").val();
	var farm_form=$("input[name='farm_form']").val();
	var manufacturer=$("input[name='manufacturer']").val();
	var datas="p_target=" + data + "&p_data_search=" + data_search + "&p_datatime=" + datatime;
	if(name!==""){
		datas=datas + "&p_name=" + name;
	}
	if(data=='city' ||  data=='farm_group' || data=='farm_form' || data=='manufacturer'){
		var i=0;
		var arr_country=[];
		$('.remove_country').find('.CheckBoxSingleClassSelected').children().each(function(){arr_country[i]=$(this).val(); i++;});
		if(i>0){
			for(a=0;a<i;a++){
				datas=datas + "&p_data_country_arr" + a + "=" + arr_country[a];
			}
		}
		else{
			var data_country=$("input[name='country']").val();
			if(data_country!==""){
				datas=datas + "&p_data_country=" + data_country;
			}
		}
	}
	if(data=='farm_group' || data=='farm_form' || data=='manufacturer'){
		var i=0;
		var arr_city=[];
		$('.remove_city').find('.CheckBoxSingleClassSelected').children().each(function(){arr_city[i]=$(this).val(); i++;});
		if(i>0){
			for(a=0;a<i;a++){
				datas=datas + "&p_data_city_arr" + a + "=" + arr_city[a];
			}
		}
		else{
			var data_city=$("input[name='city']").val();
			if(data_city!==""){
				datas=datas + "&p_data_city=" + data_city;
			}
		}
	}
	if(data=='country' ||  data=='city' || data=='farm_form' || data=='manufacturer'){
		var i=0;
		var arr_farm_group=[];
		$('.remove_farm_group').find('.CheckBoxSingleClassSelected').children().each(function(){arr_farm_group[i]=$(this).val(); i++;});
		if(i>0){
			for(a=0;a<i;a++){
				datas=datas + "&p_data_farm_group_arr" + a + "=" + arr_farm_group[a];
			}
		}
		else{
			var data_farm_group=$("input[name='farm_group']").val();
			if(data_farm_group!==""){
				datas=datas + "&p_data_farm_group=" + data_farm_group;
			}
		}
	}
	if(data=='country' ||  data=='city' || data=='farm_group' || data=='manufacturer'){
		var i=0;
		var arr_farm_form=[];
		$('.remove_farm_form').find('.CheckBoxSingleClassSelected').children().each(function(){arr_farm_form[i]=$(this).val(); i++;});
		if(i>0){
			for(a=0;a<i;a++){
				datas=datas + "&p_data_farm_form_arr" + a + "=" + arr_farm_form[a];
			}
		}
		else{
			var data_farm_form=$("input[name='farm_form']").val();
			if(data_farm_form!==""){
				datas=datas + "&p_data_farm_form=" + data_farm_form;
			}
		}
	}
	if(data=='country' ||  data=='city' || data=='farm_form' || data=='farm_group'){
		var i=0;
		var arr_manufacturer=[];
		$('.remove_manufacturer').find('.CheckBoxSingleClassSelected').children().each(function(){arr_manufacturer[i]=$(this).val(); i++;});
		if(i>0){
			for(a=0;a<i;a++){
				datas=datas + "&p_data_manufacturer_arr" + a + "=" + arr_manufacturer[a];
			}
		}
		else{
			var data_manufacturer=$("input[name='manufacturer']").val();
			if(data_manufacturer!==""){
				datas=datas + "&p_data_manufacturer=" + data_manufacturer;
			}
		}
	}
	return datas;
}
//функция поиска
function search(search_value,targets_object){
	$(".search_pad").remove();
	$.ajax({
		url: "/application/ajax/search.php",
		type: "POST",
		dataType: "json",
		data:({param1: search_value, param2: targets_object}),
		success: function(data){
			var s = "<div class='search_pad'><ul class='search_list' style='text-align:left;'>";
            $.each(data, function(key, val) {
				s=s+"<li>"+val+"</li>";
            });
			s=s+"</ul></div>";
			$(targets_object).after(s);
			$(document).one('click', function(e) {
				targets=e.target;
				object=e.target.nodeName;
				if(object=='LI'){
					if(targets_object=='#search_target'){
						$(targets_object).val($(targets).text());
						$(".search_pad").remove();
						form_name=$(targets_object).closest('form').attr('name');
						document.forms[form_name].submit();
					}
					else if(targets_object=='#search_target1'){
						var id_name=$(targets).text();
						$.ajax({
							'url': "/application/ajax/session_name.php",
							'type': "POST",
							'data': {param1: id_name},
							'success':function(data){
								location.href="/search.html";
							}
						});
					}
					else{
						$(targets_object).val($(targets).text());
						$(".search_pad").remove();
					}
				}
				else{
					$(".search_pad").remove();
				}
			});
		}
	});
}
$(document).ready(function(e) {
//работа чекбоксов
//работа не кликнутого одиночного чекбокса
	$('body').on('click','.CheckBoxSingleClass',function(){
	var target = $(this);
	var object = $(target).attr('class');
	if(object=='CheckBoxSingleClass'){
		$(target).attr('class','CheckBoxSingleClassSelected');
		$(target).closest('td').find('.single').prop('checked', true);
	}
	else{
		$(target).attr('class','CheckBoxSingleClass');
		$(target).closest('td').find('.single').prop('checked', false);
	}
	});
//работа кликнутого одиночного чекбокса
	$('body').on('click','.CheckBoxSingleClassSelected',function(){
	var target = $(this);
	var object = $(target).attr('class');
	if(object=='CheckBoxSingleClass'){
		$(target).attr('class','CheckBoxSingleClassSelected');
		$(target).closest('td').find('.single').prop('checked', true);
	}
	else{
		$(target).attr('class','CheckBoxSingleClass');
		$(target).closest('td').find('.single').prop('checked', false);
	}
	});
//работа не кликнутого одиночного чекбокса для планшета
	$('body').on('touchstart','.CheckBoxSingleClass',function(){
	var target = $(this);
	var object = $(target).attr('class');
	if(object=='CheckBoxSingleClass'){
		$(target).attr('class','CheckBoxSingleClassSelected');
		$(target).closest('td').find('.single').prop('checked', true);
	}
	else{
		$(target).attr('class','CheckBoxSingleClass');
		$(target).closest('td').find('.single').prop('checked', false);
	}
	});
//работа кликнутого одиночного чекбокса для планшета
	$('body').on('touchstart','.CheckBoxSingleClassSelected',function(){
	var target = $(this);
	var object = $(target).attr('class');
	if(object=='CheckBoxSingleClass'){
		$(target).attr('class','CheckBoxSingleClassSelected');
	}
	else{
		$(target).attr('class','CheckBoxSingleClass');
	}
	});
//работа не кликнутого общего чекбокса
	$('body').on('click','.CheckBoxTotalClass',function(){
	var target = $(this);
	var object = $(target).attr('class');
	if(object=='CheckBoxTotalClass'){
		$(target).attr('class','CheckBoxTotalClassSelected');
		$('.CheckBoxSingleClass').each(function(){$(this).attr('class','CheckBoxSingleClassSelected')});
		$(target).closest('table').find('.single').prop('checked', true);
	}
	else{
		$(target).attr('class','CheckBoxTotalClass');
		$('.CheckBoxSingleClassSelected').each(function(){$(this).attr('class','CheckBoxSingleClass')});
		$(target).closest('table').find('.single').prop('checked', false);
	}
	});
//работа кликнутого общего чекбокса
	$('body').on('click','.CheckBoxTotalClassSelected',function(){
	var target = $(this);
	var object = $(target).attr('class');
	if(object=='CheckBoxTotalClass'){
		$(target).attr('class','CheckBoxTotalClassSelected');
		$('.CheckBoxSingleClass').each(function(){$(this).attr('class','CheckBoxSingleClassSelected')});
		$(target).closest('table').find('.single').prop('checked', true);
	}
	else{
		$(target).attr('class','CheckBoxTotalClass');
		$('.CheckBoxSingleClassSelected').each(function(){$(this).attr('class','CheckBoxSingleClass')});
		$(target).closest('table').find('.single').prop('checked', false);
	}
	});
//Работа радиобоксов
$('body').on('click','.RadioBoxClass',function(){
	var target = $(this);
	$(target).closest('table').find('.RadioBoxClassSelected').attr('class','RadioBoxClass');
	$(target).closest('table').find('.radio_button').prop('checked', false);
	$(target).attr('class','RadioBoxClassSelected');
	$(target).closest('td').find('.radio_button').prop('checked', true);
});
//Работа радиобоксов
$('body').on('click','.RadioBoxClassSelected',function(){
	var target = $(this);
	$(target).closest('table').find('.RadioBoxClassSelected').attr('class','RadioBoxClass');
	$(target).closest('table').find('.radio_button').prop('checked', false);
	$(target).attr('class','RadioBoxClassSelected');
	$(target).closest('td').find('.radio_button').prop('checked', true);
});
//Включение/отключение радиобоксов
$('.DisRadio').bind('click',function(){
	var target=$(this);
	if($(target).closest('td').find('.single').prop('checked')){
		$(target).closest('table').find('.RadioBoxClassDisabled').attr('class','RadioBoxClass');
	}
	else{
		$(target).closest('table').find('.RadioBoxClass').attr('class','RadioBoxClassDisabled');
		$(target).closest('table').find('.RadioBoxClassSelected').attr('class','RadioBoxClassDisabled');
	}
});

//сортировка столбцов
$('th').bind('click',function(){
	var target = $(this);
	var curClassName = $(target).attr('class');
	var ColumnName = $(target).text();
	$('.up').attr('class','unsort');
	$('.down').attr('class','unsort');
	var itempathname = location.pathname;
	var itempathsearch = location.search;
	if(curClassName=='unsort' || curClassName=='up' || curClassName=='down'){
		if (curClassName=='unsort'){
			var sort = 1;
		}
		else if (curClassName=='up'){
			var sort = 2;
		}
		else if (curClassName=='down'){
			var sort = 0;
		}
		if(sort>0){
			if(itempathsearch!==''){
				var pos = itempathsearch.indexOf('sort=');
				if(pos==-1){
					itempathname = itempathname + itempathsearch + '&sort=' + sort + '&column_name=' + ColumnName;
				}
				else if (pos==0){
					var last = itempathname.length - 1;
					var strlast = itempathname.charAt(last);
					if(strlast=='/'){
						itempathname=itempathname.slice(0, last);
					}
					itempathname=itempathname + '/?sort='+ sort + '&column_name=' + ColumnName;
				}
				else{
					var temp = itempathsearch.substring(0,pos);
					itempathname=itempathname + temp + 'sort='+ sort + '&column_name=' + ColumnName;
				}
			}
			else{
				var last = itempathname.length - 1;
				var strlast = itempathname.charAt(last);
				if(strlast=='/'){
					itempathname=itempathname.slice(0, last);
				}
				itempathname=itempathname + '/?sort='+ sort + '&column_name=' + ColumnName;
			}
		}
		location.href=itempathname;
	}
	});
//точечное редактирование
	$('.pasted').bind('click', function(){
		function delimage(){$("img[src*=load]").remove();}
		var target = $(this);
		var table_name = $(target).closest('table').attr('name');
		var object = $(target).get(0).tagName;
		var object_name = $(target).parent().attr('data');
		var clicked = $(target).val();
			if(object=='INPUT'){
				$(target).bind('focusout',function(){
					var clicked1 = $(target).val();
					if(clicked!==clicked1){
						if(table_name=='tables_level'){
							var name_aproach = $(target).closest('tr').find('td:eq(1)').attr('data');
							var aproach = $(target).closest('tr').find('td:eq(1)').text();
						}
						else{
							var name_aproach = 'id_'+table_name;
							var aproach = $(target).closest('tr').find('div').children().val();
						}
						if(table_name=='User'){
							var datas = {param1: table_name,param2: object_name,param3: clicked1};
						}
						else{
							if(object_name==name_aproach){
								aproach = clicked;
							}
							var datas = {param1: table_name,param2: object_name,param3: clicked1,param4: name_aproach,param5: aproach};
						}
					$.ajax({
						url: "/application/ajax/pasted.php",
						type: "POST",
						data: datas
						});
					//Если индикатора закрузки не существует, то создаём его и через 1 секунду удаляем
					if(!$(target).parent().children('img[src*=load]').length)
					{
						$(target).closest('td').append('<img class="load" src="/images/load.gif">')
						setTimeout(delimage, 1000);
						}
					}
				});
			}
			if(object=='SELECT'){
				$(target).bind('change', function(){
					var clicked1 = $(target).val();
					if(clicked!==clicked1){
						if(table_name=='tables_level'){
							var name_aproach = $(target).closest('tr').find('td:eq(1)').attr('data');
							var aproach = $(target).closest('tr').find('td:eq(1)').text();
						}
						else{
							var name_aproach = 'id_'+table_name;
							var aproach = $(target).closest('tr').find('div').children().val();
						}
					$.ajax({
						url: "/application/ajax/pasted.php",
						type: "POST",
						data:({param1: table_name,param2: object_name,param3: clicked1,param4: name_aproach,param5: aproach,param6: 'SELECT'})
						});
					$(target).closest('td').append('<img src="/images/load.gif">');
					setTimeout(delimage,1000);
					}
				});
			}
	});
//точечное редактирование
	$('.selected').bind('click', function(){
		function delimage(){$("img[src*=load]").remove();}
		var target = $(this);
		var clicked = $(target).val();
		$(target).bind('change', function(){
			var clicked1 = $(target).val();
			if(clicked!==clicked1){
				var aproach = $(target).closest('tr').find('td:eq(1)').text();
				var table_name = $(target).closest('tr').find('td:eq(2)').text();
				$.ajax({
					url: "/application/ajax/quotes_status.php",
						type: "POST",
						data:({param1: table_name,param2: clicked1,param3: aproach})
						});
			$(target).closest('td').append('<img src="/images/load.gif">');
			setTimeout(delimage,1000);
		}
		});
	});
//автозаполнение
	$('#search_target').bind('keyup', function (){
		var targets=$(this);
		search_value=$(targets).val();
		targets_object="#search_target";
		return search(search_value,targets_object);
	});
//автозаполнение верхнее
	$('#search_target1').bind('keyup', function (){
		var targets=$(this);
		search_value=$(targets).val();
		targets_object="#search_target1";
		return search(search_value,targets_object);
	});
//автозаполнение верхнее
	$('#search_target2').bind('keyup', function (){
		var targets=$(this);
		search_value=$(targets).val();
		targets_object="#search_target2";
		return search(search_value,targets_object);
	});
//автозаполнение верхнее
	$('#search_target3').bind('keyup', function (){
		var targets=$(this);
		search_value=$(targets).val();
		targets_object="#search_target3";
		return search(search_value,targets_object);
	});
//автозаполнение верхнее
	$('#search_target4').bind('keyup', function (){
		var targets=$(this);
		search_value=$(targets).val();
		targets_object="#search_target4";
		return search(search_value,targets_object);
	});
//автозаполнение верхнее
	$('#search_target5').bind('keyup', function (){
		var targets=$(this);
		search_value=$(targets).val();
		targets_object="#search_target5";
		return search(search_value,targets_object);
	});
//переключение отображения количества строк
	$('.count_string').bind('change', function(){
		var clicked = $(this).val();
		var itempathname = location.pathname.toString();
		var last = itempathname.length - 1;
		var strlast = itempathname.charAt(last);
		if(strlast=='/'){
			itempathname=itempathname.slice(0, last);
		}
		$.cookie("string_number",clicked,{expires: 7, path: '/', domain: 'medobmen.com.ua'});
		location=itempathname;
	});
//обновление селектов при создании связей между таблицами
	$('.reload').bind('change',function(){
		form_name=$(this).closest('form').attr('name');
		document.forms[form_name].submit();
		$('*').css('cursor','wait');
		setTimeout(delimage,100);
		$('*').css('cursor','default');
	});
//обновление селектов при создании связей между таблицами
	$('.reload_radio').bind('click',function(){
		var target = $(this);
		$(target).children('.radio_button').prop('checked', true);
		form_name=$(this).closest('form').attr('name');
		document.forms[form_name].submit();
		$('*').css('cursor','wait');
		setTimeout(delimage,1000);
		$('*').css('cursor','default');
	});
//Подтверждение удаления
	$('.u_delete').bind('click',function(){
		return confirm_action();
	});
//работа поиска
	$('.arrow').bind('click',function(){
		var targets =$(this);
		var classes = $(targets).attr('class');
		if(classes=='arrow'){
			$('*').css('cursor','wait');
			$(targets).attr('class','arrow_sel');
			var datas=scan_data($(targets).children().attr('id'));
			var input_name="input[name='" + $(targets).children().attr('id') + "']";
			$(input_name).val('');
			$.ajax({
				'url': "/application/ajax/build_change_list.php",
				'type': "POST",
				'data': datas,
				'success':function(data){
					$(targets).closest('tr').after(data);
					$('*').css('cursor','default');
				}
			});
		}
		else{
			child_classes=$(targets).children().attr('id');
			var remove_name=".remove_" + child_classes;
			$(remove_name).remove();
			$(targets).attr('class','arrow');
		}

	});
	$('body').on('click','.add',function(){
		var target=$(this);
		var target_class=$(target).attr('data');
		var target_value=$(target).text();
		target_value=target_value.substring(0,target_value.length-1);
		var input_name="input[name='" + target_class + "']";
		var id_arrow="#" + target_class;
		var remove_name=".remove_" + target_class;
		$(input_name).val(target_value);
		$(id_arrow).parent().attr('class','arrow');
		$(remove_name).remove();
	});
//отображение полного и не полного описания медикамента
	$('body').on('click','.remove_descriprion',function(){
		var target=$(this);
		var div_id=$(target).closest('div').attr('id');
		var m_name=$('h1').text();
		if(div_id=='close_description'){
			var temp=2;
		}
		if(div_id=='description'){
			var temp=1;
		}
		$.ajax({
			'url': "/application/ajax/change_description.php",
			'type': "POST",
			'data': {param1: temp,param2: m_name},
			'success':function(data){
				if(temp==2){
					$('#close_description').remove();
				}
				if(temp==1){
					$('#description').remove();
				}
				$('#smart_description').after(data);
			}
		});

	});
//отображение информации по алфавиту
	$('body').on('click','.select_alfabet',function(){
		var target=$(this);
		$.ajax({
			'url': "/application/ajax/alfabet_count.php",
			'type': "POST",
			'success':function(data){
				$('.select_alfabet').after(data);
			}
		});
	});
//отображение информации по препаратам
	$('body').on('click','.remove_alfabet strong',function(){
		var target=$(this);
		var text_target=$(target).text().substr(0,1);
		$.ajax({
			'url': "/application/ajax/session_name.php",
			'type': "POST",
			'data': {param1: text_target},
			'success':function(data){
				location.href="/search.html";
			}
		});
	});
//закрытие алфавитного предложения
	$('body').on('click','.close_alfabet',function(){
		$('.remove_alfabet').remove();
	});
//переход на поиск по заявке или предложению
	$('body').on('click','.drive',function(){
		var id_name=$(this).attr('id');
		$.ajax({
			'url': "/application/ajax/session_name.php",
			'type': "POST",
			'data': {param2: id_name},
			'success':function(data){
				location.href="/search.html";
			}
		});
	});
//прикрепление файлов к медикоментам, вызов окна
	$('.button').on('click',function(){
		$.ajax({
			'url': "/application/ajax/scan.php",
			'type': "POST",
			'success':function(data){
				$('.button').after(data);
			}
		});
	});
//закрытие меню прикрепления файлов
	$('body').on('click','.close-viewer-btn',function(){
		$('.image-viewer-lightbox').remove();
	});
//переход в папку
	$('body').on('click','.folder',function(){
		var name_folder=$(this).attr('id');
		$.ajax({
			'url': "/application/ajax/scan.php",
			'type': "POST",
			'data': {'dir':name_folder},
			'success':function(data){
				$('.image-viewer-lightbox').remove();
				$('.button').after(data);
			}
		});
	});
//закрытие меню прикрепления файлов
	$('body').on('click','.back_to_root',function(){
		$('.image-viewer-lightbox').remove();
		$.ajax({
			'url': "/application/ajax/scan.php",
			'type': "POST",
			'success':function(data){
				$('.button').after(data);
			}
		});
	});
//вставление в инпут выбранного файла
	$('body').on('click','.file',function(){
		var fileTypes = ['png','PNG','jpg','jpeg','JPG','JPEG','gif','GIF'];
		var fileName=$(this).text();
		var folder=$(this).attr('data');
		if(fileTypes.indexOf(fileName.match(/\.(.*)/)[1])+1) {
			$('td[data="photo"] input').val('/'+folder+'/'+fileName);
			$('.image-viewer-lightbox').remove();
		}
		else {
			alert('Выбран некоректный файл');
		}
	});
});

//hover на линках с изоображениями
	$('.img_hover')
		.mouseover(function(event)
		{
			var target = $(this);
			var img = $('<img class="img_hover_card" src=' + target.attr('href') + ' />');
			img.css({
				left: target.position().left,
				top: target.position().top + target.height() + 5
			});
			$('body').prepend(img);
			img.animate({opacity: 1}, 350);
		})
		.mouseout(function(event)
		{
			var target = $(this);
			var img = $('img[src="' + target.attr('href') + '"]');
			img.animate({opacity: 0}, 350);
			setTimeout(function(){img.remove()}, 350);
		});

	/*$(document).mousemove(function(event){
		$('.img_hover_card').each(function(){
			if(!(event.pageX > $(this).position().left && event.pageX < $(this).position().left + $(this).width() &&
				 event.pageY > $(this).position().top && event.pageY < $(this).position().top + $(this).height()))
		 	{
				var target = $(this);
				target.animate({opacity: 0}, 350);
				setTimeout(function(){target.remove()}, 350);
			}
		});
	});*/

<?php
class View
{
 	//public $template_view общий вид по умолчанию.
	
	/*
	$content_file - виды отображающие контент страниц;
	$template_file - общий для всех страниц шаблон;
	$data - массив, содержащий элементы контента страницы. Обычно заполняется в модели.
	*/
	function generate($content_view, $template_view, $data = null)
	{
		
		if(is_array($data)) {
			extract($data);
		}

		if (isset($model['error'])) {
			$error = $model['error'];
		}
		
		include 'application/views/'.$template_view;
    }
}
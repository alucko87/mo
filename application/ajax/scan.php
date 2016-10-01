<?

	$dir_path=$_SERVER['DOCUMENT_ROOT']."/upload/";
	if(isset($_POST['dir']) and !empty($_POST['dir'])){
		$dir_path=$dir_path.$_POST['dir']."/";
	}
	$Counter = 0; 
	$files = scandir($dir_path); 
	$namefiles="<div class='image-viewer-lightbox' style='height: 325px;width: 490px; position: fixed; left: 25%;top: 25%;background: #fff;padding: 10px; border: 1px solid #B8B5B5;z-index:1;'>";
	$namefiles.="<div style='text-align:right;height:25px;'><span class='close-viewer-btn' style='cursor:pointer; font-size: 16px; position:absolute; right:5px; top:5px; height:15px;'>закрыть</span></div><div style='text-align:left; overflow-y: auto; height: 305px;'>";
	foreach ($files as $file) { 
		if ($file!='.'){ 
			if(isset($_POST['dir']) and  $_POST['dir']!=='root'){
				if($file!='..'){
					$namefiles.="<div class='file' data='".$_POST['dir']."' style='padding:5px; cursor:pointer;'>$file</div>"; 
				}
				else{
					$namefiles.="<div class='back_to_root' style='padding:5px; cursor:pointer;'>Назад</div>"; 
				}
			}
			else{
				if($file!='..'){
					$namefiles.= "<div class='folder' id='$file' style='padding:7px 7px 7px 70px;cursor:pointer;display:inline-block;width: 150px;background:url(/images/folder_2.png) no-repeat left;margin:3px;'>файлы с расширением <span style='font-size:18px;'>*.$file</span></div>"; 
				}
			}
		}
	} 
	$namefiles.="</div></div>";
	
	echo $namefiles;
?>
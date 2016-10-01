<?php

// подключаем файлы ядра
require_once 'defines.php';
require_once 'core/model.php';
require_once 'core/view.php';
require_once 'core/controller.php';
require_once 'core/route.php';

db_mysql_connect();	
// запускаем маршрутизатор
Route::start();
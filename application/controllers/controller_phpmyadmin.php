<?php
session_start();

class Controller_phpmyadmin extends Controller
{
    function action_main()
    {	
		if(isset($_SESSION['level']) and $_SESSION['level']<5){
		header('Location:http://195.189.246.5/phpmyadmin');
		}
		else{
		header('Location:/404.html');
		}
    }
}
<?php
class Controller_logout extends Controller
{
    
	function action_main()
    {	
		session_start();
		session_destroy();
		header('Location:/');
		
    }
}
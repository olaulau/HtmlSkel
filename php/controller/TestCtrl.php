<?php
namespace controller;

class TestCtrl
{
	
	public static function beforeRoute ()
	{
		
	}
    
	
	public static function afterRoute ()
	{
		
	}
	
	
	public static function bootstrapGET ()
	{
		$view = new \View();
		echo $view->render('test/bootstrap.phtml');
	}

	
	public static function jqueryuiGET ()
	{
		$view = new \View();
		echo $view->render('test/jqueryui.phtml');
	}
	
}

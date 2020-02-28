<?php
namespace controller;

class IndexCtrl
{

	public static function beforeRoute ()
	{
		
	}
    
	
	public static function afterRoute ()
	{
		
	}

	
	public static function indexGET ()
	{
		$view = new \View();
		echo $view->render('index.phtml');
	}
	
	
}

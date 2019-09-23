<?php
namespace controller;

class Ctrl
{

	public static function beforeRoute ()
	{
		
	}

	public static function afterRoute ()
	{
		
	}

	public static function GET_index ()
	{
		$view = new \View();
		echo $view->render('index.phtml');
	}
}

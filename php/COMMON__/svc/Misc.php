<?php

namespace COMMON__\svc;

class Misc
{
	
	public static function array_add($array, $element)
	{
		$array [] = $element;
		return $array;
	}
	
	
	public static function load_asset(string $module, string $path, string $type, bool $fail=false)
	{
		$f3 = \Base::instance();
		$BASE = $f3->get("BASE");
		$filename = \Base::instance()->get("PROJECT_ROOT")."/php/$module/assets/$path.$type";
		
		$page = $f3->get("page");
		
		if(file_exists($filename))
		{
			switch ($type)
			{
				case "css" :
					$page ["css"] [] = "$BASE/php/$module/assets/$path.css";
					?>
					<?php
				break;
				
				case "js" :
					$page ["js"] [] = "$BASE/php/$module/assets/$path.js";
					?>
					<?php
				break;
				
				default :
					die("unsupported asset type : $type");
				break;
			}
			$f3->set("page", $page);
		}
		else
		{
			if($fail)
			{
				die("required asset not found : $filename");
			}
		}
	}
	
	
	public static function show_db_logs ()
	{
		$f3 = \Base::instance();
		$db = $f3->get("db");
		$log = $db->log();
		echo "<pre>$log</pre>";
		die;
	}
}

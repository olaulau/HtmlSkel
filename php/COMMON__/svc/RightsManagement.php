<?php
namespace COMMON__\svc;

class RightsManagement
{
	
	public static function userHasPrivilege($privilege_clue)
	{
		$f3 = \Base::instance();
		$privileges = $f3->get("auth.privileges");
		$res = false;
		foreach ($privileges as $privilege)
		{
			if($privilege->clue === $privilege_clue)
				$res = true;
		}
		return $res;
	}
	
}

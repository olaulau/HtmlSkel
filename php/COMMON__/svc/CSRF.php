<?php

namespace COMMON__\svc;

class CSRF
{
	
	public static function newToken ()
	{
		$f3 = \Base::instance();
		$session = $f3->get("session"); /* @var \Session $session */
		
		$f3->CSRF = $session->csrf();
		$f3->set("SESSION.CSRF", $f3->CSRF);
	}
	
	
	public static function validate ()
	{
		$f3 = \Base::instance();
		$form_csrf = $f3->get($f3->VERB.".CSRF");
		$session_csrf = $f3->get('SESSION.CSRF');
		
		if (empty($form_csrf) || empty($session_csrf) || $form_csrf !== $session_csrf)
		{
			$f3->error(403, "CSRF");
		}
		$f3->clear($f3->VERB.".CSRF");
	}
	
}

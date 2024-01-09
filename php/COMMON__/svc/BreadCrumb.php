<?php
namespace COMMON__\svc;

class BreadCrumb
{
	
	public function __construct (private string $label, private string $link, private string $title="")
	{
		
	}

	
	public function getLabel ()
	{
		return $this->label;
	}
	
	public function getLink ()
	{
		return $this->link;
	}
	
	public function getTitle ()
	{
		return $this->title;
	}
	
	
	public function setLabel($label)
	{
		$this->label = $label;
	}
	
	public function setLink($link)
	{
		$this->link = $link;
	}
	
	public function setTitle($title)
	{
		$this->title = $title;
	}
	
	
	public function displayBreadCrumb ()
	{
		
	}
	
}

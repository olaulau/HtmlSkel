<?php
namespace COMMON__\mdl;

use Base;
use ErrorException;

abstract class Mdl extends \DB\Cortex
{
	
	const TABLE_NAME = null; // each subclass must fill-in this var
	
	const BOOLEAN_ENUM =
	[
		0 =>	"non",
		1 =>	"oui",
	];
	
	const OPERAND_ENUM =
	[
		"<" =>	"<",
		"=" =>	"=",
		">" =>	">",
	];
	
	
	// subclasses have to implement this method to use getAsList generic method
	public function __toString ()
	{
		throw new \ErrorException("__toString() method not implemented for class " . get_class($this));
	}
	
	
	// this method can lead to fatal error when the data is not foud, combining F3 with cortex ORM
	public function findone ($filter = null, ?array $options = null, $ttl = 0)
	{
		throw new \ErrorException("findone() method shoud not be used (class : " . get_called_class() . ")");
	}
	
	
	function __construct ()
	{
		$f3 = \Base::instance();
		$db = $f3->get("db"); /* @var $db \DB\SQL */
		parent::__construct($db, static::TABLE_NAME);
	}
	
	
	public function find($filter = NULL, array $options = NULL, $ttl = 0) : \DB\CortexCollection
	{
		$res = parent::find($filter, $options, $ttl);
		if(empty($res)) {
			return new \DB\CortexCollection();
		}
		else {
			return $res;
		}
	}
	
	
	
	public static function findBy($key, $value)
	{
		$entity = new static();
		
		$f3 = \Base::instance();
		$db = $f3->get("db"); /** @var \DB\SQL $db DataBase */
		
		// check $key is valid to avoid SQL injection
		$table = $entity->getTable();
		$schema = $db->schema($table);
		$fields = array_keys($schema);
		if(array_search($key, $fields) === false) {
			throw new ErrorException("$key is not a $table field");
		}
		
		$data = $entity->find(["$key = ?", $value]);
		return $data;
	}
	
	public static function findOneBy($key, $value)
	{
		$data = self::findBy($key, $value);
		if(empty($data)) {
			throw new \ErrorException("$key = $value not found");
		}
		if(count($data) > 1) {
			throw new \ErrorException("multiple $key = $value found");
		}
		return $data[0] ?? null;
	}
	
	
	public static function getAll ($order_field=null) : \DB\CortexCollection
	{
		$entity = new static(); /* var $entity \DB\Cortex */
		$order_field = $order_field ?? "name";
		// if the entity has a property "name", order results with it
		if(in_array($order_field, $entity->fields()))
		{
			$res = $entity->find("", ["order" => "$order_field ASC"]);
		}
		else
		{
			$res = $entity->find();
		}
		
		if(empty($res))
		{
			return new \DB\CortexCollection();
		}
		else
		{
			return $res;
		}
	}
	
	/**
	 *	key -> object
	 */
	public static function objectsIndexed (\DB\CortexCollection $objects, $key="id")
	{
		$values = [];
		foreach ($objects as $row)
		{
			$values [$row->$key] = $row;
		}
		
		return $values;
	}
	
	
	/**
	 * id -> name
	 */
	public static function objectsAsList (\DB\CortexCollection $objects) : array
	{
		$res = [];
		foreach ($objects as $row)
		{
			$res [$row->id] = $row->__toString();
		}
		return $res;
	}
	
	
	public static function getAsList () : array
	{
		$all = static::getAll();
		return static::objectsAsList ($all);
	}
	
	
	/**
	 * [
	 * 	{
	 * 		"value" : id,
	 * 		"label" : name,
	 *	},
	 * ]
	 */
	public static function objectsAsAjaxList (\DB\CortexCollection $objects) : array
	{
		$res = [];
		foreach ($objects as $row)
		{
			$res [] = [
				"value" => $row->id,
				"label" => $row->__toString(),
			];
		}
		return $res;
	}
	
	
	public static function getAsAjaxList () : array
	{
		$all = static::getAll();
		$res = self::objectsAsAjaxList($all);
		return $res;
	}
	
	
	public function isErasable ()
	{
		$f3 = \Base::instance();
		$db = $f3->get("db"); /* @var $db \DB\SQL */
		
		$db->begin();
		try
		{
			$this->erase();
		}
		catch(\Exception $ex)
		{
			return false;
		}
		
		$db->rollback();
		return true;
	}
	
	
	public function tryErase ()
	{
		$f3 = \Base::instance();
		$db = $f3->get("db"); /* @var $db \DB\SQL */
		
		$db->begin();
		try
		{
			$this->erase();
		}
		catch(\Exception $e)
		{
			$db->rollback();
			$class = get_class($e);
			$code = $e->getCode();
			if($class === "PDOException" && $code === "23000")
			{
				$error_message = "La donnée ne peut être supprimée, probablement car elle est utilisée ailleurs.";
			}
			else
			{
				$error_message = $class . " : " . $code . " : " . $e->getMessage();
			}
			throw new \ErrorException($error_message);
		}
		
		$db->commit();
	}
	
}

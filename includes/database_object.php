<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once(LIB_PATH.DS.'database.php');

class DatabaseObject {

	// I'm waiting for Late Static Bindings in PHP 5.3
	// http://www.php.net/lsb
	
	//protected static $table_name="users";
		//***************Using LATE STATIC BINDING and replacing "self" with "static"***************//
		
	// Common Database Methods
	public static function find_all($table_name="") {
		return static::find_by_sql("SELECT * FROM ".$table_name);
  }
  
  public static function find_by_id($id=0,$table_name="") {
    $result_array = static::find_by_sql("SELECT * FROM ".static::$table_name." WHERE auto_id={$id} LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  
  public static function find_by_sql($sql="") {
    global $database;
    $result_set = $database->query($sql);
    $object_array = array();
    while ($row = $database->fetch_array($result_set)) {
      $object_array[] = self::instantiate($row);
    }
    return $object_array;
  }
	// to fill in the attribures of the class with the vales from the database
	private static function instantiate($record) {
		// Could check that $record exists and is an array
		$class_name=get_called_class();//---------LATE STATIC BINDING only availabe in PHP 5.3
		
    $object = new $class_name;
		// Simple, long-form approach:
		// $object->id 				= $record['id'];
		// $object->username 	= $record['username'];
		// $object->password 	= $record['password'];
		// $object->first_name = $record['first_name'];
		// $object->last_name 	= $record['last_name'];
		
		// More dynamic, short-form approach:
		foreach($record as $attribute=>$value){
		  if($object->has_attribute($attribute)) {
		    $object->$attribute = $value;
		  }
		}
		return $object;
	}
		protected function has_attribute($attribute) {
	  // We don't care about the value, we just want to know if the key exists
	  // Will return true or false
	  return array_key_exists($attribute, $this->attributes());
	}

	protected function attributes() { 
		// return an array of attribute keys and their values
		$attributes=array();
		foreach(static::$db_fields as $field){
			if(property_exists($this,$field)){
			$attributes[$field]=$this->$field;
			}
		}
	  return $attributes;
	}
	
	protected function sanitized_attributes() {
	  global $database;
	  $clean_attributes = array();
	  // sanitize the values before submitting
	  // Note: does not alter the actual value of each attribute
	  foreach($this->attributes() as $key => $value){
	    $clean_attributes[$key] = $database->escape_value($value);
	  }
	  return $clean_attributes;
	}
	
}
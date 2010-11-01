<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once(LIB_PATH.DS.'database.php');

class User extends DatabaseObject {
	
	protected static $table_name="users";
	protected static $db_fields=array('auto_id','owner_id','usertype_id','username','fullname','email_id','password','contact_no');


	public $username;
	public $password;
	public $auto_id;
	public $usertype_id;
	public $fullname;
	public $email_id='null';
	public $contact_no;
	public $owner_id;
	
	
/*  public function full_name() {
    if(isset($this->first_name) && isset($this->last_name)) {
      return $this->first_name . " " . $this->last_name;
    } else {
      return "";
    }
  }*/

	public static function authenticate($username="", $password="") {
    global $database;
    $username = $database->escape_value($username);
    $password = $database->escape_value($password);

	$sql  = "SELECT auto_id,owner_id,username,usertype_id FROM users ";
    $sql .= "WHERE username = '{$username}' ";
    $sql .= "AND password = '{$password}' ";
    $sql .= "LIMIT 1";
	$result_set=self::find_by_sql($sql);
	return !empty($result_set) ? array_shift($result_set) : false;
	//$sql="call Authenticateuser('";
	//$sql.=$username."','";
	//$sql.=$password."')";
    //$result_array = $database->query($sql);
	//$valueset=$database->fetch_array($result_array);
	//print_r($valueset);
	//echo "<br/>";
	//return !empty($valueset) ? $valueset : false;
		
	}
	
	public static function select_user_details($user_id)
	{
		$result_set=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE auto_id=".$user_id);
		return !empty($result_set) ? array_shift($result_set) : false;
	}
	public function userCheck($uname)
		{
			global $database;
			$sql="SELECT username FROM users WHERE username='";
			$sql.=$uname."'";
			$result=$database->query($sql);
			$val=$database->fetch_array($result);
			if($val)
					{
					$string="<font color='#fff'><STRONG style='color:#000'>";
					$string.=$uname;
					$string.="</STRONG> is already in use.</font>";
					return $string;
					}
					else
					return "OK";
				 	
		}

	
	public function save() {
	  // A new record won't have an id yet.
	  return isset($this->id) ? $this->update() : $this->create();
	}
	
	public function create() {
		global $database;
		// Don't forget your SQL syntax and good habits:
		// - INSERT INTO table (key, key) VALUES ('value', 'value')
		// - single-quotes around all values
		// - escape all values to prevent SQL injection
		
		
		
		$attributes = static::sanitized_attributes(); // making use of LATE STATIC BINDING in PHP 5.3 onwards to access a method of super class
	  //$sql = "INSERT INTO ".self::$table_name." (";
		//$sql .= join(", ", array_keys($attributes));
	  //$sql .= ") VALUES ('";
		//$sql .= join("', '", array_values($attributes));
		//$sql .= "')";
		
		//Calling a MYSQL procedure to INSERT ***** returns username if that username exists , returns null if successful.****
		$sql="call Createuser('";
		$sql.=join("','",array_values($attributes));
		$sql .= "',@name)";
		
		if($database->query($sql))
		{
	    //$this->auto_id = $database->insert_id();
		$result=$database->query("SELECT @name");
		$value=$database->fetch_array($result);
			if($value[0]==null)
				{
					echo $value[0];
					return true;
				}
			else
				{
				$output = "Username <b> " . $value[0] . "</b> already exists.<br /><br />";
				die($output);
				return false;
				}
	  
		}
		else
		return false;   
	}
	
	
	
	public function update() {
	  global $database;
		// Don't forget your SQL syntax and good habits:
		// - UPDATE table SET key='value', key='value' WHERE condition
		// - single-quotes around all values
		// - escape all values to prevent SQL injection
		$attributes = $this->sanitized_attributes();
		$attribute_pairs = array();
		foreach($attributes as $key => $value) {
		  $attribute_pairs[] = "{$key}='{$value}'";
		}
		$sql = "UPDATE ".self::$table_name." SET ";
		$sql .= join(", ", $attribute_pairs);
		$sql .= " WHERE auto_id=". $database->escape_value($this->auto_id);
	  $database->query($sql);
	  return ($database->affected_rows() == 1) ? true : false;
	}

	public function delete() {
		global $database;
		// Don't forget your SQL syntax and good habits:
		// - DELETE FROM table WHERE condition LIMIT 1
		// - escape all values to prevent SQL injection
		// - use LIMIT 1
	  $sql = "DELETE FROM ".self::$table_name;
	  $sql .= " WHERE auto_id=". $database->escape_value($this->id);
	  $sql .= " LIMIT 1";
	  $database->query($sql);
	  return ($database->affected_rows() == 1) ? true : false;
	
		// NB: After deleting, the instance of User still 
		// exists, even though the database entry does not.
		// This can be useful, as in:
		//   echo $user->first_name . " was deleted";
		// but, for example, we can't call $user->update() 
		// after calling $user->delete().
	}
	
	
}

?>
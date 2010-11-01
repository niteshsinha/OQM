<?php
require_once(LIB_PATH.DS.'database.php');
require_once(LIB_PATH.DS.'session.php');


class Questions extends DatabaseObject
{

protected static $table_questions="questions";
protected static $table_options="options";
protected static $table_answers="answers";

//Preserve the order...this is the same as in the database table

protected static $db_fields=array('question_id','question','marks','test_id','ques_level','testdomain_id','owner_id','option_id','option');

public $question_id;
public $question;
public $marks;
public $test_id;
public $ques_level;
public $testdomain_id;
public $owner_id;
public $option_id;
public $option;

public function insert_ques()
	{
		global $database;
		$sql="call InsertQues('";
		$sql.=$this->question."',";
		$sql.=$this->marks.",";
		$sql.=$this->test_id.",";
		$sql.=$this->ques_level.",";
		$sql.=$this->testdomain_id.",";
		$sql.=$this->owner_id.",";
		$sql.=$this->option_id.",'";
		$sql.=$this->options."')";
		$database->query($sql);
	 return ($database->affected_rows() == 1) ? true : false;
	  
		}

public function get_ques_level($tid)
{
	global $database;
	$sql="SELECT DISTINCT ques_level FROM questions WHERE test_id=".$tid;
	$sql.=" ORDER by ques_level ASC";
	$result_set=self::find_by_sql($sql);
	return !empty($result_set)? $result_set :false;
}

}
	
	
?>


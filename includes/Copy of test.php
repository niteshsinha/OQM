<?php
require_once(LIB_PATH.DS.'database.php');
require_once(LIB_PATH.DS.'session.php');


class Test extends DatabaseObject
{

protected static $table_test="test";
protected static $table_ctest="ctest";

//Preserve the order...this is the same as in the database table

protected static $db_fields=array('test_id','testdomain_id','no_of_ques','testdate','no_of_students','avg_marks','top_scorer','test_name','ctest_id','examinee','invigilator_id','ques_correct','ques_incorrect','score','last_time_log');

public $test_id;
public $testdomain_id;
public $no_of_ques;
public $testdate;
public $no_of_students;
public $avg_marks;
public $top_scorer;
public $test_name;
public $ctest_id;
public $examinee;
public $invigilator_id;
public $ques_correct;
public $ques_incorrect;
public $score;
public $last_time_log;

public $record_ques=array();
public $record_status=array();
public $record_ans=array();

public $fwd_array=array();
public $temp_status=array();
public $temp_ans=array();

public $question="";
public marks=0;
public $options=array();

public function authenticatetest()
{
global $database;

$username=$_POST[username];
$secret_id=$_POST[secret_id];
$test_id=$_POST[test_id];

$sql="SELECT auto_id AS invigilator_id FROM users,usertype WHERE CONCAT(username,password)='";
$sql.=$secret_id."' AND (usertype='invigilator' OR usertype='admin') AND usertype.usertype_id=users.usertype_id LIMIT 1";
$result=$database->query($sql);
if(empty($result))
$output="The Secret Code of Invigilator/Admin is Incorrect.";
else
{
//we wil get the $invigilator_id automatically populated by the above find_by_sql call.
$this->Begin_test($_POST[test_id],$result);


}
}
//To list the number of tests availabe to the user.
public function list_tests()
{
//$sql="SELECT test_id,test_name,testdate FROM ".$table_test;
$sql="SELECT test_id,test_name,testdate FROM test";
$result_array = self::find_by_sql($sql);
print_r($result_array);
return !empty($result_array) ? array_shift($result_array) : false;
}


public function Begin_test($testid,$inviid)
{
global $database;

//$sql="call Begintest(";
//$sql.=$testid.",'";
//$sql.=$_POST[username]."',";
//$sql.=$inviid.",NOW(),";
//$sql.=$_POST[questionlevel].")";
//$resultset=$database->query($sql);

$resultset=$database->query("call Begintest(4,'nits',4,NOW(),6)");


 while ($valueset = $database->fetch_array($resultset)) {
$this->$record_ques[$valueset['question_id']]= $valueset['question_id'];
} 
//TO shuffle the questions given to every user.
shuffle($record_ques);

$keys=array_keys($record_ques);
foreach ($keys as $key)
{
// TO form a "QuestionId:Status" pair the record_status will have the question id's as keys and their statuses as their value.
// Status = Unanswered / Answered / Reviewed
$this->$record_status[$record_ques[$key]]="Unanswered";
// TO keep a track the Answer of the particilar question = 0/1/2/3/4
$this->$record_ans[$record_ques[$key]]=0;
}

$this->SetSession($record_ques,0,$record_status,$record_ans);

//$fwd_array=$record_ques;
//$temp_status=$record_status;
//$temp_ans=$record_ans;

$value=$database->query("SELECT max(ctest_id) as ctest_id FROM ctest");
$ctest_id_arr=$database->fetch_array($value);
echo "<br/><br/><br/>";
print_r($record_status);
echo "<br/><br/><br/>";
echo "Ctest id is:".$ctest_id_arr[0];
}

public function Conduct_test ($status,$option,$cid)
{
	$this->$fwd_array=$_SESSION['fwd_array'];
	$this->$bkd_array=$_SESSION['bkd_array'];
	$this->$temp_ans=$_SESSION['temp_ans'];
	$this->$temp_status=$_SESSION['temp_status'];
	
	if(move_forward){
	$fwd_ques=array_shift($fwd_array);
	$bkd_count=array_push($bkd_array,$fwd_ques); // this count tells the size of the backward array that grows
	$temp_status[$fwd_ques]=$status;
	$temp_ans[$fwd_ques]=$option;
	$ques=$fwd_ques;
	}
	else if (move_backward){
	$bkd_ques=array_pop($bkd_array)
	$fwd_count=array_unshift($fwd_array,$bkd_ques); //this count tells us the size of the forward array that grows.
	$temp_status[$bkd_ques]=$status;
	$temp_ans[$bkd_ques]=$option;
	$ques=$bkd_ques;
	}
	
	$this->SetSession($fwd_array,$bkd_array,$temp_status,$temp_ans);
	
	global $database;

	$sql="call Conducttest(";
	$sql.=$ques.",";
	$sql.=$cid.",";
	$sql.="NOW() )";
	$resultset=$database->query($sql);
	$num_rows=$database->num_rows($resultset);
	$c=1;
	while($valueset=$database->fetch_array($resultset) || $c<=$num_rows){
		$this->$question=$valueset['question'];
		$this->$marks=$valueset['marks'];
		$this->$options[$c]=$valueset['option'];
		}
			

// sql= call the ques from db with id=fwdques
}

public static SetSession($fwd_array,$bkd_array,$temp_status,$temp_ans)
{
	global $session;
	
		$_SESSION['fwd_array']=$fwd_array;
		$_SESSION['bkd_array']=$bkd_array;
		$_SESSION['temp_status']=$temp_status;
		$_SESSION['temp_ans']=$temp_ans;
}



}
?>
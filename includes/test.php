<?php
require_once(LIB_PATH.DS.'database.php');
require_once(LIB_PATH.DS.'session.php');


class Test extends DatabaseObject
{

protected static $table_test="test";
protected static $table_ctest="ctest";
protected static $table_testdomain="testdomain";

//Preserve the order...this is the same as in the database table

protected static $db_fields=array('test_id','testdomain_id','no_of_ques','testdate','no_of_students','test_duration','top_scorer','test_name','ctest_id','examinee','invigilator_id','ques_correct','ques_incorrect','score','last_time_log','owner_id','testdomain_name');

public $test_id;
public $testdomain_id;
public $no_of_ques;
public $testdate;
public $no_of_students;
public $test_duration;
public $top_scorer;
public $test_name;
public $ctest_id;
public $examinee;
public $invigilator_id;
public $ques_correct;
public $ques_incorrect;
public $score;
public $last_time_log;
public $owner_id;
public $testdomain_name;

public $record_ques=array();
public $record_status=array();
public $record_ans=array();

public $ques_array=array();
public $temp_status=array();
public $temp_options=array();

public $ques_id;
public $question;
public $marks;
public $oid=array();
public $options=array();
public $ques_unans;

// Variables to be passed to the browser.
public $logarray=array();


public function authenticatetest($secret_id,$test_id)
{
global $database;

$sql="SELECT auto_id AS invigilator_id,username FROM users,usertype,owner WHERE CONCAT(username,password)='";
$sql.=$secret_id."' AND (usertype='invigilator' OR usertype='admin') AND owner.owner_id=users.owner_id AND usertype.usertype_id=users.usertype_id LIMIT 1";
$result=$database->query($sql);
$value=$database->fetch_array($result);
return $value;

}
//To list the number of tests availabe to the user.
public function list_tests($owner_id)
{
//IT NEEDS TO CHECKED THAT TEST IS LISTED IN QUESTIONS TABLE AS WELL BECOS IF NOT IT MEANS THAT TEST HAS NO QUESTIONS DEFINED FOR IT AS YET. 
$sql="SELECT DISTINCT t.test_id as test_id,test_name,testdate FROM test t,questions q,owner o WHERE o.owner_id=t.owner_id AND q.test_id=t.test_id AND t.owner_id=".$owner_id;
$result_set = self::find_by_sql($sql);
return !empty($result_set)? $result_set :false;
}

public function last_test_record($owner_id,$uname,$per_page,$offset)
{
	$sql="SELECT test_name,testdate,test_duration,ques_correct,ques_incorrect,score,last_time_log ";
	$sql.="FROM test t, ctest c ";
	$sql.="WHERE c.owner_id=".$owner_id;
	$sql.=" AND c.examinee='".$uname;
	$sql.="' AND t.test_id=c.test_id AND t.owner_id=c.owner_id ";
	$sql.="ORDER BY last_time_log DESC LIMIT ".$per_page;
	$sql.=" OFFSET ".$offset;
	$result_set=self::find_by_sql($sql);
	return !empty($result_set)? $result_set :false;
}


public function test_record_count($owner_id,$uname)
{

	$sql="SELECT count(ctest_id)";
	$sql.="FROM test t, ctest c ";
	$sql.="WHERE c.owner_id=".$owner_id;
	$sql.=" AND c.examinee='".$uname;
	$sql.="' AND t.test_id=c.test_id AND t.owner_id=c.owner_id ";
	$sql.="ORDER BY last_time_log DESC";
	global $database;
	$result_set=$database->query($sql);
	$nrows=$database->fetch_array($result_set);
	return array_shift($nrows);
}


public  function Begin_test($owner_id,$testid,$inviid=4,$ql,$un)
{
global $database;

$sql="call Begintest(";
$sql.=$owner_id.",";
$sql.=$testid.",'";
$sql.=$un."',";
$sql.=$inviid.",NOW(),";
$sql.=$ql.")";
$resultset=$database->query($sql);

//$resultset=$database->query("call Begintest(1,4,'nits',4,NOW(),3)");

	while ($valueset = $database->fetch_array($resultset)) {
 $record_ques[$valueset['question_id']]= $valueset['question_id'];
 $record_ans[$valueset['question_id']]= $valueset['option_id'];
 $record_marks[$valueset['question_id']]= $valueset['marks'];

} 

/*print_r($record_ques);
echo "<br/>";
print_r($record_ans);
echo "<br/>";
print_r($record_marks);
echo "<br/>";
echo "<br/>";
echo "<br/>";*/

//To record the answers and marks in the session
$_SESSION['record_ans']=$record_ans;
$_SESSION['record_marks']=$record_marks;
$_SESSION['ques_key']=-1;
$_SESSION['ques_key_count']=count($record_ques)-1;

//TO shuffle the questions given to every user.
shuffle($record_ques);

/*echo "<br/>";
print_r($record_ques);*/

$values=array_values($record_ques);
/*echo "<br/>";
print_r($values);
echo "<br/>";*/
foreach ($values as $val)
{
//echo $val."<br/>";
// TO form a "QuestionId:Status" pair the record_status will have the question id's as keys and their statuses as their value.
// Status = Unanswered / Answered / Reviewed
$record_status[$val]="Unanswered";
// TO keep a track the Answer of the particilar question = 0/1/2/3/4
$record_options[$val]=0;
}

$this->SetSession($record_ques,0,$record_status,$record_options);


//$database->ClearStoredResults();//To clear to mysqli buffer in order to execute the next query.
$value=$database->query("SELECT test_duration, max(ctest_id) as ctest_id FROM test,ctest,owner WHERE test.owner_id={$owner_id} AND test.test_id={$testid} AND owner.owner_id=ctest.owner_id ");
$arr=$database->fetch_array($value);
$_SESSION['test_duration']=$this->test_duration=$arr[0];
$_SESSION['ctest_id']=$this->ctest_id=$arr[1];


/*echo "<br/>";
print_r($record_status);
echo "<br/>";
print_r($record_options);
echo "<br/>";*/

return $this->ctest_id;
}

public function Conduct_test ($status='Unanswered',$option=0,$cid=0,$last_return_ques_id=0,$dir,$end_test='false',$given_qid=-1)
{
	
	$key=-1;
	$ary=$_SESSION['fwd_array'];
	$temp_options=$_SESSION['temp_options'];
	$temp_status=$_SESSION['temp_status'];
	
	if(isset($_SESSION['ques']) && $given_qid==-1)
		{	
			$q=$_SESSION['ques'];
			$temp_status[$q]=$status;
			$temp_options[$q]=$option;
		}
	
		if($last_return_ques_id==0)
		$key=-1;
		else
		$key=$_SESSION['ques_key'];
		
//		echo "SET:";print_r($ary);echo "<br/>";
		if($end_test=='false')
		{
			if($given_qid==-1)
				{
					if($dir=='f'){
						$key=$key+1;
						}
					elseif ($dir=='b'){
						$key=$key-1;
						}	
//					echo "KEY:";echo($key);echo "<br/>";
					$_SESSION['ques_key']=$key;
					$ques=$ary[$key];
				}
				else		
				{
					$ques=$given_qid;
					foreach($ary as $id => $val)
					if($val == $given_qid)
						{	$key=$id;
						$_SESSION['ques_key']=$key;
						}
						//$option=0;//has no option
						$last_return_ques_id=0;
						$temp_status[$ques]=$status;
						$temp_options[$ques]=$option;
				}
			}
			else
			{
				$ques=$_SESSION['ques'];
			
			}
			if($option == 0)
				$last_return_ques_id=0;
			
		
	$this->SetSession($ary,$ques,$temp_status,$temp_options);

	global $database;

	$sql="call Conducttest(";
	$sql.=$_SESSION['owner_id'].",";
	$sql.=$ques.",";
	$sql.=$cid.",";
	$sql.=$option.",";// get the option selected of the last question returned by the user
	$sql.=$last_return_ques_id.",'";// get the last question id returned from the user
	$sql.=$status."',";
	$sql.="NOW() )";
	//echo $sql."<br/>";
	$resultset=$database->query($sql);
	if($end_test=="false")
	{
	
	while($valueset=$database->fetch_array($resultset)){
		$oid[$valueset['option_id']]=$valueset['option_id'];
		$options[$valueset['option_id']]=$valueset['option'];
		$question=$valueset['question'];
		$marks=$valueset['marks'];
		}
		
		$this->ques_id=$ques;
		$this->question=$question;
		$this->marks=$marks;
		$this->options=$options;
		
		/*echo $this->question."<br/>";
		echo $this->marks."<br/>";
		print_r($this->options);*/
		
		
		//$database->free_result($resultset);
		
	}
		
}

public function SetSession($fwd_array,$ques,$temp_status,$temp_options)
{
	global $session;
	
		$_SESSION['fwd_array']=$fwd_array;
		if($ques != 0)
		$_SESSION['ques']=$ques;
		$_SESSION['temp_status']=$temp_status;
		$_SESSION['temp_options']=$temp_options;
}

public function Review_test()
	{
		$array=$_SESSION['fwd_array'];
		$answers=$_SESSION['record_ans'];// has the ans on its corrosponding ques_id as the array key.
		$marks=$_SESSION['record_marks'];//  has the marks on its corrosponding ques_id as the array key.
		global $database;
		$ques_array=array();
		$c=0;
		foreach ($array as $qid)
			{
				$sql="call Reviewtest(";
				$sql.=$_SESSION['owner_id'].",";
				$sql.=$qid.")";
				$resultset=$database->query($sql);
				$valueset=$database->fetch_array($resultset);
				$ques_array[$c++]=$valueset['question'];
			}
		
		$_SESSION['ques_array']=$ques_array;
			
	}
	
	public function GetAllQues()
		{
		return $_SESSION['ques_array'];
		}
		

// need to convert to static 
public function Evaluate_test()
	{
		$array=$_SESSION['fwd_array'];
		$answers=$_SESSION['record_ans'];// has the ans on its corrosponding ques_id as the array key.
		$marks=$_SESSION['record_marks'];//  has the marks on its corrosponding ques_id as the array key.
		$temp_status=$_SESSION['temp_status'];
		$temp_options=$_SESSION['temp_options'];
		
		$total_marks=0;
		$ques_corr=0;
		$ques_incorr=0;
		$ques_unans=0;
		
		foreach ($array as $key => $value)
			{		
				if($temp_status[$value]=='Answered' || $temp_status[$value]=='Reviewed' && $temp_options[$value]!=0 )
					{
						if($answers[$value] == $temp_options[$value])
							{ 
							$total_marks+=$marks[$value];
							$ques_corr++;
							$logarray[$key]="Question with Id: ".$value." with Option no: ".$answers[$value]." Correct Option no: ".$temp_options[$value]." Status : Right.";
							}
							else
							{
							$ques_incorr++;
							$logarray[$key]="Question with Id: ".$value." with Option no: ".$answers[$value]." Correct Option no: ".$temp_options[$value]." Status : Wrong.";
							}
					}
					else
					{
					$ques_unans++;
					$logarray[$key]="Question with Id: ".$value." is Unanswered.";
					}
							
			}
			
			$this->ques_unans=$ques_unans;
			$this->score=$total_marks;
			$this->ques_correct=$ques_corr;
			$this->ques_incorrect=$ques_incorr;
			$this->logarray=$logarray;
			
			
	global $database;

//	echo "<br/>i am at evaluate test<br/>";
	
	
	$sql="call Evaluatetest(";
	$sql.=$_SESSION['owner_id'].",";
	$sql.=$_SESSION['ctest_id'].",";
	$sql.=$this->score.",";
	$sql.=$this->ques_correct.",";
	$sql.=$this->ques_incorrect.",";
	$sql.="NOW() )";
	$resultset=$database->query($sql);		
	}
	
	public function Add_TestDomain()
	{
		global $database;
		$sql="call AddTestDomain('";
		$sql.=$this->testdomain_name."',";
		$sql.=$this->owner_id.",";
		$sql.="@name)";
		if($database->query($sql))
		{
		$result=$database->query("SELECT @name");
		$value=$database->fetch_array($result);
		return ($value[0]==null) ? true : $value[0];
		}
	}
	
	public function List_TestDomain($tname)
	{
		global $database;
		if($tname=='**notest**')
		$sql="SELECT DISTINCT testdomain_id,testdomain_name FROM testdomain JOIN test USING (testdomain_id) WHERE testdomain.owner_id=".$this->owner_id;
		else if($tname=='null')
		$sql="SELECT testdomain_id,testdomain_name FROM testdomain WHERE testdomain.owner_id=".$this->owner_id;
		else{
		$sql="SELECT td.testdomain_id as testdomain_id,td.testdomain_name as testdomain_name FROM testdomain td,test tt WHERE td.owner_id=".$this->owner_id;
		$sql.=" AND tt.test_name='".$tname;
		$sql.="' AND tt.testdomain_id=td.testdomain_id";
		}
		$result_set = self::find_by_sql($sql);
		return !empty($result_set)? $result_set :false;
	
	}
	public function Add_TestInfo()
	{
		global $database;
		$sql="INSERT INTO test (test_id,testdomain_id,no_of_ques,testdate,test_duration,test_name,owner_id) VALUES (DEFAULT,";
		$sql.=$database->escape_value($this->testdomain_id).",";
		$sql.=$database->escape_value($this->no_of_ques).",'";
		$sql.=$this->testdate."','";
		//$sql.=$database->escape_value($this->testdate).",'";
		$sql.=$database->escape_value($this->test_duration)."','";
		$sql.=$database->escape_value($this->test_name)."',";
		$sql.=$database->escape_value($this->owner_id).")";
//		echo $sql."<br/>";
		$database->query($sql);
	 	 return ($database->affected_rows() == 1) ? true : false;
	}
	public function List_Tests_perDomain($tname)
	{
	if($tname=='null')
	{
	$sql="SELECT test_id,test_name,testdate FROM test,owner WHERE owner.owner_id=test.owner_id AND test.owner_id=".$this->owner_id;
	$sql.=" AND test.testdomain_id=".$this->testdomain_id;
	$sql.=" ORDER BY test_id DESC";
	}
	else
	{
	$sql="SELECT test_id,test_name,testdate FROM test,owner WHERE owner.owner_id=test.owner_id AND test.owner_id=".$this->owner_id;
	$sql.=" AND test.testdomain_id=".$this->testdomain_id;
	$sql.=" AND test.test_name='".$tname."'";
	}
	$result_set = self::find_by_sql($sql);
	return !empty($result_set)? $result_set :false;
	}
	public function ChangeDomain($para)
		{	
			global $database;
			if($para=='up'){
			$sql="UPDATE testdomain SET testdomain_name='".$database->escape_value($this->testdomain_name);
			$sql.="' WHERE testdomain_id=".$database->escape_value($this->testdomain_id);
			$sql.=" AND owner_id=".$database->escape_value($this->owner_id);
			}
			else if($para=='del'){
			$sql="DELETE FROM testdomain WHERE testdomain_id=".$this->testdomain_id;
			$sql.=" AND owner_id=".$this->owner_id;
			}
			 $database->query($sql);
	  		return ($database->affected_rows() == 1) ? true : false;
		}
	
}//END of class

?>
<?php 
require_once("includes/initialize.php");

if(isset($_GET['tid'])) {$tid=$_GET['tid'];}else{$tid=$_POST['tid'];}
if(isset($_GET['tname'])) {$tname=$_GET['tname'];}else {$tname=$_POST['tname'];}
//$tid=2;
$tt = new Test();
$qa =  new Questions();
$records=$qa->get_ques_level($tid);

if(isset($_POST['submit']))
	{
	$username=trim($_POST['username']);
	$password=trim($_POST['password']);
	$sid=$username.$password;
	$result=$tt->authenticatetest($sid,$tid);
	if(empty($result))
		{
		$message="The Secret Code of Invigilator/Admin is Incorrect.";
		}
		else
		{
		$log = new Logs($_SESSION['owner_id'],$tname);
		// do some logging operations
		
		//set the parameters to Begintest
		
		//$ctid=$tt->Begintest($session->owner_id,$tid,$result,$_POST['ql']);
		$_SESSION['first_time']="true";
		$ctid=$tt->Begin_test($_SESSION['owner_id'],$tid,$result[0],$_POST['myselect'],$_SESSION['uname']);
		
		$filename="Current_test_".$ctid;
		$log->write_logfile($filename,'Test Authorised', "For User:{$_SESSION['uname']} By Admin/Invigilator :{$result[1]}.",time());
		
		$path="test-pg.php?n=";
		$path.=urlencode($tname);
		$path.="&c=";
		$path.=$ctid;
		redirect_to($path);
		
		//echo "<script type='text/javascript' language='javascript'>";
			//echo "submitform();";
		//echo "<//script>";

		
		
		}
	}
?>
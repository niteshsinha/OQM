
<?php require_once("includes/initialize.php"); ?>

<?php
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
		//echo "thios is corrstc";
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
		
		}
	}
?>

<p class="name" style="margin-top:-2px;"><span class="txtshd">Authenticate Test</span >:<?php echo $tname;?></p>

		<form method="post" id="formID" action="validatetest.php" name="formID" onsubmit="return CheckData();">
               <div class="label"><b>Username</div>
  			<input type="text" class="form-login validate[required]" name="username" id="username">
                        <input type="hidden" value="<?php echo isset($_GET['tid']) ? $_GET['tid']:$_POST['tid'];?>" name="tid" >
                        <input type="hidden" value="<?php echo isset($_GET['tname']) ? $_GET['tname']:$_POST['tname'];?>" name="tname" >

          	   <div class="label">Password</div>
        
           				<input type="password" class="form-login validate[required]" name="password" id="password" >
        
		  	   <div class="label">Question Level</div>
						<select name="myselect" id="myselect">
                                <option value="0">Select</option>
                              <?php foreach ($records as $tr) { ?>
 								<?php if($tr->ques_level==1){?><option value="1">Beginner</option><?php }?>
             					<?php if($tr->ques_level==2){?><option value="2">Medium</option><?php }?>
 			 					<?php if($tr->ques_level==3){?><option value="3">Expert</option><?php }?>
                    			<?php } ?>
                    			
       					</select>

                        <input class="button white" type="submit" name="submit" value="Submit"/>

</form>

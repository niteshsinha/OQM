<?php require_once("includes/initialize.php"); ?>

<?php 
if(isset($_POST['userName'])){
$ur = new User;
if(isset($_POST['auto_id'])){$ur->auto_id=$_POST['auto_id'];}else {$ur->auto_id=1;}
$ur->usertype_id=$_POST['usertypeid'];
$ur->username=$_POST['userName'];
$ur->password=$_POST['cnfpassword'];
$ur->fullname=$_POST['fullName'];
$ur->email_id=$_POST['email'];
$ur->owner_id=$_POST['owner_id'];
$ur->contact_no=$_POST['contact'];
	if($_GET['type']=='new'){
			$result=$ur->create();
				if($result=='true'){
				redirect_to("success.html");
				}
				else{
				redirect_to("error.html");
				}
		}
		else if($_GET['type']=='old'){
				$result=$ur->update();
				if($result=='true'){
				redirect_to("success.html");
				}
				else{
				redirect_to("error.html");
				}
		}
}
?>
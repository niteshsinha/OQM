<?php require_once("includes/initialize.php"); ?>
<?php

$ur =  new User();
if(isset($_POST['uname'])) 
		{
		$response=$ur->userCheck($_POST['uname']);
		echo $response;
		}
	
?>
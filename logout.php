<?php require_once("includes/initialize.php"); ?>
<?php
		$log = new Logs($_SESSION['owner_id'],'user');
		$filename=$_SESSION['user_id']."_".$_SESSION['uname'];
		$log->write_logfile($filename,'Logout', "{$_SESSION['uname']} ({$_SESSION['user_id']}) has logged out.",time());
    $session->logout();
    redirect_to("login.php");
?>

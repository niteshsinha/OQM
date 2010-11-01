<?php
require_once('../../includes/initialize.php');
//if (!$session->is_logged_in()) { redirect_to("login.php"); }
?>

<?php include_layout_template('admin_header.php'); ?>

<?php 
//$tt=new Test();
//$tt->list_tests();
//Test::Begin_test(4,4);
//$logs=new Logs(1,'test');
//$logs->write_logfile('Current_Test_1','Login','Nitesh Sinha has taken 4nd test');
User::select();
?>

	<h2>Menu</h2>
	<ul>
		<li><a href="logfile.php">View Log file</a></li>
		<li><a href="logout.php">Logout</a></li>
	</ul>

<?php include_layout_template('admin_footer.php'); ?>
		
<?php require_once("../includes/initialize.php"); 
if (!$session->is_logged_in()) { redirect_to("login.php"); }
?>


<?php include_layout_template('header.php'); ?>
<?php
$user = User::find_by_id(1,"users");
echo $user->fullname;

echo "<hr />";

$users = User::find_all("users");
foreach($users as $user) {
  echo "User: ". $user->username ."<br />";
  echo "Name: ". $user->fullname ."<br /><br />";
}
?>

	<ul>
		<li><a href="logfile.php">View Log file</a></li>
		<li><a href="logout.php">Logout</a></li>
	</ul>

<?php include_layout_template('footer.php'); ?>

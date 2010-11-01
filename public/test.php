<?php require_once("../includes/initialize.php"); ?>
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

<?php include_layout_template('footer.php'); ?>

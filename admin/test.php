<?php
require_once('../../includes/initialize.php');
if ($session->is_logged_in()) { redirect_to("login.php"); }
?>

<?php include_layout_template('admin_header.php'); ?>

	<h2>Menu</h2>
		
<?php
$user=new User();
//$user->auto_id=2;
//$user->usertype_id=2;
$user->username="test10";
$user->password="test5";
$user->fullname="TEST13 TES13";
$user->csimember_id=null;
$user->contact_no=123345;
$user->owner_id=1;
$user->create();

?>
<?php include_layout_template('admin_footer.php'); ?>
		

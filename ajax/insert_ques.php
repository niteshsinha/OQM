<?php
require_once('../includes/initialize.php');
if (isset($_GET['tques'])){
$qa= new Questions();
$qa->question=($_GET['tques']);
$qa->marks=$_GET['marks'];
$qa->option_id=$_GET['ans'];
$qa->ques_level=$_GET['dl'];
$qa->testdomain_id=$_GET['tdid'];
$qa->test_id=$_GET['tid'];
$qa->owner_id=$_SESSION['owner_id'];
$arr=array($_GET['op1'],$_GET['op2'],$_GET['op3'],$_GET['op4']);
$qa->options=implode("','",$arr);
$result=$qa->insert_ques();
}
if($result)
{
?>
<h2><strong>question inserted</strong></h2>
<?php }
else{
?>
<h2><strong>question not inserted</strong></h2>
<?php }?>
	
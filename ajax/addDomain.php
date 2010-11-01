<?php 
require_once('../includes/initialize.php');

$domain=htmlentities($_GET['d']);
$tt = new Test();
$tt->testdomain_name=$domain;
$tt->owner_id=1;
$result=$tt->Add_TestDomain();
if($result=='true')
	{
	echo $domain." Successfully inserted in the Test Domain.";
	echo "<br/>";
	}
	
	else
	
	{
	echo $result." Already exists in the Test Domain.";
	}
	
	

?>
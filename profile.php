<?php require_once("includes/initialize.php"); ?>
<?php

$id=$_REQUEST['record'];
$result=User::select_user_details($id);

echo '<table style="border:1px solid #666;" cellpadding="10" class="usrlst4">';
echo "<tr>";
echo "<td width=\"120\">";
echo "User Id";
echo "</td>";
echo "<td>";
echo $result->auto_id;
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>";
echo "User Type";
echo "</td>";
echo "<td>";
if($result->usertype_id==1)
echo "Administrator";
else if($result->usertype_id==2)
echo "Examinee";
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>";
echo "User Name";
echo "</td>";
echo "<td>";
echo $result->username;
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>";
echo "Full Name";
echo "</td>";
echo "<td>";
echo $result->fullname;
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>";
echo "Email ID";
echo "</td>";
echo "<td>";
echo $result->email_id;
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>";
echo "Contact No.";
echo "</td>";
echo "<td>";
echo $result->contact_no;
echo "</td>";
echo "</tr>";
echo "</table>";
?>
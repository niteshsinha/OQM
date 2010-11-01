
<?php 
require_once('../includes/initialize.php');
if(isset($_GET['did']) && $_GET['did']!='*null*'){
$did=$_GET['did'];
$dname=$_GET['dname'];
}
else{
$oid=$_SESSION['owner_id'];
	$tt=new Test();
	$tt->owner_id=$oid;
	$test_domains=$tt->List_TestDomain('null');	
}
?>

    
		<table>
     <tr>
     <td>Test Category</td>
     <?php if(isset($_GET['did']) && $_GET['did']!='*null*'){ ?>
     <td><input type="text" name="txtcatrgory" id="txtcategory" disabled="disabled" value="<?php echo $dname;?>"></td>
	 <?php
	 }
	 else {
	  ?>
      <td>
      <form name="frm">
      <select name="myselect" id="myselect">
      <?php foreach ($test_domains as $td)
								{
								?>
      	<option value="<?php echo $td->testdomain_id;?>" > <?php echo $td->testdomain_name; ?> </option>
        <?php } ?>
      </select>
      </form>
      </td>
      <?php 
	  }
	  ?>
     </tr>
     <tr>
     <td>Test Name:</td><td><input type="text" name="txttestname" id="txttestname">
     &nbsp;&nbsp;&nbsp;&nbsp; Number of Questions:<input type="text" name="txtqno" id="txtqno">&nbsp;&nbsp;&nbsp;&nbsp;
     </td>
     </tr>
     <tr>
     <td>Test Duration:</td><td>
     <input type="text" name="hrs" id="hrs" class="time">&nbsp;&nbsp;Hr. &nbsp;&nbsp;
     <input type="text" name="mins" id="mins" class="time">&nbsp;&nbsp;Min. &nbsp;&nbsp;
     <input type="text" name="secs" id="secs" class="time">&nbsp;&nbsp;Secs. &nbsp;&nbsp;
     </td>
     </tr>   
     <tr>
     <td></td>
     		<?php if(isset($_GET['did']) && $_GET['did']!='*null*') { ?>
    		 <td>
                     <input name="addtest" type="submit" value="Create Test & Proceed to Add Questions" class="button rosy medium" onclick="return addTestInfo('**novalue**');">
             </td>
             <?php }
			 	else {
			 ?>
             <input name="addtest" type="submit" value="Create Test & Proceed to Add Questions" class="button rosy medium" onclick="return addTestInfo(gettidval());">
             <?php }?>
     </tr>
     <tr>
     <td><input type="hidden" name="owner_id" id="owner_id" value="<?php echo $_SESSION['owner_id'];?>"></td>
     <?php if(isset($_GET['did']) && $_GET['did']!='*null*'){ ?>
     <td><input type="hidden"  name="testdomain_id" id="testdomain_id"  value="<?php echo $did; ?>"></td>
	<?php } ?>
     </tr>
   </table>
		
 
  
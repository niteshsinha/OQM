<?php 
require_once('../includes/initialize.php');
$tt = new Test();
if(isset($_GET['tname']))
	{
	$tt->test_name=$tname=$_GET['tname'];
	$tt->testdate=$date=date("Y-n-j G:i:s",time());
	$tt->test_duration=$time=$_GET['time'];
	$tt->owner_id=$owner_id=$_GET['ow_id'];
	$tt->testdomain_id=$testdomain_id=$_GET['td_id'];
	$tt->no_of_ques=$_GET['qno'];
	$flag=$tt->Add_TestInfo();
	$test_domains=$tt->List_TestDomain($tname);
	}
	else{
	$tt->owner_id=$owner_id=$_GET['ow_id'];
	$test_domains=$tt->List_TestDomain('**notest**');
	}
?>

<form name="frm" id="frm">
  <table class="surround2">
    <tr>
    <td>Select Test Topic</td>
      <td>
      		<select name="td_select" id="td_select" <?php if(isset($_GET['tname'])) {echo "disabled"; }?> onchange="gettestnames(gettid(this),<?php echo ($_SESSION['owner_id']); ?>,'<?php if(isset($_GET['tname'])){echo $_GET['tname'];} else {echo "null";} ?>')" >
            <?php foreach ($test_domains as $td)
								{
								?>
            	<option  <?php if(isset($_GET['tname'])) {echo "selected"; }?> value="<?php echo $td->testdomain_id;?>" >
				<?php echo $td->testdomain_name;?>
                </option>
                <?php } ?>
      		</select>
      </td>
      	<div id="testnames_div">
        <?php if (isset($_GET['tname'])) 
		{
		$total_tests_perdomain=$tt->List_Tests_perDomain($tname);
							foreach ($total_tests_perdomain as $ttp)
								{
		?>
        <td>Select Test Name</td>
        <td >
                            	<select name="tid_select" id="tid_select" <?php if(isset($_GET['tname'])){echo "disabled";} ?>>
     						 		<option <?php echo "selected"; ?> value="<?php echo $ttp->test_id;?>"><?php echo $ttp->test_name;?></option>
                       			</select>
                       		 </td>
        <?php 
				}
			}
	?>
      	</div>
    </tr>
    <tr><td>Type The Question</td>
      <td colspan="4"><textarea name="taques" id="taques" cols="80" rows="5"></textarea></td>
    </tr>
    <tr><td>Type The Options For The Above Question</td>
      <td><input type="text" name="txtop1" id="txtop1"></td>
      <td><input type="text" name="txtop2" id="txtop2"></td>
      <td><input type="text" name="txtop3" id="txtop3"></td>
      <td><input type="text" name="txtop4" id="txtop4"></td>
    </tr>
    <tr><td>Choose The Correct Answer</td>
      <td>
      <label>
      <input type="radio" name="RG" value="1" id="RadioGroup1_0">
      Option 1.</label></td>
      <td><label>
      <input type="radio" name="RG" value="2" id="RadioGroup1_1">
      Option 2.</label></td>
      <td><label>
      <input type="radio" name="RG" value="3" id="RadioGroup1_2">
      Option 3.</label></td>
      <td><label>
      <input type="radio" name="RG" value="4" id="RadioGroup1_3">
      Option 4.</label></td>
    </tr>
     <tr align="right"><td>Difficulty Level</td>
      <td colspan="4">
      	<select name="myselect" id="myselect">
     		 <option value="0">Select</option>
 			 <option value="1">Beginner</option>
             <option value="2">Medium</option>
 			 <option value="3">Expert</option>
       </select>
      </tr>
     <tr align="right"><td>Marks</td>
      <td colspan="4"><input type="text" name="txtmarks" id="txtmarks"></tr>
    <tr align="right"><td></td>
      <td colspan="4"><input name="" class="button rosy medium2" type="button" value="Save" onclick="return ValidateSubmit()" ></td>
    </tr>
  </table>
</form>
<?php	
	require_once('../includes/initialize.php');
	$oid=$_GET['ow_id'];
	$td_id=$_GET['td_id'];
	$val=$_GET['val'];
	$tt=new Test();
	$tt->owner_id=$oid;
	$tt->testdomain_id=$td_id;
	$total_tests_perdomain=$tt->List_Tests_perDomain('null');
								?>
                            <td>Select Test Name</td>   
                            <td >
                            	<?php if ($val=='add'){?>
                            	<select name="tid_select" id="tid_select" >
                                <?php } else if ($val=='mod'){?>
                                <select name="tid_select" id="tid_select" onchange="ShowTestDetails(gettid(this),<?php echo td_id;?>,<?php echo oid; ?>)" >
                                <?php } ?>
                                <?php foreach ($total_tests_perdomain as $ttp)
								{
								?>
     						 		<option value="<?php echo $ttp->test_id;?>"><?php echo $ttp->test_name;?></option>
                                    <?php
								}
	  							?>		
                       			</select>
                       		 </td>
                             
            			
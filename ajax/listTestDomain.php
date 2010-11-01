<?php	
	require_once('../includes/initialize.php');
	$oid=$_GET['oid'];
	$para=$_GET['p'];
	$tt=new Test();
	$tt->owner_id=$oid;
	$test_domains=$tt->List_TestDomain('null');	
		if ($para == 'add')
			{
	?>
    				<label class="for_label">Click on a Category.</label>	
  						<ul>
					<?php
							foreach ($test_domains as $td)
								{
								?>
                           
                           		 <li>
            					<a href="javascript: addTest(<?php echo $td->testdomain_id; ?>,'<?php echo $td->testdomain_name; ?>');" > <?php echo $td->testdomain_name; ?> </a>
            					</li>

            			<?php
								}
	  							?>
								</ul>
                          <?php 
						  	}// end if
							else
							{
							?>
                            <table>
                            	<tr>
                                	<td>
                                    <?php if ($para=='mod'){?>
                            <label for="for_label">Select a Category to Edit or Delete.</label>
                            		<?php } else if($para=='test'){ ?>
							<label for="for_label">Select a Category and then the Test.</label>
                            		<?php } ?>		
                            		</td>
                                 </tr>
                                 <tr>
                                 	<td>
                            <select name="td_select" id="td_select" 
                            	<?php if ($para=='mod'){?>
                                onchange="ShowValMod(gettid(this),gettname(this),<?php echo ($_SESSION['owner_id']); ?>)" >
                                <?php } else if($para=='test'){ ?>
                                onchange="ShowValTest(gettid(this),<?php echo ($_SESSION['owner_id']); ?>)" >
                                <?php } ?>
           						 <?php foreach ($test_domains as $td)
								{
								?>
            					<option value="<?php echo $td->testdomain_id;?>" > <?php echo $td->testdomain_name;?>
               					 </option>
               				 <?php } ?>
      						</select>
									</td>
                                 </tr>
                              </table>
                      <?php }// end else if 
								
					  ?>
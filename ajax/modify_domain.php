<?php	
	require_once('../includes/initialize.php');
	$tt=new Test();
	$tt->owner_id=$oid;
	$test_domains=$tt->List_TestDomain('null');	
	?>
							<table>
    							<tr>
        							<td>
   					 <div id="hide_list">
                   			 <h4><strong>Select a Category.</strong></h4>
  						
                        <select name="ddldomain" id="ddldomain" onchange="modifytest(gettid(this),gettname(this),<?php echo $_SESSION['owner_id']; ?>)">
                                	<option value="0">Select</option>
                    		 <?php 
							foreach ($test_domains as $td)
								{
								?>
                                	<option value="<?php echo $td->testdomain_id;?>"><?php echo $td->testdomain_name; ?></option>
            			<?php
								}
	  							?>
                         </select>
                 </div><!-- this is to hide the list when needed-->
            </td>
            <td>
        			<div id="change"><!-- this is the div to be updated on ajax call of the  right container-->
                    </div><!-- this is end of change div-->
             </td>
            </tr>
           </table> 
		  
            					
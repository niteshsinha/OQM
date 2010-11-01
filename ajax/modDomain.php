<?php	
	require_once('../includes/initialize.php');
	$oid=$_GET['o'];
	$para=$_GET['v'];
	$tdid=$_GET['i'];
	$tdname=$_GET['t'];
	$tt = new Test();
	$tt->owner_id=$oid;
	$tt->testdomain_id=$tdid;
	$tt->testdomain_name=$tdname;
	if($para=='up')
		{
			$result=$tt->ChangeDomain($para);
			if($result)
				{
	?>	
    			<label style="color:#339900"><b><?php echo $tdname;?></b> was successfully updated.</label>
        <?php 
				}
				else
				{
		?>
				<label style="color:#FF0000">There was ab error in updating the category <?php echo $tdname;?></label>
         <?php 
		 		}
			}
			else if($para=='del')
			{
				$result=$tt->ChangeDomain($para);
				if($result)
				{
			?>
				<label style="color:#339900"><b><?php echo $tdname;?></b> was successfully deleted.</label>
             <?php 
			 	}
				else
				{
			?>
				<label style="color:#FF0000">There was ab error in deleting the category <?php echo $tdname;?></label>
            <?php 
				}
			}// end elseif
			?>
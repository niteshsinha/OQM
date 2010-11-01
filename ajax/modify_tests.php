<?php
$tdname=$_GET['tdname'];
$td_id=$_GET['td_id'];
$ow_id=$_GET['ow_id'];
?>
<input type="text" id="txtdomain" value="<?php echo $tdname; ?>" />
<input type="button" class="button orange" value="Update" onclick="changedomain(<?php echo $td_id;?>,document.getElementById("txtdomain"))"/>

<input type="text" value="<?php echo $tdname; ?>" disabled="disabled"/>
<input type="button" class="button orange" value="Delete" onclick="deldomain(<?php echo $td_id;?>)"/>


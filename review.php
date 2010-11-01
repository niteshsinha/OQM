<?php require_once("includes/initialize.php"); ?>
<?php
// For Pagination
//current page number($current_page)
$page=!empty($_GET['page'])?(int)$_GET['page']:1;
//records per page ($per_page)
$per_page=10;
//total record count ($total_count)
$count=count($_SESSION['fwd_array']);
$total_count=$count;
//array for questions

$ques_set=array();
$ques_ids=array();
$ques_ids=$_SESSION['fwd_array'];
$ques_status=$_SESSION['temp_status'];
/*echo "Status <br/>";
print_r($ques_status);
echo "<br/>";*/
$ques_options=$_SESSION['temp_options'];
$pg = new Pagination($page,$per_page,$total_count);
$tt = new Test();
if(isset($_SESSION['first_time']))
{
$tt->Review_Test();
}
else
{
unset($_SESSION['first_time']);
}
$ques_set=$tt->GetAllQues();

?>
    <table width="933" border="0" cellspacing="0" cellpadding="0" class="revtab">
    <?php 
			$check=($per_page*$page > $total_count) ? $total_count : $per_page*$page;
			for($i=$pg->offset();$i<$check;$i++)
			{
			$id=$ques_ids[$i];
		?>
  <tr>
    <td width="53"><?php echo $i+1; ?></td>
    <td width="687" ><?php echo $ques_set[$i];?></td>
    <td><input type="button" class="button orange" onClick="call_test(<?php echo $id;?>,'<?php echo $ques_options[$id]?>','<?php echo $ques_status[$id]?>')" value="Goto Question" /> </td>
    <?php
		
		if($ques_status[$id] == 'Answered'){$im="images/pass.png";}
		elseif($ques_status[$id] == 'Reviewed') {$im="images/cross.png";}
		else {$im="images/cross1.png";}
	?>
    <td width="129"><img src="<?php echo $im;?>" height="66" width="64">
  </tr>
  	<input type="hidden" readonly name="last_return_review_id" id="last_return_review_id" value=0 />
  	<input type="hidden" readonly name"review_status" id="review_status" value="<?php echo $ques_status[$id]?>" />
    <input type="hidden" readonly name"review_option" id="review_option" value="<?php echo $ques_options[$id]?>" />
  	<?php 
		}
	?>
</table>
  
  <div id="pagination" style="clear: both;">
<?php
	if($pg->total_pages() > 1) {
		
		if($pg->has_previous_page()) { ?>
    	<a href="javascript:void(0)" onClick="call_review('review.php?page=<?php echo $pg->previous_page();?>')"> &laquo; Previous</a> 
   		<?php } ?>

		<?php 
        for($j=1; $j <= $pg->total_pages(); $j++) {
			if($j == $page) {
			?>
			<span class="selected"><?php echo $j;?></span>
            <?php
			} else {
			?>
            	<a href="javascript:void(0)" onClick="call_review('review.php?page=<?php echo $j;?>')"> <?php echo $j;?> </a>
			<?php
			}
		}
		?>
		<?php 
		if($pg->has_next_page()) { ?>
			<a href="javascript:void(0)" onClick="call_review('review.php?page=<?php echo $pg->next_page();?>')"> Next &raquo;</a>
            <?php } ?>
<?php		
	}
?>
</div>

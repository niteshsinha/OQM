<?php require_once("includes/initialize.php"); ?>
<?php

$status=$_GET['a'];
$option=$_GET['b'];
$cid=$_GET['c'];
$last_return_ques_id=$_GET['d'];
$dir=$_GET['e'];
$end_test=$_GET['f'];
$given_qid=$_GET['g'];

$op=($given_qid!=-1)?$option: 'null';
$qid=($given_qid!=-1)?$given_qid: 'null';



$tt = new Test();
$tt->Conduct_test($status,$option,$cid,$last_return_ques_id,$dir,$end_test,$given_qid);

?>
	 <div id="change" >
         <form id="frm" name="frm" >
            <div class="topcol txtshd">
    			  <?php echo $tt->question;?>
   			</div>
   			 <div class="botmcol txtshd"> 
    			 <div class="radios" >
      				 
      				 <?php 
	   					foreach ($tt->options as $id => $value ) { ?>
        				<label> <input type="radio" name="RadioOptions" value="<?php echo $id ; ?>" id="RadioOptions" <?php if ($op==$id) echo "checked" ;?> >
        				 <?php echo $value ; ?>
      				 </label>
      				 <?php } ?><br />
<br />

       					<input type="hidden" name="last_return_ques_id" id="last_return_ques_id" value="<?php echo $tt->ques_id ; ?>"/>
                        <input type="hidden" name="cid" id="cid" value="<?php echo $tt->ques_id ; ?>"/>
    			 </div>
  			  </div>
          </form>    
    </div>
    	<div class="butns" align="right";>
   			 <form id="RC" name="RC" ><input type="checkbox" name="CheckReview" value="review" >Mark for Review <br/></form>
    		 <div class="prev" style="display:inline;"> <input class="button rosy" type="button" value="Previous" <?php if($_SESSION['ques_key']==0){echo "disabled";} else {echo "enabled"; }?> 	onClick="call_test('b','false','main');" /></div>
        	 <div class="nxt" style="display:inline; margin-left:5px;"> 
            		 <input class="button rosy" type="button" 
			 		<?php if($_SESSION['ques_key']==$_SESSION['ques_key_count']){?>
					value="Submit & Review" onClick="call_test('f','true','main');"
                    <?php }
			 		else 
			 		{ ?>
                    value="Next" onClick="call_test('f','false','main');"
					 <?php }?> 
              		/>
             </div>
          		 <div class="evl" style="display:inline; margin-left:5px; <?php if($_SESSION['ques_key']==$_SESSION['ques_key_count']){ echo "display:none;"; }?>"> 
                 <input class="button rosy" type="button" value="Review" onClick="call_review('review.php?page=1');"/>
                 
                 </div>
    	</div>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<?php require_once("includes/initialize.php"); ?>
<?php
$ctid=$_GET['c'];
$tname=urldecode($_GET['n']);
$tt = new Test();
$tt->Evaluate_test();
$tt->logarray;

$log = new Logs($_SESSION['owner_id'],$tname);
$filename="Current_test_".$ctid;
foreach ($tt->logarray as $val){
$log->write_logfile($filename,'Ques/Ans Log',$val,time());
}
$log->write_logfile($filename,'Test Ended',"User:{$_SESSION['uname']} has ended the Test.",time());
$log->write_logfile($filename,'Test Result',"Score : {$tt->score} with Questions Correct : {$tt->ques_correct} , Questions Incorrect : {$tt->ques_incorrect} and Questions Unanswered : {$tt->ques_unans}.",time());


?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Test Results</title>
<link rel="stylesheet" href="css/style_examinee.css" type="text/css">
	<script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/jquery.textshadow.js"></script>
    <script type="text/javascript" src="js/jquery.color.js"></script>
    <script>$(document).ready(function(){
  if ($.browser.msie) {
	  var sha = {
			x      : 0,
			y      : 0,
			radius : 2,
			color  : '#191919',
			opacity: 50
		};
  $(".txtshd").textShadow(sha);
  
}
else
{$("table").addClass("txtshd");}
})
	
</script>
<script>
$(document).ready(function(){
	$("table.revtab tr").hover(function() {
$(this).stop().animate({ backgroundColor: "#0077f0"}, "fast");
},function() {
$(this).stop().animate({ backgroundColor: "#4197ee"}, "slow");
});
})
</script>
</head>

<body>
<div class="block_header">
		<!--<div class="leftshadow" ></div>
        <div class="centerblock" ></div>
        <div class="rightshadow" ></div>-->   
           
</div>
<!--<div class="bottomshadow" ></div> -->
<div class="content">

	<div class="cnthead">
		<div class="txtshd">Results</div>
    	<div class="img_rt"><img src="images/document.png" height="100" width="100"></div>
	</div>
 <div class="wrap">    
    <table width="933" border="0" cellspacing="0" cellpadding="0" class="revtab">
  <tr>
    <td width="165">Marks Obtained</td>
    <td width="766"><?php echo $tt->score; ?></td>
    
  </tr>
  <tr >
    <td width="165">Questions Corrent</td>
    <td width="766"><?php echo $tt->ques_correct;?></td>
    
  </tr>
  <tr >
    <td width="165">Question Incorrect</td>
    <td width="766"><?php echo $tt->ques_incorrect;?></td>
    
  </tr>
   <tr >
    <td width="165">Question Unanswered</td>
    <td width="766"><?php echo $tt->ques_unans;?></td>
    
  </tr>
</table>

  </div>
</div>

<div class="footer">
	
      <ul>
      <li><a href="index.php">Home</a> </li>
        <li><a href="logout.php">Logout</a> </li>
       </ul> 
    
</div>
<div style=" display:none"><a href="http://apycom.com/"></a></div>
</body>
</html>

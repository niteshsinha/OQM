<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<?php require_once("includes/initialize.php"); ?>
<?php 

$ctid=$_GET['c'];
$tname=urldecode($_GET['n']);
$name=urlencode($tname);
if(!isset($_SESSION['test_duration']))
	{ 
	redirect_to("evaluate.php?n={$name}&c={$ctid}"); }
	
$test_duration=$_SESSION['test_duration'];
$h=(int)substr($test_duration,0,2);
$m=(int)substr($test_duration,strpos($test_duration,':')+1,2);
$s=(int)substr($test_duration,strrpos($test_duration,':')+1,2);

/*echo "TEST_DURATION : ".$test_duration."</br>";
echo "HOUR : ".$h."<br/>";
echo "MIN : ".$m."<br/>";
echo "SEC : ".$s."<br/>";*/
	
unset($_SESSION['test_duration']);
$tt = new Test();
$tt->Conduct_test('Unanswered',0,$ctid,0,'f','false',-1);

$log = new Logs($_SESSION['owner_id'],$tname);
$filename="Current_test_".$ctid;
$log->write_logfile($filename,'Test Started', "User:{$_SESSION['uname']} has started test of duration  :{$test_duration}.",time());
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Test Page</title>
<link rel="stylesheet" href="css/style_examinee.css" type="text/css">

	<script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/jquery.textshadow.js"></script>
    <script type="text/javascript" src="js/jquery.lwtCountdown-0.9.5.js"></script>
    <link rel="stylesheet" href="css/dark.css" type="text/css">
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
 <script language="javascript" type="text/javascript">
			jQuery(document).ready(function() {
	    $('#countdown_dashboard').countDown({
	        targetOffset: {
	            'day':      0,
	            'month':    0,
	            'year':     0,
	            'hour':     <?php echo $h;?>,
	            'min':      <?php echo $m;?>,
	            'sec':      <?php echo $s;?>
	        },
	        // onComplete function
	        onComplete: function() { 
							jQuery("#eve").submit();
							//document.body.innerHTML += '<form id="dynForm" action="evaluate.php?n=<php echo $name;?>&c=<php echo $ctid;?>" method="get"></form>';
							//document.getElementById("dynForm").submit();
			 }
	    });
	});
		</script>
<script type="text/javascript" language="javascript">
	function call_finishtest()
		{
			var res=confirm("Are you sure you want to Finish the Test");
										if(!res)
											return false;
											else
										document.forms["eve"].submit();
		}
</script>
<script language="javascript" type="text/javascript">
				
					function postRequest(strURL,end){
                    var xmlHttp;
                    if(window.XMLHttpRequest){ // For Mozilla, Safari, ...
                         var xmlHttp = new XMLHttpRequest();
                    }
                    else if(window.ActiveXObject){ // For Internet Explorer
                         var xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    xmlHttp.open('POST', strURL, true);
                    xmlHttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xmlHttp.onreadystatechange = function(){
                         if (xmlHttp.readyState == 4){
                              updatepage(xmlHttp.responseText,end);
                         }
                    }
                    xmlHttp.send(strURL);
               }
               function updatepage(str,end){
			   		if(end == 'false')
					{
			  		 document.RC.CheckReview.checked=false;
                    document.getElementById("wrap").innerHTML = str;
					}
					else if (end=='true')
					{
					call_review('review.php?page=1');
					}
					
               }
			   function call_review(loc)
			   		{
							var url = loc
                   			 postRequest(url,'false');	
					}
			   
			   function call_test(dir,end_test,loc)
			   {			            
						if(loc == 'main')
						{
							myOption = -1;
							for (i=document.frm.RadioOptions.length-1; i > -1; i--) 
								{
									if (document.frm.RadioOptions[i].checked) 
										{
											myOption = i; i = -1;
										}
								}
							if (myOption == -1) 
								{
									alert("You must select an Option.");
									return false;
								}
							else 
								{
									/*alert("You selected button number " + myOption
									+ " which has a value of "
									+ document.frm.RadioOptions[myOption].value);*/
									var a= "Answered";
									var b= document.frm.RadioOptions[myOption].value;
								}
					
								if(document.RC.CheckReview.checked==true)
								{
									var a="Reviewed";
								}
								/*if(end_test=='true')
									{
										var res=confirm("Are you sure you want to Finish the Test");
										if(!res)
											return false;
											}*/
											
							var g =-1;
							var e = dir;
							var d = document.getElementById("last_return_ques_id").value;
							var f = end_test;
							
							
						}
						else
							{
								var e='f';
								var g = dir;
								var a= loc;
								var b=end_test;
								var d = document.getElementById("last_return_review_id").value;
								var f= 'false';
							}	
							var c = <?php echo $_SESSION['ctest_id']; ?>;
							
					
					
					
					
					
					
					var url = "call_conducttest.php"
					url = url + "?a="+a
					url = url + "&b="+b
					url = url + "&c="+c
					url = url + "&d="+d
					url = url + "&e="+e
					url = url + "&f="+f
					url = url + "&g="+g
					
					
                    postRequest(url,f)	
								
               }
	
</script>

</head>

<body >
<div class="block_header">
		<!--<div class="leftshadow" ></div>
        <div class="centerblock" ></div>
        <div class="rightshadow" ></div>-->
        <div id="dblewrap">
        <!-- Countdown dashboard start -->
		<div id="countdown_dashboard">
   
			<div class="dash hours_dash">
				<span class="dash_title">hours</span>
				<div class="digit"><?=$date['hours'][0]?></div>
				<div class="digit"><?=$date['hours'][1]?></div>
			</div>

			<div class="dash minutes_dash">
				<span class="dash_title">minutes</span>
				<div class="digit"><?=$date['mins'][0]?></div>
				<div class="digit"><?=$date['mins'][1]?></div>
			</div>

			<div class="dash seconds_dash">
				<span class="dash_title">seconds</span>
				<div class="digit"><?=$date['secs'][0]?></div>
				<div class="digit"><?=$date['secs'][1]?></div>
			</div>

		</div>
		<!-- Countdown dashboard end -->   
         </div>  
</div>
<!--<div class="bottomshadow" ></div> -->
<div class="content">

	<div class="cnthead">
		<div class="txtshd">Welcome</div>
        
       
        
    	<div class="img_rt"><img src="images/todo.png" height="100" width="100"></div>
	</div>
 <div class="wrap" id="wrap">
	 <div id="change" >
         <form id="frm" name="frm" >
            <div class="topcol txtshd">
    			  <?php echo $tt->question;?>
   			</div>
   			 <div class="botmcol txtshd"> 
    			 <div class="radios" >
      				 
      				 <?php 
	   					foreach ($tt->options as $id => $value ) { ?>
        				<label> <input type="radio" name="RadioOptions" value="<?php echo $id ; ?>" id="RadioOptions" >
        				 <?php echo $value ; ?>
      				 </label>
      				 <?php } ?><br>
<br>

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
  </div>
  <div style="float:right; margin-bottom:30px; margin-right:17px;">
  <form id="eve" name="eve"  action="evaluate.php?n=<?php echo urlencode($tname);?>&c=<?php echo $ctid;?>" method="post">
  	<input type="button" class="button blue" onClick="call_finishtest();" name="evaluate" id="evaluate" value="Evaluate" />
  </form>
  </div>
  
</div>

<div class="footer"> 
	
      <ul>
        <li><a href="logout.php">Logout</a> </li>
       </ul> 
    
</div>
<div style=" display:none"><a href="http://apycom.com/"></a></div>
</body>
</html>

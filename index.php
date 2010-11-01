<?php require_once("includes/initialize.php"); 
if (!$session->is_logged_in()) { redirect_to("login.php"); }
// For Pagination
//current page number($current_page)
$page=!empty($_GET['page'])?(int)$_GET['page']:1;
//records per page ($per_page)
$per_page=10;
//total record count ($total_count)
$total_count=0;

$user=User::select_user_details($session->user_id);
$test=new Test();
$total_count=$test->test_record_count($_SESSION['owner_id'],$_SESSION['uname']);
$pagination = new Pagination($page,$per_page,$total_count);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Profile Page</title>
<link rel="stylesheet" href="css/style_examinee.css" type="text/css">
	<link type="text/css" href="css/menu.css" rel="stylesheet" >
    <link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css" media="screen" charset="utf-8" />
           <link rel="stylesheet" href="css/modalbox.css" type="text/css" />
       <script type="text/javascript" src="js/prototype.js"></script>
	   <script type="text/javascript" src="js/scriptaculous.js"></script>

	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/menu.js"></script>
    <script type="text/javascript" src="js/jquery.textshadow.js"></script>
   	<script type="text/javascript" src="js/modalbox.js"></script>
    <script src="js/jquery.validationEngine-en.js" type="text/javascript"></script>
    <script src="js/jquery.validationEngine.js" type="text/javascript"></script>
    <script>$(document).ready(function(){
	var $j = jQuery.noConflict();
  if ($.browser.msie) {
	  var sha = {
			x      : 0,
			y      : 0,
			radius : 2,
			color  : '#191919',
			opacity: 50
		};
  $j(".txtshd").textShadow(sha);
}
})
	
</script>
<script type="text/javascript" language="javascript">
function postRequest(strURL){
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
                              updatepage(xmlHttp.responseText);
                         }
                    }
                    xmlHttp.send(strURL);
               }
               function updatepage(str){
						document.getElementById("change").innerHTML = str;
						}
				function authenticate(id,name)
					{
						var url="authenticatetest.php";
						url = url + "?tid="+id;
						url = url + "&tname="+name;
						postRequest(url);
					}
</script>
<script type="text/javascript" language="javascript">
function CheckData(){
if(document.getElementById("username").value=="")
	{
	alert ("Enter a username");
	return false;
	}
	else if(document.getElementById("password").value=="")
	{
	alert ("Enter a password");
	return false;
	}
var a=document.formID.myselect.selectedIndex;
myValue=document.formID.myselect.options[a].value;
	if(myValue==0)
	{
	alert ("Please select Question Level.");
	return false;
	}
	//else
	//return myValue;
}
</script>
</head>

<body>
<div class="block_header">
		<!--<div class="leftshadow" ></div>
        <div class="centerblock" ></div>
        <div class="rightshadow" ></div>-->      
</div>
<!--<div class="bottomshadow" ></div> -->
<div id="menu">

		<ul class="menu">
			<li><a href="index.php"><span>Home</span></a></li>
			<li><a href="#"><span>Profile</span></a>
			  <div><ul>
					<li><a href="#"  onClick="Modalbox.show('profile.php?record=<?php echo $_SESSION['user_id'];?>',{title: 'Profile Details', width:500, overlayClose: false});" ><span>View Profile</span></a></li>
					<li><a href="editpro.php?record=<?php echo $_SESSION['user_id'];?>" title="Edit Profile" onclick="return GB_showPage('Edit Profile',this.href)"><span>Edit Profile</span></a></li>
                    
				</ul></div>
			</li>
		 
            <li class="last"><a href="logout.php"><span>Logout</span></a></li>

		</ul>

	</div>
 

<div class="content">
			<div class="cnthead">
				<div class="txtshd">Welcome <?php echo $user->fullname;?></div>
    			<div class="img_rt"><img src="images/home.png" height="100" width="100"></div>
			</div>
 		<div class="wrap">    
    			<div class="leftcol">
    				<ul>
      		<?php
				
	  			$total_tests=$test->list_tests($_SESSION['owner_id']);	
				foreach ($total_tests as $tt)
				{
			?>
            			<li>
        <a href="javascript: authenticate(<?php echo $tt->test_id; ?>,'<?php echo $tt->test_name; ?>');" > <?php echo $tt->test_name; ?> </a>     					</li>
            	<?php
				}
	  			?>
      				</ul>
    			</div>
    			<div class="rightcol">
                <div id="change"><!-- this is to load ajax page when required-->

     				<p class="name" style="margin-top:-2px;"><span class="txtshd"><?php echo $user->fullname; ?></span ></p>
    <?php
		$test_record=$test->last_test_record($_SESSION['owner_id'],$_SESSION['uname'],$per_page,$pagination->offset());
		if($test_record){
		echo '<table class="records">';
 echo "<tr style='font-size:18px;' align='center'><td>Previous Records:</td><td></td><td></td></tr>";
 echo "<tr>";
 echo "<th>";
 echo "Course";
 echo "</th>";
 echo "<th>";
 echo "Date Of Test";
 echo "</th>";
 echo "<th>";
 echo "Score Obtained";
 echo "</th>";
  echo "<th>";
 echo "Questions Correct";
 echo "</th>";
  echo "<th>";
 echo "Questions Incorrect";
 echo "</th>";
 echo "</tr>";
		foreach($test_record as $tr)
			{
			?>
            <tr >
            <td style="width:140px;"><?php echo $tr->test_name; ?></td>
            <td style="text-align:center" ><?php echo date('j M,Y',strtotime($tr->last_time_log)); ?></td>
            <td style="text-align:center" ><?php echo $tr->score; ?></td>
            <td style="text-align:center" ><?php echo $tr->ques_correct; ?></td>
            <td style="text-align:center"><?php echo $tr->ques_incorrect; ?></td>
            <?php
			}?>
            
            </tr>
            </table>
            <?php
			}
			else
			{
			 echo '<table class="records">';
	 echo "<tr height=\"80\">";
	 echo "<td>";
	echo "<img src=\"images/cross.png\" height=\"69\" width=\"64\" style=\"margin-top:10px;\"><div style=\"margin-top:-85px; margin-left:80px; line-height:1.8em;\"> You Have Not Given Any Test Yet  !!";
	echo "<br>We Have No Records Of Your Test Scores.<br>Why Don't you Try Any Of Test Listed On The Left Side.</div>  ";
	echo "</td>";
echo "</tr>";
echo "</table>";
			}
	?>
    <div id="pagination" style="clear: both;">
<?php
	if($pagination->total_pages() > 1) {
		
		if($pagination->has_previous_page()) { 
    	echo "<a href=\"index.php?page=";
      echo $pagination->previous_page();
      echo "\">&laquo; Previous</a> "; 
    }

		for($i=1; $i <= $pagination->total_pages(); $i++) {
			if($i == $page) {
				echo " <span class=\"selected\">{$i}</span> ";
			} else {
				echo " <a href=\"index.php?page={$i}\">{$i}</a> "; 
			}
		}

		if($pagination->has_next_page()) { 
			echo " <a href=\"index.php?page=";
			echo $pagination->next_page();
			echo "\">Next &raquo;</a> "; 
    }
		
	}

?>
</div><!-- div pagination closed-->
		</div><!--div change closed -->
    </div><!-- div rightcol closed-->
  </div><!-- div wrap closed-->
</div><!-- div content closed-->

<div class="footer">
	
     <ul>
    	<li><a href="index.php">Home</a> </li>
        <li><a href="#" onClick="Modalbox.show('profile.php?record=<?php echo $_SESSION['user_id'];?>',{title: 'Profile Details', width:500, overlayClose: false});" >Profile</a> </li>
        <li><a href="logout.php">Logout</a></li>
       </ul>  
    
</div>
<div style="display:none"><a href="http://apycom.com/"></a></div>
</body>
</html>


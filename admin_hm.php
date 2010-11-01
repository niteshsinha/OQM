<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<?php require_once("includes/initialize.php"); ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Profile Page</title>
<link rel="stylesheet" href="css/style_examinee.css" type="text/css">
<link rel="stylesheet" href="css/modalbox.css" type="text/css" />
<link type="text/css" href="css/menu.css" rel="stylesheet" >
<link rel="stylesheet" type="text/css" href="css/jquery.jgrowl.css"/>
<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css" media="screen" charset="utf-8" />
<!-- start -->
<script type="text/javascript">
   var GB_ROOT_DIR = "greybox/";
</script>
<script type="text/javascript" src="greybox/AJS.js"></script>
<script type="text/javascript" src="greybox/AJS_fx.js"></script>
<script type="text/javascript" src="greybox/gb_scripts.js"></script>
<link href="greybox/gb_styles.css" rel="stylesheet" type="text/css" />
<!-- end -->


<script type="text/javascript" src="js/jquery-1.4.2.js"></script>
<script src="js/jquery.jgrowl.js"></script>
<script type="text/javascript" src="js/jquery.textshadow.js"></script>
<script>
var $j= jQuery.noConflict();
$j(document).ready(function(){
                         if ($j.browser.msie) {
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


<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/accordian.pack.js"></script>

<script type="text/javascript" src="js/menu.js"></script>
<!-- end -->

 <script language="javascript" type="application/javascript">
 				function urlencode(str) {
return escape(str).replace(/\+/g,'%2B').replace(/%20/g, '+').replace(/\*/g, '%2A').replace(/\//g, '%2F').replace(/@/g, '%40');
}
				function doc(name){
				return urlencode(document.getElementById(name).value);
				}
					
				 function postRequest(strURL,fn_name){
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
                              updatepage(xmlHttp.responseText,fn_name);
                         }
                    }
                    xmlHttp.send(strURL);
               }
               function updatepage(str,fn_name){
			   		
					if (fn_name=='show_addDomain')
						{
						document.getElementById("change").innerHTML = str;
						}
					else if(fn_name=='show_modify' || fn_name=='show_delete')
						{
						document.getElementById("change").innerHTML = str;
						document.getElementById("hide_list").style.display='none';
						}
					else if(fn_name=='addDomain')
						 {
						 document.getElementById("addDomain").innerHTML = str;
						 ajax_call('listTestDomain');
						 }
					else if(fn_name=='listTestDomain')
						 document.getElementById("listTestDomain").innerHTML = str;
					else if(fn_name=='addTest'){
						document.getElementById("change").innerHTML = str;
						}
					else if(fn_name=='addTestInfo')
						document.getElementById("change").innerHTML = str;
					else if(fn_name=='addQuesDirectly'){
						document.getElementById("change").innerHTML = str;
						document.getElementById("hide_list").style.display='none';
						}
					else if(fn_name=='listTestNames')
						document.getElementById("testnames_div").innerHTML = str;
					else if(fn_name=='insert_ques')
						document.getElementById("q_inserted").innerHTML = str;
						
               }
			   
			   function ajax_call(fn_name)
			   {			            
					if(fn_name=='show_addDomain')
					{
						postRequest('ajax/show_addDomain.php',fn_name);
					}
					else if(fn_name=='show_modify')
					{
						postRequest('ajax/show_modify.php',fn_name);
					}	
					else if(fn_name=='show_delete')
					{
						postRequest('ajax/show_delete.php',fn_name);
					}
					else if(fn_name=='addDomain')
					{	
						var d=document.getElementById("txtDomain").value
						if(d=='')
							{
							alert ("No value entered");
							return false
							}
						document.getElementById("txtDomain").value="";
						var url="ajax/addDomain.php";
						url = url + "?d="+d
						postRequest(url,fn_name)
					}
					else if(fn_name=='listTestDomain')
						{
							document.getElementById("hide_list").style.display='block';
							//var oid=<php echo $_SESSION['owner_id'];?>;
							var oid=1;
							var url="ajax/listTestDomain.php";
							url = url + "?oid="+oid;
							postRequest(url,fn_name);
						}
						
								
               }
			   
			   function addTestInfo(val)
					{
						if(document.getElementById("txttestname").value==""){
						alert("Enter the Test Name.");
						document.getElementById("txttestname").focus();
						return false
							}
						else if(document.getElementById("txtqno").value=="" || isNaN(document.getElementById("txtqno").value)){
						alert("Enter valid value for number of questions.");
						document.getElementById("txtqno").focus();
						return false
							}
						else if(document.getElementById("hrs").value=="" || isNaN(document.getElementById("hrs").value)){
						alert("Enter valid value for Hours.");
						document.getElementById("hrs").focus();
						return false
						}
						else if(document.getElementById("mins").value==""|| isNaN(document.getElementById("mins").value)){
						alert("Enter valid value for Minutes.");
						document.getElementById("mins").focus();
						return false
						}
						else if(document.getElementById("secs").value==""|| isNaN(document.getElementById("secs").value)){
						alert("Enter valid value for Seconds.");
						document.getElementById("secs").focus();
						return false
						}
						var url="ajax/addQues.php";
						url = url + "?tname="+document.getElementById("txttestname").value;
						url = url + "&qno="+document.getElementById("txtqno").value;
						url = url + "&time="+document.getElementById("hrs").value+":"+document.getElementById("mins").value+":"+document.getElementById("secs").value;
						url = url + "&ow_id="+document.getElementById("owner_id").value;
						if(val=='**novalue**')
						url = url + "&td_id="+document.getElementById("testdomain_id").value;
						else
						url = url + "&td_id="+val;
						postRequest(url,'addTestInfo');
					}
					
			   function addTest(id,name)
					{
						var url="ajax/addtest.php";
						if(id!='' && name!=''){
						url = url + "?did="+id;
						url = url + "&dname="+name;
						}
						postRequest(url,'addTest');
					}
				
					
				function gettestnames(id,oid,tname)
					{
						var url="ajax/listTestNames.php";
						url = url + "?td_id="+id;
						url = url + "&ow_id="+oid;
						url = url + "&tname="+tname;
						postRequest(url,'listTestNames');
					}
				function addQuesDirectly()
					{
					//var oid=<php echo $_SESSION['owner_id'];?>;
					var oid=1;
					var url="ajax/addQues.php";
					url = url + "?ow_id="+oid;
					postRequest(url,'addQuesDirectly');
					}
				function call_addtest()
					{
					
					
					
					}

	
</script>
<script type="text/javascript" language="javascript">
function gettid(mySelect)
	{
	myIndex=mySelect.selectedIndex;
	myValue=mySelect.options[myIndex].value;
	return myValue;
	}
</script>
<script type="text/javascript" language="javascript">
function gettidval(){
var a=document.frm.myselect.selectedIndex;
myValue=document.frm.myselect.options[a].value;
	return myValue;
}
</script>
<script type="text/javascript" language="javascript">
function ValidateSubmit()
	{
	if(document.getElementById("taques").value==''){
		alert ("Enter a Question.");
		document.getElementById("taques").focus();
		return false;
		}
	else if(document.getElementById("txtop1").value=='' || document.getElementById("txtop2").value=="" || document.getElementById("txtop3").value=="" || document.getElementById("txtop4").value==""){
		alert ("Enter all options.");
		return false;
		}
	else if(document.getElementById("txtmarks").value==""){
		alert("Enter marks.");
		document.getElementById("txtmarks").focus();
		return false;
		}
	else if (isNaN(document.getElementById("txtmarks").value)){
		alert ("Enter a numeric value for marks.");
		document.getElementById("txtmarks").focus();
		return false;
		}
					myOption = -1;
							for (i=document.frm.RG.length-1; i > -1; i--) 
								{
									if (document.frm.RG[i].checked) 
										{
											myOption = i; i = -1;
										}
								}
							if (myOption == -1) 
								{
									alert("You must select an Option.");
									return false;
								}
					if(document.frm.myselect.options[document.frm.myselect.selectedIndex].value=='0'){
					alert ("Select Defficulty Level");
					return false;
					}
					
					var url="ajax/insert_ques.php";
						url = url + "?tques="+doc("taques");
						url = url + "&marks="+doc("txtmarks");
						url = url + "&ans="+document.frm.RG[myOption].value;
						url = url + "&dl="+document.frm.myselect.options[document.frm.myselect.selectedIndex].value;
						url = url + "&op1="+doc("txtop1");
						url = url + "&op2="+doc("txtop2");
						url = url + "&op3="+doc("txtop3");
						url = url + "&op4="+doc("txtop4");
						url = url + "&tdid="+document.frm.td_select.options[document.frm.td_select.selectedIndex].value;
						url = url + "&tid="+document.frm.tid_select.options[document.frm.tid_select.selectedIndex].value;
						postRequest(url,'insert_ques');
					
		}
		

</script>

<style type="text/css">

#basic-accordian{
	border:1px solid #00e4f8;
	background:#4197ee;
	clear: both;
	-moz-box-shadow:0px 0px 15px #000;
	-webkit-box-shadow:0px 0px 15px #000;
	box-shadow:0px 0px 15px #000;
	padding:5px;
	width:900px;
	overflow: auto;
	height:500px;
	
}

.accordion_headings{
	padding:5px;
	background:#99CC00;
	color:#FFFFFF;
	border:1px solid #FFF;
	cursor:pointer;
	font-weight:bold;
}

.accordion_headings:hover{
	background:#00CCFF;
}

.wrap{
	width: 900px;
	
}

.accordion_child{
	padding:15px;
	background:#EEE;
	background:#51a6e6 url(images/bg_top.jpg) repeat-x top ;
	width:870px;
	overflow: auto;
}

.header_highlight{
	background:#00CCFF;
}

.tab_container *{
	float:left;
	width:288px;
}

</style>
<style type="text/css">
.usrlst th
{
	border:border:1px solid #e5e5e5;
}
.usrlst td
{
	border:1px solid #e5e5e5;
}

.usrlst
{
	width:100%;
}
</style>
</head>

<body onload="new Accordian('basic-accordian',5,'header_highlight');ajax_call('listTestDomain');">
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
		<div class="txtshd">Welcome <?php echo $_SESSION['uname']?></div>
    	<div class="img_rt"><img src="images/home.png" height="100" width="100"></div>
	</div>
 <div class="wrap">     
    
      <div id="basic-accordian" style="font-family: Arial, Helvetica, sans-serif;font-size: 11px;margin:10px;" ><!--Parent of the Accordion-->
			<div class="tab_container">
 				<div id="test1-header" class="accordion_headings header_highlight">Manage Users</div>
 				<div id="test2-header" class="accordion_headings" >Manage Tests</div>
 				<div id="test3-header" class="accordion_headings" >Manage Reports</div>
			</div>

					<div style="float:left;">
 						 <div id="test1-content">
							<div class="accordion_child">
   
   							</div>
 						 </div>
  
 						 <div id="test2-content">
							<div class="accordion_child">
								<?php include_once('manage_tests.php');?>
                   
                    
  							</div>
 			 			</div>
  
                        <div id="test3-content">
							<div class="accordion_child"> 
                    				
							</div>
                        </div>
					</div><!-- div float:left is closed here-->
        		<div style="clear:both;"></div><!--div added to clear floats-->
			</div><!--End of accordion parent-->
    </div><!--div end of wrap-->
    <div style="clear:both;"></div><!--div added to clear floats-->
</div>

<div class="footer">
	
      <ul>
    	<li><a href="#">Home</a> </li>
        <li><a href="#">Profile</a> </li>
        <li><a href="#">Score Analysis</a> </li>
        <li><a href="#">Log</a> </li>
        <li><a href="#">Logout</a></li>
       </ul> 
    
</div>
<div style=" display:none"><a href="http://apycom.com/"></a></div>
</body>
</html>

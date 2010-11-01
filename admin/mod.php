<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<?php require_once("../includes/initialize.php"); ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Administration</title>
<!-- new stylesheet-->
<link href="../style/style.css" type="text/css" rel="stylesheet" media="screen">


<script type="text/javascript" src="../js/jquery.js"></script>
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
			   		if(fn_name=='modDomain')
						{
						document.getElementById("result").innerHTML = str;
						document.getElementById("result").style.display='block';
						document.getElementById("txttdname").value ='';
						listTestDomain('mod');
						}
					else if(fn_name=='show_modDomain')
						{
						document.getElementById("change").innerHTML = str;
						document.getElementById("hide_list").style.display='block';
						listTestDomain('mod');
						}
					
					// not req below is copied from previous page
					else if(fn_name=='addDomain')
						 {
						 document.getElementById("result").style.display='block';
						 document.getElementById("result").innerHTML = str;
						 listTestDomain('add');
						 }
					else if(fn_name=='listTestDomain')
						 document.getElementById("listTestDomain").innerHTML = str;
						 
					else if(fn_name=='addTest'){
						document.getElementById("hide_list").style.display='block';
						document.getElementById("result").style.display='none';
						document.getElementById("change").innerHTML = str;
						}
					else if(fn_name=='addTestInfo'){
						document.getElementById("hide_list").style.display='none';
						document.getElementById("hide_list").style.display='none';
						document.getElementById("change").innerHTML = str;
						}
					else if(fn_name=='addQuesDirectly'){
						document.getElementById("hide_list").style.display='none';
						document.getElementById("change").innerHTML = str;
						}
					else if(fn_name=='listTestNames'){
						document.getElementById("testnames_div").innerHTML = str;
						}
					else if(fn_name=='insert_ques'){
						document.getElementById("result").style.display='block';
						document.getElementById("result").innerHTML = str;
						clearquesvalues();
						}
					else if(fn_name=='modify_domainSub'){
						document.getElementById("change").innerHTML = str;
						}

					
						
               }
			   
			   function ajax_call(fn_name)
			   {			            
					if(fn_name=='showadd')
					{
						document.getElementById("addcontent").style.display='table';
						document.getElementById("modcontent").style.display='none';
						listTestDomain('add');
					}
					else if(fn_name=='showmod')
					{
						document.getElementById("addcontent").style.display='none';
						document.getElementById("modcontent").style.display='table';
						listTestDomain('mod');
						ajax_call('show_modDomain');
					}
					
					else if(fn_name=='show_modDomain')
					{
						postRequest('../ajax/show_modDomain.php',fn_name);
					}
					else if(fn_name=='show_modify')
					{
						postRequest('../ajax/show_modify.php',fn_name);
					}	
					else if(fn_name=='show_delete')
					{
						postRequest('../ajax/show_delete.php',fn_name);
					}
					else if(fn_name=='addDomain')
					{	
						var d=doc("txtDomain");
						if(d=='')
							{
							alert ("No value entered");
							return false
							}
						document.getElementById("txtDomain").value="";
						var url="../ajax/addDomain.php";
						url = url + "?d="+d
						postRequest(url,fn_name)
					}
						
								
               }
			   function listTestDomain(val){
			   			document.getElementById("hide_list").style.display='block';
							//var oid=<php echo $_SESSION['owner_id'];?>;
							var oid=<?php echo $_SESSION['owner_id']?>;
							var url="../ajax/listTestDomain.php";
							url = url + "?oid="+oid;
							url = url + "&p="+val;
							postRequest(url,'listTestDomain');
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
						var url="../ajax/addQues.php";
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
						var url="../ajax/addtest.php";
						if(id!='' && name!=''){
						url = url + "?did="+id;
						url = url + "&dname="+name;

						}
						postRequest(url,'addTest');
					}
				
					
				function gettestnames(id,oid,tname)
					{
						var url="../ajax/listTestNames.php";
						url = url + "?td_id="+id;
						url = url + "&ow_id="+oid;
						url = url + "&tname="+tname;
						postRequest(url,'listTestNames');
					}
				function modifytest(id,cname,oid)
					{
						var url="../ajax/modify_domainSub.php";
						url = url + "?td_id="+id;
						url = url + "&tdname="+urlencode(cname);
						url = url + "&ow_id="+oid;
						postRequest(url,'modify_domainSub');
					}
				function addQuesDirectly()
					{
					//var oid=<php echo $_SESSION['owner_id'];?>;
					var oid=1;
					var url="../ajax/addQues.php";
					url = url + "?ow_id="+oid;
					postRequest(url,'addQuesDirectly');
					}
				function ShowValMod(id,tname,oid)
					{
						document.getElementById("txttdname").value=tname;
						document.getElementById("hidtdid").value=id;
						document.getElementById("hidoid").value=oid;
					}
				

	
</script>
<script type="text/javascript" language="javascript">
function gettid(mySelect)
	{
	myIndex=mySelect.selectedIndex;
	myValue=mySelect.options[myIndex].value;
	return myValue;
	}
function gettname(mySelect)
	{
	myIndex=mySelect.selectedIndex;
	myValue=mySelect.options[myIndex].text;
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
					
					var url="../ajax/insert_ques.php";
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

		function clearquesvalues()
					{
					document.getElementById("taques").value='';
					document.getElementById("txtop1").value='';
					document.getElementById("txtop2").value='';
					document.getElementById("txtop3").value='';
					document.getElementById("txtop4").value='';
					document.getElementById("txtmarks").value="";
					}

</script>
<script type="text/javascript" language="javascript">	
function ChangeDomain(val)
	{
		var t= doc('txttdname');
		var i=document.getElementById("hidtdid").value;
		var o=document.getElementById("hidoid").value;
		if (i=='' || o=='' || t=='')
			{
				alert ("Select an appropriate Category From the Dropdown List.");
				return false;
			}
		if(val=='del')
			{
				var con=confirm("All the Tests and Questions Under category " + t + " will be Deleted. Are you sure?");
				if(!con)
					return false;
			}
		var url="../ajax/modDomain.php";
		url = url + "?t="+t;
		url = url + "&i="+i;	
		url = url + "&o="+o;
		url = url + "&v="+val;
		postRequest(url,'modDomain');
	}
function modTest()
	{
	document.getElementById("change").style.display='none';
	document.getElementById("result").style.display='none';
	listTestDomain('test');
	}
function ShowValTest(id,oid)
	{
		var url="../ajax/listTestNames.php";
		url = url + "?td_id="+id;	
		url = url + "&ow_id="+oid;
		url = url + "&val="+'mod';
		postRequest(url,'listTestNames');
	}
</script>
</head>

<body>
<div id="menu_wrap">
	<div style="width:960px; margin: 0 auto; background:#e9e6e6; height: 10px;">
    	<!--div added to creat the top 10 px space-->
    </div>
	<div id="menu">
    	<ul>
          	<li><a href="adm_index.php">Admin Home</a></li>
            <li><a href="profile.php?record=<?php echo $_SESSION['user_id'];?>">View Profile</a></li>
            <li><a href="editpro.php?record=<?php echo $_SESSION['user_id'];?>">Edit Profile</a></li>
            <li><a href="logout.php">Logout</a></li>
 		</ul>
    </div><!-- div menu closed-->
</div><!--div menu_wrap closed -->

<div id="wrapper">
	<div id="content_wrap">
    	<div id="header">
        	<p>Welcome <?php echo $_SESSION['uname'];?></p>
        </div><!-- div header closed-->
        <div id="sub_menu" style="padding-top:10px;">
        	<table style="text-align:center; width:100%;" class="surround2" >
	<tr>
    	<td>
        	<form action="mu.php" method="post">
        	<input type="submit" class="button white medium" id="btnusr" name="btnusr" value="Manage Users"/>
            </form>
        </td>
    	<td>
        	<form action="add.php" method="post">
        	<input type="submit" class="button white medium" id="btnadd" name="btnadd" value="Add Content"/>
            </form>
        </td>
    	<td>
        	<form action="mod.php" method="post">
        	<input type="submit" class="button gray medium" id="btnmod" name="btnmod" value="Modify Content" />
            </form>
        </td>
        <td>
        	<form action="disp.php" method="post">
        	<input type="submit" class="button white medium" value="Display Reports"/>
            </form>
        </td>
    </tr>
</table>
                    
        </div><!-- this div fir for that main menu.. it is between left and right bar and inside content wrap.-->
        

<!-- no need of the leftbar so not using it.-->

 <div id="rightbar">
        	<!--
            	width of right bar = 940 - ((width of left bar) + 12 + 30)
                if width of left bar = 0 the delete the following text <<< style="width: 704px;" >>> 
                from the rightbar div to get 100% rightbar
            -->	
                                
<table id="addcontent" style="text-align:center; border-bottom:3px solid #333333;">
	<tr>
    	<td>
        	<input type="button" class="button blue medium" value="Edit/Delete Category" onClick="ajax_call('show_modDomain');" />
        </td>
        <td>
        	<input type="button" class="button blue medium" value="Edit/Delete Test" onClick="modTest()"/>
        </td>
        <td>
        	<input type="button" class="button blue medium" value="Edit/Delete Questions" onClick="addQuesDirectly()"/>
        </td>
    </tr>
</table>

<div id="contentval"><!-- this is the full content div to be updated on ajax call of the entire right container-->
    <table>
    	<tr>
        	<td>
			  <div id="hide_list">
                    		<div id="listTestDomain"></div>       
              </div><!-- this is to hide the list when needed-->
            </td>
            <td>
            		<div id="testnames_div">
                    </div>
     		 <td>
		 			 <div id="change"><!-- this is the div to be updated on ajax call of the  right container-->
                
                <label> Use the above buttons to Edit or Delete Categories , Tests or Questions.</label>
				          
                    </div><!-- this is end of change div-->
             </td>
         </tr>
           <tr>
            	<td> </td>
                <td colspan="2">
                	<div id="result"><!-- this is the result div to get the result of whatever processing is done. -->
                    	&nbsp;
                    </div>
                </td>
            </tr>        
       </table>   
        </div><!-- div contentval closed-->        
</div><!-- div rightbar closed-->
<div style="clear: both;"></div>
    </div><!-- div content_wrap closed -->
   &nbsp;
</div><!-- div wrapper closed --> 



</body>
</html>

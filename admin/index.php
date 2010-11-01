<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<?php require_once("../includes/initialize.php"); ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Administration</title>
<!-- new stylesheet-->
<link href="../style/style.css" type="text/css" rel="stylesheet" media="screen">


<script type="text/javascript" src="../js/jquery.js"></script>
</head>

<body onload="listTestDomain('add');">
<div id="menu_wrap">
	<div style="width:960px; margin: 0 auto; background:#e9e6e6; height: 10px;">
    	<!--div added to creat the top 10 px space-->
    </div>
	<div id="menu">
    	<ul>
          	<li><a href="../adm_index.php">Admin Home</a></li>
            <li><a href="../profile.php?record=<?php echo $_SESSION['user_id'];?>">View Profile</a></li>
            <li><a href="../editpro.php?record=<?php echo $_SESSION['user_id'];?>">Edit Profile</a></li>
            <li><a href="../logout.php">Logout</a></li>
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
        	<input type="submit" class="button gray medium" id="btnusr" name="btnusr" value="Manage Users"/>
            </form>
        </td>
    	<td>
        	<form action="add.php" method="post">
        	<input type="submit" class="button white medium" id="btnadd" name="btnadd" value="Add Content"/>
            </form>
        </td>
    	<td>
        	<form action="mod.php" method="post">
        	<input type="submit" class="button white medium" id="btnmod" name="btnmod" value="Modify Content" />
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
                    <table>
                    <tr>
                    	<td>
                        	<label class="heading">Real Time Statistics</label>
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
		  <div id="change"><!-- this is the div to be updated on ajax call of the  right container-->
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

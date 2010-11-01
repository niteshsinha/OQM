<script type="text/javascript" language="javascript">
function CheckData()
	{
	if(document.getElementById("taques").value==''){
		alert ("Enter a Question.");
		document.getElementById("taques").focus();
		return false;
		}
	else if(document.getElementById("txtmarks").value==""){
		alert("Enter marks.");
		document.getElementById("txtmarks").focus();
		return false;
		}
	else if (!isNaN(document.getElementById("txtmarks").value)){
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
							else 
								{
									alert("You selected button number " + myOption
									+ " which has a value of "
									+ document.frm.RG[myOption].value);
									var a= "Answered";
									var b= document.frm.RG[myOption].value;
								}
					if(document.frm.myselect.options[document.frm.myselect.selectedIndex].value=='0'){
					alert ("Select Defficulty Level");
					return false;
					}
					
		}
		

</script>


<form name="frm" id="frm">
<tr><td>Type The Question</td>
      <td colspan="4"><textarea name="taques" id="taques" cols="79" rows="5"></textarea></td>
    </tr>
    <tr><td>Type The Options For The Above Question</td>
      <td><input type="text" name="txtop1" id="txtop1"></td>
      <td><input type="text" name="txtop2" id="txtop2"></td>
      <td><input type="text" name="txtop3" id="txtop3"></td>
      <td><input type="text" name="txtop4" id="txtop4"></td>
    </tr>
    <tr><td>Choose The Correct Answer</td>
      <td>
      <label>
      <input type="radio" name="RG" value="radio" id="RadioGroup1_0">
      Option 1.</label></td>
      <td><label>
      <input type="radio" name="RG" value="radio" id="RadioGroup1_1">
      Option 2.</label></td>
      <td><label>
      <input type="radio" name="RG" value="radio" id="RadioGroup1_2">
      Option 3.</label></td>
      <td><label>
      <input type="radio" name="RG" value="radio" id="RadioGroup1_3">
      Option 4.</label></td>
    </tr>
     <tr align="right"><td>Difficulty Level</td>
      <td colspan="4">
      	<select name="myselect" id="myselect">
     		 <option value="0">Select</option>
 			 <option value="1">Beginner</option>
             <option value="2">Medium</option>
 			 <option value="3">Expert</option>
       </select>
      </tr>
     <tr align="right"><td>Marks</td>
      <td colspan="4"><input type="text" name="txtmarks" id="txtmarks"></tr>
    <tr align="right"><td></td>
      <td colspan="4"><input name="" type="button" value="Save" onclick="return ValidateSubmit()" ></td>
    </tr>
    </form>
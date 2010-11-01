var flag=true;

function validate()
{
	userchk();
	pwdchk();
	return flag;
}

function userchk()
{
	if(document.getElementById("usrnm").value==0)
	{
		alert("username cannot be empty");
		document.getElementById("usrnm").value="This Cannot Be Empty";
		flag=false;
	}
	else
	{
		if(document.getElementById("usrnm").value=="username")
		{
			alert("Username Field cannot be \" username \" ");
			flag=false;
		}
	}
}

function pwdchk()
{
	if(document.getElementById("paswd").value==0)
	{
		alert("password cannot be empty");
		flag=false;
	}
	else
	{
		if(document.getElementById("paswd").value=="password")
		{
			alert("Password Field cannot be \" password \" ");
			flag=false;
		}
	}
}

function cleard(id,value)
{
	
	if(document.getElementById(id).value=="This Cannot Be Empty")
	  {
		  document.getElementById(id).value=="";
	  }
	  else
	  {
		  document.getElementById(id).value=value;
	  }
	  
}
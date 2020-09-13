function isValidEmail(element)
{
	var x=document.getElementById(element).value;
	var atpos=x.indexOf("@");
	var dotpos=x.lastIndexOf(".");
	if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
	{
		alert("Not a valid e-mail address");
		return false;
	}
	
	return true;
}

function isNotEmpty(element)
{
	var x=document.getElementById(element).value;
	if(x.length > 0)
	{
		return true;
	}
	return false;
}

//Returns true if value is present in arr else false 
function isValueInArray(arr, value) 
{
	for (i = 0; i < arr.length; i++)
	{
		if (value == arr[i])
		{
			return true;
		}
	}
	return false;
}

//shows an element with id element if show == true else it is hidden
function showhide(element, show)
{
	if(show == true)
	{
		document.getElementById(element).style.display = "";
	}
	else
	{
		document.getElementById(element).style.display = "none";
	}
}

//enables an element with id element if enable == true else it is disabled
function enableDisable(element, enable)
{
	if(enable == true)
	{
		document.getElementById(element).disabled = false;
	}
	else
	{
		document.getElementById(element).disabled = true;
	}
}

// return the value of the radio button that is checked
// return an empty string if none are checked, or
// there are no radio buttons
function getCheckedRadiobuttonValue(radioObj) 
{
	if(!radioObj)
	{
		return "";
	}
	var radioLength = radioObj.length;
	if(radioLength == undefined)
	{
		if(radioObj.checked)
		{
			return radioObj.value;
		}
		else
		{
			return "";
		}
	}
	
	for(var i = 0; i < radioLength; i++) 
	{
		if(radioObj[i].checked) 
		{
			return radioObj[i].value;
		}
	}
	return "";
}
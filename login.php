<?php
$overskrift = "Login";
$hovertext = "'Login'";
$pagename = "Login";
include 'header.php';

//----------------- main content -------------------//

if (isset($_GET['url']))
{
    $url = $_GET['url'];
}

echo "<strong> For at oprette/redigere data i CafeBD skal du være logget ind.</strong> <br> <br>
	<table width='300' border='0' cellpadding='0' cellspacing='1' bgcolor='#CCCCCC'>
		<tr>
			<form name='form1' method='post' action='checklogin.php'>
			<td><table width='100%' border='0' cellpadding='3' cellspacing='1' bgcolor='#FFFFFF'>
				<tr>
					<td width='78'>Brugernavn:</td>
					<td width='294'><input name='myusername' type='text' id='myusername'></td>
				</tr>
				<tr>
					<td>Password:</td>
					<td><input name='mypassword' type='password' id='mypassword'></td>
				</tr>
				<tr>
					<td>&nbsp;</td><td>&nbsp;</td>
					<td><input type='submit' name='Submit' value='Login'></td>
				</tr>
			</table></td>
			</form>
		</tr>
	</table>";
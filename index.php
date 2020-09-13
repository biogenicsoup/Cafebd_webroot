<?php error_reporting (E_ALL ^ E_NOTICE);
	session_start();
	$overskrift = "Login til cafebd";
	$hovertext = "'CafeBD'";
	$pagename = "Main";	
	include 'header.php';
	
	//----------------- main content -------------------//

	if (isset($_GET['url'])) 
	{
		$url = $_GET['url'];
	}	
		
	echo "<strong> For at oprette/redigere data i CafeBD skal du være logget ind. Det er muligt at s&oslash;ge i databasen uden at være logget ind. </strong> <br> <br>";
	echo "<table width='300' border='0' cellpadding='0' cellspacing='1' bgcolor='#CCCCCC'>";
	echo "<tr>";
		//echo "<form name='form1' method='post' action='checklogin.php?url=" . $url . "'>";
		echo "<form name='form1' method='post' action='checklogin.php'>";
		echo "<td> <table width='100%' border='0' cellpadding='3' cellspacing='1' bgcolor='#FFFFFF'>";
			/* echo "<tr>";
				echo "<td colspan='3'><strong> For at oprette/redigere personer skal du være logget ind. Det er muligt at s&oslash;ge i databasen uden at være logget ind. </strong></td>";
			echo "</tr>"; */
			echo "<tr>";
				echo "<td width='78'>Brugernavn:</td>";
				//echo "<td width='6'>:</td>";
				echo "<td width='294'><input name='myusername' type='text' id='myusername'></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td>Password:</td>";
				//echo "<td>:</td>";
				echo "<td><input name='mypassword' type='password' id='mypassword'></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td>&nbsp;</td>";
				echo "<td>&nbsp;</td>";
				echo "<td><input type='submit' name='Submit' value='Login'></td>";
			echo "</tr>";
		echo "</table> </td>";
		echo "</form>";
	echo "</tr>";
	echo "</table>";

	include 'footer.php';
?>

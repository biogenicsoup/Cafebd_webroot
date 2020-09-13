<?php error_reporting (E_ALL ^ E_NOTICE);
	session_start();
	include 'header.php';
	
	//----------------- main content -------------------//

	session_destroy();
	echo "<table>";
		echo "<tr>";
			echo "<td> Du er nu logget ud. </td>";
		echo "</tr>";		
	echo "</table>";
	include 'footer.php';
?>
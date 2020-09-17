<?php
include 'defaults.php';
include 'session.php';
include 'header.php';

	session_destroy();
	echo "<table>";
		echo "<tr>";
			echo "<td> Du er nu logget ud. </td>";
		echo "</tr>";		
	echo "</table>";
	include 'footer.php';
?>
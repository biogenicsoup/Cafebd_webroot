<?php 
	session_start();
	include 'defaults.php';
	//----------------- main content -------------------//
	include 'connect.php';

/**
 * @var $con
 */

	if (isset($_GET['url'])) 
	{
		$url = $_GET['url'];
	}	

	// username and password sent from form
	$myusername=$_POST['myusername'];
	$mypassword=$_POST['mypassword'];

	// To protect MySQL injection (more detail about MySQL injection)
	$myusername = stripslashes($myusername);
	$mypassword = stripslashes($mypassword);
	$myusername = mysqli_real_escape_string($con, $myusername);
	$mypassword = mysqli_real_escape_string($con, $mypassword);

	$query="SELECT * FROM login WHERE username='" . $myusername . "' and password='" . $mypassword . "'";
	//echo $query . "<br>";
	$result=mysqli_query($con, $query);

	// Mysql_num_row is counting table row
	$count=mysqli_num_rows($result);
	// If result matched $myusername and $mypassword, table row must be 1 row

	if($count==1)
	{
		// Register $myusername, $mypassword and redirect to file 'oversigt.php'
		$_SESSION['myusername'] = $myusername;
		$_SESSION['mypassword'] = $mypassword;

		//if ($url)
		//{
		//	header('Location: $url');
		//}
		//else
		//{
			header('location:oversigt.php');
		//}
	}
	else 
	{
		$overskrift = "Login til CafeBD;";
		$hovertext = "'CafeBD'";
		$pagename = "Login";
		include 'header.php';
		echo 'Wrong Username or Password';
		include 'footer.php';
	}
	
	
?>

<?php

	function curPageURL()
		{
			$pageURL = 'http';
			if ($_SERVER["HTTPS"] == "on")
			{
				$pageURL .= "s";
			}
			$pageURL .= "://";
			if ($_SERVER["SERVER_PORT"] != "80")
			{
				$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
			}
			else
			{
				$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
			}
			return $pageURL;
		}

		function curPageName()
		{
			return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
		}

echo "<!DOCTYPE html>";
echo "<!--[if IE 8]><html lang='da' class='lt-ie9 ie8' id='ng-app' xmlns:ng='http://angularjs.org'><![endif]-->";
echo "<!--[if gte IE 9]><!-->";
echo "<html lang='da-DK' id='ng-app' xmlns:ng='http://angularjs.org'>";
echo "<!--<![endif]-->";
echo "<head>";


echo "    <title>Region Midtjylland </title>";
echo "    <meta property='og:title' content='Region Midtjylland' />";
echo "    <meta property='twitter:title' content='Region Midtjylland' />";
echo "    <meta name='date' content='2020-08-28T11:44:23.23Z' />";




echo "    <meta http-equiv='X-UA-Compatible' content='IE=edge' />";
echo "    <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1' />";

echo "    ";


echo "                    <meta name='Description' content='Region Midtjylland er en offentlig organisation med hovedopgaverne sundhed og hospitaler, specialiserede tilbud til socialt udsatte og handicappede og at v&#230;re politisk drivkraft for v&#230;kst gennem regional udvikling.' />";


echo "        <meta name='identifier-URL' content='https://www.rm.dk/'>";
echo "        <meta name='revised' content='28-08-2020 11:44:23' />";
echo "        <meta property='og:url' content='https://www.rm.dk/' />";

echo "            <meta property='og:description' content='Region Midtjylland er en offentlig organisation med hovedopgaverne sundhed og hospitaler, specialiserede tilbud til socialt udsatte og handicappede og at v&#230;re politisk drivkraft for v&#230;kst gennem regional udvikling.' />";
echo "            <meta property='twitter:card' content='summary_large_image' />";
echo "                    <meta property='og:image' content='https://www.rm.dk/siteassets/forside/rm_logo_1200x628.png' />";
echo "            <meta property='twitter:image' content='https://www.rm.dk/siteassets/forside/rm_logo_1200x628.png' />";






echo "    ";

echo "            <link rel='apple-touch-icon' href='https://www.rm.dk/globalassets/zdesign/midt_icon180.png'>";
echo "            <link rel='icon' type='image/png' href='https://www.rm.dk/globalassets/zdesign/midt_icon180.png' />";

echo "    <!--";


echo "    ";


echo "    ";

echo "-->";

echo "    <link href='https://www.rm.dk/Bundled/css/master.min.css?hash=ffb6c4e6824a1974610eb1cad6a4b761' rel='stylesheet' />";

echo "    ";
echo "    ";
echo "    <!--[if lt IE 10]>";
echo "        <script type='text/javascript' src='https://www.rm.dk/Resources/Scripts/Frameworks/Pie/PIE.js?hash=c15da940666362b333924a4cda28596a'></script>";
echo "    <![endif]-->";
echo "    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->";
echo "    <!--[if lt IE 9]>";
echo "        <script src='https://www.rm.dk/Bundled/js/legacy/modernizr.min.js?hash=93411880a3af87e6ba9d084651b7c817'></script>";
echo "        <script src='https://www.rm.dk/Bundled/js/legacy/html5shiv-printshiv.js?hash=d0d9a764f9d376be88401200ad930100'></script>";
echo "        <script src='https://www.rm.dk/Bundled/js/legacy/respond.min.js?hash=78915bb8b3dd6696d3842d82ed48b104'></script>";
echo "    <![endif]-->";

echo "<script id='Cookiebot' src='https://consent.cookiebot.com/uc.js' data-cbid='25925447-91d4-4601-899c-d8c623f49be1' type='text/javascript' data-blockingmode='auto'></script>";
echo "    <meta name='google-site-verification' content='6IeAzcTJ2kBrZ2Hnxjttlw3YgqlSEbec2FJf14GbiKg' />";

echo "<link href='https://www.rm.dk/globalassets/zdesign/hjemekstra.css' type='text/css' rel='stylesheet'/>";
echo "<meta http-equiv='Origin' content='http://www.rm.dk'>";

echo "<style>";

echo ".container-block .image-links-list .block-row:last-child .image-link-block {";
echo "margin-bottom: 0px !important;";
echo "}";



echo "</style>";

echo "<style>";

echo ".aside-right .container-content .block {";
echo "margin-left:0px;";

echo "}";

echo ".aside-right .container-content .row {";

echo "margin-left: 0px;";
echo "margin-right: 0px;";
echo "} ";

echo "</style>";

echo "    <!-- www.Cludo.com search start CSS -->";
echo "    <!-- www.Cludo.com search end CSS   -->";

echo "    ";
echo "</head>";
?>
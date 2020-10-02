<?php

/**
 * @hovertext
 * @overskrift
 * @pagename
 */
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"da\" lang=\"da\">\n";

echo "<head>\n";
echo "\t<meta http-equiv=\"Content-Type\" content=\"text/html; charset=ISO-8859-1\" />\n";
echo "\t<!--<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">-->\n";

echo "\t<!--<base href=\"http://www.person.au.dk/\" />-->\n";

echo "	<link rel=\"stylesheet\" type=\"text/css\" href=\"typo3temp/stylesheet_16f9e30c33.css?1322554569\" media=\"all\" />\n";
echo "	<link rel=\"stylesheet\" type=\"text/css\" href=\"http://cmsdesign.au.dk/design/2008/css/base.css\" media=\"all\" title=\"AU normal contrast\" />\n";
echo "	<link rel=\"alternate stylesheet\" type=\"text/css\" href=\"http://cmsdesign.au.dk/design/2008/css/base_contrast.css\" media=\"all\" title=\"AU high contrast\" />\n";
echo "	<link rel=\"stylesheet\" type=\"text/css\" href=\"http://cmsdesign.au.dk/design/2008/css/print.css\" media=\"print\" />\n";
echo "	<link rel=\"stylesheet\" type=\"text/css\" href=\"http://cmsdesign.au.dk/design/2008/css/siab.css\" media=\"all\" />\n";
echo "	<link rel=\"stylesheet\" type=\"text/css\" href=\"typo3conf/ext/au_config/css/au_typo3_shared.css?1327646727\" media=\"all\" />\n";
echo "	<link rel=\"stylesheet\" type=\"text/css\" href=\"http://cmsdesign.au.dk/design/2008/css/rgb.css\" media=\"all\" />\n";
echo "	<link rel=\"stylesheet\" type=\"text/css\" href=\"http://cmsenhed.au.dk/8000/css?locale=da_DK\" media=\"all\" />\n";
echo "	<link rel=\"stylesheet\" type=\"text/css\" href=\"http://cmsdesign.au.dk/design/2008/css/typo3.css\" media=\"all\" />\n";
echo "	<link rel=\"stylesheet\" type=\"text/css\" href=\"typo3conf/ext/perfectlightbox/res/css/slightbox.css?1316416574\" media=\"screen, projection\" />\n";
echo "	<link rel=\"stylesheet\" type=\"text/css\" href=\"typo3conf/ext/au_config/css/au_news.css?1327646727\" media=\"all\" />\n";
echo "	<link rel=\"stylesheet\" type=\"text/css\" href=\"typo3conf/ext/au_config/css/au_passata_rev2.css?1327646727\" media=\"all\" />\n";
echo "	<link rel=\"stylesheet\" type=\"text/css\" href=\"typo3conf/ext/au_config/css/au_comments.css?1327646727\" media=\"all\" />\n";
echo "	<link rel=\"stylesheet\" type=\"text/css\" href=\"typo3conf/ext/au_config/css/au_addthis.css?1327646727\" media=\"all\" />\n";
echo "	<link rel=\"stylesheet\" type=\"text/css\" href=\"typo3conf/ext/au_config/css/au_gsa.css?1327646727\" media=\"all\" />\n";
echo "	<link rel=\"stylesheet\" type=\"text/css\" href=\"typo3conf/ext/au_coursecatalog/Resources/Public/Css/CourseCatalog.css?1329901606\" media=\"all\" />\n";
echo "	<link rel=\"stylesheet\" type=\"text/css\" href=\"typo3conf/ext/peoplexs/Resources/Public/Css/PeopleXS.css?1328275080\" media=\"all\" />\n";
echo "	<link rel=\"stylesheet\" type=\"text/css\" href=\"typo3conf/ext/peoplexs/Resources/Public/Css/lib/jquery.jscrollpane.css?1328275080\" media=\"all\" />\n";
echo "	<link rel=\"stylesheet\" type=\"text/css\" href=\"typo3temp/stylesheet_b7ecf904d3.css?1322554569\" media=\"all\" />\n";
echo "	<link href=\"http://cmsdesign.au.dk/design/2008/graphics/favicon.ico\" rel=\"shortcut icon\" />\n";
echo "	<!--<meta content=\"AU normal contrast\" http-equiv=\"Default-Style\" />-->\n";
echo "	<link rel=\"stylesheet\" href=\"/fileadmin/templates/extensions/googlequery/au_gsa.css\" type=\"text/css\" media=\"all\" />\n";
echo "	<link rel=\"stylesheet\" href=\"typo3conf/ext/auidmcontent/pi1/idm.css\" type=\"text/css\" media=\"all\"/>\n";
echo "	<link rel=\"stylesheet\" href=\"typo3conf/ext/googlequery/pi1/res/css/autosuggest.css\" type=\"text/css\" media=\"screen\" charset=\"utf-8\" />\n";

echo "	<style type=\"text/css\">\n";
echo "		<!--#au_searchbox {visibility:hidden;}-->\n";
echo "		.treeTable { margin-left: 8px !important;\n";
echo "		@import url(http://www.au.dk/fileadmin/www.au.dk/personer_og_bygninger/form/jquery.treeTable.css);\n";
echo "		@import url(http://www.au.dk/typo3conf/ext/au_config/lib/maps/css/maps_styles.css);\n";
echo "	</style>\n";
echo "	<!--<link rel=\"schema.dc\" href=\"http://purl.org/metadata/dublin_core_elements\" />-->\n";
echo "	<script type=\"text/javascript\" src=\"scripts.js\"></script>\n";
echo "\n";

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

echo "</head>\n";

echo "<body class=\"au_layout_4\">\n";
echo "	<div id=\"au_wrapper\">\n";
echo "	<!-- header -->\n";

echo "		<div id=\"au_header\">\n";
echo "		<!-- headers -->\n";
echo "			<div id=\"au_header_top\">\n";
echo "				<img src=\"http://cmsenhed.au.dk/8000/png/da\" width=\"500\" id=\"fullres_header\" alt=\"\"/>\n";
echo "				<h1 id=\"au_primary_unit\">\n";
echo "					<a title=\"G&aring; til universitetets hjemmeside\" href=\"http://www.au.dk\">Aarhus Universitet</a>\n";
echo "				</h1>\n";
echo "				<h2 id=\"au_secondary_unit\"></h2>\n";
echo "				<h3 id=\"au_tertiary_unit\"></h3>\n";
echo "				<h4 id=\"au_quaternary_unit\">\n\n";

echo "				<a title=" . $hovertext . " href='/persondatabase/'>" . $overskrift. "</a>\n";
echo "				<title>" . $pagename . "</title>\n\n";

echo "			</div>\n";
echo "		<!-- headers end -->\n";
echo "		<!-- mainmenu -->\n";
echo "			<div id=\"au_header_nav\"></div>\n";
echo "		<!-- mainmenu end -->\n";

echo "		</div>\n";
echo "	<!-- header end -->\n";

echo "	<!-- contentwrap -->\n";
echo "		<div id=\"au_content_wrapper\">\n";
echo "		<!-- contentheader -->\n";
echo "		<!-- contentheader end -->\n";
echo "			<div id=\"au_content\">\n";
echo "				<div class=\"au_padding\">\n";
echo "				<!-- contentinner -->\n";
echo "					<div class=\"contentinner\">\n";


?>


<?php
$overskrift = "Suites";
$hovertext = "'Suites'";
$pagename = "Region Midt: Suites";

include_once 'header.php';
include_once 'banner.php';
//include 'components.php';
include_once 'mustbeloggedin.php';
include_once 'Views/viewSuite.php';
include_once 'classes/Product.php';
include_once 'Views/viewTestCase.php';

/**
 * @var $con
 */

echo "<link rel='stylesheet' href='http://lukasoppermann.github.io/html5sortable/basscss.css'>";
echo "<script src='js/html5sortable.js'></script>";

echo "<script>
	$( function() {
		$( '#accordion' )
			.accordion({
				header: '> div > h3 '
			})
	} );
	</script>";    

echo "
    <section class='mb3 mx-auto col col-12'>
        <div class='p3 bg-white orange col col-6'>
            <h2 class='h3 m0'>Træk en testcases over i en suite for at tilføje den. </h2>
                <div id='accordion' class='ui-accordion ui-widget ui-helper-reset ui-sortable' role='tablist'>";

$product = new Product($productid, $con);
foreach ($product->get_suites() as $suite)
{
    echo"
            <div class='group'>
                <h3>" . $suite->get_name() . "</h3>
                <div><p>Description: " . $suite->get_description() . "</p>
                <ul class='p2 border maroon border-maroon js-sortable-connected-" . $suite->get_id() . " list flex flex-column list-reset' id='".$suite->get_id()."' aria-dropeffect='move'>";
    foreach ($suite->get_testcases() as $testCase) {
        echo        "<li class='p1 mb1 white bg-blue js-handle px1' draggable='true' role='option' id='".$testCase->get_id()."' aria-grabbed='false'>".$testCase->get_name() ."</li>";
    }
    echo " 
                    <!--<li class='p1 mb1 white bg-white js-handle px1'draggable='true' role='option' aria-grabbed='false'>træk her hen</li>-->
                </ul>
                </div>
            </div>";
}
echo       "</div>
            <div>";
            echo draw_add_suite('addEditSuite.php', $productid, $con);
echo "      </div>
        </div>";
echo"
				
	<div class='p3 bg-orange white col col-6'>
            <ul class='js-sortable-testcases list flex flex-column list-reset' id='0' aria-dropeffect='move'>";
foreach ($product->get_testcases() as $testcase)
{
    echo "      <li class='p1 mb1 white bg-blue js-handle px1' draggable='true' role='option' id='".$testcase->get_id()."' aria-grabbed='false'>".$testcase->get_name()."</li>";                                 
}
echo "      </ul>";
            echo draw_add_testcase('addEditTestCase.php', $productid, $con);
echo "  </div>
    </section>";


echo "<script>";
        foreach ($product->get_suites() as $suite)
        {
            echo "sortable('.js-sortable-connected-".$suite->get_id()."', {
			forcePlaceholderSize: true,
			acceptFrom: '.js-sortable-testcases',
			handle: '.js-handle',
			items: 'li',
			placeholderClass: 'border border-white bg-orange mb1'
		});
            
                document.querySelector('.js-sortable-connected-".$suite->get_id()."').addEventListener('sortupdate', function(e){
			console.log('Sortupdate: ', e.detail);
			console.log('Container: ', e.detail.origin.container, ' -> ', e.detail.destination.container);
			console.log('Index: '+e.detail.origin.index+' -> '+e.detail.destination.index);
			console.log('Element Index: '+e.detail.origin.elementIndex+' -> '+e.detail.destination.elementIndex);
                        
                        var testcaseId = e.detail.item.id;
                        var originSuiteIid = e.detail.origin.container.id;
                        var destinationSuiteId = e.detail.destination.container.id;
                        
                        console.log('testcaseId: ',testcaseId);
                        console.log('originSuiteIid: ',originSuiteIid);
                        console.log('destinationSuiteId: ',destinationSuiteId);
                        
                        var params = 'testcaseId=' + testcaseId + '&originSuiteIid=' + originSuiteIid + '&destinationSuiteId=' + destinationSuiteId;
                        xhttp = new XMLHttpRequest();
                        xhttp.open('POST', 'bind_suite_testcase.php', true);
                        xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                        xhttp.onreadystatechange = function() {
                            if (this.readyState == 4 && this.status == 200) {
                                /*alert(xhttp.responseText);*/
                                //document.getElementById('" . $return_tag_id . "').innerHTML = this.responseText;
                            }
                        };
                        xhttp.send(params);
                        
		});

		document.querySelector('.js-sortable-connected-".$suite->get_id()."').addEventListener('sortstart', function(e){
			console.log('Sortstart: ', e.detail);
		});

		document.querySelector('.js-sortable-connected-".$suite->get_id()."').addEventListener('sortstop', function(e){
			console.log('Sortstop: ', e.detail);
                        
		});";
        }
         echo "          
                sortable('.js-sortable-testcases', {
		  forcePlaceholderSize: true,
		  copy: true,
				acceptFrom: false,
		  placeholderClass: 'mb1 bg-navy border border-yellow',
		});
		sortable('.js-sortable-copy-target', {
		forcePlaceholderSize: true,
			acceptFrom: '.js-sortable-copy,.js-sortable-copy-target',
		placeholderClass: 'mb1 border border-maroon',
	  });
		sortable('.js-grid', {
					forcePlaceholderSize: true,
					placeholderClass: 'col col-4 border border-maroon'
				});
		sortable('.js-connected', {
			forcePlaceholderSize: true,
			connectWith: '.js-connected',
			handle: '.js-handle',
			items: 'li',
			placeholderClass: 'border border-white bg-orange mb1'
		});
		sortable('.js-sortable-inner-connected', {
			forcePlaceholderSize: true,
			connectWith: 'js-inner-connected',
			handle: '.js-inner-handle',
			items: '.item',
                        maxItems: 3,
			placeholderClass: 'border border-white bg-orange mb1'
		});
		

		sortable('.js-sortable-buttons', {
			forcePlaceholderSize: true,
			items: 'li',
			placeholderClass: 'border border-white mb1',
                        hoverClass: 'bg-yellow'
		});
		// buttons to add items and reload the list
		// separately to showcase issue without reload
		/*document.querySelector('.js-add-item-button').addEventListener('click', function(){
			doc = new DOMParser().parseFromString(`<li class='p1 mb1 blue bg-white'>new item</li>`, 'text/html').body.firstChild;
			document.querySelector('.js-sortable-buttons').appendChild(doc);
		});*/

		/*document.querySelector('.js-reload').addEventListener('click', function(){
			console.log('Options before re-init:');
			console.log(document.querySelector('.js-sortable-buttons').h5s.data.opts);
			sortable('.js-sortable-buttons');
			console.log('Options after re-init:');
			console.log(document.querySelector('.js-sortable-buttons').h5s.data.opts);
		});*/
		// JS DISABLED
		/*document.querySelector('.js-disable').addEventListener('click', function(){
			var list = document.querySelector('[data-disabled]');
			if ( list.getAttribute('data-disabled') === 'false' ) {
				this.innerHTML = 'Enable';
				sortable(list, 'disable');
				list.setAttribute('data-disabled', true);
				list.classList.add('muted');
			} else {
				this.innerHTML = 'Disable';
				sortable(list, 'enable');
				list.setAttribute('data-disabled', false);
				list.classList.remove('muted');
			}
		});*/

		// Destroy & Init
		/*document.querySelector('.js-destroy').addEventListener('click', function(){
			sortable('.js-sortable-buttons', 'destroy');
		});*/
		/*document.querySelector('.js-init').addEventListener('click', function(){
			sortable('.js-sortable-buttons', {
				forcePlaceholderSize: true,
				items: 'li',
				placeholderClass: 'border border-white mb1'
			})
		});*/
	</script>";

     

include 'footer.php';
<?php
$overskrift = "Testcases";
$hovertext = "'Testcases'";
$pagename = "Region Midt: Testcases";

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

echo "<link rel='stylesheet' href='css/basscss.css'>";
echo "<script src='js/html5sortable.js'></script>";

echo "
    <section class='mb3 mx-auto col col-12'>
        <div class='p3 bg-white black col col-6'>
            <h2 class='h3 m0'>Træk et step eller et module over i din testcase. </h2>";

$product = new Product($productid, $con);
foreach ($product->get_testcases() as $testcase)
{
    echo"
            <div class='group'>
                <h3>" . $testcase->get_name() . "</h3>
                <p>Description: " . $testcase->get_description() . "</p>
                <ul class='p2 border maroon border-maroon js-sortable-connected-" . $testcase->get_id() . " list flex flex-column list-reset' id='".$testcase->get_id()."' aria-dropeffect='move'>";
    foreach ($testcase->get_modules() as $module) {
        if($module->get_hidden() == 1)
        { // hidden module. Draw the single childstep
            $step = ($module->get_steps())[0]; // get the first step 
            echo     "<li class='p1 mb1 blue bg-white js-handle px1' draggable='true' role='option' id='".$step->get_id()."' aria-grabbed='false'><a href='#'>".$step->get_name() ."</a></li>";
        }
        else //Draw the module
        {
            echo "  <li class='p1 mb1 border border-white white bg-orange' role='option' aria-grabbed='false'>
                        <div class='mb1 js-handle px1' draggable='true'>".$module->get_name()."</div>
                        <ul class='js-sortable-inner-connected list flex flex-column list-reset m0 py1' aria-dropeffect='move'>";
            foreach ($module->get_steps() as $step) {
                echo "      <li class='p1 mb1 border border-blue blue bg-white item js-inner-handle px1' role='option' id='".$step->get_id()."' aria-grabbed='false' draggable='true'><a href='#'>".$step->get_name() ."</a></li>";
            }                            
            echo "      </ul>
                    </li>";
        }
           
    }
    echo " 
                </ul>
            </div>";
    
}
echo draw_add_testcase('addEditTestCase.php', $productid, $con);
echo"   </div>";
echo"				
	<div class='p3 bg-orange white col col-6'>
            
            <ul class='js-sortable-modules list flex flex-column list-reset' id='0' aria-dropeffect='move'>";
foreach ($product->get_modules() as $module)
{
    if($module->get_hidden() != 1) // not hidden => draw the module
    {
        echo "  <li class='p1 mb1 border border-white white bg-orange' id='m-".$module->get_id()."' role='option' aria-grabbed='false'>
                    <div class='mb1 js-handle px1' draggable='true'>".$module->get_name()."</div>
                    <ul class='js-sortable-inner-connected list flex flex-column list-reset m0 py1' aria-dropeffect='move'>";
            foreach ($module->get_steps() as $step) {
                echo "  <li class='p1 mb1 border border-blue white bg-green item js-inner-handle px1' role='option' id='s-".$step->get_id()."' aria-grabbed='false' draggable='true'><a href='#'>".$step->get_name() ."</a></li>";
            }                            
            echo "  </ul>
                </li>";
    }
}
echo "      </ul>
    
            <ul class='js-sortable-steps list flex flex-column list-reset' id='0' aria-dropeffect='move'>";
foreach ($product->get_steps() as $step)
{
    echo "      <li class='p1 mb1 blue bg-green js-handle px1' draggable='true' role='option' id='s-".$step->get_id()."' aria-grabbed='false'><a href='#'>".$step->get_name() ."</a></li>";                                 
}
echo "      </ul>
        </div>
    </section>";


echo "<script>";
        foreach ($product->get_testcases() as $testcase)
        {
            echo "sortable('.js-sortable-connected-".$testcase->get_id()."', {
			forcePlaceholderSize: true,
			acceptFrom: '.js-sortable-modules, .js-sortable-steps, .js-sortable-connected-".$testcase->get_id()."',
			handle: '.js-handle',
			items: 'li',
			placeholderClass: 'border border-white bg-orange mb1'
		});
            
                document.querySelector('.js-sortable-connected-".$testcase->get_id()."').addEventListener('sortupdate', function(e){
			console.log('Sortupdate: ', e.detail);
			console.log('Container: ', e.detail.origin.container, ' -> ', e.detail.destination.container);
			console.log('Index: '+e.detail.origin.index+' -> '+e.detail.destination.index);
			console.log('Element Index: '+e.detail.origin.elementIndex+' -> '+e.detail.destination.elementIndex);
                        
                        var itemId = e.detail.item.id;
                        var originTestcaseId = e.detail.origin.container.id;
                        var destinationTestcaseId = e.detail.destination.container.id;
                        
                        console.log('itemId: ',itemId);
                        console.log('originTestcaseId: ',originTestcaseId);
                        console.log('destinationTestcaseId: ',destinationTestcaseId);
                        
                        var params = 'itemId=' + itemId + '&originTestcaseId=' + originTestcaseId + '&destinationTestcaseId=' + destinationTestcaseId;
                        xhttp = new XMLHttpRequest();
                        xhttp.open('POST', 'bind_testcase_module.php', true);
                        xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                        xhttp.onreadystatechange = function() {
                            if (this.readyState == 4 && this.status == 200) {
                                //alert(xhttp.responseText);
                                console.log('xhttp.responseText', xhttp.responseText);
                                //document.getElementById('" . $return_tag_id . "').innerHTML = this.responseText;
                            }
                        };
                        xhttp.send(params);
                        
		});

		document.querySelector('.js-sortable-connected-".$testcase->get_id()."').addEventListener('sortstart', function(e){
			console.log('Sortstart: ', e.detail);
		});

		document.querySelector('.js-sortable-connected-".$testcase->get_id()."').addEventListener('sortstop', function(e){
			console.log('Sortstop: ', e.detail);
                        
		});";
        }
         echo "          
                sortable('.js-sortable-modules', {
		  forcePlaceholderSize: true,
		  copy: true,
		  acceptFrom: false,
		  placeholderClass: 'mb1 bg-navy border border-yellow',
		});
                
                sortable('.js-sortable-steps', {
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
                        hoverClass: 'bg-yellow',
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
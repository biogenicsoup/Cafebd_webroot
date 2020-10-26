<?php
$overskrift = "Modules";
$hovertext = "'Modules'";
$pagename = "Region Midt: Modules";


include_once 'defaults.php';
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
        <div class='p3 bg-white black col col-6'>
            <h2 class='h3 m0'>Træk et step over i et module for at tilføje den. </h2>
            <div id='accordion' class='ui-accordion ui-widget ui-helper-reset ui-sortable' role='tablist'>";

$product = new Product($productid, $con);
foreach ($product->get_modules() as $module)
{
    if($module->get_hidden() != 1) //it is not hidden
    {
        echo"
                <div class='group'>
                    <h3>" . $module->get_name() . "</h3>
                    <div><p>Description: " . $module->get_description() . "</p>
                        <ul class='p2 border maroon border-maroon js-sortable-connected-" . $module->get_id() . " list flex flex-column list-reset' id='".$module->get_id()."' aria-dropeffect='move'>";
        foreach ($module->get_steps() as $step) {
            echo "          <li class='p1 mb1 blue bg-white js-handle px1' draggable='true' role='option' id='".$step->get_id()."' aria-grabbed='false'><a href='#'>".$step->get_name() ."</a></li>";
        }
        echo " 
                        </ul>
                    </div>
                </div>";
    }
}
echo "      </div>
            <div>";
                echo draw_add_module('addEditModule.php', $productid, $con);
echo "      </div>
        </div>";

echo"
        <div class='p3 bg-orange white col col-6'>
            <ul class='js-sortable-steps list flex flex-column list-reset' id='0' aria-dropeffect='move'>";
foreach ($product->get_steps() as $step)
{
    echo "      <li class='p1 mb1 blue bg-green js-handle px1' draggable='true' role='option' id='".$step->get_id()."' aria-grabbed='false'><a href='#'>".$step->get_name() ."</a></li>";                                 
}
echo "      </ul>";
            echo draw_add_step('addEditStep.php', $productid, $con);
echo "  </div>
    </section>";


echo "<script>";
        foreach ($product->get_modules() as $module)
        {
            if($module->get_hidden() != 1)
            {
                echo "sortable('.js-sortable-connected-".$module->get_id()."', {
			forcePlaceholderSize: true,
			acceptFrom: '.js-sortable-steps, .js-sortable-connected-".$module->get_id()."',
			handle: '.js-handle',
			items: 'li',
			placeholderClass: 'border border-white bg-orange mb1'
                    });
            
                    document.querySelector('.js-sortable-connected-".$module->get_id()."').addEventListener('sortupdate', function(e){
			console.log('Sortupdate: ', e.detail);
			console.log('Container: ', e.detail.origin.container, ' -> ', e.detail.destination.container);
			console.log('Index: '+e.detail.origin.index+' -> '+e.detail.destination.index);
			console.log('Element Index: '+e.detail.origin.elementIndex+' -> '+e.detail.destination.elementIndex);
                        
                        var stepId = e.detail.item.id;
                        var originModuleId = e.detail.origin.container.id;
                        var destinationModuleId = e.detail.destination.container.id;
                        
                        console.log('stepId: ',stepId);
                        console.log('originModuleId: ',originModuleId);
                        console.log('destinationModuleId: ',destinationModuleId);
                        
                        var params = 'stepId=' + stepId + '&originModuleId=' + originModuleId + '&destinationModuleId=' + destinationModuleId;
                        xhttp = new XMLHttpRequest();
                        xhttp.open('POST', 'bind_module_step.php', true);
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

                    document.querySelector('.js-sortable-connected-".$module->get_id()."').addEventListener('sortstart', function(e){
			console.log('Sortstart: ', e.detail);
                    });

                    document.querySelector('.js-sortable-connected-".$module->get_id()."').addEventListener('sortstop', function(e){
			console.log('Sortstop: ', e.detail);
                        
                    });";
            }  
        }
        echo "          
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
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
include_once 'Views/viewStepData.php';

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
echo draw_add_stepdata_dialog('addEditStepData.php');

echo "
    <section class='mb3 mx-auto col col-12'>
        <div class='p3 bg-white black col col-6'>
            <h2 class='h3 m0'>Træk et step eller et module over i din testcase. </h2>
                <div id='accordion' class='ui-accordion ui-widget ui-helper-reset ui-sortable' role='tablist'>";

$product = new Product($productid, $con);
foreach ($product->get_testcases() as $testcase)
{
    echo"
                    <div class='group'>
                        <h3>" . $testcase->get_name() . "</h3>
                        <div><p>Description: " . $testcase->get_description() . "</p>
                            <ul class='p2 border maroon border-maroon js-sortable-connected-" . $testcase->get_id() . " list flex flex-column list-reset' id='".$testcase->get_id()."' aria-dropeffect='move'>";
    foreach ($testcase->get_modules() as $module) {
        if($module->get_hidden() == 1)
        { // hidden module. Draw the single childstep
            $step = ($module->get_steps())[0]; // get the first step 
            echo "              <li class='p1 mb1 blue bg-white js-handle px1' draggable='true' role='option' id='s-".$step->get_id()."' aria-grabbed='false'>".$step->get_name() ."</li>";
        }
        else //Draw the module
        {
            echo "              <li class='p1 mb1 border border-white white bg-orange' id='m-".$module->get_id()."' role='option' aria-grabbed='false'>
                                    <div class='mb1 js-handle px1' draggable='true'>".$module->get_name()."</div>
                                    <ul class='js-sortable-inner-connected list flex flex-column list-reset m0 py1' aria-dropeffect='move'>";
            foreach ($module->get_steps() as $step) {
                echo "                  <li class='p1 mb1 border border-blue blue bg-white item js-inner-handle px1' role='option' id='".$step->get_id()."' aria-grabbed='false' draggable='true'>".$step->get_name() ."</li>";
            }                            
            echo "                  </ul>
                                </li>";
        }
           
    }
    echo " 
                            </ul>
                        </div>
                    </div>";
}
echo "          </div>";
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
                echo "  <li class='p1 mb1 border border-blue white bg-green item js-inner-handle px1' role='option' id='s-".$step->get_id()."' aria-grabbed='false' draggable='true'>".$step->get_name() ."</li>";
            }                            
            echo "  </ul>
                </li>";
    }
}
echo "      </ul>
    
            <ul class='js-sortable-steps list flex flex-column list-reset' id='0' aria-dropeffect='move'>";
foreach ($product->get_steps() as $step)
{
    echo "      <li class='p1 mb1 blue bg-green js-handle px1 expandable' draggable='true' role='option' id='s-".$step->get_id()."' aria-grabbed='false'>".$step->get_name() ."
                    <div class='stepdata' id='d-".$step->get_id()."' style='display: none'>
                        <ul>";
                            foreach ($step->get_stepData() as $stepdata) {
                                echo "<li>Name = ". $stepdata->get_name() ." : Value = " . $stepdata->get_value();
                                echo draw_editstepdata_button($step->get_id(), $stepdata->get_id(), $stepdata->get_name(), $stepdata->get_value());
                                echo "</li>";
                            }
                            echo "<li>";
                            echo draw_opretstepdata_button($step->get_id());
                            echo "</li>";
    echo "              </ul>
                    </div>
                    <button>Edit</button>
                    <button>Copy</button>
                </li>";                                 
}
echo "      </ul>";
            echo draw_add_step('addEditStep.php', $productid, $con);
            echo "<div class='center py1 ml4'>
						<button class='js-destroy button blue bg-white'>Destroy</button>
						<button class='js-init button blue bg-white'>Init</button>
					</div>";
echo "  </div>
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
			console.log('Testcase ".$testcase->get_id()."-Sortupdate: ', e.detail);
			console.log('Container: ', e.detail.origin.container, ' -> ', e.detail.destination.container);
			console.log('Index: '+e.detail.origin.index+' -> '+e.detail.destination.index);
			console.log('Element Index: '+e.detail.origin.elementIndex+' -> '+e.detail.destination.elementIndex);
                        
                        var itemId = e.detail.item.id;
                        var originTestcaseId = e.detail.origin.container.id;
                        var destinationTestcaseId = e.detail.destination.container.id;
                        
                        console.log('itemId: ',itemId);
                        console.log('originTestcaseId: ',originTestcaseId);
                        console.log('destinationTestcaseId: ',destinationTestcaseId);
                        
                        var params = 'itemId=' + itemId + '&originTestcaseId=' + originTestcaseId + '&destinationTestcaseId=' + destinationTestcaseId + '&originIndex=' + e.detail.origin.index + '&destinationIndex=' + e.detail.destination.index;
                        console.log('params = ',params);
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
			console.log('Testcase ".$testcase->get_id()."-Sortstart: ', e.detail); 
		});

		document.querySelector('.js-sortable-connected-".$testcase->get_id()."').addEventListener('sortstop', function(e){
			console.log('Testcase ".$testcase->get_id()."-Sortstop: ', e.detail);                        
		});";
        }
        echo "          
                sortable('.js-sortable-modules', {
		  //forcePlaceholderSize: true,
		  copy: true,
                  placeholderClass: 'mb1 bg-navy border border-yellow',";
        $testcaselist = $product->get_testcases();
        if(count($testcaselist)>=1)
        {  
            echo "acceptFrom: '";
            for ($x = 0; $x < count($testcaselist) -1 ; $x++)
            {
                $testcase = $testcaselist[$x];
                echo ".js-sortable-connected-".$testcase->get_id().", ";
            }
            echo ".js-sortable-connected-".$testcase->get_id()."',";
        }
        else 
        {
            echo "acceptFrom: false,";
        }
    
        echo "  
		});
                
                document.querySelector('.js-sortable-modules').addEventListener('sortupdate', function(e){
			console.log('modules-Sortupdate: ', e.detail);
			console.log('Container: ', e.detail.origin.container, ' -> ', e.detail.destination.container);
			console.log('Index: '+e.detail.origin.index+' -> '+e.detail.destination.index);
			console.log('Element Index: '+e.detail.origin.elementIndex+' -> '+e.detail.destination.elementIndex);
                        
                        var itemId = e.detail.item.id;
                        var originTestcaseId = e.detail.origin.container.id;
                        var destinationTestcaseId = e.detail.destination.container.id;
                        
                        console.log('itemId: ',itemId);
                        console.log('originTestcaseId: ',originTestcaseId);
                        console.log('destinationTestcaseId: ',destinationTestcaseId);
                        
                        var params = 'itemId=' + itemId + '&originTestcaseId=' + originTestcaseId + '&destinationTestcaseId=' + destinationTestcaseId + '&originIndex=' + e.detail.origin.index + '&destinationIndex=' + e.detail.destination.index;
                        console.log('params = ',params);
                        e.detail.item.hidden = true;
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
                
                sortable('.js-sortable-steps', {
		  //forcePlaceholderSize: true,
		  copy: true,
                  placeholderClass: 'mb1 bg-navy border border-yellow',";
        $testcaselist = $product->get_testcases();
        if(count($testcaselist)>=1)
        {  
            echo "acceptFrom: '";
            for ($x = 0; $x < count($testcaselist) -1 ; $x++)
            {
                $testcase = $testcaselist[$x];
                echo ".js-sortable-connected-".$testcase->get_id().", ";
            }
            echo ".js-sortable-connected-".$testcase->get_id()."',";
        }
        else 
        {
            echo "acceptFrom: false,";
        }
    
        echo "  
		});
                
                document.querySelector('.js-sortable-steps').addEventListener('sortupdate', function(e){
			console.log('step-Sortupdate: ', e.detail);
			console.log('Container: ', e.detail.origin.container, ' -> ', e.detail.destination.container);
			console.log('Index: '+e.detail.origin.index+' -> '+e.detail.destination.index);
			console.log('Element Index: '+e.detail.origin.elementIndex+' -> '+e.detail.destination.elementIndex);
                        
                        var itemId = e.detail.item.id;
                        var originTestcaseId = e.detail.origin.container.id;
                        var destinationTestcaseId = e.detail.destination.container.id;
                        
                        console.log('itemId: ',itemId);
                        console.log('originTestcaseId: ',originTestcaseId);
                        console.log('destinationTestcaseId: ',destinationTestcaseId);
                        
                        var params = 'itemId=' + itemId + '&originTestcaseId=' + originTestcaseId + '&destinationTestcaseId=' + destinationTestcaseId + '&originIndex=' + e.detail.origin.index + '&destinationIndex=' + e.detail.destination.index;
                        console.log('params = ',params);
                        e.detail.item.hidden = true;
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
                                
                $('li.expandable').on('click',function(event) {    
                    console.log('testing');
                    console.log(this);
                    console.log(event);
                    console.log('id = ' + event.target.id);
                    if($( event.target ).children('.stepdata').is(':visible'))
                    {
                        $( event.target ).children('.stepdata').hide('slow');
                        sessionStorage.removeItem('stepid-' + event.target.id);
                        //sessionStorage.clear();
                    }
                    else if($( event.target ).children('.stepdata').is(':hidden'))
                    {
                        $( event.target ).children('.stepdata').show('slow');
                        sessionStorage.setItem('stepid-' + event.target.id, 'expanded');
                    }
                });
                
/*document.addEventListener('DOMContentLoaded', function(event){
    console.log('DOMContentLoaded');
    console.log(event);
    $.each(sessionStorage, function(key, value){
        
        if (value === 'expanded')
        {
            console.log('key = ' + key + ' value = ' + value);
            var divid = 'd' + key.substring(8);
            console.log('divid = ' + divid);
            document.getElementById(divid).style.display = 'block';            
        }
    });
});*/

window.addEventListener('load', function(){
   console.log('PAGE loaded');
    console.log(event);
    $.each(sessionStorage, function(key, value){
        
        if (value === 'expanded')
        {
            console.log('key = ' + key + ' value = ' + value);
            var divid = 'd' + key.substring(8);
            console.log('divid = ' + divid);
            document.getElementById(divid).style.display = 'block';            
        }
    });
});
	</script>";

include 'footer.php';
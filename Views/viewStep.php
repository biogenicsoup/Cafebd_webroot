<?php
function draw_div_add_form() {
    return "<div class='group'>
                    <h3>Opret nyt step</h3>
                    <div>
                    <p><form name='addStep' method='post' action='href'>
                        Navn = <input name='stepname' type='text' id='stepname'> 
                        Funktion = <input name='stepfunction' type='text' id='stepfunction'>
                        <Input type = 'Submit' Value = 'Opret' class='button'>
                    </p>
                    </div>
                </div>";
}

function draw_div_edit_form(Step $step) {
    return "<div class='group'>
                    <h3>Opret nyt step</h3>
                    <div>
                    <p><form name='edit' method='post' action='href'>
                        Navn = <input name='stepname' type='text' id='stepname' value='".$step->get_name()."'> 
                        Funktion = <input name='stepfunction' type='text' id='stepfunction' value='".$step->get_function()."'>
                        <Input type = 'Submit' Value = 'Opdater' class='button'>
                    </p>
                    </div>
                </div>";
}

function draw_div_edit_form_with_data(Step $step) {
    return "<div class='group'>
                    <h3>Opret nyt step</h3>
                    <div>
                    <p><form name='edit' method='post' action='href'>
                        Navn = <input name='stepname' type='text' id='stepname' value='".$step->get_name()."'> 
                        Funktion = <input name='stepfunction' type='text' id='stepfunction' value='".$step->get_function()."'>
                        <Input type = 'Submit' Value = 'Opdater' class='button'>
                    </p>
                    <ul>";
    $viewstepdata = new ViewStepData();
    foreach ($step->get_stepData() as $stepdata) {
        $returnstr .= $viewstepdata->draw_edit_li($stepdata);
    }
    $returnstr .= $viewstepdata->draw_add_li($step);
    $returnstr .= "    </ul>
                        </div>
                      </div>";
    return $returnstr;


}

function draw_step_div_with_data(Step $step)
{
    $returnstr = "<div class='group'>
                        <h3>" . $step->get_name() . "</h3>
                        <div>
                            <p>" . $step->get_function() . "</p>
                            <ul>";
    foreach ($step->get_stepData() as $stepdata) {
        $returnstr .= $viewstepdata->draw_li($stepdata);
    }
    $returnstr .= "    </ul>
                        </div>
                      </div>";
    return $returnstr;
}

function draw_step_div_with_addData(Step $step)
{
    $returnstr = "<div class='group'>
                        <h3>" . $step->get_name() . "</h3>
                        <div>
                            <p>" . $step->get_function() . "</p>
                            <ul>";
    foreach ($step->get_stepData() as $stepdata) {
        $returnstr .= draw_stepdata_li($stepdata);
    }
    $returnstr .= draw_add_stepdata('addEditStepData.php', $step->get_id());
    $returnstr .= "    </ul>
                        </div>
                      </div>";
    return $returnstr;
}

function draw_add_step_dialog($phpfile, $productid, $con)
{
    $returnstr = draw_addedit_step_dialog_script($phpfile);
    $returnstr .=  draw_addedit_step_dialog_form($productid, $con);
    return $returnstr;
}

function draw_addedit_step_dialog_script($phpfile)
{
    $returnstr =  "<script>
/** add module dialog **/
$( function addStepDialog() {
    var dialog, 
        form,																																																																			 
        id = $( '#step-id' ),
        name = $( '#step-name' ),
        func = $( '#step-function' ),
        product = $( '#step-product-select' ),
        clonefromid = $('#clonefrom-id'),
        allFields = $( [] ).add(id).add( name ).add( func ).add(product).add( clonefromid ),
        tips = $( '.validateTips' );

    function updateTips( t ) {
        tips
            .text( t )
            .addClass( 'ui-state-highlight' );
        setTimeout(function() {
            tips.removeClass( 'ui-state-highlight', 1500 );
        }, 500 );
    }

    function checkLength( o, n, min, max ) {
        if ( o.val().length > max || o.val().length < min ) {
            o.addClass( 'ui-state-error' );
            updateTips( 'Length of ' + n + ' must be between ' +
                min + ' and ' + max + '.' );
            return false;
        } else {
            return true;
        }
    }

    function checkExists( o, regexp, n ) {
        if ( !( regexp.test( o.val() ) ) ) {
            o.addClass( 'ui-state-error' );
            updateTips( n );
            return false;
        } else {
            return true;
        }
    }

    function addStep() {
        var valid = true;
        allFields.removeClass( 'ui-state-error' );
        valid = valid && checkLength( name, 'navn', 3, 16 );
        valid = valid && checkLength( func, 'funktion', 5, 80 );
        valid = valid && product.val() > 0;

        if ( valid ) {
            var i = id.val();
            var n = name.val();
            var f = func.val();
            var p = product.val();
            var c = 0;
            if($('#step-clonedata-checkbox').prop('checked')) {
                c = clonefromid.val();
            } 
            stepdialog.dialog( 'close' );
            persistStep(i, n, f, p, c);
        }
        return valid;
    }

    function persistStep(i, n, f, p, c) {
        var xhttp;
        if (n == '') {
            document.getElementById('".$return_tag_id."').innerHTML = '';
            return;
        }
        var params = 'id=' + i + '&name=' + n + '&function=' + f + '&productid=' + p + '&clonefromid=' + c;
        console.log(' params = ' +params);
        xhttp = new XMLHttpRequest();
        xhttp.open('POST', '".$phpfile."', true);
        xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                /*alert(xhttp.responseText);*/
                console.log('xhttp.responseText', xhttp.responseText);
                //document.getElementById('".$return_tag_id."').innerHTML = this.responseText;
                //location.reload();
            }
        };
        xhttp.send(params);
        
    }


    stepdialog = $( '#step-dialog-form' ).dialog({
        autoOpen: false,
        height: 310,
        width: 350,
        modal: true,
        buttons: [
            { 
                text: 'Opret step',
                id: 'stepdialog-ok-button',
                click: function(){
                    addStep();
                }   
            },
            {
                id: 'stepdialog-cancel-button',
                text: 'Cancel',
                click: function () {
                    $(this).dialog('close');
                }
            }
        ],
        close: function() {
            form[ 0 ].reset();
            allFields.removeClass( 'ui-state-error' );
        }
    });

    form = stepdialog.find( 'form' ).on( 'submit', function( event ) {
        event.preventDefault();
        addStep();
    });

    $( '#create-step' ).button().on( 'click', function() {
        stepdialog.dialog( 'open' );
    });														 
	  
} );
    function add_step(productid, header){
        console.log('add_step: productid =' + productid + ' header = ' + header);
        console.log($( '#step-dialog-form' ));
        $('#step-dialog-form').dialog({ title: header });
        $('#step-name').val('');
        $('#step-function').val('');
        $('#step-id').val(0);
        $('#step-product-select').val(productid);
        $('#stepdialog-ok-button').html('Add step');
        $('#step-clonedata-div').hide(); 
        $('#step-clonedata-checkbox').prop('checked', false);
        $('#step-dialog-form').dialog('open');
        return false;
    }
    
    function edit_step(stepid, name, f, productid, header){
        console.log('edit_step: productid =' + productid + ' header = ' + header);
        //console.log($( '#step-dialog-form' ));
         console.log($('#stepdialog-ok-button'));
        $('#step-dialog-form').dialog({ title: header });
        $('#step-name').val(name);
        $('#step-function').val(f);
        $('#step-id').val(stepid);
        $('#step-product-select').val(productid);
        $('#stepdialog-ok-button').html('Edit step');
        $('#step-clonedata-div').hide(); 
        $('#step-clonedata-checkbox').prop('checked', false);
        $('#step-dialog-form').dialog('open');
        return false;
    }
    
    function clone_step(stepid, name, f, productid, header){
        console.log('add_step: productid =' + productid + ' header = ' + header);
        console.log($( '#step-dialog-form' ));
        $('#step-dialog-form').dialog({ title: header });
        $('#step-name').val(name);
        $('#step-function').val(f);
        $('#step-id').val(0);
        $('#clonefrom-id').val(stepid);
        $('#step-product-select').val(productid);
        $('#stepdialog-ok-button').html('Clone step');
        $('#step-clonedata-div').show(); 
        $('#step-clonedata-checkbox').prop('checked', true);
        $('#step-dialog-form').dialog('open');
        return false;
    }
    
</script>";
return $returnstr;
}

function draw_addedit_step_dialog_form($productid, $con)
{
    $returnstr = "
<div id='step-dialog-form' title='Opret nyt step'>
  <p class='validateTips'>Name og Function skal udfyldes.</p>
 
  <form>
    <fieldset>
      <label for='step-name'>Name</label>
      <input type='text' name='name' id='step-name' value='' class='text ui-widget-content ui-corner-all'>
      <label for='step-function'>Function</label>
      <input type='text' name='function' id='step-function' value='' class='text ui-widget-content ui-corner-all'>
      <input type='hidden' name='id' id='step-id' value='0' >
      <input type='hidden' name='clonefrom-id' id='clonefrom-id' value='0' >
      <select name='product' id='step-product-select'>";
      
    $products = new Products($con);
    $productlist = $products->get_products_list();

    if ($productid == 0) //we have an unknown product
    {
        $returnstr .= "<option value='' selected disabled hidden>Vælg produkt</option>";
        foreach ($productlist as $row) {
            $returnstr .= "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";

        }
    } else {
        foreach ($productlist as $row) {
            if ($row['id'] == $productid) {
                $returnstr .= "<option value='" . $row['id'] . "' selected>" . $row['name'] . "</option>";
            } else {
                $returnstr .= "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
            }
        }
    }
    $returnstr .= "</select> 
      
      <div id='step-clonedata-div' style='display: none'>
        <label for='step-clonedata-checkbox'> Kopier data</label>
        <input type='checkbox' id='step-clonedata-checkbox' name='clonedata' value='true' >
      </div>
      <!-- Allow form submission with keyboard without duplicating the dialog button -->
      <input type='submit' tabindex='-1' style='position:absolute; top:-10000px'>
    </fieldset>
  </form>
</div>";
																		  
    return $returnstr;
}

function draw_opretstep_button($productid, $buttontext)
{
    $header = "Opret step";
    return "<button id='add-step' class='btn main_bt' onclick='add_step(".$productid.", ".$header.")'>".$buttontext."</button>";
}

function draw_editstep_button($stepid, $name, $function, $productid, $buttontext)
{
    $header = "Edit step";
    return "<button id='edit-step' class='btn main_bt' onclick='edit_step(".$stepid.", \"".$name."\", \"".$function."\", ".$productid.", \"".$header."\")'>".$buttontext."</button>";
}  

function draw_clonestep_button($stepid, $name, $function, $productid, $buttontext)
{
    $header = "Clone step";
    return "<button id='edit-step' class='btn main_bt' onclick='clone_step(".$stepid.", \"".$name."\", \"".$function."\", ".$productid.", \"".$header."\")'>".$buttontext."</button>";
}  

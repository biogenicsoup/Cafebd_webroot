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

function draw_add_step($phpfile, $productid, $con)
{
    $returnstr =  "<script>
/** add module dialog **/
$( function addStepDialog() {
    var dialog, form,

        // From http://www.whatwg.org/specs/web-apps/current-work/multipage/states-of-the-type-attribute.html#e-mail-state-%28type=email%29
        /*emailRegex = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/,*/
        id = $( '#step-id' ),
        name = $( '#step-name' ),
        func = $( '#step-function' ),
        product = $( '#product-select' ),
        allFields = $( [] ).add(id).add( name ).add( func ).add(product),
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
            dialog.dialog( 'close' );
            persistStep(i, n, f, p);
        }
        return valid;
    }

    function persistStep(i, n, f, p) {
        var xhttp;
        if (n == '') {
            document.getElementById('".$return_tag_id."').innerHTML = '';
            return;
        }
        var params = 'id=' + i + '&name=' + n + '&function=' + f + '&productid=' + p;
        xhttp = new XMLHttpRequest();
        xhttp.open('POST', '".$phpfile."', true);
        xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                /*alert(xhttp.responseText);*/
                console.log('xhttp.responseText', xhttp.responseText);
                //document.getElementById('".$return_tag_id."').innerHTML = this.responseText;
            }
        };
        xhttp.send(params);
        location.reload();
    }


    dialog = $( '#step-dialog-form' ).dialog({
        autoOpen: false,
        height: 300,
        width: 350,
        modal: true,
        buttons: {
            'Opret step': addStep,
            Cancel: function() {
                dialog.dialog( 'close' );
            }
        },
        close: function() {
            form[ 0 ].reset();
            allFields.removeClass( 'ui-state-error' );
        }
    });

    form = dialog.find( 'form' ).on( 'submit', function( event ) {
        event.preventDefault();
        addStep();
    });

    $( '#create-step' ).button().on( 'click', function() {
        dialog.dialog( 'open' );
    });

    function edit_module(old_name, old_description, header){
        $('#empId').val(empId);
        $('#fieldId').val(fieldId);
        $('#fieldName').val(name);
        $('#fieldValue').val(value);
        $('#customFieldDialog').dialog('open');
        return false;
    };
} );
</script>
<div id='step-dialog-form' title='Opret nyt modul'>
  <p class='validateTips'>Name og Description skal udfyldes.</p>
 
  <form>
    <fieldset>
      <label for='name'>Name</label>
      <input type='text' name='name' id='step-name' value='' class='text ui-widget-content ui-corner-all'>
      <label for='function'>Function</label>
      <input type='text' name='function' id='step-function' value='' class='text ui-widget-content ui-corner-all'>
      <input type='hidden' name='id' id='step-id' value='0' >
      <select name='product' id='product-select'>";

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
      <!-- Allow form submission with keyboard without duplicating the dialog button -->
      <input type='submit' tabindex='-1' style='position:absolute; top:-10000px'>
    </fieldset>
  </form>
</div><button class='btn sqaure_bt' id='create-step'>Opret step</button>";
    return $returnstr;
}
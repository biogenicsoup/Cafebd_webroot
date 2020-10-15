<?php
include_once 'viewStep.php';

include_once __DIR__ .'/../classes/Products.php';


function draw_div_Module(Module $module) {
    if($module->get_hidden() == 1) // it is hidden
    {
        return draw_step_div_with_data($module->get_steps()[0]);
    }
    else //not hidden
    {
        // lets keep it simple and just add add the steps
        // todo implement module accordion
        $returnstr ="";
        $steps = $module->get_steps();
        foreach ($steps as $step)
        {
            $returnstr .= draw_step_div_with_data($step);
        }
        return $returnstr;
    }
}
//modulelist, addEditModule.php
function draw_add_module($return_tag_id, $phpfile, $productid, $con)
{
    $returnstr =  "<script>
/** add module dialog **/
$( function addModuleDialog() {
    var dialog, form,

        // From http://www.whatwg.org/specs/web-apps/current-work/multipage/states-of-the-type-attribute.html#e-mail-state-%28type=email%29
        /*emailRegex = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/,*/
        id = $( '#module-id' ),
        name = $( '#module-name' ),
        description = $( '#module-description' ),
        product = $( '#product-select' ),
        allFields = $( [] ).add(id).add(name).add(description).add(product),
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

    function addToModule() {
        var valid = true;
        allFields.removeClass( 'ui-state-error' );
        valid = valid && checkLength( name, 'modulnavn', 3, 16 );
        valid = valid && checkLength( description, 'description', 5, 80 );
        valid = valid && product.val() > 0;

        if ( valid ) {
            var i = id.val();
            var n = name.val();
            var d = description.val();
            var p = product.val();
            dialog.dialog( 'close' );
            persistModule(i, n, d, p);
        }
        return valid;
    }

    function persistModule(i, n, d, p) {
        var xhttp;
        if (n == '') {
            document.getElementById('".$return_tag_id."').innerHTML = '';
            return;
        }
        var params = 'id=' + i + '&name=' + n + '&description=' + d + '&productid=' + p;
        xhttp = new XMLHttpRequest();
        xhttp.open('POST', '".$phpfile."', true);
        xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // alert(xhttp.responseText);
                document.getElementById('".$return_tag_id."').innerHTML = this.responseText;
            }
        };
        xhttp.send(params);
    }


    dialog = $( '#module-dialog-form' ).dialog({
        autoOpen: false,
        height: 300,
        width: 350,
        modal: true,
        buttons: {
            'Opret modul': addToModule,
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
        addToModule();
    });

    $( '#create-module' ).button().on( 'click', function() {
        dialog.dialog( 'open' );
    });

    function edit_module(old_name, old_description, header){
        $('#empId').val(empId);
        $('#fieldId').val(fieldId);
        $('#fieldName').val(name);
        $('#fieldValue').val(value);
        $('#customFieldDialog').dialog('open');
        return false;
    }
} );
</script>
<div id='module-dialog-form' title='Opret nyt modul'>
  <p class='validateTips'>Name og Description skal udfyldes.</p>
 
  <form>
    <fieldset>
      <label for='name'>Name</label>
      <input type='text' name='name' id='module-name' value='' class='text ui-widget-content ui-corner-all'>
      <label for='description'>Description</label>
      <input type='text' name='description' id='module-description' value='' class='text ui-widget-content ui-corner-all'>
      <input type='hidden' name='id' id='module-id' value='0' >
      <select name='product' id='product-select'>";

    $products = new Products($con);
    $productlist = $products->get_products_list();

    if($productid ==0) //we have an unknown product
    {
        $returnstr .=  "<option value='' selected disabled hidden>Vælg produkt</option>";
        foreach ($productlist as $row)
        {
            $returnstr .=  "<option value='".$row['id']."'>".$row['name']."</option>";

        }
    }
    else {
        foreach ($productlist as $row)
        {
            if($row['id']==$productid) {
                $returnstr .= "<option value='" . $row['id'] . "' selected>" . $row['$name'] . "</option>";
            }
            else {
                $returnstr .= "<option value='" . $row['id'] . "'>" . $row['$name'] . "</option>";
            }
        }
    }


$returnstr .= "</select>          
      <!-- Allow form submission with keyboard without duplicating the dialog button -->
      <input type='submit' tabindex='-1' style='position:absolute; top:-10000px'>
    </fieldset>
  </form>
</div><button class='btn sqaure_bt' id='create-module'>Opret modul</button>
";
    return $returnstr;
}


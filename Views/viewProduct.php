<?php
function draw_product_div_with_Suites(Product $product)
{
    $returnstr = "<div class='group'>
                        <h3>" . $product->get_name() . "</h3><input type='button' class='button' onclick='alert(\"you clicked!\")'>
                        <div>
                            <div>";
    foreach ($product->get_suites() as $suite) {
        $returnstr .= draw_suite_div_with_Testcases($suite);
    }
    $returnstr .= "    </div>
                        </div>
                      </div>";
    return $returnstr;
}

function draw_product_div(Product $product)
{
    $returnstr = "<div class='group'>
                        <h3>" . $product->get_name() . "</h3><input type='button' class='button' onclick='alert(\"you clicked!\")'>
                        <div>
                        </div>
                      </div>";
    return $returnstr;
}

function draw_product_div_as_link(Product $product, $targeturl)
{
    $returnstr = "<a class='btn sqaure_bt' href='".$targeturl."'><div class='group'>
                        <h3>" . $product->get_name() . "</h3>
                        <div>
                        </div>
                      </div></a>";
    return $returnstr;
}

function draw_add_product($return_tag_id, $phpfile)
{
    return "<script>
/** add module dialog **/
$( function addProductDialog() {
    var dialog, form,

        // From http://www.whatwg.org/specs/web-apps/current-work/multipage/states-of-the-type-attribute.html#e-mail-state-%28type=email%29
        /*emailRegex = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/,*/
        id = $( '#product-id' ),
        name = $( '#product-name' ),
        allFields = $( [] ).add(id).add( name ),
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

    function addProduct() {
        var valid = true;
        allFields.removeClass( 'ui-state-error' );
        valid = valid && checkLength( name, 'navn', 3, 16 );

        if ( valid ) {
            var i = id.val();
            var n = name.val();
            dialog.dialog( 'close' );
            persistProduct(i, n);
        }
        return valid;
    }

    function persistProduct(i, n) {
        var xhttp;
        if (n == '') {
            document.getElementById('".$return_tag_id."').innerHTML = '';
            return;
        }
        var params = 'id=' + i + '&name=' + n;
        xhttp = new XMLHttpRequest();
        xhttp.open('POST', '".$phpfile."', true);
        xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                //alert(xhttp.responseText);
                document.getElementById('".$return_tag_id."').innerHTML = this.responseText;
            }
        };
        xhttp.send(params);
    }


    dialog = $( '#product-dialog-form' ).dialog({
        autoOpen: false,
        height: 300,
        width: 350,
        modal: true,
        buttons: {
            'Opret produkt': addProduct,
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
        addProduct();
    });

    $( '#create-product' ).button().on( 'click', function() {
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
<div id='product-dialog-form' title='Opret nyt produkt'>
  <p class='validateTips'>Name skal udfyldes.</p>
 
  <form>
    <fieldset>
      <label for='name'>Name</label>
      <input type='text' name='name' id='product-name' value='' class='text ui-widget-content ui-corner-all'>
      <input type='hidden' name='id' id='product-id' value='0' >
      <!-- Allow form submission with keyboard without duplicating the dialog button -->
      <input type='submit' tabindex='-1' style='position:absolute; top:-10000px'>
    </fieldset>
  </form>
</div><button class='btn sqaure_bt' id='create-product'>Opret produkt</button>
";
}
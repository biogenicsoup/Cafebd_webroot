<?php
include_once __DIR__ .'/../classes/Products.php';
function draw_suite_div_with_Testcases(Suite $suite)
{
    $returnstr = "<div class='group'>
                        <h3>" . $suite->get_name() . "</h3>
                        <div>
                            <p>Description: " . $suite->get_description() . "</p>
                            <div>";
    foreach ($suite->get_testcases() as $testCase) {
        $returnstr .= draw_testcase_div_with_modules($testCase);
    }
    $returnstr .= "    </div>
                        </div>
                      </div>";
    return $returnstr;
}

function draw_suite_accordion($suitelist)
{
    $returnstr ="  
    <script>
        $(function() {
            var icons = {
                header: 'iconClosed', //virker ikke
                headerSelected: 'iconOpen' //virker ikke
            };
            $( '#suites_accordion' )
                //$( '#accordion > div' )
                .accordion({
                    collapsible:true,
                    active: false,
                    header: '> div > h3' //,
                    //icons: icons
                })
            .sortable({
                axis: 'y',
                handle: 'h3',
                stop: function( event, ui ) {
                    // IE doesn't register the blur when sorting
                    // so trigger focusout handlers to remove .ui-state-focus
                    ui.item.children( 'h3' ).triggerHandler( 'focusout' );
                    
                    // Refresh accordion to handle new order
                    $( this ).accordion( 'refresh' );
                }
            });
        });
    </script>
    <div id='suites_accordion'>";
    foreach ($suitelist as $suite)
    {
        $returnstr .= draw_suite_div_with_Testcases($suite);
    }
    $returnstr .="</div>";
    return $returnstr;
}

function draw_add_suite($return_tag_id, $phpfile, $productid, $con)
{
    $returnstr = "<script>
/** add suite dialog **/
$( function addSuiteDialog() {
    var dialog, form,

        // From http://www.whatwg.org/specs/web-apps/current-work/multipage/states-of-the-type-attribute.html#e-mail-state-%28type=email%29
        /*emailRegex = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/,*/
        id = $( '#suite-id' ),
        name = $( '#suite-name' ),
        description = $( '#suite-description' ),
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

    function addToSuite() {
        var valid = true;
        allFields.removeClass( 'ui-state-error' );
        valid = valid && checkLength( name, 'navn', 3, 16 );
        valid = valid && checkLength( description, 'description', 5, 80 );
        valid = valid && product.val() > 0;

        if ( valid ) {
            var i = id.val();
            var n = name.val();
            var d = description.val();
            var p = product.val();
            dialog.dialog( 'close' );
            persistSuite(i, n, d, p);
        }
        return valid;
    }

    function persistSuite(i, n, d, p) {
        var xhttp;
        if (n == '') {
            document.getElementById('" . $return_tag_id . "').innerHTML = '';
            return;
        }
        var params = 'id=' + i + '&name=' + n + '&description=' + d + '&productid=' + p;
        xhttp = new XMLHttpRequest();
        xhttp.open('POST', '" . $phpfile . "', true);
        xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // alert(xhttp.responseText);
                document.getElementById('" . $return_tag_id . "').innerHTML = this.responseText;
            }
        };
        xhttp.send(params);
    }


    dialog = $( '#suite-dialog-form' ).dialog({
        autoOpen: false,
        height: 300,
        width: 350,
        modal: true,
        buttons: {
            'Opret suite': addToSuite,
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
        addToSuite();
    });

    $( '#create-suite' ).button().on( 'click', function() {
        dialog.dialog( 'open' );
    });

    function edit_suite(old_name, old_description, header){
        $('#empId').val(empId);
        $('#fieldId').val(fieldId);
        $('#fieldName').val(name);
        $('#fieldValue').val(value);
        $('#customFieldDialog').dialog('open');
        return false;
    }
} );
</script>
<div id='suite-dialog-form' title='Opret nyt suite'>
  <p class='validateTips'>Name og Description skal udfyldes.</p>
 
  <form>
    <fieldset>
      <label for='name'>Name</label>
      <input type='text' name='name' id='suite-name' value='' class='text ui-widget-content ui-corner-all'>
      <label for='description'>Description</label>
      <input type='text' name='description' id='suite-description' value='' class='text ui-widget-content ui-corner-all'>
      <input type='hidden' name='id' id='suite-id' value='0' >
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
</div>
<button class='btn sqaure_bt' id='create-suite'>Opret suite</button>";
    return $returnstr;
}
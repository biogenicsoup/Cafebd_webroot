<?php
include 'viewModule.php';
function draw_testcase_div_with_modules(TestCase $testCase)
{
    $returnstr = "<div class='group'>
                        <h3>" . $testCase->get_name() . "</h3>
                        <div>
                            <p>TestRailID: " . $testCase->get_testRailId() . "</p>
                            <p>Description: " . $testCase->get_description() . "</p>
                            <p>TestType: " . $testCase->get_testType() . "</p>
                            <div>";
    foreach ($testCase->get_modules() as $module) {
        $returnstr .= draw_div_Module($module);
    }
    $returnstr .= "    </div>
                        </div>
                      </div>";
    return $returnstr;
}

function draw_testcase_accordion($testcaselist)
{
    $returnstr ="  
    <script>
        $(function() {
            var icons = {
                header: 'iconClosed', //virker ikke
                headerSelected: 'iconOpen' //virker ikke
            };
            $( '#testcase_accordion' )
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
    <div id='testcase_accordion'>";
    foreach ($testcaselist as $testcase)
    {
        $returnstr .= draw_testcase_div_with_modules($testcase);
    }
    $returnstr .="</div>";
    return $returnstr;
}

function draw_add_testcase($phpfile, $productid, $con)
{
    $returnstr = "<script>
/** add testcase dialog **/
$( function addTestcaseDialog() {
    var dialog, form,

        // From http://www.whatwg.org/specs/web-apps/current-work/multipage/states-of-the-type-attribute.html#e-mail-state-%28type=email%29
        /*emailRegex = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/,*/
        id = $( '#testcase-id' ),
        name = $( '#testcase-name' ),
        description = $( '#testcase-description' ),
        testrailid = $( '#testcase-testrailid' ),
        testtype = $( '#testtype-select' ),
        product = $( '#product-select' ),
        allFields = $( [] ).add(id).add(name).add(description).add(testrailid).add(testtype).add(product),
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
    
    function checkSelect( o, message ) {
alert('value = ' + o.val());        
if ( o.val() ==  0 || o.val() ==  null) {
            o.addClass( 'ui-state-error' );
            updateTips( message );
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

    function addToTestcase() {
        var valid = true;
        allFields.removeClass( 'ui-state-error' );
        valid = valid && checkLength( name, 'navn', 3, 40 );
        valid = valid && checkLength( description, 'description', 5, 80 );
        valid = valid && checkSelect(product, 'Du skal vælge et produkt.');
        valid = valid && checkSelect(testtype, 'Du skal vælge en testtype.');

        if ( valid ) {
            var i = id.val();
            var n = name.val();
            var d = description.val();
            var tr = testrailid.val();
            var tt = testtype.val();
            var p = product.val();
            dialog.dialog( 'close' );
            persistTestcase(i, n, d, tr, tt, p);
        }
        return valid;
    }

    function persistTestcase(i, n, d, tr, tt, p) {
        var xhttp;
        if (n == '') {
            document.getElementById('" . $return_tag_id . "').innerHTML = '';
            return;
        }
        var params = 'id=' + i + '&name=' + n + '&description=' + d + '&testrailid=' + tr + '&testtypeid=' + tt + '&productid=' + p;
        alert('params = ' + params);
        alert('&productid=' + p);
        xhttp = new XMLHttpRequest();
        xhttp.open('POST', '" . $phpfile . "', true);
        xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // alert(xhttp.responseText);
                //document.getElementById('" . $return_tag_id . "').innerHTML = this.responseText;
                console.log('xhttp.responseText', xhttp.responseText);
            }
        };
        xhttp.send(params);
        location.reload();
    }


    dialog = $( '#testcase-dialog-form' ).dialog({
        autoOpen: false,
        height: 300,
        width: 350,
        modal: true,
        buttons: {
            'Opret testcase': addToTestcase,
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
        addToTestcase();
    });

    $( '#create-testcase' ).button().on( 'click', function() {
        dialog.dialog( 'open' );
    });

    function edit_testcase(old_name, old_description, header){
        $('#empId').val(empId);
        $('#fieldId').val(fieldId);
        $('#fieldName').val(name);
        $('#fieldValue').val(value);
        $('#customFieldDialog').dialog('open');
        return false;
    }
} );
</script>
<div id='testcase-dialog-form' title='Opret nyt testcase'>
  <p class='validateTips'>Name og Description skal udfyldes.</p>
 
  <form>
    <fieldset>
      <label for='name'>Name</label>
      <input type='text' name='name' id='testcase-name' value='' class='text ui-widget-content ui-corner-all'>
      <label for='description'>Description</label>
      <input type='text' name='description' id='testcase-description' value='' class='text ui-widget-content ui-corner-all'>
      <label for='description'>TestRailID</label>
      <input type='text' name='testrailid' id='testcase-testrailid' value='' class='text ui-widget-content ui-corner-all'>
      <input type='hidden' name='id' id='testcase-id' value='0' >
      <label for='testtype'>Testtype</label>
      <select name='testtype' id='testtype-select'>";
    
      $products = new Products($con);
      $testtypelist = $products->get_testtype_list();
      
      $returnstr .= "<option value='' selected disabled hidden>Set testtype</option>";
        foreach ($testtypelist as $row) {
            $returnstr .= "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
        }
        $returnstr .= "</select><br>
      <label for='product'>Produkt</label>
      <select name='product' id='product-select'>";

    
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
<button class='btn sqaure_bt' id='create-testcase'>Opret testcase</button>";
    return $returnstr;
}
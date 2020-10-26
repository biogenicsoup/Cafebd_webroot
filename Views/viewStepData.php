<?php
function draw_stepdata_li (StepData $stepdata) {
    $returnstring = "<li>Name = ". $stepdata->get_name() ." : Value = " . $stepdata->get_value() . "</li>";
    return $returnstring;
}

function draw_edit_li (StepData $stepdata) {
    return "<li><form name='editStepData' method='post' action='href'>
                    Name: <input name='stepdataname-".$stepdata->get_id()."' type='text' id='stepdataname-".$stepdata->get_id()."' value ='". $stepdata->get_name() .">
                    Value: <input name='stepdatavalue-".$stepdata->get_id()."' type='text' id='stepdatavalue-".$stepdata->get_id()."' value ='". $stepdata->get_value() .">
                    <input type='hidden' id='stepid' name='stepid' value='" . $stepdata->get_stepid() . "'>
                    <Input type = 'Submit' Value = 'gem' class='button'></form>
                </li>";
}
function draw_add_li (Step $step, $postPrefix) {
    return "<li><form name='addStepData' method='post' action='href'>
                    Name: <input name='stepdataname-0' type='text' id='stepdataname-0'>
                    Value: <input name='stepdatavalue-0' type='text' id='stepdatavalue-0'>
                    <input type='hidden' id='stepid' name='stepid' value='" . $step->get_id() . "'>
                    <Input type = 'Submit' Value = 'gem' class='button'>
                    </form>
                </li>";
}

function draw_add_stepdata($phpfile, $stepid)
{
    $returnstr = "<script>
/** add stepdata dialog **/
$( function addStepDataDialog() {
    var dialog, form,

        // From http://www.whatwg.org/specs/web-apps/current-work/multipage/states-of-the-type-attribute.html#e-mail-state-%28type=email%29
        /*emailRegex = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/,*/
        id = $( '#stepdata-id' ),
        name = $( '#stepdata-name' ),
        value = $( '#stepdata-value' ),
        stepid = $( '#step-id' ),
        allFields = $( [] ).add(id).add(name).add(value).add(stepid),
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

    function addToStepdata() {
        var valid = true;
        allFields.removeClass( 'ui-state-error' );
        valid = valid && checkLength( name, 'navn', 1, 40 );
        valid = valid && checkLength( value, 'value', 1, 255 );
       
        if ( valid ) {
            var i = id.val();
            var n = name.val();
            var v = value.val();
            var s = stepid.val();
            dialog.dialog( 'close' );
            persistStepdata(i, n, v, s);
        }
        return valid;
    }

    function persistStepdata(i, n, v, s) {
        var xhttp;
        if (n == '') {
            document.getElementById('" . $return_tag_id . "').innerHTML = '';
            return;
        }
        var params = 'id=' + i + '&name=' + n + '&value=' + v + '&stepid=' + s;
        alert('params = ' + params);
        xhttp = new XMLHttpRequest();
        xhttp.open('POST', '" . $phpfile . "', true);
        xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // alert(xhttp.responseText);
                //document.getElementById('" . $return_tag_id . "').innerHTML = this.responseText;
                console.log('xhttp.responseText', xhttp.responseText);
                location.reload();
            }
        };
        xhttp.send(params);
        
    }


    dialog = $( '#stepdata-dialog-form' ).dialog({
        autoOpen: false,
        height: 500,
        width: 620,
        modal: true,
        buttons: {
            'Opret stepdata': addToStepdata,
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
        addToStepdata();
    });

    $( '#create-stepdata' ).button().on( 'click', function() {
        dialog.dialog( 'open' );
    });

    function edit_stepdata(old_name, old_description, header){
        $('#empId').val(empId);
        $('#fieldId').val(fieldId);
        $('#fieldName').val(name);
        $('#fieldValue').val(value);
        $('#customFieldDialog').dialog('open');
        return false;
    }
} );
</script>
<div id='stepdata-dialog-form' title='Opret nyt stepdata'>
  <p class='validateTips'>Name og value skal udfyldes.</p>
 
  <form>
    <fieldset>
      <label for='stepdata-name'>Name:</label>
      <input type='text' name='name' id='stepdata-name' value='' class='text ui-widget-content ui-corner-all'><br>
      <label for='stepdata-value'>Value:</label>
      <textarea id='stepdata-value' name='stepdata-value' rows='10' cols='70'></textarea>
      <input type='hidden' name='id' id='stepdata-id' value='0' >
      <input type='hidden' name='stepid' id='step-id' value='".$stepid."' >
      
      <!-- Allow form submission with keyboard without duplicating the dialog button -->
      <input type='submit' tabindex='-1' style='position:absolute; top:-10000px'>
    </fieldset>
  </form>
</div>
<button class='btn sqaure_bt' id='create-stepdata'>Opret stepdata</button>";
    return $returnstr;
}
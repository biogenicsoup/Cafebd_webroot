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

function draw_add_stepdata_dialog($phpfile)
{
    $returnstr = draw_addedit_stepdata_dialog_script($phpfile);
    $returnstr .=  draw_addedit_stepdata_dialog_form();
    return $returnstr;
}
    
function draw_addedit_stepdata_dialog_script($phpfile)
{
    $returnstr = "<script>
/** add stepdata dialog **/
$( function addStepDataDialog() {
    var stepdatadialog, stepdataform,

        id = $( '#stepdata-id' ),
        name = $( '#stepdata-name' ),
        value = $( '#stepdata-value' ),
        stepid = $( '#stepdata-step-id' ),
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
            stepdatadialog.dialog( 'close' );
            persistStepdata(i, n, v, s);
        }
        return valid;
    }

    function persistStepdata(i, n, v, s) {
        var xhttp;
        var params = 'id=' + i + '&name=' + n + '&value=' + v + '&stepid=' + s;
        //alert('params = ' + params);
        xhttp = new XMLHttpRequest();
        xhttp.open('POST', '" . $phpfile . "', true);
        xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // alert(xhttp.responseText);
                console.log('xhttp.responseText', xhttp.responseText);
                location.reload(false);
            }
        };
        xhttp.send(params);
        
    }

    stepdatadialog = $( '#stepdata-dialog-form' ).dialog({
        autoOpen: false,
        height: 500,
        width: 620,
        modal: true,
        buttons: {
            'Gem': addToStepdata,
            Cancel: function() {
                stepdatadialog.dialog( 'close' );
            }
        },
        close: function() {
            stepdataform[ 0 ].reset();
            allFields.removeClass( 'ui-state-error' );
        }
    });
    //dialog 
    stepdataform = stepdatadialog.find( 'form' ).on( 'submit', function( event ) {
        event.preventDefault();
        addToStepdata();
    });

    $( '#create-stepdata' ).button().on( 'click', function() {
        stepdatadialog.dialog( 'open' );
    });
} );

    function add_stepdata(stepid, header){
        //console.log('add_stepdata: stepid =' + stepid + ' header = ' + header);
        //console.log($( '#stepdata-dialog-form' ));
        $( '#stepdata-dialog-form').dialog({ title: header });
        $('#stepdata-name').val('');
        $('#stepdata-value').val('');
        $('#stepdata-id').val(0);
        $('#stepdata-step-id').val(stepid);
        $( '#stepdata-dialog-form' ).dialog('open');
        return false;
    }
    
    function edit_stepdata(stepid, stepdataid, header, name, value){
        console.log('edit_stepdata: stepid =' + stepid + ' header = ' + header);
        console.log($( '#stepdata-dialog-form' ));
        $( '#stepdata-dialog-form').dialog({ title: header });
        $('#stepdata-name').val(name);
        $('#stepdata-value').val(value);
        $('#stepdata-id').val(stepdataid);
        $('#stepdata-step-id').val(stepid);
        $( '#stepdata-dialog-form' ).dialog('open');
        return false;
    }
</script>";
return $returnstr;
}

function draw_addedit_stepdata_dialog_form()
{
    $returnstr = "
<div id='stepdata-dialog-form' title='Opret nyt stepdata'>
  <p class='validateTips'>Name og value skal udfyldes.</p>
 
  <form>
    <fieldset>
      <label for='stepdata-name'>Name:</label>
      <input type='text' name='name' id='stepdata-name' value='' class='text ui-widget-content ui-corner-all'><br>
      <label for='stepdata-value'>Value:</label>
      <textarea id='stepdata-value' name='stepdata-value' rows='10' cols='70'></textarea>
      <input type='hidden' name='id' id='stepdata-id' value='0' >
      <input type='hidden' name='stepid' id='stepdata-step-id' value='0' >
      
      <!-- Allow form submission with keyboard without duplicating the dialog button -->
      <input type='submit' tabindex='-1' style='position:absolute; top:-10000px'>
    </fieldset>
  </form>
</div>";
return $returnstr;
}

function draw_opretstepdata_button($stepid)
{
    $header = "\"Opret stepdata\"";
    /*class='btn sqaure_bt'*/
    return "<button id='add-stepdata'  class='btn main_bt' onclick='add_stepdata(".$stepid.", ".$header.")'>Opret stepdata</button>";
}

function draw_editstepdata_button($stepid, $stepdataid, $name, $value, $buttontext)
{
    $header = "\"Edit stepdata\"";
    return "<button id='edit-stepdata' class='btn main_bt' onclick='edit_stepdata(".$stepid.", ".$stepdataid.", ".$header.", \"".$name."\", \"".$value."\")'>".$buttontext."</button>";
}
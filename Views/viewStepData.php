<?php
function draw_li (StepData $stepdata) {
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
<?php
include 'viewModule.php';
function draw_testcase_div_with_modules(TestCase $testCase)
{
    $returnstr = "<div class='group'>
                        <h3>" . $testCase->get_name() . "</h3><input type='button' class='button' onclick='alert(\"you clicked!\")'>
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
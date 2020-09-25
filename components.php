<?php

function accordion ($array, $linkpage)
{
    //assume array is og structure array[x]=(id=>int, name=>string, description=>string);
    echo "<div class='panel-group' id='accordion'>";


    foreach ($array as $row) {
        echo "    <div class='panel panel-default'>
                      <div class='panel-heading'>
                        <p class='panel-title'> 
                            <a data-toggle='collapse' data-parent='#accordion' href='#collapse" . $row['id'] . "'>
                                <i class='fa fa-bar-chart' aria-hidden='true'></i>
                                 " . $row['name'] . "
                                 <i class='fa fa-angle-down'></i>
                             </a>
                        </p>
                      </div>
                      <div id='collapse" . $row['id'] . "' class='panel-collapse collapse'>
                        <div class='panel-body'>
                          <p><a href='".$linkpage."?id=".$row['id']."'>".$row['description']."</a></p>
                        </div>
                      </div>
                  </div>";
    }
    echo "    </div>";
}
?>
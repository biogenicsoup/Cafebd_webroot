<?php

$overskrift = "Teamet";
$hovertext = "'Teamet'";
$pagename = "Region Midt: Teamet";

include 'defaults.php';
include 'session.php';
include 'header.php';
include 'banner.php';
include 'connect.php';

echo "
<div class='section padding_layout_1'>
  <div class='container'>
    <div class='row'>
      <div class='col-md-12'>
        <div class='full'>
          <div class='main_heading text_align_left'>
            <h2>Mød vores fantastiske team</h2>
            <p class='large'>Noget om teamet.</p>
          </div>
        </div>
      </div>
    </div>
    <div class='row'>";

$social = array (
                    "<a class='fa fa-facebook' href='https://www.facebook.com/' title='Facebook' target='_blank'></a>",
                    "<a class='fa fa-google-plus' href='https://plus.google.com/' title='Google+' target='_blank'></a>",
                    "<a class='fa fa-twitter' href='https://twitter.com' title='Twitter' target='_blank'></a>",
                    "<a class='fa fa-linkedin' href='https://www.linkedin.com' title='LinkedIn' target='_blank'></a>",
                    "<a class='fa fa-instagram' href='https://www.instagram.com' title='Instagram' target='_blank'></a>"
                );

/* bør flyttes til db*/
$theteam = array (
                    array('images/it_service/team-member-1.jpg','Flemming Mannov Laursen', $social),
                    array('images/it_service/team-member-2.jpg','Randi Braüner Nielsen ', $social),
                    array('images/it_service/team-member-3.jpg','Peter Timmermann Kjeldsen', $social),
                    array('images/it_service/team-member-4.jpg','Kim Vogel', $social)
                );

$returnstr ="";
foreach ($theteam as $row) {
    $returnstr .= "<div class='col-md-3 col-sm-6'>
                    <div class='full team_blog_colum'>
                        <div class='it_team_img'> <img class='img-responsive' src='" . $row[0] . "' alt='#'> </div>
                        <div class='team_feature_head'>
                            <h4>" . $row[1] . "</h4>
                        </div>
                        <div class='team_feature_social'>
                        <div class='social_icon'>
                            <ul class='list-inline'>";

    foreach ($row[2] as $socialrow) {
        $returnstr .= "<li>" . $socialrow . "</li>";
    }

    $returnstr .= "                    </ul>
                                    </div>
                                </div>
                            </div>
                        </div>";
}
echo $returnstr;
include 'footer.php';



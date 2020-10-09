<?php
$overskrift = "Test";
$hovertext = "'Test'";
$pagename = "Region Midt: Test";
include 'header.php';
include 'banner.php';
echo"  
<script>
  $(function() {
      var icons = {
         header: 'iconClosed', //virker ikke
         headerSelected: 'iconOpen' //virker ikke
      };
      $( '#jQuery_accordion' )
      //$( '#accordion > div' )
      .accordion({
        collapsible:true,
        active: false,
        header: '> div > h3',
        icons: icons
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


<div id='jQuery_accordion'>
<div class='group'>
  <h3>hepehey</h3>
    <div>
    <p>
    This is section 1. Place your content here in paragraphs or use div elements etc.
    </p>
    </div>
</div>    
<div class='group'>
  <h3>Whaaaaaaat</h3>
    <div>
    <p>
    This is sextion 2. You can also include images
    </p>
    </div>
</div>  
<div class='group'>
  <h3>Is this a style</h3>
    <div>
    <p>
    This is section 3. Content can include listing as well.
    <ol>
      <li>item 1</li>
      <li>Item 2</li>
      <li>Item 3</li>
    </ol>
    </p>
    </div>
</div>
</div>";
include 'footer.php';
 
?>

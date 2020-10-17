<?php
$overskrift = "Suites";
$hovertext = "'Suites'";
$pagename = "Region Midt: Suites";

$productid = 0;
if (isset($_POST['id']))
{
    $productid = $_POST['id'];
} else if (isset($_GET['id']))
{
    $productid = $_GET['id'];
}
if($productid == 0)
{
    header('Location: Page_products.php');
    exit("could not find product id: redirected to page_products.php");
}

include_once 'defaults.php';
include_once 'header.php';
include_once 'banner.php';
//include 'components.php';
include_once 'mustbeloggedin.php';
include_once 'Views/viewSuite.php';
include_once 'classes/Product.php';
include_once 'Views/viewTestCase.php';

/**
 * @var $con
 */

echo "
    <script>
        (function( $, undefined ) {

$.widget( 'ui.accordion', $.ui.accordion, {
    
    options: {
         target: false,
         accept: false,
         header: '> h3, > div > h3'
    },

    _teardownEvents: function( event ) {

        var self = this,
            events = {};

        if ( !event ) {
            return;
        }

        $.each( event.split(' '), function( index, eventName ) {
            self._off( self.headers, eventName );
        });

    },

    _createTarget: function() {

        var self = this,
            draggableOptions = {
                handle: 'h3',
                helper: 'clone',
                connectToSortable: this.options.target,
            };

        this.headers.each( function() {
            $( this ).next()
                     .addBack()
                     .wrapAll( '<div/>' )
                     .parent()
                     .draggable( draggableOptions );
        });
    },

    _createAccept: function() {

        var self = this,
            options = self.options,
            target = $( options.accept ).data( 'uiAccordion' );

        var sortableOptions = {

            stop: function ( event, ui ) {

                var dropped       = $(ui.item),
                    droppedHeader = dropped.find('> h3'),
                    droppedClass  = 'ui-draggable',
                    droppedId;

                if ( !dropped.hasClass( droppedClass ) ) {
                    return;
                }
                
                // Get the original section ID, reset the cloned ID.
                droppedId = droppedHeader.attr( 'id' );
                droppedHeader.attr( 'id', '' );

                // Include dropped item in headers
                self.headers = self.element.find( options.header )

                // Remove old event handlers
                self._off( self.headers, 'keydown' );
                self._off( self.headers.next(), 'keydown' );
                self._teardownEvents( options.event );

                // Setup new event handlers, including dropped item.
                self._hoverable( droppedHeader );
                self._focusable( droppedHeader );
                self._on( self.headers, { keydown: '_keydown' } );
                self._on( self.headers.next(), { keydown: '_panelKeyDown' } );
                self._setupEvents( options.event );
				
				                // Perform cleanup
                $( '#' + droppedId ).parent().fadeOut( 'slow', function() {
                    $( this ).remove();
                    target.refresh();
                });

                dropped.removeClass( droppedClass );

            }

        };

        this.headers.each( function() {
            $(this).next()
                   .addBack()
                   .wrapAll( '<div/>' );
        });

        this.element.sortable( sortableOptions );

    },

    _create: function() {

        this._super( '_create' );

        if ( this.options.target ) {
            this._createTarget();
        }

        if ( this.options.accept ) {
            this._createAccept();
        }

    },

    _destroy: function() {

        this._super( '_destroy' );
        
        if ( this.options.target || this.options.accept ) {

            this.headers.each( function() {
                $( this ).next()
                         .addBack()
                         .unwrap( '<div/>' );
            });
        }
    }

});

})( jQuery );

$(function() {

    $( '#target-accordion' ).accordion({
        target: '#accept-accordion'
    });

    $( '#accept-accordion' ).accordion({
        accept: '#target-accordion' 
    });

});
</script>";

echo"
<div id='target-accordion' style='width: 30%'>
    <h3>Section 1</h3>
    <div>
        <p>Section 1 content</p>
    </div>
    <h3>Section 2</h3>
    <div>
        <p>Section 2 content</p>
    </div>
    <h3>Section 3</h3>
    <div>
        <p>Section 3 content</p>
    </div>
</div>
<p></p>
<div id='accept-accordion' style='width: 30%'>
    <h3>Section 4</h3>
    <div>
        <p>Section 4 content</p>
    </div>
    <h3>Section 5</h3>
    <div>
        <p>Section 5 content</p>
    </div>
    <h3>Section 6</h3>
    <div>
        <p>Section 6 content</p>
    </div>
</div>";

/*$product = new Product($productid, $con);
echo "<div class='container'>
        <div class='row'>
            <div class='col-7'>
                <div id='suite-accordion' >";
echo draw_suite_accordion($product->get_suites());
echo "          </div>
                <div>";
                    echo draw_add_suite('suitelist','addEditSuite.php', $productid, $con);
echo "          </div>
            </div>
            <div class='col-5'>
                <div id='testcaselist'>";
echo draw_testcase_accordion($product->get_testcases());
echo "          </div>
                <div>";
                    echo draw_add_testcase('testcaselist','addEditTestCase.php', $productid, $con);
echo "          </div>
            </div>
        </div>
      </div>";

*/
include 'footer.php';
?>
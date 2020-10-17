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

echo "
<script>
    $(function()
    {
        var options = {
                placeholderCss: {'background-color': '#ff8'},
                hintCss: {'background-color':'#bbf'},
                onChange: function( cEl )
                {
                        console.log( 'onChange' );
                },
                complete: function( cEl )
                {
                        console.log( 'complete' );
                },
                isAllowed: function( cEl, hint, target )
                {
                        // Be carefull if you test some ul/ol elements here.
                        // Sometimes ul/ols are dynamically generated and so they have not some attributes as natural ul/ols.
                        // Be careful also if the hint is not visible. It has only display none so it is at the previous place where it was before(excluding first moves before showing).
                        if( target.data('module') === 'c' && cEl.data('module') !== 'c' )
                        {
                                hint.css('background-color', '#ff9999');
                                return false;
                        }
                        else
                        {
                                hint.css('background-color', '#99ff99');
                                return true;
                        }
                },
                opener: {
                        active: true,
                        as: 'html',  // if as is not set plugin uses background image
                        close: '<i class='fa fa-minus c3'></i>',  // or 'fa-minus c3'
                        open: '<i class='fa fa-plus'></i>',  // or 'fa-plus'
                        openerCss: {
                                'display': 'inline-block',
                                //'width': '18px', 'height': '18px',
                                'float': 'left',
                                'margin-left': '-35px',
                                'margin-right': '5px',
                                //'background-position': 'center center', 'background-repeat': 'no-repeat',
                                'font-size': '1.1em'
                        }
                },
                ignoreClass: 'clickable'
        };

        var optionsPlus = {
                insertZonePlus: true,
                placeholderCss: {'background-color': '#ff8'},
                hintCss: {'background-color':'#bbf'},
                opener: {
                        active: true,
                        as: 'html',  // if as is not set plugin uses background image
                        close: '<i class='fa fa-minus c3'></i>',
                        open: '<i class='fa fa-plus'></i>',
                        openerCss: {
                                'display': 'inline-block',
                                'float': 'left',
                                'margin-left': '-35px',
                                'margin-right': '5px',
                                'font-size': '1.1em'
                        }
                }
        };

        $('#sTree2').sortableLists( options );
        $('#sTreePlus').sortableLists( optionsPlus );

        $('#toArrBtn').on( 'click', function(){ console.log( $('#sTree2').sortableListsToArray() ); } );
        $('#toHierBtn').on( 'click', function() { console.log( $('#sTree2').sortableListsToHierarchy() ); } );
        $('#toStrBtn').on( 'click', function() { console.log( $('#sTree2').sortableListsToString() ); } );
        $('.descPicture').on( 'click', function(e) { $(this).toggleClass('descPictureClose'); } );

        $('.clickable').on('click', function(e)	{ alert('Click works fine! IgnoreClass stopped onDragStart event.'); });

        /* Scrolling anchors */
        $('#toPictureAnch').on( 'mousedown', function( e ) { scrollToAnch( 'pictureAnch' ); return false; } );
        $('#toBaseElementAnch').on( 'mousedown', function( e ) { scrollToAnch( 'baseElementAnch' ); return false; } );
        $('#toBaseElementAnch2').on( 'mousedown', function( e ) { scrollToAnch( 'baseElementAnch' ); return false; } );
        $('#toCssPatternAnch').on( 'mousedown', function( e ) { scrollToAnch( 'cssPatternAnch' ); return false; } );

        function scrollToAnch( id )
        {
                return true;
                $('html, body').animate({
                        scrollTop: '-=-' + $('#' + id).offset().top + 'px'
                }, 750);
                return false;
        }
    });
</script>";




/**
 * @var $con
 */

$product = new Product($productid, $con);
echo "<div class='container'>
        <div class='row'>
            <div class='col-7'>
                <div id='suitelist' >
                    <ul class='sTree2 listsClass' id='sTree2'>
                        <li id='item_a' data-module='a'>
                            <div>Item a</div>
                        </li>
                        <li class='s-l-open' id='item_b' data-module='b'>
                            <div>
                                <span class='s-l-opener' style='float: left; display: inline-block; background-position: center center; background-repeat: no-repeat; margin-left: -35px; margin-right: 5px; font-size: 1.1em;'>
                                    <i class='fa fa-minus c3'></i>
                                </span>Item b
                            </div>
                            <ul class='' style='display: block;'>
                                <li id='item_b1' data-module='b'>
                                    <div>Item b1</div>
                                </li>
                                <li id='item_b1' data-module='b'>
                                    <div>
                                        <span class='clickable'>Item b2 - clickable text</span>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li class='s-l-closed' id='item_c' data-module='c'>
                            <div>
                                <span class='s-l-opener' style='float: left; display: inline-block; background-position: center center; background-repeat: no-repeat; margin-left: -35px; margin-right: 5px; font-size: 1.1em;'>
                                    <i class='fa fa-plus'></i>
                                </span>Item c - c block disallows inserting items from other blocks</div>
                            <ul class='' style='display: none;'>
                                <li id='item_c1' data-module='c'>
                                        <div>Item c1</div>
                                </li>
                                <li id='item_c2' data-module='c'>
                                        <div>Item c2</div>
                                </li>
                            </ul>
                        </li>
                        <li class='s-l-closed' id='item_d' data-module='d'>
                            <div>
                                <span class='s-l-opener' style='float: left; display: inline-block; background-position: center center; background-repeat: no-repeat; margin-left: -35px; margin-right: 5px; font-size: 1.1em;'>
                                    <i class='fa fa-plus'></i>
                                </span>Item d
                            </div>
                            <ul class='' style='display: none;'>
                                <li id='item_d1' data-module='d'>
                                        <div>Item d1</div>
                                </li>
                                <li id='item_d2' data-module='d'>
                                        <div>Item d2</div>
                                </li>
                            </ul>
                        </li>
                        <li class='' id='item_e' data-module='e'>
                            <div>Item e</div>
                        </li>	
                    </ul>";

/*echo draw_suite_accordion($product->get_suites());*/
echo "          </div>
                <div>";
                    echo draw_add_suite('addEditSuite.php', $productid, $con);
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


include 'footer.php';
?>
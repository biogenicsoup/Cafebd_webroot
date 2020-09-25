<!doctype html>
<html lang="en">
<head>
    <title>jQuery UI Selectable() Method - Display as grid</title>
    <link rel="stylesheet"
          href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <style type="text/css">
        #grid .ui-selecting {
            background: aqua;
        }
        #grid .ui-selected {
            background: yellow;
            color: green;
        }
        #grid {
            list-style-type: none;
            margin: 0;
            padding: 0;
            width: 450px;
        }
        #grid li {
            margin: 3px;
            padding: 1px;
            float: left;
            width: 50px;
            height: 50px;
            font-size: 2.5em;
            text-align: center;
        }
    </style>
    <script src="https://code.jquery.com/jquery-1.12.4.js">
    </script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js">
    </script>
    <script>
        $( function() {
            $( "#grid" ).selectable();
        });
    </script>
</head>
<body>
<center>
    <h1>Geeks for Geeks</h1>
    <ol id="grid">
        <li class="ui-state-default">1</li>
        <li class="ui-state-default">2</li>
        <li class="ui-state-default">3</li>
        <li class="ui-state-default">4</li>
        <li class="ui-state-default">5</li>
        <li class="ui-state-default">6</li>
        <li class="ui-state-default">7</li>
        <li class="ui-state-default">8</li>
        <li class="ui-state-default">9</li>
        <li class="ui-state-default">10</li>
        <li class="ui-state-default">11</li>
        <li class="ui-state-default">12</li>
        <li class="ui-state-default">13</li>
        <li class="ui-state-default">14</li>
        <li class="ui-state-default">15</li>
        <li class="ui-state-default">16</li>
        <li class="ui-state-default">17</li>
        <li class="ui-state-default">18</li>
        <li class="ui-state-default">19</li>
        <li class="ui-state-default">20</li>
        <li class="ui-state-default">21</li>
        <li class="ui-state-default">22</li>
        <li class="ui-state-default">23</li>
        <li class="ui-state-default">24</li>
        <li class="ui-state-default">25</li>
        <li class="ui-state-default">26</li>
        <li class="ui-state-default">27</li>
        <li class="ui-state-default">28</li>
    </ol>
</center>
</body>
</html>
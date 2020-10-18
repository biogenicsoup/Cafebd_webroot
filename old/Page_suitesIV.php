<?php

echo "<link rel='stylesheet' href='http://lukasoppermann.github.io/html5sortable/basscss.css'>";


echo "<script src='js/html5sortable.js'></script>
<script src='js/jquery.min.js'></script>";

echo "<section class='mb3 mx-auto col col-12'>
  		<div class='p3 clearfix bg-navy yellow'>
				<div class='col col-6'>
			    <h2 class='h3 m0'>
						Sortable List
			    </h2>
					<div class='mt2 p2 bg-navy border yellow border-yellow'>
				    <code class='mb0'>
							<div>sortable('.o-sortable', {</div>
							<div class='px2 muted'>
								forcePlaceholderSize: true,<br>
								placeholderClass: 'ph-class', <br>
								hoverClass: 'bg-maroon yellow' <br>
							</div>
							<div>});</div>
						</code>
  				</div>
		    </div>
				<div class='col col-6'>
					<ul class='ml4 js-sortable sortable list flex flex-column list-reset' aria-dropeffect='move'>
						<li class='p1 mb1 navy bg-yellow' style='position: relative; z-index: 10' draggable='true' role='option' aria-grabbed='false'>Item 1</li>
						<li class='p1 mb1 navy bg-yellow' style='position: relative; z-index: 10' draggable='true' role='option' aria-grabbed='false'>Item 2</li>
						<li class='p1 mb1 navy bg-yellow' style='position: relative; z-index: 10' draggable='true' role='option' aria-grabbed='false'>Item 3</li>
						<li class='p1 mb1 navy bg-yellow' style='position: relative; z-index: 10' draggable='true' role='option' aria-grabbed='false'>Item 4</li>
						<li class='p1 mb1 navy bg-yellow' style='position: relative; z-index: 10' draggable='true' role='option' aria-grabbed='false'>Item 5</li>
						<li class='p1 mb1 navy bg-yellow' style='position: relative; z-index: 10' draggable='true' role='option' aria-grabbed='false'>Item 6</li>
					</ul>
          <button class='ml4 js-serialize-button button navy bg-yellow'>Serialize</button>
					<script type='text/javascript'>
						sortable('.js-sortable', {
							forcePlaceholderSize: true,
							placeholderClass: 'mb1 bg-navy border border-yellow',
							hoverClass: 'bg-maroon yellow',
              itemSerializer: function (item, container) {
                item.parent = '[parentNode]'
                item.node = '[Node]'
                item.html = item.html.replace('<','&lt;')
                return item
              },
              containerSerializer: function (container) {
                container.node = '[Node]'
                return container
              }
						})
            document.querySelector('.js-serialize-button').addEventListener('click', function () {
              let serialized = sortable('.js-sortable', 'serialize')
              document.querySelector('.serialized-content').innerHTML = JSON.stringify(serialized, null, ' ')
            })
					</script>
		    </div>
			</div>
      <div class='p2 bg-navy border-top yellow border-yellow'>
        <h5>Serialized:</h5>
        <code>
          <pre class='serialized-content'>          </pre>
        </code>
      </div>
		</section>";


echo "
    <section class='mb3 mx-auto col col-12'>
  		<div class='p3 bg-white orange col col-6'>
		    <h2 class='h3 m0'>
					Connected lists
		    </h2>
				<p>Connected: This means an item can be dragged into another (connected) list.</p>
				<p class='mb2'>Handles: Elements, e.g. || an item can be dragged with.</p>
				<ul class='js-sortable-connected list flex flex-column list-reset' aria-dropeffect='move'>
					<script>// scripts are needed for a test for indexes in sortupdate</script>
					<script></script>
					<script></script>
          <li class='p1 mb1 border border-white white bg-orange' role='option' aria-grabbed='false'><span class='js-handle px1' draggable='true'>||</span><span draggable='true' ondragstart='console.log('I am testing that draggable elements do not act as handles')'>Item 1</span></li>
					<li class='p1 mb1 border border-white white bg-orange' role='option' aria-grabbed='false'>
						<div class='mb1'><span class='js-handle px1' draggable='true'>||</span>Only 3 children allowed</div>
					<ul class='js-sortable-inner-connected list flex flex-column list-reset m0 py1' aria-dropeffect='move'>
						<li class='p1 mb1 border border-blue white bg-blue item' role='option' aria-grabbed='false'><span class='js-inner-handle px1' draggable='true'>||</span>Inner item 1</li>
						<li class='p1 mb1 border border-blue white bg-blue item' role='option' aria-grabbed='false'><span class='js-inner-handle px1' draggable='true'>||</span>Inner item 2</li>
					</ul>
					</li>
					<li class='p1 mb1 border border-white white bg-orange' role='option' aria-grabbed='false'><span class='js-handle px1' draggable='true'>||</span>Item 3</li>
					<li class='p1 mb1 border border-white white bg-orange' role='option' aria-grabbed='false'><span class='js-handle px1' draggable='true'>||</span>Item 4</li>
					<li class='p1 mb1 border border-white white bg-orange' role='option' aria-grabbed='false'><span class='js-handle px1' draggable='true'>||</span>Item 5</li>
					<li class='p1 mb1 border border-white white bg-orange' role='option' aria-grabbed='false'><span class='js-handle px1' draggable='true'>||</span>Item 6</li>
				</ul>
			</div>
			<div class='p3 bg-orange white col col-6'>
				<div class='px3 py2 border border-white mb1'>
					<code class='mb0'>
						<div class='muted'>// white &amp; orange items</div>
						<div>sortable('.o-sortable', {</div>
						<div class='px2'>connectWith: 'js-connected'</div>
						<div>});</div>
						<div class='muted'>// blue items</div>
						<div>sortable('.o-sortable-inner', {</div>
						<div class='px2'>connectWith: 'js-inner-connected'</div>
						<div>});</div>
					</code>
				</div>
				<ul class='js-sortable-connected list flex flex-column list-reset' aria-dropeffect='move'>
					<li class='p1 mb1 border border-orange orange bg-white' role='option' aria-grabbed='false'><span class='js-handle px1' draggable='true'>||</span>Item 1</li>
					<li class='p1 mb1 white bg-blue js-handle px1' draggable='true' role='option' aria-grabbed='false'>Item X</li>
                                        <li class='p1 mb1 border border-orange orange bg-white' role='option' aria-grabbed='false'><span class='js-handle px1' draggable='true'>||</span>Item 2</li>
					<li class='p1 mb1 border border-orange orange bg-white' role='option' aria-grabbed='false'><span class='js-handle px1' draggable='true'>||</span>Item 3</li>
					<li class='p1 mb1 border border-orange orange bg-white' role='option' aria-grabbed='false'>
						<div class='mb1'><span class='js-handle px1' draggable='true'>||</span>Only 3 children allowed</div>
						<ul class='js-sortable-inner-connected list flex flex-column list-reset mb0 py1' aria-dropeffect='move'>
							<li class='p1 mb1 border border-blue white bg-blue item' role='option' aria-grabbed='false'><span class='js-inner-handle px1' draggable='true'>||</span>Inner item 3</li>
							<li class='p1 mb1 border border-blue white bg-blue item' role='option' aria-grabbed='false'><span class='js-inner-handle px1' draggable='true'>||</span>Inner item 4</li>
						</ul>
					</li>
				</ul>
			</div>
		</section>";


echo "<script>
		sortable('.js-sortable-copy', {
		  forcePlaceholderSize: true,
		  copy: true,
				acceptFrom: false,
		  placeholderClass: 'mb1 bg-navy border border-yellow',
		});
		sortable('.js-sortable-copy-target', {
		forcePlaceholderSize: true,
			acceptFrom: '.js-sortable-copy,.js-sortable-copy-target',
		placeholderClass: 'mb1 border border-maroon',
	  });
		sortable('.js-grid', {
					forcePlaceholderSize: true,
					placeholderClass: 'col col-4 border border-maroon'
				});
		sortable('.js-sortable-connected', {
			forcePlaceholderSize: true,
			connectWith: '.js-connected',
			handle: '.js-handle',
			items: 'li',
			placeholderClass: 'border border-white bg-orange mb1'
		});
		sortable('.js-sortable-inner-connected', {
			forcePlaceholderSize: true,
			connectWith: 'js-inner-connected',
			handle: '.js-inner-handle',
			items: '.item',
	maxItems: 3,
			placeholderClass: 'border border-white bg-orange mb1'
		});
		document.querySelector('.js-sortable-connected').addEventListener('sortupdate', function(e){
			console.log('Sortupdate: ', e.detail);
			console.log('Container: ', e.detail.origin.container, ' -> ', e.detail.destination.container);
			console.log('Index: '+e.detail.origin.index+' -> '+e.detail.destination.index);
			console.log('Element Index: '+e.detail.origin.elementIndex+' -> '+e.detail.destination.elementIndex);
		});

		document.querySelector('.js-sortable-connected').addEventListener('sortstart', function(e){
			console.log('Sortstart: ', e.detail);
		});

		document.querySelector('.js-sortable-connected').addEventListener('sortstop', function(e){
			console.log('Sortstop: ', e.detail);
		});

		sortable('.js-sortable-buttons', {
			forcePlaceholderSize: true,
			items: 'li',
			placeholderClass: 'border border-white mb1',
      hoverClass: 'bg-yellow'
		});
		// buttons to add items and reload the list
		// separately to showcase issue without reload
		/*document.querySelector('.js-add-item-button').addEventListener('click', function(){
			doc = new DOMParser().parseFromString(`<li class='p1 mb1 blue bg-white'>new item</li>`, 'text/html').body.firstChild;
			document.querySelector('.js-sortable-buttons').appendChild(doc);
		});*/

		/*document.querySelector('.js-reload').addEventListener('click', function(){
			console.log('Options before re-init:');
			console.log(document.querySelector('.js-sortable-buttons').h5s.data.opts);
			sortable('.js-sortable-buttons');
			console.log('Options after re-init:');
			console.log(document.querySelector('.js-sortable-buttons').h5s.data.opts);
		});*/
		// JS DISABLED
		/*document.querySelector('.js-disable').addEventListener('click', function(){
			var list = document.querySelector('[data-disabled]');
			if ( list.getAttribute('data-disabled') === 'false' ) {
				this.innerHTML = 'Enable';
				sortable(list, 'disable');
				list.setAttribute('data-disabled', true);
				list.classList.add('muted');
			} else {
				this.innerHTML = 'Disable';
				sortable(list, 'enable');
				list.setAttribute('data-disabled', false);
				list.classList.remove('muted');
			}
		});*/

		// Destroy & Init
		/*document.querySelector('.js-destroy').addEventListener('click', function(){
			sortable('.js-sortable-buttons', 'destroy');
		});*/
		/*document.querySelector('.js-init').addEventListener('click', function(){
			sortable('.js-sortable-buttons', {
				forcePlaceholderSize: true,
				items: 'li',
				placeholderClass: 'border border-white mb1'
			})
		});*/
	</script>";




    
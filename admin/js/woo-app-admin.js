(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	 var wa_get_orders_dashboards = function() {
		function _ajax() {
			var _get_orders = $.ajax({
					type: "POST",
					url: ajaxurl,
					data: {
						action: 'wa_refresh_orders',
					},
					async: false
			});
			return _get_orders;
		}
		function _test() {
			$('.test-ajax').on('click', function(e){
				var _init_ajax = _ajax();
				_init_ajax.done(function( msg ) {
			    //console.log(msg);
					$('.orders-list').html(msg);
			  });
			});
		}
		function _get_orders() {
			var _init_ajax = _ajax();
			_init_ajax.done(function( msg ) {
		    //console.log(msg);
				$('.orders-list').html(msg);
		  });
		}
		return {
			init : function() {
				_test();
			},
			getOrders : function() {
				_get_orders();
				alert('aasd');
			}
		};
	}();

	function uniqid(a = "",b = false){
	  var c = Date.now()/1000;
	  var d = c.toString(16).split(".").join("");
	  while(d.length < 14){
	      d += "0";
	  }
	  var e = "";
	  if(b){
	      e = ".";
	      var f = Math.round(Math.random()*100000000);
	      e += f;
	  }
	  return a + d + e;
	}

	function printData( order_id )
	{
	   	//var divToPrint = document.getElementById("list-order-" + order_id);
	   	var divToPrint = jQuery("#list-order-" + order_id).html();
			var getAddress = jQuery("#collapse"+order_id).find('.customer-billing').html();
			var getContact = jQuery("#collapse"+order_id).find('.customer-phone').html();
			var getCustomerNote = jQuery("#collapse"+order_id).find('.customer-notes').html();
			var getPickupDate = jQuery("#collapse"+order_id).find('.pickup-date').html();
			var getPickupTime = jQuery("#collapse"+order_id).find('.pickup-time').html();

	   	var newWin = window.open('', 'Print Orders');
		 	var style = "<style>";
 				style += "body {margin: 1.5cm 8px;}";
 				style += "ul {list-style-type:none;margin:0;padding:0;}";
 				style += ".order-qty {font-weight:bold;}";
 				style += ".to-print{height:100%; width:100mm; }";
 				style += "</style>";

			newWin.document.write('<html><head><title></title>' + style);
      newWin.document.write('</head><body >');

			newWin.document.write('<div class="to-print">');

			newWin.document.write('<h1 style="text-align: center;margin:0;padding:0;">Ny ordre</h1>');

			newWin.document.write('<ul>');
      newWin.document.write(divToPrint);
			newWin.document.write('</ul>');

			newWin.document.write('<ul>');
			newWin.document.write('<li> <p> ' + getAddress + '</p></li>');
			newWin.document.write('<li> <p>Tlf : ' + getContact + '</p></li>');
			newWin.document.write('<li> <p>Afhentningsdato : ' + getPickupDate + '</p></li>');
			newWin.document.write('<li> <p>Afhentningstidspunkt : ' + getPickupTime + '</p></li>');
			newWin.document.write('<li> <p>Kundekommentar : ' + getCustomerNote + '</p></li>');
			newWin.document.write('</ul>');

			newWin.document.write('</div>');

      newWin.document.write('</body></html>');

		 	newWin.print();
	   	newWin.close();
	}

	$( window ).load(function() {
		wa_get_orders_dashboards.init();
		jQuery(document).on('click', '.print-order', function(e){
			e.preventDefault();
			var _this = jQuery(this);
			var _order_id = _this.data('order-id');

			printData(_order_id);
		});
	});

})( jQuery );

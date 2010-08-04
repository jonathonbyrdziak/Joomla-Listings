/**
 * @author  Jonathon Byrd Jonathonbyrd@gmail.com
 * @link	http://www.jonathonbyrd.com
 * @package Mootools 1.2.4.js
 * @script  FacebookPopup.js
 * 
 * @description 
 * The facebook popup is designed to look and feel just like..  yes, the popup
 * used by facebook. the CSS, HTML and images are on borrow from facebook, the
 * Javascript has been developed by Jonathon Byrd.
 * 
 * Only a single popup is allowed on the screen at any given time. I've designed
 * this to allow you to load iframes, ajax or static content right into the popup
 * body.
 * 
 * @example
 * <pre>

<script>
window.addEvent('domready', function() { 
	
	// hunting down any elements with the class of button
	// we'll use the attributes given to this element in order
	// to generate a popup window for it.
	// normally I'll use a <button> to do this
	
	$$('[class*=popup]').each(function(button){
		button.addEvent('click', function(evt) {
			evt.stop();
			
			// check the button to see if it has a title to use, if not, then use the default
			// do the same for all other attributes
			
			new fbPopUp({
				title: (button.getAttribute('title') ? button.getAttribute('title'):''),
				subtitle: (button.getAttribute('subtitle') ? button.getAttribute('subtitle'):''),
				width: (button.getAttribute('width') ? button.getAttribute('width'):'500px'),
				height: (button.getAttribute('height') ? button.getAttribute('height'):'250px'),
				iframe: 'index.php?module=ven_Orders&action=popup' + button.getAttribute('body'),
				onClose : function()
				{
					// reloading the page on load so that it reflects
					// the changes made
					window.location.reload();
				}
				
			}).open();
			
		});
		
	});
	
});
</script>

<html>

	// This is the button element that the above script will be looking for
	// you can see that I have set all the attributes here to affect the popup
	
	<button class='button popup' title='PDF Invoice' subtitle="Order Number:" 
	width="980px" height="600px" body="&type=ViewPdfInvoice&to_pdf=1&record=1">
		View PDF</button>
	
</html>

 * </pre>
 * 
 */
var fbPopUp = new Class({
	
	//implements
	Implements: [Events, Options],
	
	//options
	options: {
		onOpen: $empty,
		onClose: $empty,
		onRequest: $empty,
		
		view: false,
		layout: false,
		task: 'add',
		variables: '',
		layoutView: 'true',
		ajax: false,
		title: 'Title',
		body: false,
		subtitle: 'Sub-Title',
		iframe: false,
		width: '500px',
		height: '500px'
		/*,
		buttons: {
			Save : function (){
				alert('save worked');
			},
			Apply : function (){
				alert('apply worked');
			}

		}
		*/
		
	},
	
	/**
	 * Initialize the popup
	 * 
	 * Method sets as much work as it can do at this moment and waits.
	 * 
	 * @return void
	 */
	initialize: function(options) {
		//set options
		this.setOptions(options);
		
		fbPopUps = this;
		
		//If there's an iframe, start loading it now
		if (this.options.iframe)
		{
			this.iframe = new Element('iframe', {'id':'popup_inner_iframe',
				'width':this.options.width, 'height':this.options.height,
				'name':'popup_inner_iframe', 'src': this.options.iframe,
				'styles': {'border':'none','overflow-y':'hidden !important'}});
			
			this.options.body = this.iframe;
		}
		
		// creates the popup
		this.ajax = new Request({
			variables: 'view='+ this.options.view +'&layout='+ this.options.layout +
					   '&task='+ this.options.task +'&_ajax='+ this.options.layoutView
					   + this.options.variables,
			onSuccess: function(response)
			{
				fbPopUps.body(response);
				
			}
			
		});
		
		//preloading the spinner image
		this.spinner_img = new Element('img', {
			'id':'spinner_img',
			'src':'modules/ven_Orders/media/images/processpayment.gif',
			'styles':{'position':'relative','float':'left','top':'15px','left':'-20px'}
		});
		
	},
	
	/**
	 * Handles the body loading
	 * 
	 * The body loading is called multiple times to ensure that we can load the body elements as quickly
	 * as possible. Once loaded it holds the body in a static variable and prevents any future body
	 * calls from resetting the static var.
	 * 
	 * @return string
	 */
	body: function(response, refresh) {
		//initializing variables
		var dialog_body = $('dialog_body');
		
		if ($chk(dialog_body) && $chk(response) && ( !$chk( dialog_body.innerHTML ) || $chk(refresh) ) ){
			var Sliders = new Fx.Slide(dialog_body);
			if (!$chk(refresh)) Sliders.hide();
			
			//grab from the store if available
			if ($chk(this.bodystore) && !$chk(refresh) ){
				response = this.bodystore;
			}
			
			//checking on response type
			if ( typeof response == 'function' ){
				dialog_body.innerHTML = response();
				
			} else if ( typeof response == 'object' ){
				response.inject(dialog_body);
				
			} else {
				dialog_body.innerHTML = response;
			}
			
			if (!$chk(refresh))
			{
				dialog_body.setStyle('height', 'auto');
				$('dialog_loading').removeClass('dialog_loading');
				Sliders.slideIn();
			}
			
			//since we used it, clean it all
			this.bodystore = false;
			response = false;
			
		} else {
			this.bodystore = response;
		}
	},

	/**
	 * Create a Button
	 * 
	 * Method will create the html dom for the expected button
	 * 
	 * @return boolean
	 */
	buttons: function() {
		fbPopUps = this;
		for (var button in this.options.buttons) {
			var myInput = new Element('input', {
			    'type': 'button',
			    'value': button,
			    'name': button,
			    'class': 'inputsubmit',
			    'id': button + '_fb',
			    'events': {
			        'click':  fbPopUps.options.buttons[button]
			    }
			
			});
			$extend($(myInput), fbPopUps);
			$(myInput).inject($('close_fb'), 'before');
		}
		return true;
	},
	
	/**
	 * Add a Button
	 * 
	 * Method will inject a button into the popup
	 * 
	 * @return boolean
	 */
	addButton : function( buttons )
	{
		fbPopUps = this;
		for (var button in buttons) {
			
			//first remove any existing like buttons
			this.removeButton( button );
			
			//create the new button
			var Input = new Element('input', {
			    'type': 'button',
			    'value': button,
			    'name': button,
			    'class': 'inputsubmit',
			    'id': button + "_fb",
			    'events': {
			        'click':  buttons[button]
			    }
			
			});
			
			$extend($(Input), fbPopUps);
			$(Input).inject($('close_fb'), 'before');
			
		}
		return true;
	},
	
	/**
	 * Remove a Button
	 * 
	 * Method will dispose of a button within the popup
	 * 
	 * @return boolean
	 */
	removeButton : function( button_id )
	{
		if ( $chk($(button_id+'_fb')) )
		{
			$(button_id+'_fb').setStyle('display','none').set('id','disposed');
			return true;
		}
		return false;
	},
	
	/**
	 * Set Buttons function
	 * 
	 * Method will set the listeners that will determine how the popup is closed
	 * 
	 */
	setFunction: function(){
		// hide using opacity on page load
		this.pup.setStyles({
			opacity:0,
			display:'block'
		});
		
		self = this;
		
		// hide on close button
		this.closer.addEvent('click',function(e) { 
			self.close();
		});
		
		// hide on esc button
		window.addEvent('keypress',function(e) { 
			if(e.key == 'esc') { self.close(true); } 
		});
		
		//hide on off click
		$(document.body).addEvent('click',function(e) {
			if(self.pup.get('opacity') == 1 && !e.target.getParent('.generic_dialog')) { 
				self.close(true);
			} 
		});
		
	},
	
	/**
	 * Insert popup window
	 * 
	 * Method will insert the popup window into the html dom object
	 * 
	 */
	insertDiv: function(){
		//generating the id
		this.popupid = 'popup_fb';  // $('popup_fb')
		
		//create the popup as node
		var pop_node = document.createElement('div');
		pop_node.id = this.popupid;
		pop_node.className = 'generic_dialog';
		pop_node.innerHTML = this.popup();
		
		//create the body node
		var body_node = document.body.childNodes[0];
		
		//insert the pop into the body
		body_node.parentNode.insertBefore(pop_node, body_node);
		
		//remember it
		this.pup = $(this.popupid);
		this.closer = $('close_fb');
		this.title = $('dialog_title');
		this.subtitle = $('dialog_summary');
		this.bodydiv = $('dialog_body');
		this.buttons();
		
		//remove the ajax loader if this is not ajax
		if (!this.options.ajax){
			$('dialog_loading').removeClass('dialog_loading');
		}
		
	},
	
	/**
	 * Ajax calls
	 * 
	 * Method activates the preset ajax object
	 * 
	 */
	ajaxsend: function() {
		if(!this.options.ajax) return false;
		
		var variables = this.fireEvent('request');
		this.ajax.send( variables );
	},
	
	/**
	 * Check if popup exists
	 * 
	 * Method returns a simple true if the popup window is already open
	 * 
	 * @return boolean
	 */
	check: function(){
		if($chk( $$('body')[0].getElement('div[id=parent_popup_div]') ))
			return true;
		return false;
	},
	
	/**
	 * Display the popup window
	 * 
	 * Method will prepare the popup body and display the popup window. 
	 * 
	 */
	open: function(){
		this.close(true);
		if(this.check()) return false;
		
		//call to ajax
		this.ajaxsend();
		
		//put the div in place
		this.insertDiv();
		
		//set the initials
		this.setFunction();
		
		this.title.innerHTML = this.options.title;
		this.subtitle.innerHTML = this.options.subtitle;
		this.body( this.options.body );
		
		new Drag($('parent_popup_div'), {
			snap: 0,
			handle : 'dialog_title_h2'
			
		});
		
		//bring into view
		this.pup.fade('in');
		this.fireEvent('open');
		
	},
	
	/**
	 * Close the popup window
	 * 
	 * Method will dispose of the popup window
	 * 
	 */
	close: function( isSilent ){
		if(!fbPopUps.check()) return false;
		
		var popup = $$('body')[0].getElement('div[id=parent_popup_div]');
		popup.chains().fade('out').dispose();
		
		if(!$chk(isSilent)) this.fireEvent('close');
		
	},
	
	/**
	 * Enable spinner
	 * 
	 * Method is designed to cover the popup body with a spinner. The spinner is a default image
	 * however, the text can be changed.
	 * 
	 */
	enableSpinner : function()
	{
		var parentDiv = $('dialog_content_body');
		var bodyDiv = $('dialog_body');
		if ($chk(bodyDiv)) bodyDiv.setStyle('display','none');
		
		var Sizes = this.getSize();
		
		//inject the overlay
		fbPopUps.spinner = new Element('div', {'id':'popup_spinner','styles':
			{'position':'absolute','width':Sizes.x +'px','height':Sizes.y +'px','margin':'0','background':'#fff'}
		}).inject(parentDiv, 'top');
		
		//inject the Notice
		var notice = new Element('div', {
			'styles': {'width':'200px','margin':'0 auto',
				'font-size':'25px','color':'#032F6E'},
			'html': 'Please Wait...<br/>Processing '
		}).inject(fbPopUps.spinner, 'top');

		//inject the spinner image
		this.spinner_img.inject(notice, 'top');
		
		//adding a cancel button
		this.addButton({
			Cancel : function (){
				fbPopUps.disableSpinner();
			}
		});
	},
	
	/**
	 * Disable the spinner
	 * 
	 * Method is designed to hide the spinner cover
	 * 
	 */
	disableSpinner : function()
	{
		//remove cancel button
		this.removeButton( 'Cancel' );
		
		//initializing variables
		var bodyDiv = $('dialog_body');
		if(!$chk(bodyDiv)) return false;
		
		bodyDiv.setStyle('display','block');
		if ($chk(fbPopUps.spinner)) fbPopUps.spinner.dispose();
		
		return true;
	},
	
	/**
	 * Body has changed
	 * 
	 * Method is designed to let the popup know that the body has changed
	 * so that the popup can resize if it needs to
	 * 
	 * @return boolean
	 */
	change : function( iframeWindow )
	{
		//resetting sizes
		this.resize();
		
		//disable spinner on reload
		fbPopUps.disableSpinner();
		
		return true;
	},
	
	/**
	 * Method resizes the box to its minimum size without scroll bars
	 */
	resize : function( width, height )
	{
		//cleaning given variables
		if ($chk(width))
		{
			width = width +'';
			if (width.substr(width.length - 2) == 'px') 
				var width = width.substr(0, width.length - 2);
		}
		if ($chk(height))
		{
			height = height +'';
			if (height.substr(height.length - 2) == 'px') 
				var height = height.substr(0, height.length - 2);
		}
		
		//loading resources
		var poptable = $('pop_dialog_table');
		var content = $('dialog_content_body').getElements('div')[0];
		
		//initializing variables
		var Size = this.getSize();
		var Scroll = this.getScrollSize();
		if (!$chk(width) && Scroll.x > Size.x)
		{
			var width = Scroll.x;
		}
		if (!$chk(height) && Scroll.y > Size.y)
		{
			var height = Scroll.y;
		}
		
		return this.setSize(width, height);
	},
	
	/**
	 * Get's the popup sizes
	 * 
	 */
	getSize : function()
	{
		//loading resources
		var parentbody = $('dialog_content_body').getElements('div')[0];
		
		//getting size
		var bSize = parentbody.getSize();
		
		return bSize;
	},
	
	/**
	 * Method determines the scroll size of the popup body
	 * 
	 */
	getScrollSize : function()
	{
		//If the iframe exists then resize it
		var iframe = $('popup_inner_iframe');
		if ($chk(iframe))
		{
			var iSize = iframe.getSize();
			
			var iDoc = window.frames['popup_inner_iframe'].document;
			var iScroll = iDoc.getScrollSize();
			
			//resizing iframe to idoc scroll size
			iframe.setStyles({'height':iScroll.y,'width':iScroll.x});
		}
		
		//locate the popup body inner div size
		var content = $('dialog_content_body').getElements('div')[0];
		content.setStyle('overflow','auto');
		
		//getting scroll size
		var bScroll = content.getScrollSize();
		
		return bScroll;
	},
	
	/**
	 * Set the popups sizes
	 * 
	 */
	setSize : function( width, height )
	{
		//loading objects
		var dialog_body = $('dialog_body');
		var poptable = $('pop_dialog_table');
		var body = $('dialog_content_body');
		var parentbody = $('dialog_content_body').getElements('div')[0];
		//var body = $('dialog_body');
		var iframe = $(this.iframe);
		
		//setting the width if we received a width to set
		if ($chk(width))
		{
			//formatting dimensions
			//removing the 'px' from the currently set width and height
			width = width +'';
			if (width.substr(width.length - 2) == 'px') 
				var width = width.substr(0, width.length - 2);
			
			//setting dimensions
			tableWidth = (width.toInt() +50) + 'px';
			width = (width.toInt()) + 'px';
			
			//resizing the iframe instantly
			if ($chk(iframe)) iframe.setStyles({'width':width});
			
			//resizing the popup outerskin
			var oldW = poptable.getStyle('width');
			
			var Effect = new Fx.Morph(poptable, {duration: 'short', transition: Fx.Transitions.Sine.easeOut});
			Effect.start({ 'width': [oldW, tableWidth] });
			
			//resizing the popups body
			var oldW = parentbody.getStyle('width');
			
			var Effect = new Fx.Morph(parentbody, {duration: 'short', transition: Fx.Transitions.Sine.easeOut});
			Effect.start({ 'width': [oldW, tableWidth] });
			
		}
		
		
		//setting the height if we received a width to set
		if ($chk(height))
		{
			//formatting dimensions
			//removing the 'px' from the currently set width and height
			height = height +'';
			if (height.substr(height.length - 2) == 'px') 
				var height = height.substr(0, height.length - 2);
			
			//setting dimensions
			tableHeight = (height.toInt() +50) + 'px';
			height = (height.toInt()) + 'px';
			
			//resizing the iframe instantly
			dialog_body.erase('style');
			dialog_body.setStyles({'height':tableHeight+ ' !important', 'margin':0, 'overflow-x':'hidden'});
			if ($chk(iframe)) iframe.setStyles({'height':tableHeight});
			
			//resizing the popups body
			var oldH = parentbody.getStyle('height');
			
			var Effect = new Fx.Morph(parentbody, {duration: 'short', transition: Fx.Transitions.Sine.easeOut});
			Effect.start({ 'height': [oldH, tableHeight] });
			
		}
		
		return true;
	},
	
	/**
	 * Create Popup
	 * 
	 * Method creates the html dom for the popup and returns it to the requesting method.
	 * The height and width of this popup is determined by the body height and width.
	 * 
	 */
	popup: function(){ 
		var width = this.options.width;
		if (width.substring(width.length - 2) == 'px')
		{
			width = width.substring(0, (width.length - 2));
			width = (width.toInt() + 50) + 'px';
		}
		else if (width.substring(width.length - 1) == '%')
		{
			width = '550px';
		}
		
	return '<div id="parent_popup_div" class="generic_dialog_popup" style="top: 125px;left: 0;">'+
		'<table id="pop_dialog_table" class="pop_dialog_table" style="width: '+ width +';">'+
		'<tbody>'+
		
		'<tr>'+
		'<td class="pop_topleft"/>'+
		'<td class="pop_border pop_top"/>'+
		'<td class="pop_topright"/>'+
		'</tr>'+
		
		'<tr>'+
		'<td class="pop_border pop_side"/>'+
			'<td id="pop_content" class="pop_content" valign="top" height="100%">'+
			'<h2 id="dialog_title_h2" class="dialog_title"><span id="dialog_title">' + '</span></h2>'+
			'<div id="dialog_content" class="dialog_content" height="100%">'+
				'<div class="dialog_summary" id="dialog_summary">' + '</div>'+
				
				'<div class="dialog_body dialog_loading" id="dialog_loading">'+
					'<div class="ubersearch search_profile">'+
						'<div id="dialog_content_body" class="result clearfix dialog_content_body">' +
							'<div id="dialog_body"></div>'+
							'<div class="clear" style="clear:both;display:block;width:100%;"></div> '+
						'</div>'+
					'</div>'+
				'</div>'+
				
				'<div class="dialog_buttons" id="_dialog_buttons">' + 
					'<input type="button" value="Close" name="close" class="inputsubmit" id="close_fb" />'+
				'</div>'+
			'</div>'+
		'</td>'+
		'<td class="pop_border pop_side"/>'+
		'</tr>'+
		
		'<tr>'+
		'<td class="pop_bottomleft"/>'+
		'<td class="pop_border pop_bottom"/>'+
		'<td class="pop_bottomright"/>'+
		'</tr>'+
		
		'</tbody>'+
		'</table>'+
		'</div>';
	}
	
});

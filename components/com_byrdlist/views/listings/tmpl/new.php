<?php
/**
 * Joomla! 1.5 component reservation
 *
 * @version $Id: view.html.php 2010-06-02 12:34:25 svn $
 * @author 
 * @package Joomla
 * @subpackage Listings
 * @license Copyright (c) 2010 - All Rights Reserved
 *
 * 
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

//initializing variables
$street = ($t = $this->_record->primary_street()) ?$t:"Street";
$city = ($t = $this->_record->primary_city()) ?$t:"City";
$state = ($t = $this->_record->primary_state()) ?$t:"State";
$postal_code = ($t = $this->_record->primary_postal_code()) ?$t:"Postal Code";

//loading resources
$editor = &JFactory::getEditor();

$params = array( 
	'smilies'=> 0,
	'layer'  => 0,
	'clear_entities' => 0,
	'compressed' => 0,
	'style'  => 0,
	'newlines'  => 1,
	'theme'  => 'advanced',
	'searchreplace'  => 0,
	'insertdate'  => 0,
	'inserttime'  => 0,
	'hr'  => 0,
	'fullscreen'  => 0,
	'directionality'  => 0,
	'xhtmlxtras'  => 0,
	'table'  => 1,
);
                 
// parameters : areaname, content, width, height, cols, rows
$description = $editor->display( 'description',  $this->_record->description(), '545px', '550', '75', '20', false, $params );

?>

<div id="listing"> 
	<h2>
		New Listing
		<div style="position:relative;float:right;">
			<div class="mbutton"> 
				<a href="?option=com_byrdlist&view=myaccount" rel="nofollow">
				Back to the My Account</a>
			</div>
		</div>
	</h2>
	
	<div class="column first">
		<form name="newListingForm" class="composeForm" id="newListingForm"  method="post"
		action="#"> 
		
		<table border="0" cellpadding="3" cellspacing="0" width="100%">
		
		<tr> 
			<td> 
				<h1 style="font-size:14px;margin-top:10px;">Item Name:</h1> 
			</td> 
			</tr> 
			<tr> 
			<td>
				<input type="text" id="inputname" name="name" class="inputbox cannotBeEmpty" style="width:530px" 
				value="<?php echo $this->_record->name(); ?>" />
				<span class="warning" style="display:none;" id="inputname_error">
				Listing Name cannot be empty.</span>
			</td> 
		</tr>
			
		<tr> 
			<td> 
				<h1 style="font-size:14px;margin-top:10px;">Listing Type:</h1> 
			</td> 
			</tr> 
			<tr> 
			<td>
				<?php if ($this->_record->isNew()): ?>
				<?php $this->element('dropdown_listingtype'); ?>
				<?php else: ?>
				<input type="hidden" name="type" value="<?php echo $this->_record->type(); ?>" />
				<?php echo $GLOBALS['dropdowns']['listing_types'][$this->_record->type()]; ?>
				<?php endif; ?>
			</td> 
		</tr>
		
		<tr> 
			<td> 
				<h1 style="font-size:14px;margin-top:10px;">Address:</h1> 
			</td> 
			</tr> 
			<tr> 
			<td>
				<input type="text" name="primary_street" id="primary_street" class="inputbox cannotBeEmpty"
				style="width:530px" value="<?php echo $street; ?>" 
				onFocus="_focus(this,'Street');" onBlur="_blur(this,'Street');"/>
				<span class="warning" style="display:none;" id="primary_street_error">
				Street cannot be empty.</span>
			</td> 
		</tr>
			
		<tr> 
			<td> 
				
			</td> 
			</tr> 
			<tr> 
			<td>
				<br/>
				<input type="text" id="primary_city" name="primary_city" class="inputbox cannotBeEmpty" 
				onFocus="_focus(this,'City');" onBlur="_blur(this,'City');" style="width:180px;margin-right:17px" 
				value="<?php echo $city; ?>"/>
				<input type="text" id="primary_state" name="primary_state" class="inputbox" 
				onFocus="_focus(this,'State');" onBlur="_blur(this,'State');" style="width:180px;margin-right:17px" 
				value="<?php echo $state; ?>"/>
				<input type="text" id="primary_postal_code" name="primary_postal_code" class="inputbox" 
				onFocus="_focus(this,'Postal Code');" onBlur="_blur(this,'Postal Code');" style="width:100px" 
				value="<?php echo $postal_code; ?>" />
				<span class="warning" style="display:none;" id="primary_city_error">
				Address cannot be empty.</span>
			</td> 
		</tr>
			
		<tr>
			<td>
				<h1 style="font-size:14px;margin-top:10px;">Description:</h1> 
			</td>
			</tr> 
			<tr>
			<td>
				<?php echo $description; ?>
			</td>
		</tr> 
		
		<tr> 
			<td class="mbutton"> 
				
				<a href="#" onClick="javascript: isValid( 'newListingForm' ); return false;" rel="nofollow">
				Submit</a>
				
				<?php if ($this->_record->isNew()): ?>
				<a href="?option=com_byrdlist&view=myaccount" rel="nofollow">
				Cancel</a>
				<?php else: ?>
				<a href="?option=com_byrdlist&view=listings&layout=details&record=<?php echo $this->_record->id(); ?>" rel="nofollow">
				Cancel</a>
				<?php endif; ?>
			</td> 
		</tr> 
			
		</table> 
		
		<input type="hidden" name="id" value="<?php echo $this->_record->id(); ?>" />
		<input type="hidden" name="published" value="0" />
		<input type="hidden" name="option" value="com_byrdlist" />
		<input type="hidden" name="view" value="listings" />
		<input type="hidden" name="layout" value="new_two" />
		<input type="hidden" name="task" value="save" />
		<input type="hidden" name="id" value="<?php echo $this->id; ?>" />
		<input type="hidden" name="Itemid" value="<?php echo JRequest::getVar('Itemid'); ?>" />
		
		</form> 
	</div>
	
	<div class="column second">
		<h3>Notes</h3>
		<div class="fields">
			
			<div class="row0">
				<div class="fieldRow lastFieldRow" style="width:98%">
					<p><b>Step One: </b> In this step you'll be entering the basic information
					associated with your item. If you choose not continue with any other step,
					you will still have a viable listing within our system.</p>
					
					<p>Step Two: In step two you'll have the opportunity to customize your listing
					with "listing type" specific fields as well as images, tags and categories.</p>
					
					<p>Step Three: Rinse and repeat. Review your full listing and then publish it.</p>
				</div>
			</div>
			
		</div>
	</div>
	
</div>


<script src="<?php echo DOTCOM; ?>components/<?php echo EBOOK_COMPONENT; ?>/media/js/new_two.js"></script>

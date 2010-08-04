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
		New Webpage
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
				<h1 style="font-size:14px;margin-top:10px;">Is this your Homepage?:</h1> 
			</td> 
			</tr> 
			<tr> 
			<td>
				<label style="display:inline;">
					Yes 
					<input type="radio" id="inputhomepage" name="homepage" 
					<?php echo ($this->_record->homepage())?'checked="true"':""; ?> value="1" />
				</label>
				<label style="display:inline;">
					No 
					<input type="radio" id="inputhomepage" name="homepage" 
					<?php echo (!$this->_record->homepage())?'checked="true"':""; ?> value="0" />
				</label>
			</td> 
		</tr>
			
		<tr> 
			<td> 
				<h1 style="font-size:14px;margin-top:10px;">Page Type:</h1> 
			</td> 
			</tr> 
			<tr> 
			<td>
				<?php if ($this->_record->isNew()): ?>
					<?php $this->element('dropdown_websitetype'); ?>
				<?php else: ?>
					<?php echo $GLOBALS['dropdowns']['website_types'][$this->_record->type()]; ?>
				<?php endif; ?>
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
					<a href="?option=com_byrdlist&view=accounts&layout=details&record=<?php echo $this->_record->id(); ?>" rel="nofollow">
					Cancel</a>
				<?php endif; ?>
			</td> 
		</tr> 
			
		</table> 
		
		<input type="hidden" name="id" value="<?php echo $this->_record->id(); ?>" />
		<input type="hidden" name="published" value="0" />
		<input type="hidden" name="option" value="com_byrdlist" />
		<input type="hidden" name="view" value="authors" />
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
					<p><b>Step One: </b> Enter basic information and then spend time creating
					the webpage content that your viewers are going to see.</p>
					
					<p>Step Two: Custom information will be required for this step. Allowing you
					to enter specific information that will determine how the page type operates.</p>
					
					<p>Step Three: Rinse and repeat. Review your webpage and then publish it.</p>
				</div>
			</div>
			
		</div>
	</div>
	
</div>


<script src="<?php echo DOTCOM; ?>components/<?php echo EBOOK_COMPONENT; ?>/media/js/new_two.js"></script>

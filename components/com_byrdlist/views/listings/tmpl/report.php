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

?>

<div id="listing"> 
	<h2>
		Report - 
		<?php echo $this->_listings->name(); ?>
		
		<?php if ($this->_listings->featured()): ?>
			<sup class="featured">Featured</sup>
		<?php endif; ?>
		
		<div style="position:relative;float:right;">
			<div class="mbutton"> 
				<a href="?option=com_byrdlist&view=listings&layout=details&record=<?php 
				echo $this->_listings->id(); ?>" rel="nofollow">
				Back to the Listing</a>
			</div>
		</div>
	</h2>
 
	<div class="column first">
		<form name="writeMessageForm" class="composeForm" id="writeMessageForm" 
		action="" method="post"> 
		
		<table border="0" cellpadding="3" cellspacing="0" width="100%"> 
			<tr> 
				<td> 
					<h1 style="font-size:14px;">Subject:</h1> 
				</td> 
			</tr> 
			<tr> 
				<td><input type="text" name="subject" class="inputbox" style="width:530px" value="" /></td> 
			</tr>
			<tr> 
				<td> 
					<h1 style="font-size:14px;margin-top:10px;">Violation Type:</h1> 
				</td> 
			</tr> 
			<tr> 
				<td>
					<?php $this->element('dropdown_violation'); ?>
				</td> 
			</tr>
			<tr>
				<td>
					<h1 style="font-size:14px;margin-top:10px;">Message:</h1> 
				</td>
			</tr> 
			<tr>
				<td>
					<textarea name="description" rows="8" style="width:530px" class="inputbox"></textarea>
				</td>
			</tr> 
			<tr> 
				<td class="mbutton"> 
			
					<a href="javascript:document.getElementById('writeMessageForm').submit();" rel="nofollow">
					Submit</a>
					
					<a href="?option=com_byrdlist&view=listings&layout=details&record=<?php 
					echo $this->_listings->id(); ?>" rel="nofollow">
					Cancel</a>
					
				</td> 
			</tr> 
		</table> 
		
		<input type="hidden" name="_listings_id" value="<?php echo JRequest::getVar('_listings_id'); ?>" /> 
		<input type="hidden" name="_comments_id" value="<?php echo JRequest::getVar('_comments_id'); ?>" /> 
		<input type="hidden" name="parent_id" value="<?php echo JRequest::getVar('parent_id'); ?>" /> 
		<input type="hidden" name="published" value="1" /> 
		<input type="hidden" name="option" value="com_byrdlist" /> 
		<input type="hidden" name="view" value="listings" /> 
		<input type="hidden" name="layout" value="report" /> 
		<input type="hidden" name="task" value="send" /> 
		<input type="hidden" name="Itemid" value="<?php echo JRequest::getVar('Itemid'); ?>" />
		
		</form> 
	</div>
	
	<div class="column second">
		<?php if (!isset($this->_listings->_notalisting)): ?>
		<h3>Listings details</h3>
		<div class="fields">
			
			<?php foreach ($this->_listings->listing_details() as $caption => $value): ?>
			<div class="row0">
				<div class="fieldRow lastFieldRow" style="width:98%">
					<div class="caption"><?php echo $caption; ?></div>
					<div class="output"><?php echo $value; ?></div>
				</div>
			</div>
			<?php endforeach; ?>
			
		</div>
		<?php else: ?>
		<h3>Comment details</h3>
		<div class="fields">
			
			<div class="row0">
				<div class="fieldRow lastFieldRow" style="width:98%">
					<div class="caption">Title</div>
					<div class="output"><?php echo $this->_listings->name(); ?></div>
				</div>
			</div>
			
			<div class="row0">
				<div class="fieldRow lastFieldRow" style="width:98%">
					<div class="caption">Author</div>
					<div class="output"><?php echo $this->_author->name(); ?></div>
				</div>
			</div>
			
			<div class="row0">
				<div class="fieldRow lastFieldRow" style="width:98%">
					<div class="caption">Comment</div>
					<div class="output"><?php echo $this->_listings->description(); ?></div>
				</div>
			</div>
			
		</div>
		<?php endif; ?>
	</div>
	
</div>
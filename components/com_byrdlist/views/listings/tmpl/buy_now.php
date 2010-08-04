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
		Buy Now - 
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
	
		<div class="rating-fav">
			<div style="position:relative;float:left;width:100%">
				<div class="favourite" style="margin-bottom:5px;">
					<span class="fav-caption">Buy Now Price:</span> 
					<div id="fav-count">$<?php echo $this->_listings->buy_now(); ?></div>
				</div>
				<div class="favourite" style="margin-bottom:10px;padding-bottom:5px;">
					<span class="fav-caption">Shipping Cost:</span> 
					<div id="fav-count">$<?php echo $this->_listings->shipping_cost(); ?></div>
				</div>
				
				<hr/>
				
				<div class="favourite" style="margin-bottom:5px;">
					<span class="fav-caption">Total Cost:</span> 
					<div id="fav-count">$<?php echo $this->amount; ?></div>
				</div>
			</div>
		</div>
	
		<form name="writeMessageForm" class="composeForm" id="writeMessageForm" 
		action="" method="post"> 
		
		<table border="0" cellpadding="3" cellspacing="0" width="100%">
			<tr> 
			<td> 
				<h1 style="font-size:14px;">Buy it Now Price:</h1> 
			</td> 
			</tr> 
			<tr> 
			<td>
			
				<input type="text" name="amount" class="inputbox" style="width:530px" 
				value="<?php echo $this->amount; ?>" readonly="true"/>
			</td> 
			</tr>
			<tr>
			<td>
				<h1 style="font-size:14px;margin-top:10px;">Message:</h1> 
			</td>
			</tr> 
			<tr>
			<td>
				<textarea name="description" rows="8" style="width:530px" 
				class="inputbox"></textarea>
			</td>
			</tr> 
			<tr> 
			<td class="mbutton"> 
				
				<a href="javascript:document.getElementById('writeMessageForm').submit();" rel="nofollow">
				Take me to Paypal</a>
				
				<a href="?option=com_byrdlist&view=listings&layout=details&record=<?php echo $this->_listings->id(); ?>" rel="nofollow">
				Cancel</a>
				
			</td> 
			</tr> 
		</table> 
		
		<input type="hidden" name="_listings_id" value="<?php echo JRequest::getVar('_listings_id'); ?>" /> 
		<input type="hidden" name="published" value="0" /> 
		<input type="hidden" name="option" value="com_byrdlist" /> 
		<input type="hidden" name="view" value="listings" /> 
		<input type="hidden" name="layout" value="buy_now" /> 
		<input type="hidden" name="task" value="save" /> 
		<input type="hidden" name="gateway" value="paypal" /> 
		<input type="hidden" name="Itemid" value="<?php echo JRequest::getVar('Itemid'); ?>" />
		
		</form> 
	</div>
	
	<div class="column second">
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
	</div>
	
</div>

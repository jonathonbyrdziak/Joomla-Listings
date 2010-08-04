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
$count = 0;
$this->_record->addView();

//loading resources
$last_bid = $this->_record->last_bid();
$winner = $this->_record->getWinner();

?>
<style>
a.publishbutton:hover{background-color:pink !important;}
a.publishbutton{background-color:red !important;}
</style>
	
<a name="bidhere"></a>
<div id="listing">
	<?php if (!$this->_record->published() && !$this->_record->isClosed()): ?>
		<br/><span class="warning">In order for users to view your listing, click on the PUBLISH button below.</span><br/><br/><br/>
	<?php endif; ?>
	
	<b>
		<?php echo $GLOBALS['dropdowns']['listing_types'][$this->_record->type()]; ?>
	</b>
	
	<h2>
		<?php if (!$this->_record->isClosed()): ?>
			<?php if ($this->is_owner): ?>
				<?php if (!$this->isRequest || ($this->isRequest && !$this->isAwarded)): ?>
					<?php if (!$this->_record->published()): ?>
						<a href="?option=com_byrdlist&view=listings&layout=details&task=publish&record=<?php echo $this->_record->id(); ?>" 
						class="actionlink publishbutton">PUBLISH</a>
					<?php else: ?>
						<a href="?option=com_byrdlist&view=listings&layout=details&task=unpublish&record=<?php echo $this->_record->id(); ?>" 
						class="actionlink">UN-PUBLISH</a>
					<?php endif; ?>
					
					<a href="?option=com_byrdlist&view=listings&layout=new&record=<?php echo $this->_record->id(); ?>" 
					class="actionlink">Edit</a>
					
					<a href="?option=com_byrdlist&view=listings&layout=details&task=delete&record=<?php echo $this->_record->id(); ?>"
					class="actionlink"">Delete</a>
				<?php endif; ?>
			<?php endif; ?>
		<?php endif; ?>
		
		<?php echo $this->_record->name(); ?>
		
		<?php if ($this->_record->featured()): ?>
			<sup class="featured">Featured</sup>
		<?php endif; ?>
		
		<div style="position:relative;float:right;">
			<div class="mbutton">
				<?php if ($this->isLoggedIn): ?>
					<a href="?option=com_byrdlist&view=myaccount" rel="nofollow">
					My Account</a>
				<?php endif; ?>
				
				<a href="?option=com_byrdlist&view=listings&_categories_id=<?php echo $this->_category->id(); ?>" rel="nofollow">
				Back to "<?php echo $this->_category->name(); ?>" Listings</a>
			</div>
		</div>
	</h2> 
 
	<div class="column first">
		<div class="listing-desc">
			<?php echo $this->_record->description(); ?>
		</div>
		
		<?php $this->element('details_box'); ?>
		<?php $this->element('financial_listing'); ?>
		<?php $this->element('auction_ended'); ?>
		<?php $this->element('awarded_donation_to'); ?>
		
	</div>
	
	<div class="column second">
		<div class="images"> 
			<div class="content">
			<?php if (is_array($this->_record->images())): ?>
				<?php foreach ($this->_record->images() as $id => $instance): $count++; ?>
					<?php if (!$instance->file()) { $instance->delete(); continue; } ?>
					
					<?php if ($count == 1): ?>
						<div class="thumbnail first">
							<a id="mainimagelink" href="#" onClick="javascript: return false;">
							<img id="mainimage" src="<?php echo $instance->file(); ?>" 
							alt="<?php echo $this->_record->name(); ?>" style="width:380px" />
							</a>
						</div>
					<?php else: ?>
						<div class="thumbnail-left">
							<a href="#" onClick="javascript: return _imageClick( this );">
							<img id="_image_<?php echo $count; ?>" src="<?php echo $instance->file(); ?>" alt="<?php echo $this->_record->name(); ?>"
							 style="width:120px;" />
							</a>
						</div>
					<?php endif; ?>
					
				<?php endforeach; ?>
			<?php endif; ?>
			</div>
		</div> 
		
		<h3>Listings details</h3>
		<div class="fields">
			
			<?php foreach ($this->_record->listing_details() as $caption => $value): ?>
			<div class="row0">
				<div class="fieldRow lastFieldRow" style="width:98%">
					<div class="caption"><?php echo $caption; ?></div>
					<div class="output"><?php echo $value; ?></div>
				</div>
			</div>
			<?php endforeach; ?>
			
		</div>
	</div>
	
	<?php if ($this->_record->published()): ?>
	<div class="actions-rating-fav">
		<div class="mbutton" style="padding:10px;">
			<?php if ($this->isLoggedIn): ?>
				<?php if (!$this->isRequest): ?>
					<?php if (!$this->isClosed): ?>
						<?php if (!$this->is_owner): ?>
						
							<?php if ($this->_record->type() == 'financial'): ?>
								<a href="#bidhere" onClick="javascript:bid_highlight();" rel="nofollow">
								Contribute Now</a>
							<?php else: ?>
								<a href="#bidhere" onClick="javascript:bid_highlight();" rel="nofollow">
								Bid Now</a>
							<?php endif; ?>
							
							<?php if ($this->_record->buy_now()) : ?>
							<a href="?option=com_byrdlist&view=listings&layout=buy_now&_listings_id=<?php echo $this->_record->id(); ?>" rel="nofollow">
							Buy Now</a>
							<?php endif; ?>
							
						<?php endif; ?>
						
						<a href="?option=com_byrdlist&view=listings&layout=comment&_listings_id=<?php echo $this->_record->id(); ?>" rel="nofollow">
						Submit Comment</a>
					<?php endif; ?>
				<?php else: ?>
					<?php if (!$this->isClosed): ?>
						<?php if ($this->_record->type() == 'need'): ?>
							<a href="?option=com_byrdlist&view=listings&layout=request&_listings_id=<?php echo $this->_record->id(); ?>" rel="nofollow">
							Submit an Offer</a>
							<?php elseif (!$this->user->isDonor()): ?>
							<a href="?option=com_byrdlist&view=listings&layout=request&_listings_id=<?php echo $this->_record->id(); ?>" rel="nofollow">
							Submit Request</a>
						<?php endif; ?>
					<?php endif; ?>
				<?php endif; ?>
				
				<?php if (!$this->is_owner): ?>
					<a href="?option=com_byrdlist&view=listings&layout=contact&_listings_id=<?php echo $this->_record->id(); ?>" rel="nofollow">
					Contact Owner</a>
				<?php endif; ?>
				
				<?php if (!$this->isClosed): ?>
					<a href="?option=com_byrdlist&view=listings&layout=recommend&_listings_id=<?php echo $this->_record->id(); ?>" rel="nofollow">
					Recommend</a>
				<?php endif; ?>
			<?php endif; ?>
			
			<a href="?option=com_byrdlist&view=listings&layout=details&format=pdf&record=<?php echo $this->_record->id(); ?>" title="Print">
			Print</a>
			
			<?php if (!$this->is_owner): ?>
				<a href="?option=com_byrdlist&view=listings&layout=report&_listings_id=<?php echo $this->_record->id(); ?>" rel="nofollow">
				Report</a>
				
				<a href="?option=com_byrdlist&view=listings&filter=owner&jusers_id=<?php echo $this->_record->author_id(); ?>">
				Owner's listings</a>
				
			<?php elseif ($winner || $this->user->id() == $this->_record->author_id()): ?>
				<a href="?option=com_byrdlist&view=listings&layout=shipping&format=pdf&record=<?php echo $this->_record->id(); ?>" title="Print">
				Shipping Label</a>
			<?php endif; ?>
		</div>
	</div>
	<?php endif; ?>
</div>

<?php if ($this->_record->published()): ?>
	<br/>
	<?php $this->element('comments'); ?>
<?php endif; ?>

<script>
function bid_highlight()
{
	add_border();
	setTimeout(remove_border,75);
	setTimeout(add_border,150);
	setTimeout(remove_border,225);
	setTimeout(add_border,300);
	setTimeout(remove_border,375);
	setTimeout(add_border,450);
	setTimeout(remove_border,525);
	setTimeout(add_border,600);
	setTimeout(remove_border,675);
	setTimeout(add_border,725);
	setTimeout(remove_border,800);
	setTimeout(add_border,875);
	setTimeout(remove_bg,925);
	
}
function add_border()
{
	var input = document.getElementById('amount');
	input.style.border = "1px solid red";
	input.style.background = "pink";
}
function remove_border()
{
	var input = document.getElementById('amount');
	input.style.border = "1px solid #ccc";
	input.style.background = "white";
}
function remove_bg()
{
	var input = document.getElementById('amount');
	input.style.background = "white";
}
</script>


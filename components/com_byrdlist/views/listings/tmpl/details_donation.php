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
$last_bid = $this->_record->last_bid();
$count = 0;
$this->_record->addView();

?>

<a name="bidhere"></a>
<div id="listing"> 
	<h2>
		<?php if ($this->is_owner): ?>
			<a href="?option=com_byrdlist&view=listings&layout=new&record=<?php echo $this->_record->id(); ?>" 
			class="actionlink">Edit</a>
			
			<a href="?option=com_byrdlist&view=myaccount&layout=delete&record=<?php echo $this->_record->id(); ?>"
			class="actionlink"">Delete</a>
		<?php endif; ?>
		
		<?php echo $this->_record->name(); ?>
		
		<?php if ($this->_record->featured()): ?>
			<sup class="featured">Featured</sup>
		<?php endif; ?>
		
		<div style="position:relative;float:right;">
			<div class="mbutton"> 
				<a href="?option=com_byrdlist&view=listings" rel="nofollow">Back to "Software" Listings</a>
			</div>
		</div>
	</h2> 
 
	<div class="column first">
		<div class="listing-desc">
			<?php echo $this->_record->description(); ?>
		</div>
		
		<div class="rating-fav">
			<div style="position:relative;float:left;width:48%;">
				<div class="rating">
					<div id="fav-caption" style="position:relative;float:left;margin-right:10px;">
						Rating:
					</div> 
					<?php $this->element('stars'); ?>
					<div id="total-votes"><?php echo $this->_record->countComments(); ?> vote</div>
				</div>
				
				<div class="favourite" style="margin-bottom:5px;">
					<span class="fav-caption">Viewed:</span> 
					<div id="fav-count"><?php echo $this->_record->viewed(); ?></div>
				</div>
				
				<div class="favourite" style="margin-bottom:5px;">
					<span class="fav-caption">Bids:</span> 
					<div id="fav-count"><?php echo $this->_record->countBids(); ?></div>
				</div>
				
				<div class="favourite" style="margin-bottom:5px;">
					<span class="fav-caption">Watched:</span> 
					<div id="fav-count"><?php echo $this->_record->countWatched(); ?></div>
					<div id="fav-msg">
						<?php if ($this->is_watched): ?>
						
						<small>You're Watching</small>
						<?php else: ?>
						
						<a href="?option=com_byrdlist&view=listings&layout=details&record=<?php echo $this->_record->id(); ?>&watched=<?php echo $this->_record->id(); ?>">
						Add to Watch list</a>
						<?php endif; ?>
						
					</div>
					
				</div>
				
				<div class="favourite" style="margin-bottom:5px;">
					<span class="fav-caption">Recommended:</span> 
					<div id="fav-count"><?php echo $this->_record->recommended(); ?></div>
					<div id="fav-msg">
					<a href="?option=com_byrdlist&view=listings&layout=recommend&_listings_id=<?php echo $this->_record->id(); ?>">
					Recommend</a>
					</div>
				</div>
				
			</div>
			<div style="position:relative;float:left;width:48%;">
				
				<div class="favourite" style="margin-bottom:5px;">
					<span class="fav-caption">Expires:</span> 
					<div id="fav-count"><?php echo $this->_record->auction_end(); ?></div>
				</div>
				
				<div class="favourite" style="margin-bottom:5px;">
					<span class="fav-caption">Last Bid:</span> 
					<div id="fav-count">$<?php echo $last_bid->amount(); ?></div>
				</div>
				
				<?php if ($this->_record->buy_now()) : ?>
				<div class="favourite" style="margin-bottom:5px;">
					<span class="fav-caption">Buy Now:</span> 
					<div id="fav-count">$<?php echo $this->_record->buy_now(); ?></div>
				</div>
				<?php endif; ?>
				
				<div class="favourite" style="margin-top:10px;">
					<form action="?option=com_byrdlist&view=listings&layout=details&task=&record=<?php echo $this->_record->id(); ?>"
					method="post" id="placebid">
						<input type="text" id="amount" name="amount" value="" class="bidboxinput"/>
						<input type="hidden" id="_listings_id" name="_listings_id" value="<?php echo $this->_record->id(); ?>"/>
						<input type="hidden" id="task" name="task" value="placebid"/>
						
						<div class="mbutton">
							<a href="javascript: document.getElementById('placebid').submit();" style="margin:0;">
							Place a Bid</a> 
						</div>
						
					</form>
				</div>
				
				<?php if ($this->_record->buy_now()) : ?>
				<div class="mbutton">
					<a href="?option=com_byrdlist&view=listings&layout=comment&_listings_id=<?php echo $this->_record->id(); ?>">
					Buy it Now</a> 
				</div>
				<?php endif; ?>
				
			</div>
		</div>
	</div>
	
	<div class="column second">
		<div class="images"> 
			<div class="content">
			<?php if (is_array($this->_record->images())): ?>
			<?php foreach ($this->_record->images() as $id => $instance): $count++; ?>
			
				<?php if ($count == 1): ?>
				<div class="thumbnail first">
					<a id="mainimagelink" href="">
					<img id="mainimage" src="<?php echo $instance->file(); ?>" alt="<?php echo $this->_record->name(); ?>" />
					</a>
				</div>
				<?php else: ?>
				<div class="thumbnail-left">
					<a href="">
					<img src="<?php echo $instance->file(); ?>" alt="<?php echo $this->_record->name(); ?>" />
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
	
	<div class="actions-rating-fav">
		<div class="mbutton" style="padding:10px;"> 
			<a href="#bidhere" onClick="javascript:bid_highlight();" rel="nofollow">
			Bid Now</a>
			
			<?php if ($this->_record->buy_now()) : ?>
			<a href="#acquire" rel="nofollow">
			Buy Now</a>
			<?php endif; ?>
			
			<a href="?option=com_byrdlist&view=listings&layout=contact&_listings_id=<?php echo $this->_record->id(); ?>" rel="nofollow">
			Contact Owner</a>
			
			<a href="?option=com_byrdlist&view=listings&layout=comment&_listings_id=<?php echo $this->_record->id(); ?>" rel="nofollow">
			Submit Comment</a>
			
			<a href="?option=com_byrdlist&view=listings&layout=recommend&_listings_id=<?php echo $this->_record->id(); ?>" rel="nofollow">
			Recommend</a>
			
			<a href="?option=com_byrdlist&view=listings&layout=details&format=pdf&record=<?php echo $this->_record->id(); ?>" title="Print">
			Print</a>
			
			<a href="?option=com_byrdlist&view=listings&layout=report&_listings_id=<?php echo $this->_record->id(); ?>" rel="nofollow">
			Report</a>
			
			<a href="?option=com_byrdlist&view=listings&type=owner&_listings_id=<?php echo $this->_record->id(); ?>">
			Owner's listings</a>
			
		</div>
	</div>
</div>

<br/>
<?php $this->element('comments'); ?>

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


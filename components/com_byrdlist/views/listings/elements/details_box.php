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

<div class="rating-fav">
			<div style="position:relative;float:left;width:48%;">
				<!-- 
				<div class="rating">
					<div id="fav-caption" style="position:relative;float:left;margin-right:10px;">
						Rating:
					</div> 
					<?php //$this->element('stars'); ?>
					<div id="total-votes"><?php //echo $this->_record->countComments(); ?> vote</div>
				</div>
				 -->
				 
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
					
					<?php if (!$this->_record->isClosed()): ?>
						<?php if ($this->isLoggedIn): ?>
							<?php if (!$this->is_owner): ?>
								<?php if ($this->is_watched): ?>
									<small>You're Watching</small>
								<?php else: ?>
									<a href="?option=com_byrdlist&view=listings&layout=details&record=<?php echo $this->_record->id(); ?>&watched=<?php echo $this->_record->id(); ?>">
									Add to Watch list</a>
								<?php endif; ?>
							<?php endif; ?>
						<?php endif; ?>
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
					<div id="fav-count"><?php echo $this->_record->html_auction_end(); ?></div>
				</div>
				
				<?php if (!$this->_record->isClosed()): ?>
					<?php if ( $hasBid ): ?>
						<div class="favourite" style="margin-bottom:5px;">
							<span class="fav-caption">Last Bid:</span> 
							<div id="fav-count">$<?php echo $last_bid->amount(); ?> <small class="reserve">Reserve [<?php echo $this->_record->reserve_price(); ?>]</small></div>
						</div>
					<?php else: ?>
						<div class="favourite" style="margin-bottom:5px;">
							<span class="fav-caption">Last Bid:</span> 
							<div id="fav-count"> None <small class="reserve">Reserve [<?php echo $this->_record->reserve_price(); ?>]</small></div>
						</div>
					<?php endif; ?>
					
					<?php if ($this->isLoggedIn): ?>
						<?php if (!$this->is_owner): ?>
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
									<input type="hidden" name="published" value="published"/>
									
									<div class="mbutton">
										<a href="javascript: document.getElementById('placebid').submit();" style="margin:0;">
										Place a Bid</a> 
									</div>
								</form>
							</div>
							
							<?php if ($this->_record->buy_now()) : ?>
								<div class="mbutton">
									<a href="?option=com_byrdlist&view=listings&layout=buy_now&_listings_id=<?php echo $this->_record->id(); ?>">
									Buy it Now</a> 
								</div>
							<?php endif; ?>
						<?php endif; ?>
					<?php endif; ?>
					
				<?php elseif ($this->_record->isBuyNow()): ?>
					<div class="favourite" style="margin-bottom:5px;">
						<span class="fav-caption">Purchased for:</span> 
						<div id="fav-count">$<?php echo $this->_record->buy_now(); ?></div>
					</div>
				<?php else: ?>
					<div class="favourite" style="margin-bottom:5px;">
						<span class="fav-caption">Winning Bid:</span> 
						<div id="fav-count">$<?php echo $last_bid->amount(); ?></div>
					</div>
				<?php endif; ?>
				
			</div>
			
			<div style="clear:both;"><br/></div>
			<?php if ( $hasBid ): ?>
				<b>Last bid by : <?php $bidder->name(); ?></b>
			<?php endif; ?>
		</div>
		
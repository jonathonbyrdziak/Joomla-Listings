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
					<span class="fav-caption">Offers:</span> 
					<div id="fav-count"><?php echo $this->_record->countComments(); ?></div>
				</div>
				
				<div class="favourite" style="margin-bottom:5px;">
					<span class="fav-caption">Watched:</span> 
					<div id="fav-count"><?php echo $this->_record->countWatched(); ?></div>
					<div id="fav-msg">
					
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
					<?php if (!$this->isClosed): ?>
						<div id="fav-count"><?php echo $this->_record->html_auction_end(); ?></div>
					<?php else: ?>
						<div id="fav-count" style="color:red;">Auction Ended!</div>
					<?php endif; ?>
				</div>
				
				<?php if ($this->isLoggedIn): ?>
					<?php if (!$this->is_owner): ?>
						<?php if (!$this->_record->isClosed()): ?>
							<div class="mbutton">
								<a href="?option=com_byrdlist&view=listings&layout=offer&_listings_id=<?php echo $this->_record->id(); ?>" rel="nofollow">
								Make an Offer</a>
							</div>
						<?php endif; ?>
					<?php endif; ?>
				<?php endif; ?>
				
			</div>
		</div>
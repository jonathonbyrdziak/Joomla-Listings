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
			<div class="favourite" style="margin-bottom:10px;font-weight:bold;font-size:24px;">
				Received $<?php echo $this->_record->received(); ?> of 
				$<?php echo $this->_record->funding_goal(); ?>
			</div>
				
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
					
					<?php if (!$this->_record->isClosed()): ?>
						<div id="fav-msg">
						<a href="?option=com_byrdlist&view=listings&layout=recommend&_listings_id=<?php echo $this->_record->id(); ?>">
						Recommend</a>
						</div>
					<?php endif; ?>
					
				</div>
			</div>
			
			
			
			<div style="position:relative;float:left;width:48%;">
				<div class="favourite" style="margin-bottom:5px;">
					<?php if (!$this->_record->isClosed()): ?>
						<span class="fav-caption">Expires:</span> 
						<div id="fav-count"><?php echo $this->_record->html_campaign_ends(); ?></div>
					<?php endif; ?>
						<span class="fav-caption" style="color:red;">Goal Reached!</span>
				</div>
				
				<div class="favourite" style="margin-bottom:5px;">
					<span class="fav-caption">Contributions:</span> 
					<div id="fav-count"><?php echo $this->_record->countPayments(); ?></div>
				</div>
				
				<div class="favourite" style="margin-top:10px;">
					<?php if (!$this->_record->isClosed()): ?>
						<form action="?option=com_byrdlist&view=listings&layout=payment" method="post" id="formcontribute">
							
							<input type="text" id="amount" name="amount" value="" class="bidboxinput"/>
							<input type="hidden" id="_listings_id" name="_listings_id" value="<?php echo $this->_record->id(); ?>"/>
							
							<div class="mbutton">
								<a href="javascript: document.getElementById('formcontribute').submit();" style="margin:0;">
								Contribute</a> 
							</div>
							
						</form>
					<?php endif; ?>
				</div>
			</div>
		</div>
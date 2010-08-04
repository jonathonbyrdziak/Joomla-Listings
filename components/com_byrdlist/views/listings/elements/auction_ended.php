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
<?php if ($winner && $user->id() == $winner->id()): ?>

	<?php if (!$this->_record->getPaid()): ?>
		<div style="position:relative;float:left;width:38%;">
			<div class="favourite" style="margin-bottom:5px;">
				<span class="fav-caption">Final Bid:</span> 
				<div id="fav-count">$<?php echo $this->_record->getPaid(); ?></div>
			</div>
			
			<div class="mbutton">
				<a href="?option=<?php echo EBOOK_COMPONENT; ?>&view=listings&layout=payment&task=save&_listings_id=<?php echo $this->_record->id(); ?>" style="margin:0;">
				Take me to Payal!</a> 
			</div>
		</div>
		<div style="position:relative;float:left;width:58%;">
			<h2>Congratulations</h2>
		</div>
	<?php else: ?>
		<h2 style="">Congratulations <?php echo $winner->name(); ?></h2>
	<?php endif; ?>
	
<?php elseif ($owner && $user->id() == $owner->id()): ?>
	<div style="position:relative;float:left;width:100%;" class="mbutton">
		<a href="?option=com_byrdlist&view=listings&layout=shipping&format=pdf&record=<?php echo $this->_record->id(); ?>" title="Print">
		Shipping Label</a>
	</div>
<?php else: ?>
	<h2 style="">Auction Won by <?php if ($winner) echo $winner->name(); ?></h2>
<?php endif; ?>
</div>
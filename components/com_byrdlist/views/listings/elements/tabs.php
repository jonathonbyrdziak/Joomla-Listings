<?php
/**
 * Joomla! 1.5 component reservation
 *
 * @version $Id: view.html.php 2010-06-02 12:34:25 svn $
 * @author 
 * @package Joomla
 * @subpackage reservation
 * @license Copyright (c) 2010 - All Rights Reserved
 *
 * 
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

$all = count($this->getQuery( 1, 'all' ));
$auction_count = count($this->getQuery( 1, 'auction' ));
$donation_count = count($this->getQuery( 1, 'donation' ));
$need_count = count($this->getQuery( 1, 'need' ));
$financial_count = count($this->getQuery( 1, 'financial' ));

?>

<div class="users-tab"> 
	<?php if (JRequest::getVar('filter', false)): ?>
		<div class="users-listings">
			<a href="/index.php?option=com_byrdlist&view=listings&_categories_id=<?php echo JRequest::getVar('_categories_id'); ?>">
			All Listings </a> (<?php echo $all; ?>)
		</div> 
	<?php else: ?>
		<div class="users-listings-active">
			<span>All Listings </span> (<?php echo $all; ?>)
		</div> 
	<?php endif; ?>
	
	
	<?php if (JRequest::getVar('filter') != 'auction'): ?>
		<div class="users-reviews">
			<a href="/index.php?option=com_byrdlist&view=listings&filter=auction&_categories_id=<?php echo JRequest::getVar('_categories_id'); ?>">
			Auctions </a> (<?php echo $auction_count; ?>)
		</div>
	<?php else: ?>
		<div class="users-reviews-active">
			<span>Auctions </span> (<?php echo $auction_count; ?>)
		</div>
	<?php endif; ?>
	
	
	<?php if (JRequest::getVar('filter') != 'donation'): ?>
		<div class="users-favourites">
			<a href="/index.php?option=com_byrdlist&view=listings&filter=donation&_categories_id=<?php echo JRequest::getVar('_categories_id'); ?>">
			Donations </a> (<?php echo $donation_count; ?>)
		</div>
	<?php else: ?>
		<div class="users-favourites-active">
			<span>Donations </span> (<?php echo $donation_count; ?>)
		</div>
	<?php endif; ?>
	
	
	<?php if (JRequest::getVar('filter') != 'financial'): ?>
		<div class="users-favourites">
			<a href="/index.php?option=com_byrdlist&view=listings&filter=financial&_categories_id=<?php echo JRequest::getVar('_categories_id'); ?>">
			Financial Campaigns </a> (<?php echo $financial_count; ?>)
		</div>
	<?php else: ?>
		<div class="users-favourites-active">
			<span>Financial Campaigns </span> (<?php echo $financial_count; ?>)
		</div>
	<?php endif; ?>
	
	
	<?php if (JRequest::getVar('filter') != 'need'): ?>
		<div class="users-favourites">
			<a href="/index.php?option=com_byrdlist&view=listings&filter=need&_categories_id=<?php echo JRequest::getVar('_categories_id'); ?>">
			Needs </a> (<?php echo $need_count; ?>)
		</div>
	<?php else: ?>
		<div class="users-favourites-active">
			<span>Needs </span> (<?php echo $need_count; ?>)
		</div>
	<?php endif; ?>
</div> 
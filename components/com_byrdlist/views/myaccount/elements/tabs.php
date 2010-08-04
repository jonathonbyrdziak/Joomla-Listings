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

$all = ($t = $this->getQuery( 1, 'owner' ))? count($t) : 0;
$watch_count = ($t = $this->getQuery( 1, 'mywatch' ))? count($t) : 0;
$acq_count = ($t = $this->getQuery( 1, 'myacquired' ))? count($t) : 0;
$closed_count = ($t = $this->getQuery( 1, 'myclosed' ))? count($t) : 0;

?>


<div class="users-tab"> 
	<?php if (JRequest::getVar('filter','owner') != 'owner'): ?>
		<div class="users-listings">
			<a href="/index.php?option=com_byrdlist&view=myaccount&filter=owner">My Listings </a> (<?php echo $all; ?>)
		</div> 
	<?php else: ?>
		<div class="users-listings-active">
			<span>My Listings </span> (<?php echo $all; ?>)
		</div> 
	<?php endif; ?>
	
	
	<?php if (JRequest::getVar('filter') != 'mywatch'): ?>
		<div class="users-reviews">
			<a href="/index.php?option=com_byrdlist&view=myaccount&filter=mywatch">Watch List </a> (<?php echo $watch_count; ?>)
		</div>
	<?php else: ?>
		<div class="users-reviews-active">
			<span>Watch List </span> (<?php echo $watch_count; ?>)
		</div>
	<?php endif; ?>
	
	
	<?php if (JRequest::getVar('filter') != 'myacquired'): ?>
		<div class="users-favourites">
			<a href="/index.php?option=com_byrdlist&view=myaccount&filter=myacquired">Acquired Listings </a> (<?php echo $acq_count; ?>)
		</div>
	<?php else: ?>
		<div class="users-favourites-active">
			<span>Acquired Listings </span> (<?php echo $acq_count; ?>)
		</div>
	<?php endif; ?>
	
	
	<?php if (JRequest::getVar('filter') != 'myclosed'): ?>
		<div class="users-favourites">
			<a href="/index.php?option=com_byrdlist&view=myaccount&filter=myclosed">Closed Listings </a> (<?php echo $closed_count; ?>)
		</div>
	<?php else: ?>
		<div class="users-favourites-active">
			<span>Closed Listings </span> (<?php echo $closed_count; ?>)
		</div>
	<?php endif; ?>
</div> 
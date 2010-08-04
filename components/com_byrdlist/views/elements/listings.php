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

$pagination = $this->getPagination();

?>

<div id="listings">	
	<!-- <div class="title">Listings</div> -->
 
	<div class="pages-links"> 
		<span class="xlistings">Results <?php echo $pagination['limitstart']; ?> - 
		<?php echo $pagination['limitrecords']; ?> of <?php echo $pagination['total_rows']; ?></span> 
	</div> 
	
	<?php $this->element('listing_item'); ?>
	
	<div class="pages-links">
		<span class="xlistings">Results <?php echo $pagination['limitstart']; ?> - 
		<?php echo $pagination['limitrecords']; ?> of <?php echo $pagination['total_rows']; ?></span>
		
		<?php $this->element('pagination'); ?>
	</div>
</div>



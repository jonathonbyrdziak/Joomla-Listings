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
	<div style="position:relative;float:left;width:100%">
		<h2>Congratulations </h2>
		<p>This auction has been awarded to <?php echo $winner->name(); ?></p>
		<hr/><br/>
		<h4><?php echo $awarded->name(); ?></h4>
		<?php echo $awarded->description(); ?>
	</div>
</div>
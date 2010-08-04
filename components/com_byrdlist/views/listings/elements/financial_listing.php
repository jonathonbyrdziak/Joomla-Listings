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
	<div style="position:relative;float:left;width:100%">
		<b>Contributing Auctions</b>
		<p>Earnings from the following auctions will be contributed to this Financial Campaign.</p>
	</div>
</div>

<?php $this->element('financial_listings');?>
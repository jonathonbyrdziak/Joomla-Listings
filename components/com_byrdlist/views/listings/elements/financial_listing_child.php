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
		<b>Earnings from the sale of this auction will be contributed to : </b><br/><br/>
		<a href="?option=com_byrdlist&view=listings&layout=details&record=<?php echo $record->id(); ?>"><b><?php echo $record->name(); ?></b></a><br/><br/>
		<p><?php echo $record->description( 500 ); ?></p>
	</div>
</div>
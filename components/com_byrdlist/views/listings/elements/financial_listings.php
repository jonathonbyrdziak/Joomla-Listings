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

<a href="?option=com_byrdlist&view=listings&layout=details&record=<?php echo $record->id(); ?>" class="search_result_link">
	<div class="search_result" style="border:none;width:95%;">
		<img src="<?php echo $thumb->file(); ?>" width="100px" />
		<span><?php echo $record->name(); ?></span>
		<p><?php echo $record->description( 250 ); ?></p>
		<div class="clearfix"></div>
	</div>
</a>
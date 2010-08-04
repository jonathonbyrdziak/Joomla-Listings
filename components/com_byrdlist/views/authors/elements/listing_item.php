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
	<div class="listing-summary"> 
		<div class="header"> 
			<h3 style="width:400px;display:inline;">
				<a href="?option=com_byrdlist&view=authors&layout=new&record=<?php echo $record->id(); ?>" 
				class="actionlink">
				Edit</a>
				
				<a style="font-size:22px;color:#555;text-decoration:none;"
				href="?option=com_byrdlist&view=authors&layout=details&record=<?php echo $record->id(); ?>">
				<?php echo $record->name(); ?></a>
			</h3>
			
			<div class="column" style="width:300px;display:inline;">
			Registered on :: <b><?php echo $record->created_on( 1 ); ?></b>
			</div>
			
		</div>
		
		<a href="?option=com_byrdlist&view=listings&layout=details&record=<?php echo $record->id(); ?>">
			<?php echo $record->getHtmlAvatar( ); ?>
		</a>
		
		<?php if ($record->website()): ?>
			<p class="website">
				<a style="text-decoration:none;padding:3px;font-size:10px;letter-spacing:1px;"
				href="http:<?php echo str_replace('http://','', $record->website()); ?>" target="_blank">
				<?php echo $record->website(); ?></a>
			</p>
		<?php endif; ?>
		
		<p>
			<?php echo $record->description( 500 ); ?><b>...</b>
		</p>
		
		<div class="fields"></div>
		
	</div>
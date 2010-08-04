<?php
/**
 * Joomla! 1.5 component byrdlist
 *
 * @version $Id: byrdlist.php 2010-06-07 11:32:44 svn $
 * @author Jonathon Byrd
 * @package Joomla
 * @subpackage byrdlist
 * @license Copyright (c) 2010 - All Rights Reserved
 *
 * 
 *
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

//initializing variables
$data = JRequest::get('post');
 	
//loading resources
$record =& JTable::getInstance('byrdlist_images', 'Table');
$record->bind( $data, array(), false );

$record->store();


?>
<?php if ($record->valid()): ?>
	<span id="imageid" imageid="<?php echo $record->id(); ?>" class="imageactions"> 
		<?php if (!$record->isThumbnail()): ?>
			<span id="<?php echo $record->id(); ?>_span">
				<a href="#" onClick="javascript: _thumb('<?php echo $record->id(); ?>'); return false;">
				thumbnail | </a>
			</span>
		<?php endif; ?>
		<span>
			<a href="#" onClick="javascript: _delete('<?php echo $record->id(); ?>'); return false;">
			delete | </a>
			<!-- 
			<a href="#" onClick="javascript: _edit('<?php echo $record->id(); ?>'); return false;">
			edit</a>
			 -->
		</span>
	</span>
	
	<img src="<?php echo $record->file(); ?>" border="0" width="75px" align="left" style="margin-right:10px;"/>
	<b><?php echo $record->name(); ?></b>
	<br/>
	<span style="font-size:10px;"><?php echo substr($record->description(),0,120); ?></span>
<?php else: ?>
	<span class="warning">Sorry, there was an error.</span>
<?php endif; ?>
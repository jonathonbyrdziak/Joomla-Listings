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

?>
<div id="listing"> 
	<h2>
		<?php echo $this->_record->name(); ?>
		
		<?php if ($this->_record->featured()): ?>
			<span>Featured</span>
		<?php endif; ?>
	</h2> 
	
	<div>
		<?php echo $this->_record->description(); ?>
	</div>
	
	<br/><br/>
	
	<h3>Listings details</h3>
	<table>
		
		<?php foreach ($this->_record->listing_details() as $caption => $value): ?>
		<tr>
			<td>
				<?php echo $caption; ?>
			</td>
			<td>
				<?php echo $value; ?>
			</td>
		</tr>
		<?php endforeach; ?>
		
	</table>
	
	<br/>
	
	<?php foreach ($this->_record->images() as $id => $instance): $count++; ?>
		<?php if ($count == 2) break; ?>
		<?php if (!$instance->isPdfValid()) break; ?>
		
		<img align="left" src="<?php echo DOTCOM.substr($instance->file(),1); ?>" 
		alt="<?php echo $this->_record->name(); ?>" />
		
	<?php endforeach; ?>
	
</div>
	
<?php
/**
 * Joomla! 1.5 component reservation
 *
 * @version $Id: reservation.php 2010-06-02 12:34:25 svn $
 * @author 
 * @package Joomla
 * @subpackage reservation
 * @license Copyright (c) 2010 - All Rights Reserved
 *
 * 
 *
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access'); 

//loading resources
$listing =& $this->_record->getOneToOne('byrdlist_listings');
$listings = JTable::getInstance('byrdlist_listings', 'Table');
$list = $listings->getList();

//initializing variables
$count = 0;

?>
<div style="width:500px;height:50px;overflow:auto;">
	<table>
	<?php foreach ($list as $id => $instance): $count++; ?>
		<tr>
		<td>
			<input type="radio" id="cb<?php echo $count; ?>" name="_listings_id" 
			value="<?php echo $instance->id(); ?>" <?php if ($listing->id() == $instance->id()) echo 'checked="true"'; ?>/>
		</td>
		<td>
			<label for="cb<?php echo $count; ?>">
				<?php echo $instance->name(); ?>
			</label>
		</td>
		</tr>
	<?php endforeach; ?>
	</table>
</div>
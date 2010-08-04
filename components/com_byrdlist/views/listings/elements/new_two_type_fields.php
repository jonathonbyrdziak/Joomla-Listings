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

$cannotBeEmpty = true;
$ignore = array('reserve_price','shipping_cost','buy_now');

if (in_array($property, $ignore))
{
	$cannotBeEmpty = false;
}


switch ($property): 
	case "":break; // prevents t_switch error
?>
	<?php default: ?>
	<tr> 
		<td> 
			<h1 style="font-size:14px;margin-top:10px;"><?php echo $name; ?>:</h1> 
		</td> 
		</tr> 
		<tr> 
		<td>
			<input type="text" id="<?php echo $property; ?>" name="<?php echo $property; ?>" 
			class="inputbox <?php if ($cannotBeEmpty) echo 'cannotBeEmpty'; ?>" style="width:530px" value="<?php echo $value; ?>" />
			<span class="warning" style="display:none;" id="<?php echo $property; ?>_error">
			Field cannot be empty.</span>
		</td> 
	</tr>
	<?php break; ?>
	
	<?php case "availability": ?>
	<tr> 
		<td> 
			<h1 style="font-size:14px;margin-top:10px;"><?php echo $name; ?>:</h1> 
		</td> 
		</tr> 
		<tr> 
		<td>
			<?php $this->element('dropdown_availability'); ?>
		</td> 
	</tr>
	<?php break; ?>
	
	<?php case "auction_end": ?>
	<tr> 
		<td> 
			<h1 style="font-size:14px;margin-top:10px;"><?php echo $name; ?>:</h1> 
		</td> 
		</tr> 
		<tr> 
		<td>
			<?php $this->element('dropdown_auction_end'); ?>
		</td> 
	</tr>
	<?php break; ?>
	
	<?php case "campaign_ends": ?>
	<tr> 
		<td> 
			<h1 style="font-size:14px;margin-top:10px;"><?php echo $name; ?>:</h1> 
		</td> 
		</tr> 
		<tr> 
		<td>
			<?php $this->element('dropdown_campaign_ends'); ?>
		</td> 
	</tr>
	<?php break; ?>
	
	<?php case "condition": ?>
	<tr> 
		<td> 
			<h1 style="font-size:14px;margin-top:10px;"><?php echo $name; ?>:</h1> 
		</td> 
		</tr> 
		<tr> 
		<td>
			<?php $this->element('dropdown_item_condition'); ?>
		</td> 
	</tr>
	<?php break; ?>
	
<?php endswitch; ?>
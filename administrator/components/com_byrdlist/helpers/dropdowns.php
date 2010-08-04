<?php
/**
 * Joomla! 1.5 component Every Booking
 *
 * @author Jonathon Byrd
 * @package Joomla
 * @subpackage everybooking
 * @license Proprietary software, closed source, All rights reserved November 2009 Every Booking Inc.
 * For more information please see http://www.everybooking.com
 * 
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

//loading resources
$user =& eFactory::getUser();

$GLOBALS['dropdowns'] = array(
	'gateways' => array(
		'paypal' => 'Paypal',
	),
	'listing_types' => array(
		'auction' => 'Auction Listing',
		'donation' => 'Donation Listing',
		'financial' => 'Financial Campaign',
		'need' => 'Requested Need',
	),
	'violation_type' => array(
		'toc' => 'Violates Terms and Conditions',
		'rating' => 'Vulgar Language',
		'spam' => 'Spam or Unecessary Listing',
		'links' => 'Broken Links',
		'inaccurate' => 'Inaccurate information',
		'category' => 'This listing is in the wrong category',
		'other' => 'Other Reason Explained',
	),
	'availability' => array(
		'7' => 'Seven Days',
		'10' => 'Ten Days',
		'15' => 'Fifteen Days',
		'30' => 'Thirty Days',
	),
	'auction_end' => array(
		'7' => 'Seven Days',
		'10' => 'Ten Days',
		'15' => 'Fifteen Days',
		'30' => 'Thirty Days',
	),
	'campaign_ends' => array(
		'30' => 'Thirty Days',
		'60' => 'Two Months',
		'182' => 'Six Months',
		'365' => 'One Year',
	),
	'name_mapping' => array(
		'buy_now' => 'Buy It Now Price',
		'auction_end' => 'Listing Expires In',
	),
	'item_condition' => array(
		'1' => '1 Very Poor',
		'2' => '2 Poor',
		'3' => '3 No Major Problems',
		'4' => '4 Fair',
		'5' => '5 Excellent',
	),
	'website_types' => array(
		'default' => 'Standard Page',
	//	'contact' => 'Contact Page',
	//	'images' => 'Image Gallery',
	),
);


if ($user->isNonProfit())
{
	$GLOBALS['dropdowns']['listing_types'] = array(
		'auction' => 'Auction Listing',
	//	'donation' => 'Donation Listing',
		'financial' => 'Financial Campaign',
		'need' => 'Requested Need',
	);
}

if ($user->isDonor())
{
	$GLOBALS['dropdowns']['listing_types'] = array(
		'auction' => 'Auction Listing',
		'donation' => 'Donation Listing',
	//	'financial' => 'Financial Campaign',
	//	'need' => 'Requested Need',
	);
}
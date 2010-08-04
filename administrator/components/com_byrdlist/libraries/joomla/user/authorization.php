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

/**
 * Authorization array
 * 
 * 
 */
$authorization = array(
	'Super Administrator' => array(
	
	),
	'Individual Donor' => array(
	
	),
	'NonProfit' => array(
	
	),
	'Registered' => array(
		'authors.new',
		'authors.new_two',
		'listings.ajaxupload',
		'listings.buy_now',
		'listings.payment',
		'listings.new',
		'listings.new_two',
		'listings.new_three',
		'listings.request',
		'listings.comment',
		'listings.contact',
		'listings.offer',
		'listings.report',
		'myaccount.default',
		'myaccount.delete',
		'myaccount.payment',
		'myaccount.settings',
		'myaccount.shipping',
	),
	'Public' => array(
		'authors.default',
		'authors.details',
		'myaccount.ipn',
		'myaccount.cron',
		'categories.default',
		'listings.search_results',
		'listings.default',
		'listings.details',
		'listings.details_donation',
		'listings.details_financial',
		'listings.details_need',
		'listings.details_pdf',
		'listings.recommend',
		'listings.search',
	),
	
);

//loading libraries
require_once EBOOK_HELPERS.DS.'authorization.php';

//process this array
eHelper::loop( $authorization );




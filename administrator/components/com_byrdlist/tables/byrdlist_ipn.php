<?php
/**
* @version		$Id: user.php 11223 2008-10-29 03:10:37Z pasamio $
* @package		Joomla.Framework
* @subpackage	Table
* @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();

/**
 * Users table
 *
 * @package 	Joomla.Framework
 * @subpackage		Table
 * @since	1.0
 */
class TableByrdlist_ipn extends ResTable
{
	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $id				= null;

	/**
	 * 
	 *
	 * @var string
	 */
	var $created_on		= null;

	/**
	 * echeck, instant
	 *
	 * @var varchar(8)
	 */
	var $payment_type = null;

    /**
	 * 22:24:40 Dec. 20, 2009 PST
	 *
	 * @var timestamp
	 */
	var $payment_date = null;

    /**
	 * Canceled_Reversal, Completed, Denied, Expired, Failed, In-Progress
	 * Partially_Refunded, Pending, Processed, Refunded, Reversed, Voided
	 *
	 * @var varchar(20)
	 */
	var $payment_status = null;

	/**
	 * echeck
	 *
	 * @var varchar(10)
	 */
	var $pending_reason = null;

    /**
	 * confirmed
	 *
	 * @var varchar(10)
	 */
	var $address_status = null;

	/**
	 * confirmed
	 *
	 * @var varchar(10)
	 */
	var $payer_status = null;

	/**
	 * the users name
	 *
	 * @var varchar(100)
	 */
	var $first_name = null;

	/**
	 * the users last name
	 *
	 * @var varchar(100)
	 */
	var $last_name = null;

	/**
	 * buyer@paypalsandbox.com
	 *
	 * @var varchar(100)
	 */
	var $payer_email = null;

	/**
	 * TESTBUYERID01
	 *
	 * @var varchar(50)
	 */
	var $payer_id = null;

	/**
	 * John Smith
	 *
	 * @var varchar(100)
	 */
	var $address_name = null;

	/**
	 * United States
	 *
	 * @var varchar(100)
	 */
	var $address_country = null;

	/**
	 * US
	 *
	 * @var varchar(25)
	 */
	var $address_country_code = null;

	/**
	 * 95131
	 *
	 * @var varchar(10)
	 */
	var $address_zip = null;

	/**
	 * WA
	 *
	 * @var varchar(10)
	 */
	var $address_state = null;

	/**
	 * San Jose
	 *
	 * @var varchar(100)
	 */
	var $address_city = null;

	/**
	 * 123, any street
	 *
	 * @var varchar(100)
	 */
	var $address_street = null;

	/**
	 * seller@paypalsandbox.com
	 *
	 * @var varchar(100)
	 */
	var $business = null;

	/**
	 * seller@paypalsandbox.com
	 *
	 * @var varchar(100)
	 */
	var $receiver_email = null;

	/**
	 * TESTSELLERID1
	 *
	 * @var varchar(50)
	 */
	var $receiver_id = null;

	/**
	 * US
	 *
	 * @var varchar(25)
	 */
	var $residence_country = null;

	/**
	 * something
	 *
	 * @var varchar(100)
	 */
	var $item_name = null;

	/**
	 * AK-1234
	 *
	 * @var varchar(100)
	 */
	var $item_number = null;

	/**
	 * 1
	 *
	 * @var int(5)
	 */
	var $quantity = null;

	/**
	 * 3.04
	 *
	 * @var decimal(10,2)
	 */
	var $shipping = null;

	/**
	 * 2.02
	 *
	 * @var decimal(10,2)
	 */
	var $tax = null;

	/**
	 * USD
	 *
	 * @var varchar(10)
	 */
	var $mc_currency = null;

	/**
	 * 0.44
	 *
	 * @var decimal(10,2)
	 */
	var $mc_fee = null;

	/**
	 * "12.34
	 *
	 * @var decimal(10,2)
	 */
	var $mc_gross = null;

	/**
	 * web_accept
	 *
	 * @var varchar(10)
	 */
	var $txn_type = null;

	/**
	 * 401221624
	 *
	 * @var int(11)
	 */
	var $txn_id = null;

	/**
	 * 2.1
	 *
	 * @var varchar(5)
	 */
	var $notify_version = null;

	/**
	 * xyz123
	 *
	 * @var varchar(10)
	 */
	var $custom = null;

	/**
	 * xyz1234
	 *
	 * @var varchar(20)
	 */
	var $invoice = null;

	/**
	 * windows-1252
	 *
	 * @var varchar(25)
	 */
	var $charset = null;

	/**
	 * A688nRBjy0haRXvEWbs5m6I-IQdpARIHDtKbXU4EbLuZVaE.Yptjpszw
	 *
	 * @var varchar(100)
	 */
	var $verify_sign = null;

	/**
	 * 
	 *
	 * @var string
	 */
	var $_payments_id		= null;

	
	/**
	 * @param database A database connector object
	 */
	function __construct( &$db )
	{
		parent::__construct( '#__byrdlist_ipn', 'id', $db );
	}

	/**
	 * 
	 */
	function Check()
	{
		return true;
	}
	
	/**
	 * 
	 */
	function store()
	{
		if ($id = parent::store())
		{
			$this->saveRelationship('byrdlist_payments');
			return $id;
		}
		return false;
	}
}

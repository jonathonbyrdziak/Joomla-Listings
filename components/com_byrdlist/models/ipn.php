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
 */

// no direct access
defined('JPATH_BASE') or die();


/**
 *
 * @author Jonathon Byrd
 *
 */
class ByrdIpn {

	/**
	 * All the tests have been passed
	 * run all the custom functions that we want
	 *
	 * @return unknown
	 */
	function verified()
	{
		//loading resources
		$payment =& $this->_record->getOneToOne('byrdlist_payments');
		$payment->setPublished( 1 );
		
		return true;
	}

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
	 * holds the table object
	 * @var object
	 */
	private $_tbl = null;

	/**
	 * holds the table paypal url
	 * @var string
	 */
	private $_paypal = null;

	/**
	 * sandbox true is for testing
	 * @var bool
	 */
	private $_sandbox = null;

	/**
	 * sandbox true is for testing
	 * @var bool
	 */
	private $_verified = null;

	/**
	 * Class constructor, overridden in descendant classes.
	 *
	 * @access	protected
	 */
	function __construct() 
	{
		//set the sandbox
		$this->_sandbox = false;
		if ($this->_sandbox) $this->_paypal = "www.sandbox.paypal.com"; 
		else $this->_paypal = "www.paypal.com";

		//bind the paypal post
		$this->setProperties( $_POST );
		
		//Validate the ipn post
		$this->postback();
		
		//do custom
		if (!$this->_sandbox && !$this->_verified) return false;
		
		$this->store();
		$this->verified();
		
		return true;
	}

	/**
	 * validates the paypal ipn post
	 *
	 * @return bool
	 */
	function postback()
	{
		$req = 'cmd=_notify-validate'.$this->getQuerystring();
		$header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
		$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
		$fp = fsockopen ($this->_paypal, 80, $errno, $errstr, 30);

		if (!$fp) {
		// HTTP ERROR
		} else {
			fputs ($fp, $header . $req);
			while (!feof($fp)) {
				$res = fgets ($fp, 1024);
				if (strcmp ($res, "VERIFIED") == 0) {
					$this->_verified = true;
				} else if (strcmp ($res, "INVALID") == 0) {
					$this->_verified = false;
				}
			}
			fclose ($fp);
		}
		return;
	}

	/**
	 * turns the properties into a querystring
	 *
	 * @return string
	 */
	function getQuerystring()
	{
		$query = '';
		foreach($this->getProperties() as $property => $value){
			$query .= '&'.$property.'='.$value;
		}

		return $query;
	}

	/**
	 * Returns an associative array of object properties
	 *
	 * @access	public
	 * @param	boolean $public If true, returns only the public properties
	 * @return	array
 	 */
	function getProperties( $public = true )
	{
		$vars  = get_object_vars($this);

        if($public)
		{
			foreach ($vars as $key => $value)
			{
				if ('_' == substr($key, 0, 1)) {
					unset($vars[$key]);
				}
			}
		}

        return $vars;
	}

	/**
	 * All the tests have been passed
	 * run all the custom functions that we want
	 *
	 * @return unknown
	 */
	function store()
	{
		//loading resources
		$this->_record =& JTable::getInstance('byrdlist_ipn', 'Table');
		
		$this->_record->bind( $this->getProperties() );
		$this->_record->_payments_id = $this->item_number;
		
		$this->_record->store();
		return true;
	}

	/**
	 * Set the object properties based on a named array/hash
	 *
	 * @access	protected
	 * @param	$array  mixed Either and associative array or another object
	 * @return	boolean
	 */
	function setProperties( $properties )
	{
		$properties = (array) $properties; //cast to an array

		if (is_array($properties))
		{
			foreach ($properties as $k => $v) {
				$this->$k = $v;
			}

			return true;
		}

		return false;
	}
}
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
class TableByrdlist_bids extends ResTable
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
	var $amount			= null;

	/**
	 * 
	 *
	 * @var string
	 */
	var $published		= null;

	/**
	 * 
	 *
	 * @var string
	 */
	var $status			= null;

	/**
	 * 
	 *
	 * @var string
	 */
	var $created_on		= null;

	/**
	 * 
	 *
	 * @var string
	 */
	var $_listings_id	= null;

	/**
	 * 
	 *
	 * @var string
	 */
	var $_payments_id	= null;
	
	/**
	 * @param database A database connector object
	 */
	function __construct( &$db )
	{
		parent::__construct( '#__byrdlist_bids', 'id', $db );
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
	public function isPaid()
	{
		//loading resources
		$listing =& $this->getOneToOne('byrdlist_listings');
		$payments =& $listing->getOneToMany('byrdlist_payments');
		
		//reasons to fail
		if (empty($payments)) return false;
		
		//initializnig variables
		$total = 0;
		
		foreach ($payments as $id => $payment)
		{
			//reasons to continue
			if (!$payment->published()) continue;
			$total = $total + $payment->amount();
		}
		
		if ($total < $this->amount()) return false;
		
		return true;
	}

	/**
	 * 
	 */
	function listing_id()
	{
		//loading resources
		$listing =& $this->getOneToOne('byrdlist_listings');
		
		return $listing->id();
	}

	/**
	 * 
	 */
	function listing_name()
	{
		//loading resources
		$listing =& $this->getOneToOne('byrdlist_listings');
		
		return $listing->name();
	}

	/**
	 * 
	 */
	function store()
	{
		//initializing object property
		$this->setAmount();
		if (!$this->valid()) return false;
		
		if ($id = parent::store())
		{
			$this->saveRelationship('byrdlist_listings');
			return $id;
		}
		return false;
	}
	
	/**
	 * 
	 */
	public function setAmount( $amount = null )
	{
		//initializing object property
		if (!is_null($amount))
		{
			$this->amount = $amount;
		}
		
		//initializing variables
		$replace = array('$');
		
		//cleaning properties
		$this->amount = str_replace($replace, "", $this->amount);
		
		return $this->amount;
	}
	
	/**
	 * Validate this object
	 * 
	 */
	protected function valid()
	{
		//initializing variables
		$lastamount = 0;
		
		//loading resources
		$listing = $this->getOneToOne('byrdlist_listings');
		$lasbid = $listing->last_bid();
		
		if (is_object($lasbid) && strlen(trim($lasbid->id)) >0)
		{
			$lastamount = $lasbid->amount();
		}
		
		//reasons to fail
		if ($this->amount() < 1) return false;
		if ($lastamount > $this->amount()) return false;
		
		return true;
	}
	
}

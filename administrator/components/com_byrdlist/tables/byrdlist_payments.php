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
class TableByrdlist_payments extends ResTable
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
	var $reference_no	= null;

	/**
	 * 
	 *
	 * @var blob
	 */
	var $gateway		= null;

	/**
	 * 
	 *
	 * @var blob
	 */
	var $published		= null;

	/**
	 * 
	 *
	 * @var blob
	 */
	var $description	= null;

	/**
	 * 
	 *
	 * @var blob
	 */
	var $_listings_id	= null;

	
	/**
	 * @param database A database connector object
	 */
	function __construct( &$db )
	{
		parent::__construct( '#__byrdlist_payments', 'id', $db );
	}

	/**
	 * 
	 */
	function Check()
	{
		return true;
	}
	
	/**
	 * Set the Payment to be Published
	 * 
	 * Other responsibilities come with this transaction.
	 * This is only set to published if a properly validated paypal amount comes back.
	 */
	public function setPublished( $num = null )
	{
		//reasons to fail
		if ( is_null($num) ) return false;
		if ( $num < 1 ) return false;
		
		//loading resources
		require_once EBOOK_HELPERS.DS.'mailer.php';
		$listings =& $this->getOneToMany('byrdlist_listings');
		
		//reasons to fail
		if (!$listings) return false;
		if (empty($listings)) return false;
		
		
		foreach ($listings as $listing)
		{
			//reasons to fail
			if ($listing->type() != 'auction') continue;
			
			//loading resources
			$payments = $listing->getOneToMany('byrdlist_payments');
			
			//reasons to fail
			if (empty($payments)) break;
			
			//initializing variables
			$total = $this->amount();
			
			foreach ($payments as $id => $payment)
			{
				if (!$payment->published()) continue;
				$total = $total + $payment->amount();
			}
			
			//loading resources
			$lastbid =& $listing->last_bid();
			$bidauthor =& eFactory::getUser( $lastbid->author_id() );
			$author =& eFactory::getUser( $listing->author_id() );
			
			//more reasons to fail
			if ($total < $lastbid->amount()) break;
			
			BMailer::auctionPaidInFull( $bidauthor, $listing );
			BMailer::notifyListingOwnerAuctionPaidInFull( $author, $listing );
		}
		
		$this->published = 1;
		$this->store();
		
		return true;
	}

	/**
	 * 
	 */
	function store()
	{
		if ($id = parent::store())
		{
			$this->saveRelationship('byrdlist_listings');
			return $id;
		}
		return false;
	}
}

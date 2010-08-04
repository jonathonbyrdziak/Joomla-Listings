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
class TableByrdlist_listings extends ResTable
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
	var $name			= null;

	/**
	 * 
	 *
	 * @var blob
	 */
	var $description	= null;

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
	var $updated_on		= null;
	
	/**
	 * 
	 *
	 * @var blob
	 */
	var $status			= null;

	/**
	 * 
	 *
	 * @var string
	 */
	var $slug			= null;

	/**
	 * 
	 *
	 * @var string
	 */
	var $primary_street	= null;

	/**
	 * 
	 *
	 * @var string
	 */
	var $primary_city	= null;

	/**
	 * 
	 *
	 * @var string
	 */
	var $primary_state	= null;

	/**
	 * 
	 *
	 * @var string
	 */
	var $primary_postal_code = null;

	/**
	 * 
	 *
	 * @var blob
	 */
	var $type			= null;

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
	var $featured		= null;

	/**
	 * 
	 *
	 * @var string
	 */
	var $viewed			= null;

	/**
	 * 
	 *
	 * @var string
	 */
	var $recommended	= null;

	/**
	 * 
	 *
	 * @var string
	 */
	var $expired		= null;
	

	/**
	 * 
	 *
	 * @var string
	 */
	var $lattitude		= null;
	

	/**
	 * 
	 *
	 * @var string
	 */
	var $longitude		= null;
	
	/**
	 * 
	 *
	 * @var string
	 */
	var $_categories_id	= null;

	/**
	 * 
	 *
	 * @var string
	 */
	var $_tags_id		= null;

	/**
	 * 
	 *
	 * @var string
	 */
	var $_juser_id		= null;

	/**
	 * 
	 *
	 * @var string
	 */
	var $_financial_id		= null;
	
	
	/**
	 * Adds a digit to the view counter
	 * 
	 */
	public function addView()
	{
		$this->viewed = $this->viewed + 1;
		$this->store();
	}
	
	/**
	 * Adds a digit to the recommended counter
	 * 
	 */
	public function addRecommend()
	{
		$this->recommended = $this->recommended + 1;
		$this->store();
	}
	
	/**
	 * Auction Ends
	 * 
	 */
	public function auction_end( $format = false )
	{
		//return the day number
		if (!$format) return $this->auction_end;
		
		$string = strtotime($this->created_on." +".$this->auction_end." day");
		$date = date("Y-m-d H:i:s", $string);
		
		return $date;
	}
	
	/**
	 * Buy Now
	 * 
	 */
	public function buy_now()
	{
		if ($this->buy_now == 0) return false;
		
		$this->buy_now = str_replace(array('$',','),'', $this->buy_now);
		
		return $this->buy_now;
	}

	/**
	 * Binds a named array/hash to this object
	 *
	 * Can be overloaded/supplemented by the child class
	 *
	 * @access	public
	 * @param	$from	mixed	An associative array or object
	 * @param	$ignore	mixed	An array or space separated list of fields not to bind
	 * @return	boolean
	 */
	public function bind( $from, $ignore=array(), $public = true )
	{
		//initializing variables
		$type = false;
		$fromArray	= is_array( $from );
		$fromObject	= is_object( $from );
		
		if ($fromArray && isset($from['type']))
		{
			$type = $from['type'];
		}
		
		if ($type)
		{
			//setting object properties
			$class = ucfirst($type).'Listing';
			$path = EBOOK_EVERY.DS.'listing_types'.DS.$type.'.php';
			
			if (file_exists($path))
			{
				require_once $path;
				$obj = new $class;
				$this->setProperties( $obj );
			}
			
		}
		
		if (!parent::bind( $from, $ignore, $public )) return false;
		
		return true;
	}
	
	/**
	 * 
	 */
	public function campaign_ends( $format = false )
	{
		//return the day number
		if (!$format) return $this->campaign_ends;
		
		$string = strtotime($this->created_on." +".$this->campaign_ends." day");
		$date = date("Y-m-d", $string);
		
		return $date;
	}
	
	/**
	 * Description
	 * 
	 */
	public function description( $length = false )
	{
		//initializing variables
		$desc = $this->description;
		
		if ($length) $desc = substr($desc, 0, $length);
		
		return $desc;
	}
	
	/**
	 * Get GEO Location.
	 * 
	 * Saves the lattitude and longitude to the database if
	 * the address is present and the lat and long don't already 
	 * exist.
	 * 
	 * @return boolean
	 */
	protected function getGeoLocation()
	{
		//reasons to fail
		if ($this->longitude > 1) return false;
		if ($this->lattitude > 1) return false;
		
		//initializing variables
		$address = $this->primary_street.' '.$this->primary_city.' '.$this->primary_state.' '.$this->primary_postal_code;
		$url = 'http://maps.google.com/maps/api/geocode/json?address='.urlencode($address).'&sensor=false';

		$data = @file_get_contents($url);
		
		//reasons to fail
		if (!($json = json_decode($data))) return false;
		if ($json->status != "OK") return false;
		if (!isset($json->results[0])) return false;
		
		
		//initializing variables
		$lattitude = $json->results[0]->geometry->location->lat;
		$longitude = $json->results[0]->geometry->location->lng;
		
		$this->lattitude = $lattitude;
		$this->longitude = $longitude;
		
		return true;
	}
	
	/**
	 * 
	 */
	public function html_campaign_ends()
	{
		//initializing variables
		$date = $this->campaign_ends( 1 );
		
		return $date;
	}

	/**
	 * @param database A database connector object
	 */
	function __construct( &$db )
	{
		parent::__construct( '#__byrdlist_listings', 'id', $db );
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
	protected function cleanNumbers()
	{
		//initializing variables
		$numbers = array('buy_now','reserve_price','funding_goal','shipping_cost','est_value');
		
		//reasons to fail
		if (empty($numbers)) return false;
		
		
		foreach ($numbers as $number)
		{
			if (!isset($this->$number)) continue;
			$this->$number = preg_replace('#[A-Za-z_,$]*#', '', $this->$number);
		}
		
		return true;
	}
	
	/**
	 * 
	 */
	function countComments()
	{
		//loading resources
		$comments =& $this->getOneToMany('byrdlist_comments');
		
		if (!$comments || empty($comments)) return 0;
		
		//initializing variables
		$count = count($comments);
		return $count;
	}
	
	/**
	 * 
	 */
	function countBids()
	{
		//loading resources
		$comments =& $this->getOneToMany('byrdlist_bids');
		
		//initializing variables
		$count = count($comments);
		return $count;
	}
	
	/**
	 * Count the Payment relationships
	 * 
	 */
	public function countPayments()
	{
		//loading resources
		$comments =& $this->getOneToMany('byrdlist_payments');
		
		//reasons to fail
		if (empty($comments)) return 0;
		
		foreach ($comments as $id => $instance)
		{
			//reasons to continue
			if ($instance->published()) continue;
			
			unset($comments[$id]);
		}
		
		
		//initializing variables
		$count = count($comments);
		return $count;
	}
	
	/**
	 * Count Watched
	 * 
	 */
	function countWatched()
	{
		//loading resources
		$count = $this->countRelationships('watched', $ids);
		
		return $count;
	}
	
	/**
	 * Finalize this expired listing
	 * 
	 * 1. Send out an email
	 * 2. Set as expired
	 * 
	 */
	public function finalizeListing()
	{
		//reasons to fail
		if (!$this->isClosed()) return false; // if the clock has NOT timed out
		if ($this->expired()) return false; // if its recorded in the database ALREADY
		
		
		//loading resources
		$author =& eFactory::getUser( $this->author_id );
		$winner =& $this->getWinner();
		require_once EBOOK_HELPERS.DS.'mailer.php';
		
		
		switch($this->type())
		{
			case 'auction':
				if ($this->isEmpty())
				{
					BMailer::listingExpiredEmpty( $author, $this );
				}
				else
				{
					BMailer::listingExpiredWinner( $author, $this );
					BMailer::listingWinner( $winner, $this );
				}
				break;
			case 'donation':
				if ($this->isEmpty())
				{
					BMailer::donationExpiredEmpty( $author, $this );
				}
				else
				{
					BMailer::donationExpiredWinner( $author, $this );
				}
				break;
			case 'need':
				if ($this->isEmpty())
				{
					BMailer::needExpiredEmpty( $author, $this );
				}
				else
				{
					BMailer::needExpiredWinner( $author, $this );
				}
				break;
			case 'financial':
				if ($this->isEmpty())
				{
					BMailer::financialExpiredEmpty( $author, $this );
				}
				else
				{
					BMailer::financialExpiredWinner( $author, $this );
				}
				break;
		}
		
		$this->expired = 1;
		$this->store();
		
		return true;
	}
	
	/*
	 * Funding Goals
	 * 
	 */
	public function funding_goal()
	{
		return number_format($this->funding_goal, 0, '.', ',');
	}
	
	/**
	 * Get the organized array of comments
	 * 
	 */
	public function getComments()
	{
		//loading resources
		$records = $this->getOneToMany('byrdlist_comments');
		$records = ByrdHelper::sort_object($records,'created_on');
		
		//initializing variables
		$new = array();
		
		//reasons to fail
		if (!is_array($records)) return $new;
		if (empty($records)) return $new;
		
		foreach ($records as $id => $instance)
		{
			//reasons to continue
			if ($instance->parent_id()) continue;
			if (!$instance->published()) continue;
			
			//initializing variables
			$instance->_comments_children = 0;
			$new[$id] = $instance;
			$children = $instance->getChildComments();
			
			if (!$children) continue;
			
			foreach ($children as $id => $instance)
			{
				//initializing variables
				$new[$id] = $instance;
			}
		}
		
		return $new;
	}
	
	/**
	 * Gets the awarded comment
	 * 
	 */
	public function getAwarded()
	{
		//loading resources
		$comments = $this->getComments();
		
		//reasons to fail
		if (!is_array($comments)) return false;
		if (empty($comments)) return false;
		
		//initializing variables
		$new = false;
		
		foreach ($comments as $id => $comment)
		{
			if ($comment->_comments_children >0) continue;
			if (!$comment->isAwarded()) continue;
			
			$new = $comment;
			break;
		}
		
		return $new;
	}
	
	/**
	 * PUBLISHED PAYMENTS
	 * 
	 */
	public function getPayments()
	{
		//initializing variables
		$total = 0;
		
		//loading resources
		$instances =& $this->getOneToMany('byrdlist_payments');
		
		//reasons to fail
		if (empty($instances)) return $total;
		
		
		foreach ($instances as $id => $instance)
		{
			//reasons to continue
			if ($instance->published()) continue;
			
			unset($instances[$id]);
		}
		
		return $instances;
	}
	
	/**
	 * Parent financial listing
	 * 
	 */
	public function getParentFinancial()
	{
		//initializing variables
		$query = "SELECT * FROM `#__byrdlist_listings_financials` AS `assoc`"
		    ." LEFT JOIN `#__byrdlist_listings` as `listings`"
		    ." ON `assoc`.`financial_id` = `listings`.`id`"
		   	." WHERE `listings`.`published` = '1'"
	    	." AND `assoc`.`listings_id` = '".$this->id()."'"
	    	." LIMIT 1;"
	    	;
		
	    //loading resources
    	$db =& JFactory::getDBO();
    	$instance = JTable::getInstance('byrdlist_listings', 'Table');
    	
    	$db->setQuery( $query );
    	$results = $db->loadAssocList();
    	
    	
    	//reasons to fail
		if (!$results) return false;
		
		$result = array_pop($results);
		
		//reasons to continue
    	if (!$instance->load( $result['id'] )) return false;
    		
    	return $instance;
	}
	
	/**
	 * Parent financial listing
	 * 
	 */
	public function getFinancialAuctions()
	{
		//reasons to fail
		if ($this->type() != 'financial') return false;
		
		//initializing variables
		$listings = array();
		$query = "SELECT * FROM `#__byrdlist_listings_financials` AS `assoc`"
		    ." LEFT JOIN `#__byrdlist_listings` as `listings`"
		    ." ON `assoc`.`listings_id` = `listings`.`id`"
		   	." WHERE `listings`.`published` = '1'"
	    	." AND `assoc`.`financial_id` = '".$this->id()."'"
	    	." LIMIT 1;"
	    	;
		
	    //loading resources
    	$db =& JFactory::getDBO();
    	
    	$db->setQuery( $query );
    	$results = $db->loadAssocList();
    	
    	
    	//reasons to fail
		if (!$results) return false;
		
		foreach ($results as $result)
    	{
    		$instance = JTable::getInstance('byrdlist_listings', 'Table');
    		
    		//reasons to continue
    		if (!$instance->load( $result['id'] )) continue;
    		
    		$listings[$result['id']] = $instance;
    	}
    	
    	$listings = ByrdHelper::sort_object($listings, 'created_on');	
    	return $listings;
	}
	
	/**
	 * Get the parent financial campaigns paypal email
	 * 
	 */
	public function getParentPaypal()
	{
		//loading resources
		$result = $this->getParentFinancial();
		
		//reasons to fail
		if (!$result) return false;
		
		return $result->paypal_email();
	}
	
	/**
	 * PUBLISHED PAYMENTS
	 * 
	 */
	public function getWinner()
	{
		//initializing variables
		$user = false;
		
		//loading resources
		$lastbid = $this->last_bid();
		$awarded = $this->getAwarded();
		$payments = $this->getPayments();
		
		//reasons to fail
		//if (!$this->isReserveMet()) return false;
		
		switch ($this->type())
		{
			default:
			case 'financial': 
				break;
			
			case 'auction':
				if ($lastbid && $lastbid->isNew())
				{
					$user =& eFactory::getUser( $lastbid->author_id() );
				}
				if (!empty($payments))
				{
					$payment = array_pop($payments);
					$user =& eFactory::getUser( $payment->author_id() );
				}
				
				break;
			case 'donation':
				if (!$awarded) return false;
				if ($awarded->isNew()) return false;
				
				$user =& eFactory::getUser( $awarded->author_id() );
				break;
			case 'need':
				if (!$awarded) return false;
				if ($awarded->isNew()) return false;
				
				$user =& eFactory::getUser( $awarded->author_id() );
				break;
		}
		
		return $user;
	}
	
	/**
	 * Get The Paid price
	 * 
	 */
	public function getPaid()
	{
		//loading resources
		$lastbid = $this->last_bid();
		$payments = $this->getPayments();
		
		if ($lastbid && !$lastbid->isNew())
		{
			return $lastbid->amount();
		}
		elseif (!empty($payments))
		{
			$payment = array_pop($payments);
			return $payment->amount();
		}
		
		return false;
	}
	
	/**
	 * Get the remaining amount to be paid
	 * 
	 */
	public function getRemaining()
	{
		//initializing variables
		$goal = $this->funding_goal();
		$goal = str_replace(array('$',','),'', $goal);
		$received = $this->received();
		$received = str_replace(array('$',','),'', $received);
		
		$due = $goal - $received;
		
		return $due;
	}
	
	/**
	 * Html Auction
	 * 
	 */
	public function html_auction_end()
	{
		if ($this->isClosed()) 
		{
			return '<span style="color:red">Auction Ended!</span>';
		}
		if ($this->isExpired()) 
		{
			return '<span style="color:red">Auction Ended!</span>';
		}
		if ($this->isRedAlert()) 
		{
			return '<span style="color:red" id="countdown">'.$this->auction_end( 1 ).'</span>';
		}
		
		return $this->auction_end( 1 );
	}
	
	/**
	 * checks to see if this is a child listing of a financial campaign
	 * 
	 * @return boolean
	 */
	public function isFinancialAuction()
	{
		$result = $this->getParentFinancial();
		
		if (!$result) return false;
		return true;
	}
	
	/**
	 * checks to see if the auction is over
	 */
	public function isExpired()
	{
		//initializing variables
		$rightnow = time();
		
		if ($this->type() == 'financial')
		{
			$auction = strtotime($this->campaign_ends( 1 ));
		}
		else
		{
			$auction = strtotime($this->auction_end( 1 ));
		}
		
		if ($rightnow > $auction) return true;
		return false;
	}

	/**
	 * checks to see if the auction is over
	 */
	public function isRedAlert()
	{
		//initializing variables
		$rightnow = time();
		
		if ($this->type() == 'financial')
		{
			$auction = strtotime($this->campaign_ends(1));
			$onehour = strtotime($this->campaign_ends(1)." -1 hour");
		}
		else
		{
			$auction = strtotime($this->auction_end( 1 ));
			$onehour = strtotime($this->auction_end( 1 )." -1 hour");
		}
		
		if ($rightnow > $onehour) return true;
		return false;
	}
	
	/**
	 * Is this listing closed?
	 * 
	 */
	public function isClosed()
	{
		//loading resources
		$comments = $this->getComments();
		$payments = $this->getPayments();
		$awarded = $this->getAwarded();
		
		//initializing variables
		$remaining_balance = $this->getRemaining();
		
		//reasons to close this listing
		switch ($this->type())
		{
			case 'auction':
				if (!empty($payments)) return true;
				if ($this->isExpired()) return true;
				if ($this->expired()) return true;
				break;
			case 'financial':
				if ($remaining_balance == 0) return true;
				if ($this->isExpired()) return true;
				if ($this->expired()) return true;
				break;
			case 'need':
				if ($this->isExpired()) return true;
				if ($awarded && !$awarded->isNew()) return true;
				break;
			case 'donation':
				if ($this->isExpired()) return true;
				if ($awarded && !$awarded->isNew()) return true;
				break;
		}
		
		return false;
	}
	
	/**
	 * Is this listing closed?
	 * 
	 */
	public function isEmpty()
	{
		//loading resources
		$lastbid = $this->last_bid();
		$comments = $this->getComments();
		$payments = $this->getPayments();
		
		//reasons to close this listing
		switch ($this->type())
		{
			case 'auction':
				if (empty($payments) && ($lastbid->isNew() || !$this->isReserveMet())) return true;
				break;
			case 'financial':
				if (!is_array($payments)) return true;
				if (empty($payments)) return true;
				break;
			case 'need':
				if (!is_array($comments)) return true;
				if (empty($comments)) return true;
				break;
			case 'donation':
				if (!is_array($comments)) return true;
				if (empty($comments)) return true;
				break;
		}
		
		return false;
	}
	
	/**
	 * Was this purchased, through buy now?
	 * 
	 */
	public function isBuyNow()
	{
		//loading resources
		$payments = $this->getPayments();
		
		//reasons to fail
		if (empty($payments)) return false;
		
		return true;
	}
	
	/**
	 * Checks to see if the reserve was met
	 * 
	 */
	public function isReserveMet()
	{
		//loading resources
		$lastbid = $this->last_bid();
		
		//initializing variables
		$reserve = $this->reserve_price();
		$reserve = str_replace(array('$',','),'', $reserve);
		$bid_amount = str_replace(array('$',','),'', $lastbid->amount());
		
		if ($reserve > $bid_amount) return false;
		return true;
	}

	/**
	 * Images array
	 * 
	 */
	function images()
	{
		//loading resources
		$images =& $this->getOneToMany('byrdlist_images');
		
		return $images;
	}

	/**
	 * Last Bid Object
	 * 
	 */
	function last_bid()
	{
		//loading resources
		$bids =& $this->getOneToMany('byrdlist_bids');
		
		$bids = ByrdHelper::sort_object($bids,'created_on');
		
		//reasons to fail
		if (empty($bids)) return JTable::getInstance('byrdlist_comments', 'Table');;
		
		return current($bids);
	}

	/**
	 * Listing Details
	 */
	function listing_details()
	{
		//initializing variables
		$properties = $this->getProperties();
		$details = array();
		$ignore = array('description','slug','primary_street','primary_city','primary_state'
		,'primary_postal_code','published','paypal_email','type','status','updated_on',
		'lattitude','longitude');
		
		switch($this->type)
		{
			case 'auction':
				$ignore2 = array();
				break;
			case 'need':
				break;
			case 'donation':
				break;
			case 'financial':
				break;
		}
		
		foreach ($properties as $k => $v)
		{
			//ignore
			if (in_array($k, $ignore)) continue;
			//if (in_array($k, $ignore2)) continue;
			
			//initializing variables
			$name = ucwords(strtolower(str_replace("_"," ",$k)));
			
			if ($k == 'campaign_ends')
			{
				$k = 'html_campaign_ends';
			}
			
			$details[$name] = $this->$k( 1 );
		}
		
		return $details;
	}

	/**
	 * Loads a row from the database and binds the fields to the object properties
	 *
	 * @access	public
	 * @param	mixed	Optional primary key.  If not specifed, the value of current key is used
	 * @return	boolean	True if successful
	 */
	function load( $oid = null )
	{
		$return = parent::load($oid);
		
		//initializing object properties
		$this->markWatched();
		
		return $return;
	}
	
	/**
	 * Mark this listing as watched
	 * 
	 */
	protected function markWatched()
	{
		//initializing variables
		static $once;
		
		//reasons to return
		if (isset($once)) return false;
		if (!isset($once)) $once = true;
		
		
		//initializing variables
		$this_id = JRequest::getVar('watched', false);
		JRequest::setVar('watched', false);
		
		//reasons to return
		if (!$this_id) return false;
		if ($this_id != $this->id()) return false;
		
		
		//populating object properties
		$user =& eFactory::getUser();
		$this->_watched_id = $user->id();
		
		//NO DUPLICATES
		$this->countRelationships('watched', $ids);
		if (in_array($user->id(), $ids)) return false;
		
		//save
		$this->saveRelationship('watched');
		
		return true;
	}
	
	/**
	 * TOTAL OF PAYMENTS RECEIVED
	 * 
	 */
	public function received()
	{
		//initializing variables
		$total = 0;
		
		//loading resources
		$instances =& $this->getOneToMany('byrdlist_payments');
		
		//reasons to fail
		if (empty($instances)) return $total;
		
		
		foreach ($instances as $id => $instance)
		{
			//reasons to continue
			if (!$instance->published()) continue;
			
			$total = $total + $instance->amount();
		}
		
		return number_format($total, 2, '.', ',');
	}

	/**
	 * Store
	 * 
	 */
	function store()
	{
		//initializing object properties
		$this->cleanNumbers();
		$this->getGeoLocation();
		
		if ($id = parent::store())
		{
			$this->saveRelationship('byrdlist_categories');
			$this->saveRelationship('byrdlist_tags');
			$this->saveRelationship('financials');
			return $id;
		}
		return false;
	}
	
	/**
	 * shipping cost
	 * 
	 */
	public function shipping_cost()
	{
		if ($this->shipping_cost == 0) return false;
		
		$this->shipping_cost = str_replace(array('$',','),'', $this->shipping_cost);
		
		return $this->shipping_cost;
	}

	/**
	 * Thumbnail Object
	 * 
	 */
	function thumbnail()
	{
		//loading resources
		$thumbnail =& $this->getOneToMany('byrdlist_images');
		
		//reasons to fail
		if (empty($thumbnail)) return false;
		
		foreach ($thumbnail as $id => $image)
		{
			if ($image->thumbnail()) break;
		}
		
		return $image;
	}
}

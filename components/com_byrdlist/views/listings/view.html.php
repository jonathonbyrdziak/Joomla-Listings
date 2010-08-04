<?php
/**
 * Joomla! 1.5 component reservation
 *
 * @version $Id: view.html.php 2010-06-02 12:34:25 svn $
 * @author 
 * @package Joomla
 * @subpackage reservation
 * @license Copyright (c) 2010 - All Rights Reserved
 *
 * 
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.view');

//initializing variables
JRequest::setVar('limit',JRequest::getVar('limit',10));



/**
 * HTML View class for the reservation component
 */
class ByrdlistViewListings extends ResView 
{
	
	/**
	 * Contains the table model to use
	 * 
	 * @var string
	 */
	var $_table = 'byrdlist_listings';
	
	/**
	 * Awarded the Donation Listing
	 * 
	 */
	protected function awarded_donation_to( $path = null )
	{
		//reasons to fail
		if (!$this->isRequest) return false;
		if (!$this->isAwarded) return false;
		
		//loading resources
		$awarded =& $this->_record->getAwarded();
		$winner = eFactory::getUser( $awarded->author_id() );
		
		require_once $path;
		
	}
    
    /**
     * The Auction ended
     * 
     */
    protected function auction_ended( $path = null )
    {
    	//loading resources
    	$winner =& $this->_record->getWinner();
    	$user =& eFactory::getUser();
    	$owner =& eFactory::getUser( $this->_record->author_id() );
    	
    	//reasons to fail
    	if ($this->_record->type() == 'financial') return false;
    	if ($this->_record->type() == 'donation') return false;
    	if (!$this->_record->isClosed()) return false;
    	//if ($user->id() == 0) return false;
    	//if (!is_object($winner)) return false;
    	//if ($user->id() != $winner->id() && $user->id() != $owner->id()) return false;
    	
    	require_once $path;
    }
    
    /**
     * Payment default
     * 
     */
    protected function buy_now_default()
    {
    	//initializing variables
    	$this->isAuction = true;
    	$this->amount = $this->_listings->buy_now() + $this->_listings->shipping_cost();
    	
    	return true;
    }
    
    /**
     * Save the Payment and forward this guy to paypal
     * 
     */
    protected function buy_now_save()
    {
    	//initializing variables
    	$data = JRequest::get('post');
    	$string = array();
    	
    	//loading resources
    	$this->_record =& JTable::getInstance('byrdlist_listings', 'Table');
    	$this->_record->load( JRequest::getVar('_listings_id') );
    	
    	$data['amount'] = $this->_record->buy_now();
    	
    	$record =& JTable::getInstance('byrdlist_payments', 'Table');
    	$record->bind( $data, array(), false );
    	
    	//saving the record
    	$record->store();
    	$data['payment_id'] = $record->id();
    	
    	if ($parent = $this->_record->getParentFinancial())
    	{
    		$data['name'] = $this->_record->name().', Contributing to '.$parent->name();
    		$data['paypal_email'] = $parent->paypal_email();
    		
    		$record->_listings_id = $parent->id();
    		$record->store();
    	}
    	else
    	{
	    	$data['name'] = $this->_record->name();
	    	$data['paypal_email'] = $this->_record->paypal_email();
    	}
    	
    	$this->paypalRedirect( $data );
    }
    
    /**
     * Comments
     * 
     */
    protected function comments( $path = null )
    {
    	//initializing variables
    	$countComments = $this->_record->countRelationships('byrdlist_comments');
    	
    	require_once $path;
    }
    
    /**
     * Comments
     * 
     */
    protected function comments_item( $path = null )
    {
    	//initializing variables
    	$countComments = $this->_record->countComments();
    	$parent_id = array();
    	$is_reply = 0;
    		
    	//loading resources
    	$records = $this->_record->getComments();
    	$user =& eFactory::getUser();
    	
    	//reasons to fail
    	if (empty($records)) return false;
    	
    	foreach ($records as $id => $record)
    	{
    		//HELPFUL NUMBERS
    		$is_helpful = false;
			$record->countRelationships('helpful', $ids);
			if (in_array($user->id(), $ids)) $is_helpful = true;
			$record->countRelationships('helpful_no', $ids);
			if (in_array($user->id(), $ids)) $is_helpful = true;
			
			//initializing variables
    		$is_reply = $record->_comments_children;
    		if ($is_reply) $margin_left = $record->_comments_children * 20;
    		else $margin_left = 0;
    		
    		$comment_owner = false;
    		if ($user->id() == $record->author_id()) $comment_owner = true;
    		
			//DISPLAY THE TEMPLATE
    		require $path;
    		
    	}
    	
    }
	
	/**
	 * Save the Posted Comment
	 * 
	 */
	protected function comment_save()
	{
		//initializing variables
    	$data = JRequest::get('post');
    	
    	//loading resources
    	$record =& JTable::getInstance('byrdlist_comments', 'Table');
    	$record->bind( $data, array(), false );
    	
    	$record->store();
    	
    	//REDIRECT
    	$msg = JText::_( 'Your Message has been saved.');
		$link = JRoute::_('index.php?option='.EBOOK_COMPONENT.'&view=listings&layout=details&record='.
			JRequest::getVar('_listings_id'), false);
		
		$this->setRedirect($link, $msg);
    	
    	return true;
	}
	
	/**
	 * Save the Posted Comment
	 * 
	 */
	protected function request_save()
	{
		return $this->comment_save();
	}
	
	/**
	 * Save the Posted Comment
	 * 
	 */
	protected function offer_save()
	{
		return $this->comment_save();
	}
	
	/**
	 * Display
	 *
	 */
	function display($tpl = null) 
	{
		//loading resources
		$this->user =& eFactory::getUser();
    	$listings_id = JRequest::getVar('_listings_id',false);
    	$comments_id = JRequest::getVar('_comments_id',false);

    	//initializing variables
    	$this->isRequest = false;
    	$this->isAwarded = $this->_record->getWinner();
    	$this->isClosed = $this->_record->isClosed();
    	$this->is_owner = false;
    	$this->isLoggedIn = false;
    	
    	//IS THE USER LOGGED IN?
    	if ($this->user->id() != 0)
    	{
    		$this->isLoggedIn = true;
    	}
	    
    	//DOES THIS REQUIRE REQUESTS?
    	if ($this->_record->type() == 'donation' || $this->_record->type() == "need")
    	{
    		$this->isRequest = true;
    	}
    	
		//IS THIS THE OWNER?
		if (isset($this->_record) && !$this->_record->isNew())
		{
			if ($this->_record->author_id() == $this->user->id()) $this->is_owner = true;
		}
    	
		//LOAD THE LISTING?
    	if ($listings_id)
    	{
    		//loading resources
    		$this->_listings =& JTable::getInstance($this->_table, 'Table');
    		$this->_listings->load( $listings_id );
    		
    		//initializing variables
    		$id = $this->_listings->author_id();
    		
    		//loading resources
    		$this->_author =& eFactory::getUser( $id );
    	}
    	
    	//LOAD THE COMMENT IN THE LISTINGS SPOT?
    	if ($comments_id)
    	{
    		//loading resources
    		$this->_listings =& JTable::getInstance('byrdlist_comments', 'Table');
    		$this->_listings->load( $comments_id );
    		
    		//initializing variables
    		$id = $this->_listings->author_id();
    		$this->_listings->_notalisting = 1;
    		
    		//loading resources
    		$this->_author =& eFactory::getUser( $id );
    	}
    	
    	//loading media
    	JHTML::script('image_click.js', 'components/'.EBOOK_COMPONENT.'/media/js/');
		
    	parent::display($tpl);
    }
    
    /**
     * Listings page
     * 
     */
    protected function default_default()
    {
    	//loading resources
    	$this->loadCategory();
    	
    	return true;
    }
    
    /**
     * Award the comment
     * 
     */
    protected function details_award()
    {
    	//loading resources
    	$this->loadCategory();
    	
    	//loading resources
    	$comment = JTable::getInstance('byrdlist_comments', 'Table');
    	$comment->load( JRequest::getVar('id') );
    	
    	$comment->setAwarded();
    	return true;
    }
    
    /**
     * Details box
     * 
     */
    protected function details_box( $path = null )
    {
    	//loading resources
    	$this->loadCategory();
    	$last_bid = $this->_record->last_bid();
		
		
    	//initializing variables
		$count = 0;
		$this->_record->addView();
		$new_path = substr($path,0,(strlen($path) -4));
		$hasBid = false;
    	
    	//specific template for the details
		if ($this->_record->type() != 'auction')
		{
			$new_path = $new_path."_".$this->_record->type().".php";
			if (file_exists($new_path))
			{
				$path = $new_path;
			}
		}
		
		if ($last_bid && !$last_bid->isNew())
		{
			$hasBid = true;
			$bidder = eFactory::getUser( $last_bid->author_id() );
		}
		
		
		require_once $path;
    }
    
    /**
     * Details page
     * 
     */
    protected function details_default()
    {
    	//loading resources
    	$this->loadCategory();
    	
    	//IS THIS WATCHED?
    	$this->is_watched = false;
    	$this->_record->countRelationships('watched', $ids);
    	if (in_array($this->user->id(), $ids)) $this->is_watched = true;
		
    	
    	return true;
    }
    
    /**
     * Delete this record
     * 
     */
    protected function details_delete()
    {
    	//required
    	$this->details_default();
    	
    	$this->_record->delete();
    	
    	//REDIRECT
    	$msg = JText::_( 'Your Listing has been removed.');
		$link = JRoute::_('index.php?option='.EBOOK_COMPONENT.'&view=myaccount', false);
		
		$this->setRedirect($link, $msg);
    	return true;
    }
    
    /**
     * Place a bid for me
     * 
     */
    protected function details_placebid()
    {
    	//required
    	$this->details_default();
    	
    	//loading resources
    	$user =& eFactory::getUser();
    	
    	//reasons to fail
    	if ($user->isGuest()) return false;
    	
    	//initializing variables
    	$data = JRequest::get('post');
    	
    	//loading resources
    	$record =& JTable::getInstance('byrdlist_bids', 'Table');
    	$record->bind( $data, array(), false );
    	
    	$record->store();
    	
    	//loading resources
    	$app =& JFactory::getApplication();
    	$app->enqueueMessage ('Your bid has been placed.');
    	return true;
    }
    
    /**
     * Publish the record
     */
    protected function details_publish()
    {
    	//required
    	$this->details_default();
    	
    	$this->_record->published = 1;
    	$this->_record->store();
    	return true;
    }
    
    /**
     * Step Two - New Listing
     * 
     */
    protected function details_save()
    {
    	//required
    	$this->details_default();
    	
    	//initializing variables
    	$data = JRequest::get('post');
    	
    	//loading resources
    	//$this->_record =& JTable::getInstance('byrdlist_listings', 'Table');
    	//$this->_record->load( $data['id'] );
    	$this->_record->bind( $data, array(), false );
    	
    	$this->_record->store();
    	$this->id = $this->_record->id;
    	
    	return true;
    }
    
    /**
     * Un publish the record
     */
    protected function details_unpublish()
    {
    	//required
    	$this->details_default();
    	
    	$this->_record->published = 0;
    	$this->_record->store();
    	return true;
    }
    
    /**
     * Financial Listings
     * 
     */
    protected function financial_listing( $path = null )
    {
    	//reasons to fail
    	if (!$this->_record) return false;
    	if ($this->_record->type() != 'financial' && $this->_record->type() != 'auction') return false;
    	
    	//CHILD AUCTION
    	if ($isChild = $this->_record->isFinancialAuction())
    	{
    		//loading resources
    		$record =& $this->_record->getParentFinancial();
    		
    		require substr($path,0,strlen($path) - 4)."_child.php";
    	}
    	
    	//PARENT FINANCIAL CAMPAIGN
    	else
    	{
    		//loading resources
    		$auctions =& $this->_record->getFinancialAuctions();
    		
    		if (!empty($auctions))
    		{
    			require $path;
    		}
    	}
    }
    
    /**
     * Financial Listings
     * 
     */
    protected function financial_listings( $path = null )
    {
    	//reasons to fail
    	if (!$this->_record) return false;
    	if ($this->_record->type() != 'financial') return false;
    	
    	
    	//loading resources
    	$auctions =& $this->_record->getFinancialAuctions();
    	
    	if (!$auctions) return false;
    	
    	foreach ($auctions as $id => $record)
    	{
    		//reasons to fail
    		if ($record->isClosed()) continue;
    		
    		//loading resources
    		$thumb =& $record->thumbnail();
    		
    		require $path;
    	}
    	
    	return true;
    }
    
    /**
     * Get the Records
     * 
     * @return array
     */
    protected function getList()
    {
    	//loading resources
    	$results = $this->getQuery();
    	
    	//reasons to fail
    	if (!$results) return false;
    	
    	
    	foreach ($results as $result)
    	{
    		$instance = JTable::getInstance($this->_table, 'Table');
    		
    		//reasons to continue
    		if (!$instance->load( $result['id'] )) continue;
    		
    		$listings[$result['id']] = $instance;
    	}
    	
    	$listings = ByrdHelper::sort_object($listings, 'created_on');
    	return $listings;
    }
    
    /**
	 * Pagination aspects
	 * 
	 */
	public function getPagination()
	{
		//initializing variables
		static $pagination;
		
		if (!isset($pagination))
		{
			//loading resources
    		$results = $this->getQuery( true );
    	
	    	//reasons to fail
	    	if (!$results) return false;
	    	
	    	//initializing variables
			$limitstart = JRequest::getVar('limitstart',0);
			$limit = JRequest::getVar('limit',20);
			
			$page = ceil($limitstart / $limit);
			$page = $page + 1;
			
			$total_rows = count($results);
			
			$pagination = array();
			$pagination['total_rows'] = $total_rows;
			$pagination['limitstart'] = $limitstart;
			$pagination['limit'] = $limit;
			$pagination['pages'] = ceil($total_rows / $limit);
			$pagination['page'] = $page;
			if ($pagination['page'] && !$pagination['pages']) $pagination['pages'] = 1;
			
			//number of records showing
			$records_left = $total_rows - $limitstart;
			if ($records_left < $limit)
			{
				$limitrecords = $records_left + $limitstart;
			}
			else
			{
				$limitrecords = $limit + $limitstart;
			}
			
			$pagination['limitrecords'] = $limitrecords;
			
		}
		
		return $pagination;
	}
	
	/**
	 * Get the Listings Query
	 * 
	 */
	protected function getQuery( $nolimit = false, $filt = false )
	{
		//loading resources
    	$db =& JFactory::getDBO();
    	$user =& eFactory::getUser();
    	
    	//initializing variables
    	$search = JRequest::getVar('search_filter', false);
    	$listings = array();
    	$query_limit = "";
		$filter = "";
    	$where = "";
    	$catid = JRequest::getVar('_categories_id', false);
    	if (!$filt) $filt = JRequest::getVar('filter', false);
    	
		//pagination
		$limitstart = JRequest::getVar('limitstart',0);
		$limit = JRequest::getVar('limit',5);
		if ($limit != 0) $query_limit = " LIMIT ".$limitstart.', '.$limit;
		
		//for total pagination
    	if ($nolimit) $query_limit = "";
    	
    	if ($search)
    	{
    		$query = "SELECT * FROM `#__byrdlist_listings` as `listings`"
	    		." WHERE `listings`.`published` = '1'"
	    		." AND (`listings`.`name` LIKE '%".trim($search)."%'"
	    		." OR `listings`.description LIKE '%".trim($search)."%')"
	    		;
    	}
    	else
    	{
	    	//BASE QUERY
	    	switch ($filt)
		    {
		    	default:
		    	case '':
		    	case 'all':
		    	case 'financial':
		    	case 'need':
		    	case 'donation':
		    	case 'owner':
		    	case 'auction':
		    		$query = "SELECT * FROM `#__byrdlist_listings_juser` AS `assoc`"
		    			." LEFT JOIN `#__byrdlist_listings` as `listings`"
		    			." ON `assoc`.`listings_id` = `listings`.`id`";
		    		break;
		    }
	    	
	    	//FILTERING
	    	switch ($filt)
		    {
		    	default:
		    	case '':
		    	case 'all':
		    		$query .=" WHERE `listings`.`published` = '1'";
		    		break;
		    	case 'owner':
		    		$query .=" WHERE `listings`.`published` = '1'"
		    				." AND `assoc`.`juser_id` = '".JRequest::getVar('jusers_id')."'";
		    		break;
		    	case 'financial':
		    		$query .=" WHERE `listings`.`published` = '1'"
		    				." AND `listings`.`type` = 'financial'";
		    		break;
		    	case 'need':
		    		$query .=" WHERE `listings`.`published` = '1'"
		    				." AND `listings`.`type` = 'need'";
		    		break;
		    	case 'donation':
		    		$query .=" WHERE `listings`.`published` = '1'"
		    				." AND `listings`.`type` = 'donation'";
		    		break;
		    	case 'auction':
		    		$query .=" WHERE `listings`.`published` = '1'"
		    				." AND `listings`.`type` = 'auction'";
		    		break;
		    }
    	}
    	$query .= $query_limit;
    	
    	$db->setQuery( $query );
    	$results = $db->loadAssocList();
    	
    	//reasons to fail
		if (!$results) return false;
		
		return $results;
	}
	
	/**
     * Load the category
     * 
     */
    protected function loadCategory()
    {
    	//loading resources
    	if (JRequest::getVar('_categories_id',false))
    	{
	    	$this->_category =& JTable::getInstance('byrdlist_categories', 'Table');
	    	
	    	if (!$this->_category->load( JRequest::getVar('_categories_id') )) return false;
	    	
    		return true;
    	}
    	else
    	{
    		$this->_category =& $this->_record->getOneToOne('byrdlist_categories');
    		return true;
    	}
    	return false;
    }
    
    /**
     * All Listings
     * 
     */
    protected function listing_item( $path = null )
    {
    	//initializing variables
    	$path = substr($path,0, (strlen($path)-4) );
    	
    	//loading resources
    	$records = $this->getList();
    	$user =& eFactory::getUser();
    	
    	//reasons to fail
    	if ( empty($records) || !$records ) return false;
    	
    	
    	foreach ($records as $id => $record)
    	{
    		//initializing variables
    		$last_bid = $record->last_bid();
    		$tags = $record->getOneToMany('byrdlist_tags');
    		
    		if (!is_array($tags)) $tags = array();
    		
    		//GET THE THUMBNAIL
    		if ($thumbnail = $record->thumbnail()) $thumbnail = $thumbnail->file();
    		
    		
    		//IS THIS THE OWNER?
    		$this->is_owner = false;
    		if ($user->id() != 0 && $record->author_id() == $user->id()) $this->is_owner = true;
    		
    		
    		//WHAT TYPE OF LISTING TEMPLATE?
    		if ($record->type() != 'auction' && file_exists($path.'_'.$record->type().'.php'))
    		{
    			$tmp_path = $path.'_'.$record->type();
    		}
    		else
    		{
    			$tmp_path = $path;
    		}
    		
    		//loading resources
    		require $tmp_path.'.php';
    	}
    	
    	
    	return true;
    }
    
    /**
     * Step Two - New Listing
     * 
     */
    protected function new_two_save()
    {
    	//initializing variables
    	$data = JRequest::get('post');
    	$data['description'] = JRequest::getVar( 'description', '', 'post', 'string', JREQUEST_ALLOWHTML );
    	
    	//loading resources
    	$this->images = $this->_record->getOneToMany('byrdlist_images');
    	
    	$this->_record =& JTable::getInstance('byrdlist_listings', 'Table');
    	$this->_record->bind( $data, array(), false );
    	
    	$this->_record->store();
    	$this->id = $this->_record->id;
    	
    	return true;
    }
    
    /**
     * Special Listing types
     * 
     */
    protected function new_two_type_fields( $path = null )
    {
    	//initializing variables
    	$type = $this->_record->type();
    	$class_path = EBOOK_EVERY.DS.'listing_types'.DS.$type.'.php';
    	$class = ucfirst(strtolower($type)).'Listing';
    	
    	//reasons to fail
    	if (!file_exists($class_path)) return false;
    	if (is_null($path)) return false;
    	
    	
    	//loading resources
    	$user = eFactory::getUser();
    	require_once $class_path;
    	$obj = new $class;
    	
    	
    	foreach ($obj as $property => $value)
    	{
    		//initializing variables
    		$name = ucwords(strtolower(str_replace("_"," ", $property)));
    		if (isset($GLOBALS['dropdowns']['name_mapping'][$property]))
    		{
    			$name = $GLOBALS['dropdowns']['name_mapping'][$property];
    		}
    		
    		//initializing variables
			$value = $this->_record->$property();
			if ($property == 'paypal_email' && !$value)
			{
				$value = $user->email();
			}
			
    		require $path;
    	}
    	
    }
    
    /**
     * Payment default
     * 
     */
    protected function payment_default()
    {
    	//initializing variables
    	$amount = JRequest::getVar('amount', "20.00");
    	$remains = $this->_listings->getRemaining();
    	$this->isAuction = false;
    	
    	if ($this->_listings->type() == 'auction')
    	{
    		$this->bid =& $this->_listings->last_bid();
    		$amount = $this->bid->amount();
    		$this->isAuction = true;
    	}
    	elseif ($this->_listings->type() == 'financial')
    	{
    		if ($remains < $amount)
    		{
    			$amount = $remains;
    		}
    	}
    	
    	//initializing variables
    	$this->amount = $amount;
    	
    	return true;
    }
    
    /**
     * Save the Payment and forward this guy to paypal
     * 
     */
    protected function payment_save()
    {
    	//initializing variables
    	$data = JRequest::get('post');
    	$string = array();
    	
    	
    	//loading resources
    	$this->_record =& JTable::getInstance('byrdlist_listings', 'Table');
    	$this->_record->load( JRequest::getVar('_listings_id') );
    	
    	if ($this->_record->type() == 'auction')
    	{
    		$lastbid =& $this->_record->last_bid();
    		$data['amount'] = $lastbid->amount();
    	}
    	
    	$record =& JTable::getInstance('byrdlist_payments', 'Table');
    	$record->bind( $data, array(), false );
    	
    	//saving the record
    	$record->store();
    	$data['payment_id'] = $record->id();
    	
    	
    	$this->paypalRedirect( $data );
    	return true;
    }
    
    /**
     * SEND THE USER TO PAYPAL
     * 
     */
    protected function paypalRedirect( $data = null )
    {
    	//reasons to fail
    	if (is_null($data)) return false;
    	
    	//initializing variables
    	$path_back = DOTCOM.'?option='.EBOOK_COMPONENT.'&view=listings&layout=payment&_listings_id='.$data['_listings_id'];
    	$path_ipn = DOTCOM.'?option='.EBOOK_COMPONENT.'&view=myaccount&layout=ipn&format=ajax';
    	
    	//loading resources
    	$this->_record =& JTable::getInstance('byrdlist_listings', 'Table');
    	$this->_record->load( JRequest::getVar('_listings_id') );
    	
    	//SINGLE PAYMENT PAYPAL VARIABLES
    	$paypal = array(
    		'cmd' => '_xclick',//'_donations',
	    	'business' => $data['paypal_email'],
    		'amount' => $data['amount'],
    		'lc' => 'US',
    		'item_name' => $data['name'],
	    	'item_number' => $data['payment_id'],
	    	'no_note' => '0',
    		'currency_code' => 'USD',
	    	'bn' => 'PP-DonationsBF:btn_donateCC_LG.gif:NonHostedGuest', //'PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHostedGuest',
    		'notify_url' => $path_ipn, //IPN script
	    	'cancel_return' => $path_back, //this page 
	    );
    	
    	//compiling the paypal string
    	foreach ($paypal as $k => $v) $string[] = $k."=".urlencode($v);
    	$paypal = implode('&', $string);
    	
    	header( "Location: https://www.paypal.com/cgi-bin/webscr?{$paypal}\r\n" );
    	exit();
    }
    
    /**
     * Place a bid for me
     * 
     */
    protected function report_send()
    {
    	//loading resources
    	$user =& eFactory::getUser();
    	
    	//reasons to fail
    	if ($user->isGuest()) return false;
    	
    	//initializing variables
    	$data = JRequest::get('post');
    	
    	//loading resources
    	$record =& JTable::getInstance('byrdlist_reported', 'Table');
    	$record->bind( $data, array(), false );
    	
    	$record->store();
    	
    	//loading resources
    	$app =& JFactory::getApplication();
    	
    	$app->enqueueMessage ('Your bid has been placed.');
    	
    	//REDIRECT
    	$msg = JText::_( 'Thank you for keeping this website clean.');
		$link = JRoute::_('index.php?option='.EBOOK_COMPONENT.'&view=listings&layout=details&record='.
			JRequest::getVar('_listings_id'), false);
		
		$this->setRedirect($link, $msg);
		
    	return true;
    }
    
    /**
     * Send email
     * 
     */
    protected function recommend_send()
    {
    	//loading resources
    	$user =& eFactory::getUser();
    	
    	//initializing variables
    	$data = JRequest::get('post');
    	
    	//loading resources
    	$mailSender =& JFactory::getMailer();
		$mailSender->addRecipient( $data['email'] );
		$mailSender->setSender( array( $user->email(), $user->name()) );
		$mailSender->setSubject( $data['name'] );
		$mailSender->setBody( $data['description'] );
		
		//reasons to fail
		if (!$mailSender->Send()) return false;
		
		$this->_listings->addRecommend();
		
		return true;
    }
    
}

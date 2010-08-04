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
JRequest::setVar('limit',JRequest::getVar('limit',5));



/**
 * HTML View class for the reservation component
 * 
 * 
 */
class ByrdlistViewMyaccount extends ResView 
{
	
	/**
	 * Contains the table model to use
	 * 
	 * @var string
	 */
	var $_table = 'byrdlist_listings';
	
	/**
	 * Display
	 *
	 */
	function display($tpl = null) 
	{
		//$user =& eFactory::getUser();print_r($user);
		parent::display($tpl);
    }
    
    /**
     * My Listings
     * 
     */
    protected function getMyListings()
    {
    	//loading resources
    	$user =& eFactory::getUser();
    	$usertable =& JTable::getInstance('juser', 'Table');
    	$usertable->load( $user->id() );
    	
    	$records = $usertable->getOneToMany('byrdlist_listings');
    	
    	return $records;
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
			$limit = JRequest::getVar('limit',5);
			
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
    	$new_results = array();
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
    	
    	
    	//BASE QUERY
    	switch ($filt)
	    {
	    	default:
	    	case 'myclosed':
	    	case 'owner':
	    		$query = "SELECT * FROM `#__byrdlist_listings_juser` AS `assoc`"
	    			." LEFT JOIN `#__byrdlist_listings` as `listings`"
	    			." ON `assoc`.`listings_id` = `listings`.`id`";
	    		break;
	    		
	    	case 'myacquired':
	    		$query = "SELECT * FROM `#__byrdlist_payments_juser` AS `juser`"
	    			." LEFT JOIN `#__byrdlist_listings_payments` AS `assoc`"
			    	." ON `assoc`.`payments_id` = `juser`.`payments_id`"
			    	." LEFT JOIN `#__byrdlist_listings` AS `listings`"
			    	." ON `assoc`.`listings_id` = `listings`.`id`";
	    		break;
	    		
	    	case 'mywatch':
	    		$query = "SELECT * FROM `#__byrdlist_listings_watched` AS `assoc`"
			    	." LEFT JOIN `#__byrdlist_listings` as `listings`"
			    	." ON `assoc`.`listings_id` = `listings`.`id`";
	    		break;
	    }
    	
    	//FILTERING
    	switch ($filt)
	    {
	    	case 'myclosed':
	    		$query .=" WHERE (`listings`.`published` = '0'"
	    				." OR `listings`.`expired` = '1')"
	    				." AND `assoc`.`juser_id` = '{$user->id()}'";
	    		break;
	    		
	    	default:
	    	case 'owner':
	    		$query .=" WHERE (`listings`.`published` = '1'"
	    				." AND `listings`.`expired` = '0')"
	    				." AND `assoc`.`juser_id` = '{$user->id()}'";
	    		break;
	    		
	    	case 'myacquired':
	    		$query .=" WHERE `juser`.`juser_id` = '{$user->id()}'"
			    		." AND `listings`.`type` != 'financial'"
			    		." AND `listings`.`published` = '1'";
	    		break;
	    		
	    	case 'mywatch':
	    		$query .=" WHERE `listings`.`published` = '1'"
	    				." AND `assoc`.`juser_id` = '{$user->id()}'";
	    		break;
	    }
    	$query .= $query_limit;
    	
		$db->setQuery( $query );
    	$results = $db->loadAssocList();
    	
    	//reasons to fail
		if (!$results) return false;
		
		foreach ($results as $result)
		{
			$new_results[$result['id']] = $result;
		}
		
		return $new_results;
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
    	$user =& eFactory::getUser();
    	
    	$records = $this->getList();
    	
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
    		if ($record->author_id() == $user->id()) $this->is_owner = true;
    		
    		
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
}
?>
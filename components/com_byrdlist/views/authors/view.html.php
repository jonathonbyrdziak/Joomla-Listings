<?php
/**
 * Joomla! 1.5 component reservation
 *
 * @version $Id: view.feed.php 2010-06-02 12:34:25 svn $
 * @author 
 * @package Joomla
 * @subpackage reservation
 * @license Copyright (c) 2010 - All Rights Reserved
 *
 * 
 *
 * This component file was created using the Joomla Component Creator by Not Web Design
 * http://www.notwebdesign.com/joomla_component_creator/
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.view');

/**
 * Feed View class for the reservation component
 */
class ByrdlistViewAuthors extends ResView 
{
	/**
	 * 
	 */
	var $_table = 'byrdlist_websites';
	
	/**
	 * Constructor.
	 *
	 * @access	protected
	 */
	function __construct($config = array())
	{
		if (!JRequest::getVar('record',false) && JRequest::getCmd('layout','') == 'details')
		{
			//loading resources
			$user =& eFactory::getUser();
			$juser =& JTable::getInstance('juser', 'Table');
			$juser->load( $user->id() );
			
			$this->_record = $juser->getWebsite();
			
			if (!$this->_record)
			{
				header( 'Location: '.DOTCOM.'index.php?option=com_byrdlist&view=authors&layout=new' );
				exit();
			}
			else
			{
				$this->id = $this->_record->id();
			}
		}
		
		parent::__construct($config);
	}
	
	/**
	 * Display.
	 * 
	 */
	function display($tpl = null) 
	{
		//loading resources
		$this->user =& eFactory::getUser();
    	
		//initializing variables
    	$this->is_owner = false;
    	$this->isLoggedIn = false;
    	
    	//IS THE USER LOGGED IN?
    	if ($this->user->id() != 0)
    	{
    		$this->isLoggedIn = true;
    	}
	    
    	//IS THIS THE OWNER?
		if (isset($this->_record) && !$this->_record->isNew())
		{
			if ($this->_record->author_id() == $this->user->id()) $this->is_owner = true;
		}
    	
    	parent::display($tpl);
    }
    
    /**
     * Delete this record
     * 
     */
    protected function details_delete()
    {
    	$this->_record->delete();
    	
    	//REDIRECT
    	$msg = JText::_( 'Your Webpage has been removed.');
		$link = JRoute::_('index.php?option='.EBOOK_COMPONENT.'&view=myaccount', false);
		
		$this->setRedirect($link, $msg);
    	return true;
    }
    
    /**
     * Publish the record
     */
    protected function details_publish()
    {
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
    	//initializing variables
    	$data = JRequest::get('post');
    	
    	//loading resources
    	$record =& JTable::getInstance($this->_table, 'Table');
    	$record->load( $data['id'] );
    	$record->bind( $data, array(), false );
    	
    	$record->store();
    	$this->id = $record->id;
    	
    	return true;
    }
    
    /**
     * Un publish the record
     */
    protected function details_unpublish()
    {
    	$this->_record->published = 0;
    	$this->_record->store();
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
    		$instance = JTable::getInstance('juser', 'Table');
    		
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
		    		$query = "SELECT * FROM `#__users` as `users`";
		    		break;
		    }
	    	
	    	//FILTERING
	    	switch ($filt)
		    {
		    	default:
		    	case '':
		    		$query .=" WHERE `users`.`block` = '0'"
		    				." AND `users`.`gid` = '31'";
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
	 * Loop through the listing items
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
    	
    	
    	foreach ($records as $id => $user)
    	{
    		$record =& $user->getWebsite();
    		
    		if (!$record) continue;
    		
    		//WHAT TYPE OF LISTING TEMPLATE?
    		if ($record->type() != 'default' && file_exists($path.'_'.$record->type().'.php'))
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
    	//loading resources
    	$this->images = $this->_record->getOneToMany('byrdlist_images');
    	
    	return $this->save();
    }
    
    /**
     * Special Listing types
     * 
     */
    protected function new_two_type_fields( $path = null )
    {
    	//initializing variables
    	$type = $this->_record->type();
    	$class_path = EBOOK_EVERY.DS.'webpage_types'.DS.$type.'.php';
    	$class = ucfirst(strtolower($type)).'Webpage';
    	
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
			
    		require $path;
    	}
    	
    }
	
    /**
     * Save this
     * 
     */
    protected function save( $table = null )
    {
    	//initializing variables
    	$data = JRequest::get('post');
    	
    	if (isset($data['description']))
    	{
    		$data['description'] = JRequest::getVar( 'description', '', 'post', 'string', JREQUEST_ALLOWHTML );
    	}
    	
    	if (is_null($table))
    	{
    		$table = $this->_table;
    	}
    	
    	//loading resources
    	$this->_record =& JTable::getInstance( $table, 'Table' );
    	$this->_record->bind( $data, array(), false );
    	
    	$this->_record->store();
    	$this->id = $this->_record->id;
    	
    	return true;
    }
}

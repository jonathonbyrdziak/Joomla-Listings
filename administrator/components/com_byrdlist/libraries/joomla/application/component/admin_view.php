<?php
/**
 * Joomla! 1.5 component reservation
 *
 * @version $Id: reservation.php 2010-06-02 12:34:25 svn $
 * @author 
 * @package Joomla
 * @subpackage reservation
 * @license Copyright (c) 2010 - All Rights Reserved
 *
 * 
 *
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.view');
require_once EBOOK_HELPERS.DS.'dropdowns.php';

class AdminView extends JView
{
	/**
	 * ID of the given record
	 * 
	 * @var string
	 */
	var $id;
	
	/**
	 * Record Model
	 * 
	 * @var object
	 */
	var $_record;
	
	/**
	 * 
	 * 
	 * @var object
	 */
	var $_table = null;
	
	/**
	 * User Object
	 * 
	 * @var object
	 */
	var $u = null;
	
	/**
	 * Constructor
	 *
	 * @access	protected
	 */
	function __construct($config = array())
	{
		parent::__construct($config);
		
		//initializing object properties
		$this->id = JRequest::getVar('record', JRequest::getVar('id'));
		
		//loading resources
		$this->u =& JFactory::getUser();
		
	}
    
    /**
     * Save it
     * 
     */
    protected function default_add()
    {
    	$this->setLayout('edit');
    }
    
    /**
	 * Publish the record
	 * 
	 */
	protected function default_edit()
	{
		//initializing variables
		$data = JRequest::get('post');
		$ids = @$data['cid'];
		
		//reasons to return
		if (empty($ids)) return false;
		
		//initializing variables
		$id = current($ids);
		
		JRequest::setVar('record', $id);
		$this->id = $id;
		$this->setLayout('edit');
	}
    
    /**
     * Default Listings
     * 
     */
    protected function default_listings( $path = null )
    {
    	return $this->_list( $path );
    }
	
	/**
	 * Publish the record
	 * 
	 */
	protected function default_publish()
	{
		//initializing variables
		$data = JRequest::get('post');
		$ids = @$data['cid'];
		
		//reasons to return
		if (empty($ids)) return false;
		
		foreach ($ids as $id)
		{
			//loading resources
			$record = JTable::getInstance($this->_table, 'Table');
			$record->load( $id );
			
			//initializing variables
    		$properties = $record->getProperties();
			if (array_key_exists('published', $properties))
			{
				$record->published = 1;
			}
			
			$record->store();
		}
	}
	
	/**
	 * Publish the record
	 * 
	 */
	protected function default_remove()
	{
		//initializing variables
		$data = JRequest::get('post');
		$ids = @$data['cid'];
		
		//reasons to return
		if (empty($ids)) return false;
		
		foreach ($ids as $id)
		{
			//loading resources
			$record = JTable::getInstance($this->_table, 'Table');
			$record->load( $id );
			
			$record->delete();
		}
	}
	
	/**
	 * Publish the record
	 * 
	 */
	protected function default_unpublish()
	{
		//initializing variables
		$data = JRequest::get('post');
		$ids = @$data['cid'];
		
		//reasons to return
		if (empty($ids)) return false;
		
		foreach ($ids as $id)
		{
			//loading resources
			$record = JTable::getInstance($this->_table, 'Table');
			$record->load( $id );
			
			//initializing variables
    		$properties = $record->getProperties();
			if (array_key_exists('published', $properties))
			{
				$record->published = 0;
			}
			
			$record->store();
		}
	}
	
	/**
	 * Establish the Media resources
	 * 
	 */
	public function display( $tpl = null )
	{
		//initializing variables
    	$task = JRequest::getCmd('task', 'default');
    	$layout = JRequest::getCmd('layout', 'default');
    	$view = JRequest::getCmd('view', 'default');
    	
    	//initializing object properties
		$this->fireMethod( $layout.'_'.$task );
		$this->getRecord();
		
		if (JRequest::getCmd('task', 'default') == 'cancel')
		{
			$this->setLayout('default');
		}
		
		
		
		//loading media
		JHTML::_('behavior.tooltip');
    	JHTML::stylesheet('general.css', 'administrator/templates/khepri/css/');
		//JHTML::script('mootools-1.2.4-core-yc.js', 'components/'.EBOOK_COMPONENT.'/media/js/');
		
		parent::display( $tpl );
	}
    
    /**
     * Get Elements
     * 
     */
    protected function element( $tpl = null )
    {
    	//reasons to return
    	if ( is_null($tpl) ) return false;
    	
    	//initializing variables
    	$view = JRequest::getCmd('view');
    	$childpath = JPATH_COMPONENT.DS.'views'.DS.$view.DS.'elements'.DS.$tpl.'.php';
    	$parentpath = JPATH_COMPONENT.DS.'views'.DS.'elements'.DS.$tpl.'.php';
    	
    	if ( is_file($childpath) )
    	{
    		$path = $childpath;
    	}
    	elseif ( is_file($parentpath) )
    	{
    		$path = $parentpath;
    	}
    	else
    	{
    		return false;
    	}
    	
    	//run this for single records
    	if ( !method_exists($this, $tpl) )
    	{
    		require $path;
	    	return true;
    	}
    	
		$this->$tpl( $path );
    	return true;
    }
    
    /**
     * Save and redirect
     * 
     */
    protected function edit_cancel()
    {
    	$this->setLayout('default');
    }
    
    /**
     * Store the posted data
     * 
     */
    protected function edit_apply()
    {
    	//initializing variables
    	$data = JRequest::get('post');
    	
    	//loading resources
    	$record =& JTable::getInstance($this->_table, 'Table');
    	$record->bind( $data, array(), false );
    	
    	$record->store();
    	
    	return true;
    }
    
    /**
     * Save and redirect
     * 
     */
    protected function edit_save()
    {
    	//loading resources
    	$this->edit_apply();
    	
    	$this->setLayout('default');
    }
	
	/**
	 * Fire this Method
	 * 
	 * Method will determine if the requested method exists, and fire it
	 * returning a consistent boolean result or the actual result
	 * 
	 * @param $method
	 * @param $args
	 * @return boolean
	 */
	function fireMethod( $method = null, $args = null )
	{
		//reasons to fail
		if (!method_exists($this, $method)) return false;
		
		//run the method
		$result = $this->$method( $args );
		
		//making the results consistent
		if (is_null($result)) return false;
		if (!$result) return false;
		
		return $result;
	}
	
	/**
     * Get the Records information
     *
     */
    protected function &getRecord()
    {
    	//reasons to return
    	if ( is_null($this->_table) ) return false;
    	if ( strlen(trim($this->_table)) <1 ) return false;
    	
    	//reasons to return
    	if ( is_object($this->_record) ) return $this->_record;
    	
    	//loading resources
    	$record =& JTable::getInstance($this->_table, 'Table');
    	
    	//reasons to return
    	if (!is_object($record)) return false;
    	
    	$record->load( $this->id );
    	
    	//initializing object properties
    	$this->_record =& $record;
    	
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
    	$models =& JTable::getInstance($this->_table, 'Table');
    	
    	//initializing variables
    	$list = $models->getList();
    	
    	return $list;
    }
    
    /**
     * Get the HTML list of Records
     * 
     * @return string
     */
    protected function getHtmlList()
    {
    	//initializing variables
    	$string = "";
    	
    	//loading resources
    	$records = $this->getList();
    	
    	//reasons to return
    	if (!$records) return false;
    	
    	foreach ($records as $id => $record)
    	{
    		ob_start();
    		require dirname(__file__).DS.'tmpl'.DS.'list_record.php';
    		$string .= ob_get_clean();
    	}
    	
    	return $string;
    }
    
    /**
     * Return a link to the record
     *
     * @return string
     */
    protected function getRecordLink( $id = null, $view = 'user' )
    {
    	//initializing variables
    	$link = "index.php?option=".EBOOK_COMPONENT."&view=".$view."&record=".$id;
    	$sef = JRoute::_($link);
    	
    	return $sef;
    }
    
    /**
     * List the group accounts
     * 
     */
    protected function _list( $path = null, $record_type = null )
    {
    	//loading resources
    	if (!is_null($record_type))
    	{
    		$records = $this->_record->getOneToMany( $record_type );
    	}
    	else
    	{
    		$records = $this->getList();
    	}
    	
    	//reasons to fail
    	if ( empty($records) || !$records ) return false;
    	
    	//initializing variables
    	$count = 0;
    	$row = 0;
    	
    	foreach ($records as $id => $record)
    	{
    		//initializing variables
    		$count++;
    		$row = (($row <1)? 1: 0);
    		
    		//loading resources
    		require $path;
    		
    	}
    	
    	
    	return true;
    }
	
    /**
     * Pagination
     * 
     */
    protected function pagination( $path = null )
    {
    	//loading resources
    	$models =& JTable::getInstance($this->_table, 'Table');
    	
    	//initializing variables
    	$limit = JRequest::getVar('limit',20, 'post');
    	$select = 'selected="selected"';
    	$pagination = $models->getPagination();
    	
    	$page = $pagination['page'];
    	$first = '0';
    	$prev = ($page -2) * $pagination['limit'];
    	$next = $page * $pagination['limit'];
    	$last = ($pagination['pages'] -1) * $pagination['limit'];
    	
    	require_once $path;
    	return true;
    }
	
    /**
     * Pagination numbers
     * 
     */
    protected function pagination_li( $path = null )
    {
    	//loading resources
    	$models =& JTable::getInstance($this->_table, 'Table');
    	
    	//initializing variables
    	$pagination = $models->getPagination();
    	$before = $pagination['page'] - 4;
    	$after = $pagination['page'] + 4;
    	
    	for ($i = 1;$i <= $pagination['pages']; $i++)
    	{
    		//initializing variables
    		$is_page = ($i == ($pagination['page']))? true:false;
    		$limitstart = ($pagination['limit'] * ($i -1));
    		
    		require $path;
    	}
    	return true;
    }
	}
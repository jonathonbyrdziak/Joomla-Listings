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

jimport( 'joomla.application.component.view' );
require_once EBOOK_HELPERS.DS.'dropdowns.php';

/**
 * 
 * 
 */
class ResView extends JView
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
		
		//loading resources
		$this->user =& JFactory::getUser();
		
		if (!$this->user->authorize( EBOOK_COMPONENT, JRequest::getCmd('view').'.'.JRequest::getCmd('layout', 'default')))
		{
				header( 'Location: '.DOTCOM.'index.php?option=com_community' );
		}
		
		//initializing object properties
		$this->id = JRequest::getVar('record', $this->id);
		
		//loading resources
       	$this->getRecord();
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
		$this->fireMethod( $layout.'_'.$task );  					//echo $layout.'_'.$task;
		$this->getRecord();
		
		if (JRequest::getCmd('task', 'default') == 'cancel')
		{
			$this->setLayout('default');
		}
		
		
		//loading media
		JHTML::stylesheet('jom_community.css', 'components/'.EBOOK_COMPONENT.'/media/css/');
		JHTML::stylesheet('mosets.css', 'components/'.EBOOK_COMPONENT.'/media/css/');
		//JHTML::stylesheet('formcheck.css', 'components/'.EBOOK_COMPONENT.'/media/css/');
		//JHTML::stylesheet('popup-fb.css', 'components/'.EBOOK_COMPONENT.'/media/css/');
		
		//JHTML::script('mootools-1.2.4-core-yc.js', 'components/'.EBOOK_COMPONENT.'/media/js/');
		//JHTML::script('mootools-1.2.4.2-more.js', 'components/'.EBOOK_COMPONENT.'/media/js/');
		//JHTML::script('popup_fb.js', 'components/'.EBOOK_COMPONENT.'/media/js/');
		//JHTML::script('formcheck.js', 'components/'.EBOOK_COMPONENT.'/media/js/');
		
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
    protected function getRecord()
    {
    	//reasons to return
    	if ( is_null($this->_table) ) return false;
    	if ( strlen(trim($this->_table)) <1 ) return false;
    	if ( is_object($this->_record) ) return false;
    	
    	//loading resources
    	$record =& JTable::getInstance($this->_table, 'Table');
    	
    	//reasons to return
    	if (!is_object($record)) return false;
    	
    	$record->load( $this->id );
    	
    	//initializing object properties
    	$this->_record = $record;
    	
    	return true;
    }
    
    /**
     * Get the Records
     * 
     * @return array
     */
    protected function getList()
    {
    	$models =& JTable::getInstance($this->_table, 'Table');
    	
    	
    	return $models->getList();
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
    	
    	
    	foreach ($records as $id => $record)
    	{
    		//loading resources
    		require $path;
    	}
    	
    	
    	return true;
    }
    
    /**
     * List the notifications
     * 
     */
    public function list_logs( $path = null )
    {
    	return $this->_list( $path, 'ven_logs');
    }
    
    /**
     * List the notifications
     * 
     */
    public function list_comments( $path = null )
    {
    	return $this->_list( $path, 'ven_comments');
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
    	
    	$categories_id = JRequest::getCmd('_categories_id',"");
    	if ($categories_id != "") $categories_id = "&_categories_id=".$categories_id;
		
    	$view = JRequest::getCmd('view',"");
		if ($view != "") $view = "&view=".$view;
		
		$layout = JRequest::getCmd('layout',"");
		if ($layout != "") $layout = "&layout=".$layout;
		
		$task = JRequest::getCmd('task',"");
		if ($task != "") $task = "&task=".$task;
		
    	$search = JRequest::getVar('search_filter',"");
		if ($search != "") $search = "&search_filter=".$search;
		
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
    	$pagination = $this->getPagination();
    	$before = $pagination['page'] - 4;
    	$after = $pagination['page'] + 4;
    	
    	
    	$categories_id = JRequest::getCmd('_categories_id',"");
    	if ($categories_id != "") $categories_id = "&_categories_id=".$categories_id;
		
    	$view = JRequest::getCmd('view',"");
		if ($view != "") $view = "&view=".$view;
		
		$layout = JRequest::getCmd('layout',"");
		if ($layout != "") $layout = "&layout=".$layout;
		
		$task = JRequest::getCmd('task',"");
		if ($task != "") $task = "&task=".$task;

    	$search = JRequest::getVar('search_filter',"");
		if ($search != "") $search = "&search_filter=".$search;
		
    	
		for ($i = 1;$i <= $pagination['pages']; $i++)
    	{
    		//initializing variables
    		$is_page = ($i == ($pagination['page']))? true:false;
    		$limitstart = ($pagination['limit'] * ($i -1));
    		
    		require $path;
    	}
    	return true;
    }
	
	
	/**
	 * Redirects the browser or returns false if no redirect is set.
	 *
	 * @access	public
	 * @return	boolean	False if no redirect exists.
	 * @since	1.5
	 */
	function setRedirect( $url = null, $msg = null, $type = null )
	{
		if (!is_null($url)) {
			global $mainframe;
			$mainframe->redirect( $url, $msg, $type );
		}
		return false;
	}

	}
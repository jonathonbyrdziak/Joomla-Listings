<?php
/**
 * @version		$Id: table.php 11646 2009-03-01 19:34:56Z ian $
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

require_once EBOOK_EVERY.DS.'utilities'.DS.'create_guid.php';

/**
 * Abstract Table class
 *
 * Parent classes to all tables.
 *
 * @abstract
 * @package 	Joomla.Framework
 * @subpackage	Table
 * @since		1.0
 * @tutorial	Joomla.Framework/jtable.cls
 */
class ResTable extends JTable
{
	/**
	 * Name of the table in the db schema relating to child class
	 *
	 * @var 	string
	 * @access	protected
	 */
	var $_tbl		= '';

	/**
	 * Name of the primary key field in the table
	 *
	 * @var		string
	 * @access	protected
	 */
	var $_tbl_key	= '';

	/**
	 * Database connector
	 *
	 * @var		JDatabase
	 * @access	protected
	 */
	var $_db		= null;

	/**
	 * Add a directory where JTable should search for table types. You may
	 * either pass a string or an array of directories.
	 *
	 * @access	public
	 * @param	string	A path to search.
	 * @return	array	An array with directory elements
	 * @since 1.5
	 */
	function addIncludePath( $path = null )
	{
		static $paths;

		if (!isset($paths)) {
			$paths = array( dirname( __FILE__ ).DS.'table' );
		}

		// just force path to array
		settype($path, 'array');

		if (!empty( $path ) && !in_array( $path, $paths ))
		{
			// loop through the path directories
			foreach ($path as $dir)
			{
				// no surrounding spaces allowed!
				$dir = trim($dir);

				// add to the top of the search dirs
				// so that custom paths are searched before core paths
				array_unshift($paths, $dir);
			}
		}
		return $paths;
	}

	/**
	 * Return the parent name
	 * 
	 */
	function author_id()
	{
		//loading resources
		$user =& $this->getOneToOne('juser');
		
    	return $user->id();
	}

	/**
	 * Return the parent name
	 * 
	 */
	function author_name()
	{
		//loading resources
		$user =& $this->getOneToOne('juser');
		
    	return $user->name();
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
	function bind( $from, $ignore=array(), $public = true )
	{
		$fromArray	= is_array( $from );
		$fromObject	= is_object( $from );
		
		if (!$fromArray && !$fromObject)
		{
			$this->setError( get_class( $this ).'::bind failed. Invalid from argument' );
			return false;
		}
		if (!is_array( $ignore )) {
			$ignore = explode( ' ', $ignore );
		}
		foreach ($this->getProperties($public) as $k => $v)
		{
			// internal attributes of an object are ignored
			if (!in_array( $k, $ignore ))
			{
				if ($fromArray && isset( $from[$k] )) {
					$this->$k = $from[$k];
				} else if ($fromObject && isset( $from->$k )) {
					$this->$k = $from->$k;
				}
			}
		}
		
		return true;
	}

	/**
	 * Object constructor to set table and key field
	 *
	 * Can be overloaded/supplemented by the child class
	 *
	 * @access protected
	 * @param string $table name of the table in the db schema relating to child class
	 * @param string $key name of the primary key field in the table
	 * @param object $db JDatabase object
	 */
	function __construct( $table, $key, &$db )
	{
		$this->_tbl		= $table;
		$this->_tbl_key	= $key;
		$this->_db		=& $db;
	}

	/**
	 * Generic check for whether dependancies exist for this object in the db schema
	 *
	 * can be overloaded/supplemented by the child class
	 *
	 * @access public
	 * @param string $msg Error message returned
	 * @param int Optional key index
	 * @param array Optional array to compiles standard joins: format [label=>'Label',name=>'table name',idfield=>'field',joinfield=>'field']
	 * @return true|false
	 */
	function canDelete( $oid=null, $joins=null )
	{
		$k = $this->_tbl_key;
		if ($oid) {
			$this->$k = intval( $oid );
		}

		if (is_array( $joins ))
		{
			$select = "$k";
			$join = "";
			foreach( $joins as $table )
			{
				$select .= ', COUNT(DISTINCT '.$table['idfield'].') AS '.$table['idfield'];
				$join .= ' LEFT JOIN '.$table['name'].' ON '.$table['joinfield'].' = '.$k;
			}

			$query = 'SELECT '. $select
			. ' FROM '. $this->_tbl
			. $join
			. ' WHERE '. $k .' = '. $this->_db->Quote($this->$k)
			. ' GROUP BY '. $k
			;
			$this->_db->setQuery( $query );

			if (!$obj = $this->_db->loadObject())
			{
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
			$msg = array();
			$i = 0;
			foreach( $joins as $table )
			{
				$k = $table['idfield'] . $i;
				if ($obj->$k)
				{
					$msg[] = JText::_( $table['label'] );
				}
				$i++;
			}

			if (count( $msg ))
			{
				$this->setError("noDeleteRecord" . ": " . implode( ', ', $msg ));
				return false;
			}
			else
			{
				return true;
			}
		}

		return true;
	}

	/**
	 * Generic check method
	 *
	 * Can be overloaded/supplemented by the child class
	 *
	 * @access public
	 * @return boolean True if the object is ok
	 */
	function check()
	{
		return true;
	}

	/**
	 * Checks out a row
	 *
	 * @access public
	 * @param	integer	The id of the user
	 * @param 	mixed	The primary key value for the row
	 * @return	boolean	True if successful, or if checkout is not supported
	 */
	function checkout( $who, $oid = null )
	{
		if (!in_array( 'checked_out', array_keys($this->getProperties()) )) {
			return true;
		}

		$k = $this->_tbl_key;
		if ($oid !== null) {
			$this->$k = $oid;
		}

		$date =& JFactory::getDate();
		$time = $date->toMysql();

		$query = 'UPDATE '.$this->_db->nameQuote( $this->_tbl ) .
			' SET checked_out = '.(int)$who.', checked_out_time = '.$this->_db->Quote($time) .
			' WHERE '.$this->_tbl_key.' = '. $this->_db->Quote($this->$k);
		$this->_db->setQuery( $query );

		$this->checked_out = $who;
		$this->checked_out_time = $time;

		return $this->_db->query();
	}

	/**
	 * Checks in a row
	 *
	 * @access	public
	 * @param	mixed	The primary key value for the row
	 * @return	boolean	True if successful, or if checkout is not supported
	 */
	function checkin( $oid=null )
	{
		if (!(
			in_array( 'checked_out', array_keys($this->getProperties()) ) ||
	 		in_array( 'checked_out_time', array_keys($this->getProperties()) )
		)) {
			return true;
		}

		$k = $this->_tbl_key;

		if ($oid !== null) {
			$this->$k = $oid;
		}

		if ($this->$k == NULL) {
			return false;
		}

		$query = 'UPDATE '.$this->_db->nameQuote( $this->_tbl ).
				' SET checked_out = 0, checked_out_time = '.$this->_db->Quote($this->_db->getNullDate()) .
				' WHERE '.$this->_tbl_key.' = '. $this->_db->Quote($this->$k);
		$this->_db->setQuery( $query );

		$this->checked_out = 0;
		$this->checked_out_time = '';

		return $this->_db->query();
	}
	
	/**
	 * Counts the relationships
	 * 
	 */
	public function countRelationships( $child = null, &$ids = null )
	{
		//initializing variables
    	$count = 0;
    	$ids = array();
    	
    	//if there is no relationship then fail
    	if (!$this->id) return 0;
    	
    	
    	//getting the relationship fields
    	$this->getRelationship( $child, &$joinTable, &$parentColumnName, &$childColumnName );
    	
    	//getting the package bean
	 	$query = " SELECT `".$childColumnName."` AS `child_id` "
	 			." FROM `".$joinTable."`"
	 			." WHERE `".$parentColumnName."` = '".$this->id."' "
	 			.";";
	 	
	 	$this->_db->setQuery($query);
		$child_id = $this->_db->loadAssocList();
	 	
		
		//reasons to return
		if (empty($child_id)) return 0;
		
		$count = count($child_id);
		
		foreach ($child_id as $id)
		{
			$ids[] = $id['child_id'];
		}
		
		return $count;
	}

	/**
	 * Default delete method
	 *
	 * can be overloaded/supplemented by the child class
	 *
	 * @access public
	 * @return true if successful otherwise returns and error message
	 */
	function delete( $oid=null )
	{
		//if (!$this->canDelete( $msg ))
		//{
		//	return $msg;
		//}

		$k = $this->_tbl_key;
		if ($oid) {
			$this->$k = intval( $oid );
		}

		$query = 'DELETE FROM '.$this->_db->nameQuote( $this->_tbl ).
				' WHERE '.$this->_tbl_key.' = '. $this->_db->Quote($this->$k);
		$this->_db->setQuery( $query );

		if ($this->_db->query())
		{
			return true;
		}
		else
		{
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
	}

	/**
     * Get the Child ID Property
     * 
     * Method makes sure that the relationship id property exists for 
     * this object
     * 
     * @param string $child
     * @return string
     */
    function _getChildIdProperty( $child = null, $model = null )
    {
    	//reasons to fail
    	if (is_null($child)) return false;
    	
    	//initializing variables
    	$replace = array('#__','byrdlist_');
    	$child = str_replace($replace, "", $child);
    	$child = '_'.strtolower(trim($child));
    	
    	$length = strlen($child);
    	
    	if (is_null($model))
    	{
    		$model = $this;
    	}
    	
    	$properties = array();
    	foreach($model->getProperties(false) as $property => $null)
    	{
    		$properties[strtolower($property)] = $property;
    	}
    	
    	//check it straight
    	$child_id = $child.'_id';
    	if (isset($properties[$child_id])) return $properties[$child_id];
    	
    	//check without the S
    	$child_id = substr($child, 0, $length-1 ).'_id';
    	if (isset($properties[$child_id])) return $properties[$child_id];
    	
    	//check with the S
    	$child_id = $child.'s_id';
    	if (isset($properties[$child_id])) return $properties[$child_id];
    	
    	//trigger an error
    	//trigger_error("Save Relationship Method cannot locate ".strtolower($child)
	    // 	."_id property in ".$this->object_name);
    	
    	return false;
    }
	
	/**
	 * Get the internal database object
	 *
	 * @return object A JDatabase based object
	 */
	function &getDBO()
	{
		return $this->_db;
	}

	/**
	 * Gets the internal primary key name
	 *
	 * @return string
	 * @since 1.5
	 */
	function getKeyName()
	{
		return $this->_tbl_key;
	}

	/**
	 * returns a list of all the items
	 * 
	 * @access public
	 * @return array
	 */
	function getList( $filter = null ) 
	{
		//initializing variables
		$class = strtolower(str_replace('Table','', get_class($this)));
		$results = array();
		$query_limit = "";
		//$filter = "";
		
		//pagination
		$limitstart = JRequest::getVar('limitstart',0);
		$limit = JRequest::getVar('limit',20);
		
		if ($limit != 0) $query_limit = " LIMIT ".$limitstart.', '.$limit;
		
		
		//filtering
		if (!is_null($filter))
		{
			$filter = " WHERE ".$filter;
		}
		
		//building queries
		$query 	= "SELECT * FROM ".$this->_tbl.' '.$filter.' '.$query_limit;
		
		//set and run the query
		$this->_db->setQuery($query);
		$records = $this->_db->loadAssocList(); 
		
		//reasons to return
		if (!$records) return false;
		
		
		foreach ($records as $record)
		{
			$model =& JTable::getInstance($class, 'Table');
			$model->bind($record);
			
			$results[$model->id] = $model;
		}
		
		return $results;
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
			//initializing variables
			$limitstart = JRequest::getVar('limitstart',0);
			$limit = JRequest::getVar('limit',20);
			
			$page = ceil($limitstart / $limit);
			$page = $page + 1;
			
			
			$query 	= "SELECT id FROM ".$this->_tbl;
			
			//running query
			$this->_db->setQuery( $query );
			$records = $this->_db->loadAssocList();
			$total_rows = count($records);
			
			$pagination = array();
			$pagination['limitstart'] = $limitstart;
			$pagination['limit'] = $limit;
			$pagination['pages'] = ceil($total_rows / $limit);
			$pagination['page'] = $page;
		}
		
		return $pagination;
	}
	
	/**
	 * Returns the ordering value to place a new item last in its group
	 *
	 * @access public
	 * @param string query WHERE clause for selecting MAX(ordering).
	 */
	function getNextOrder ( $where='' )
	{
		if (!in_array( 'ordering', array_keys($this->getProperties()) ))
		{
			$this->setError( get_class( $this ).' does not support ordering' );
			return false;
		}

		$query = 'SELECT MAX(ordering)' .
				' FROM ' . $this->_tbl .
				($where ? ' WHERE '.$where : '');

		$this->_db->setQuery( $query );
		$maxord = $this->_db->loadResult();

		if ($this->_db->getErrorNum())
		{
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		return $maxord + 1;
	}

	/**
     * Get a One to Many Relationship Object
     * 
     * Method will determine the dynamic relationship and query for the
     * related ID, finally returning the global object reference
     * 
     * @param $relation string
     * @param $options array
     * @return $instance		global object reference
     */
    function getOneToMany( $child, $options = array() )
    {
    	//initializing variables
    	$count = 0;
    	if (!is_array($options))
    	{
    		$options = array();
    	}
    	
    	$defaults = array(
    		'deleted' => false,
    		'count' => false
    	);
    	
    	$options = $options + $defaults;
    	
    	//if there is no relationship then fail
    	if (!$this->id) return false;
    	
    	
    	//getting the relationship fields
    	$this->getRelationship( $child, &$joinTable, &$parentColumnName, &$childColumnName );
    	
    	//getting the package bean
	 	$query = " SELECT `".$childColumnName."` AS `child_id` "
	 			." FROM `".$joinTable."`"
	 			." WHERE `".$parentColumnName."` = '".$this->id."' "
	 			.";";
	 	
	 	$this->_db->setQuery($query);
		$child_id = $this->_db->loadAssocList();
	 	
	 	
	 	//reasons to return
	 	if (!$child_id) return false;
	 	
	 	foreach ($child_id as $id)
	 	{
	 		$instance = JTable::getInstance( $child, 'Table' );
	 		
	 		//reasons to continue
	 		if (!$instance->load($id['child_id'])) continue;
	 		
	 		$instances[$id['child_id']] = $instance;
	 	}
	 	
	 	
	 	//making sure we return a specific number of objects
	 	if ($options['count'])
	 	{
	 		//removing some objects when there are too many
	 		foreach ($instances as $id => $instance)
	 		{
	 			$count++;
	 			if ($count > $options['count'])
	 			{
	 				unset($instances[$id]);
	 			}
	 			
	 		}
	 		
	 		//adding more empty objects if we don't have enough
	 		while ($options['count'] > count($instances))
	 		{
	 			$instance = JTable::getInstance( $child, 'Table' );
	 			$instances[] = $instance;
	 		}
	 		
	 	}
	 	
	 	return $instances; 
    }
	
    /**
     * Get a One to One Relationship
     * 
     * Method will determine the dynamic relationship and query for the
     * related ID, finally returning the global object reference
     * 
     * @example $layout_defs['<PARENT>']['subpanel_setup']['<CHILD>']
     * @param $relation string
     * @param $options array
     * @return $isntance		global object reference
     * 
     */
    function getOneToOne( $child, $options = null )
    {
    	//If the relationship is in the database, then onetomany can retreive it
	    $instances = $this->getOneToMany( $child, $options );

	    if ( !empty($instances) )
	    {
	    	//reasons to finish
	    	return current($instances);
	    }
    	
    	//loading resources
    	$instance =& JTable::getInstance( $child, 'Table' );
    	
	    if ($child_id = $this->_getChildIdProperty( $child ) )
	    {
    		$instance->load( $this->$child_id );
    	}
	    
    	return $instance;
    }
	
    /**
	 * Returns an associative array of object properties
	 *
	 * @access	public
	 * @param	boolean $public If true, returns only the public properties
	 * @return	array
	 * @see		get()
	 * @since	1.5
 	 */
	function getProperties( $public = true, $ignore = array() )
	{
		//initializing variables
		$vars  = get_object_vars($this);
		
        if($public)
		{
			foreach ($vars as $key => $value)
			{
				if ('_' == substr($key, 0, 1)) {
					unset($vars[$key]);
				}
				
				if (in_array($key, $ignore)) {
					unset($vars[$key]);
				}
			}
		}
		
        return $vars;
	}
	
	/**
     * Get Relationship Fields
     * 
     * Method is designed to locate the relationship fields 
     * and return the via global reference
     * 
     * @param $child
     * @param $join_table
     * @param $parentColumnName
     * @param $childColumnName
     * @return boolean
     */
    private function getRelationship( $child, &$join_table, &$parentColumnName, &$childColumnName, &$link = null )
    {
    	//intialiazing variables
    	$relationship = $this->_getRelationshipName( $child );
    	$relationships = $this->getRelationships();
    	
    	//loading resources
    	$link = $relationships[$relationship];
    	
    	//determine which side that the parent module is on
    	//from here we can set the join keys
    	if ($link['lhs_table'] == $this->_tbl)
    	{
    		$parentColumnName = $link['join_key_lhs'];
    		$childColumnName = $link['join_key_rhs'];
    	}
    	else
    	{
    		$parentColumnName = $link['join_key_rhs'];
    		$childColumnName = $link['join_key_lhs'];
    	}
    	
    	//get the joining table name
    	$join_table = $link['join_table'];
    	
    	return true;
    }
    
    /**
     * Get the Relationships Name
     * 
     * Method will determine the relationship name and return it as a string
     * 
     * @param string $child
     * @return string
     */
    private function _getRelationshipName( $child = null )
    {
    	//intialiazing variables
    	static $relationships;
    	$replace = array('#__','byrdlist_');
    	
    	$parent = str_replace($replace, "", $this->_tbl);
    	if ($parent == 'users') $parent = 'juser';
    	$child = str_replace($replace, "", trim($child));
    	
    	if (!isset($relationships))
    	{
    		$relationships = array();
    		foreach($this->getRelationships() as $name => $link)
    		{
    			$relationships[$link['lhs_module']][$link['rhs_module']] = $name;
    			$relationships[$link['rhs_module']][$link['lhs_module']] = $name;
    		}
    	}
    	
    	//check it straight
    	if ( isset($relationships[$child]) && isset($relationships[$child][$parent]))
    	{
    		return $relationships[$child][$parent];
    	} 
    	
    	return false;
    }
    
    /**
     * Get the sugar Relationships
     * 
     * Method will build the relationships array if it doesn't exist
     * 
     * @return array
     */
    function getRelationships()
    {
    	//load the relationships manual file
    	if (file_exists(dirname(__file__).DS.'relationships.php'))
    	require_once dirname(__file__).DS.'relationships.php';
    	
    	static $relationships;
    	
    	if (!isset($relationships))
    	{
    		global $relationships;
	    	
	    	if ($relationships) return $relationships;
	    	
	    	//initializing variables
	    	$relationships = array();
	    	$query = "SELECT * FROM `relationships`";
	    	
	    	//getting the relationships from the database
	    	$this->_db->setQuery($query);
			$results = $this->_db->loadAssocList();
	    	
			
			//reasons to return
			if ( empty($results) ) return false;
			
	    	//building the relationship array
	    	foreach($results as $key => $result)
	    	{
	    		$relationships[$result['relationship_name']] = $result;
	    	}
    	}
    	
    	return $relationships;
    }
    
    /**
	 * Gets the internal table name for the object
	 *
	 * @return string
	 * @since 1.5
	 */
	function getTableName()
	{
		return $this->_tbl;
	}

	/**
	 * Description
	 *
	 * @access public
	 * @param $oid
	 * @param $log
	 */
	function hit( $oid=null, $log=false )
	{
		if (!in_array( 'hits', array_keys($this->getProperties()) )) {
			return;
		}

		$k = $this->_tbl_key;

		if ($oid !== null) {
			$this->$k = intval( $oid );
		}

		$query = 'UPDATE '. $this->_tbl
		. ' SET hits = ( hits + 1 )'
		. ' WHERE '. $this->_tbl_key .'='. $this->_db->Quote($this->$k);
		$this->_db->setQuery( $query );
		$this->_db->query();
		$this->hits++;
	}

	/**
	 * Check if an item is checked out
	 *
	 * This function can be used as a static function too, when you do so you need to also provide the
	 * a value for the $against parameter.
	 *
	 * @static
	 * @access public
	 * @param integer  $with  	The userid to preform the match with, if an item is checked out
	 * 				  			by this user the function will return false
	 * @param integer  $against 	The userid to perform the match against when the function is used as
	 * 							a static function.
	 * @return boolean
	 */
	function isCheckedOut( $with = 0, $against = null)
	{
		if(isset($this) && is_a($this, 'JTable') && is_null($against)) {
			$against = $this->get( 'checked_out' );
		}

		//item is not checked out, or being checked out by the same user
		if (!$against || $against == $with) {
			return  false;
		}

		$session =& JTable::getInstance('session');
		return $session->exists($against);
	}
	
	/**
	 * Is this a new record that does not have an ID?
	 * 
	 */
	public function isNew()
	{
		if ( strlen(trim( $this->{$this->_tbl_key} )) <1 )
			return true;
		return false;
	}

	/**
	 * Loads a row from the database and binds the fields to the object properties
	 *
	 * @access	public
	 * @param	mixed	Optional primary key.  If not specifed, the value of current key is used
	 * @return	boolean	True if successful
	 */
	function load( $oid=null )
	{
		$k = $this->_tbl_key;

		if ($oid !== null) {
			$this->$k = $oid;
		}

		$oid = $this->$k;

		if ($oid === null) {
			return false;
		}
		$this->reset();

		$db =& $this->getDBO();

		$query = 'SELECT *'
		. ' FROM '.$this->_tbl
		. ' WHERE '.$this->_tbl_key.' = '.$db->Quote($oid);
		$db->setQuery( $query );

		if ($result = $db->loadAssoc( )) {
			$return = $this->bind($result);
			
			//loading any custom properties
			$this->loadCustomProperties();
			
			return $return;
		}
		else
		{
			$this->setError( $db->getErrorMsg() );
			return false;
		}
	}

	/**
     * Method builds this model based on a contact's id
     * 
     * @param integer $user_id
     */
    function loadByUserName( $email = null )
    {
    	if (is_null($email) || !$email) return false;
    	
    	//initializing variables
		$email = addslashes($email);
		
	 	//Get the Contacts information
		$query = "SELECT `id_c` FROM `".$this->_tbl."_cstm`"
				." WHERE `username_c` = '".$email."';";
		$result =  $this->query( $query );
		
		//reasons to return
		if (!$result) return false;
		
		$this->load( $result[0]['id_c'] );
		return true;
    }
    
    /**
	 * Description
	 *
	 * @access public
	 * @param $dirn
	 * @param $where
	 */
	function move( $dirn, $where='' )
	{
		if (!in_array( 'ordering',  array_keys($this->getProperties())))
		{
			$this->setError( get_class( $this ).' does not support ordering' );
			return false;
		}

		$k = $this->_tbl_key;

		$sql = "SELECT $this->_tbl_key, ordering FROM $this->_tbl";

		if ($dirn < 0)
		{
			$sql .= ' WHERE ordering < '.(int) $this->ordering;
			$sql .= ($where ? ' AND '.$where : '');
			$sql .= ' ORDER BY ordering DESC';
		}
		else if ($dirn > 0)
		{
			$sql .= ' WHERE ordering > '.(int) $this->ordering;
			$sql .= ($where ? ' AND '. $where : '');
			$sql .= ' ORDER BY ordering';
		}
		else
		{
			$sql .= ' WHERE ordering = '.(int) $this->ordering;
			$sql .= ($where ? ' AND '.$where : '');
			$sql .= ' ORDER BY ordering';
		}

		$this->_db->setQuery( $sql, 0, 1 );


		$row = null;
		$row = $this->_db->loadObject();
		if (isset($row))
		{
			$query = 'UPDATE '. $this->_tbl
			. ' SET ordering = '. (int) $row->ordering
			. ' WHERE '. $this->_tbl_key .' = '. $this->_db->Quote($this->$k)
			;
			$this->_db->setQuery( $query );

			if (!$this->_db->query())
			{
				$err = $this->_db->getErrorMsg();
				JError::raiseError( 500, $err );
			}

			$query = 'UPDATE '.$this->_tbl
			. ' SET ordering = '.(int) $this->ordering
			. ' WHERE '.$this->_tbl_key.' = '.$this->_db->Quote($row->$k)
			;
			$this->_db->setQuery( $query );

			if (!$this->_db->query())
			{
				$err = $this->_db->getErrorMsg();
				JError::raiseError( 500, $err );
			}

			$this->ordering = $row->ordering;
		}
		else
		{
			$query = 'UPDATE '. $this->_tbl
			. ' SET ordering = '.(int) $this->ordering
			. ' WHERE '. $this->_tbl_key .' = '. $this->_db->Quote($this->$k)
			;
			$this->_db->setQuery( $query );

			if (!$this->_db->query())
			{
				$err = $this->_db->getErrorMsg();
				JError::raiseError( 500, $err );
			}
		}
		return true;
	}

	/**
	 * Generic Publish/Unpublish function
	 *
	 * @access public
	 * @param array An array of id numbers
	 * @param integer 0 if unpublishing, 1 if publishing
	 * @param integer The id of the user performnig the operation
	 * @since 1.0.4
	 */
	function publish( $cid=null, $publish=1, $user_id=0 )
	{
		JArrayHelper::toInteger( $cid );
		$user_id	= (int) $user_id;
		$publish	= (int) $publish;
		$k			= $this->_tbl_key;

		if (count( $cid ) < 1)
		{
			if ($this->$k) {
				$cid = array( $this->$k );
			} else {
				$this->setError("No items selected.");
				return false;
			}
		}

		$cids = $k . '=' . implode( ' OR ' . $k . '=', $cid );

		$query = 'UPDATE '. $this->_tbl
		. ' SET published = ' . (int) $publish
		. ' WHERE ('.$cids.')'
		;

		$checkin = in_array( 'checked_out', array_keys($this->getProperties()) );
		if ($checkin)
		{
			$query .= ' AND (checked_out = 0 OR checked_out = '.(int) $user_id.')';
		}

		$this->_db->setQuery( $query );
		if (!$this->_db->query())
		{
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		if (count( $cid ) == 1 && $checkin)
		{
			if ($this->_db->getAffectedRows() == 1) {
				$this->checkin( $cid[0] );
				if ($this->$k == $cid[0]) {
					$this->published = $publish;
				}
			}
		}
		$this->setError('');
		return true;
	}

	/**
	 * Returns an associative array of records from a query.
	 * 
	 * @param $query
	 */
	function query( $query )
	{
		switch (strtolower( substr(trim($query),0,6) ))
		{
			case 'select':
				$this->_db->setQuery( $query );
				$results = $this->_db->loadAssocList();
				return $results;
				break;
				
			case 'insert': case'update':
				$this->_db->setQuery( $query );
				$result =  $this->_db->query();
				return $result;
				break;
		}
		return false;
	}
	
	/**
	 * Resets the default properties
	 * @return	void
	 */
	function reset()
	{
		$k = $this->_tbl_key;
		foreach ($this->getProperties() as $name => $value)
		{
			if($name != $k)
			{
				$this->$name	= $value;
			}
		}
	}

	/**
	 * Compacts the ordering sequence of the selected records
	 *
	 * @access public
	 * @param string Additional where query to limit ordering to a particular subset of records
	 */
	function reorder( $where='' )
	{
		$k = $this->_tbl_key;

		if (!in_array( 'ordering', array_keys($this->getProperties() ) ))
		{
			$this->setError( get_class( $this ).' does not support ordering');
			return false;
		}

		if ($this->_tbl == '#__content_frontpage')
		{
			$order2 = ", content_id DESC";
		}
		else
		{
			$order2 = "";
		}

		$query = 'SELECT '.$this->_tbl_key.', ordering'
		. ' FROM '. $this->_tbl
		. ' WHERE ordering >= 0' . ( $where ? ' AND '. $where : '' )
		. ' ORDER BY ordering'.$order2
		;
		$this->_db->setQuery( $query );
		if (!($orders = $this->_db->loadObjectList()))
		{
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		// compact the ordering numbers
		for ($i=0, $n=count( $orders ); $i < $n; $i++)
		{
			if ($orders[$i]->ordering >= 0)
			{
				if ($orders[$i]->ordering != $i+1)
				{
					$orders[$i]->ordering = $i+1;
					$query = 'UPDATE '.$this->_tbl
					. ' SET ordering = '. (int) $orders[$i]->ordering
					. ' WHERE '. $k .' = '. $this->_db->Quote($orders[$i]->$k)
					;
					$this->_db->setQuery( $query);
					$this->_db->query();
				}
			}
		}

	return true;
	}

	/**
	 * Inserts a new row if id is zero or updates an existing row in the database table
	 *
	 * Can be overloaded/supplemented by the child class
	 *
	 * @access public
	 * @param boolean If false, null object variables are not updated
	 * @return null|string null if successful otherwise returns and error message
	 */
	function store( $updateNulls=false )
	{
		$k = $this->_tbl_key;

		if( $this->$k )
		{
			$ret = $this->_db->updateObject( $this->_tbl, $this, $this->_tbl_key, $updateNulls );
		}
		else
		{
			//loading libraries
			$properties = $this->getProperties();
			//loading resources
			$user =& eFactory::getUser();
		
			//initializing object properties
			$this->_juser_id = $user->id;
			$this->$k = create_guid();
			
			if (array_key_exists('created_on', $properties)) 
				$this->created_on = date('Y-m-d H:i:s', time());
			
			
			if ($ret = $this->_db->insertObject( $this->_tbl, $this, $this->_tbl_key ))
			{
				$this->saveRelationship('juser');
			}
			
			
		}
		if( !$ret )
		{
			$this->setError(get_class( $this ).'::store failed - '.$this->_db->getErrorMsg());
			return false;
		}
		else
		{
			return true;
		}
	}

	/**
     * Save
     * 
     * Method is the base save function for this object class
     * 
     * @return string
     */
    function _save( $properties = null)
    {
    	//reasons to return
    	if ( is_null($properties) ) return false;
    	
    	//pass responsibilities to the update function if this has an id
    	if ( !$this->isNew() ) return $this->_update();
    	
    	//initializing variables
    	$id = create_guid();
    	
    	//building the query
    	$query = "INSERT INTO `".$this->_tbl."`"
    			." (`".implode( "`,`", $properties )."`) VALUES (";
		
    	//Saving the class property values
    	foreach ($properties as $count => $property)
    	{
    		//Making sure that system properties are also set
    		switch($property)
    		{
    			case 'id_c': $query .= "'".$id."'"; break;
    			case 'date_created': case 'date_entered': 
    				$date =& eFactory::getDate( time() );
    				$query .= "'".$date->toMySQL()."'";
    				break;
    			case 'date_modified': 
    				$date =& eFactory::getDate( time() );
    				$query .= "'".$date->toMySQL()."'";
    				break;
    			default: $query .= "'".$this->$property."'"; break;
    		}
    		
    		if ($count+1 < count($properties)) $query .=",";
    		
    	}
	 	$query .=");";
	 	
	 	if ($this->query( $query ))
	 	{
	 		return $id;
	 	}
	 	
	 	return false;
    }
    
    /**
	 * Generic save function
	 *
	 * @access	public
	 * @param	array	Source array for binding to class vars
	 * @param	string	Filter for the order updating
	 * @param	mixed	An array or space separated list of fields not to bind
	 * @returns TRUE if completely successful, FALSE if partially or not succesful.
	 */
	function save( $source, $order_filter='', $ignore='' )
	{
		if (!$this->bind( $source, $ignore )) {
			return false;
		}
		if (!$this->check()) {
			return false;
		}
		if (!$this->store()) {
			return false;
		}
		//saving the custom _C sugar properties
		$this->saveCustomProperties();
		
		if (!$this->checkin()) {
			return false;
		}
		if ($order_filter)
		{
			$filter_value = $this->$order_filter;
			$this->reorder( $order_filter ? $this->_db->nameQuote( $order_filter ).' = '.$this->_db->Quote( $filter_value ) : '' );
		}
		
		$this->setError('');
		return true;
	}

	/**
	 * Save the Custom Properties
	 * 
	 */
	function saveCustomProperties()
	{
		//initializing variables
		$properties = $this->getProperties();
		
    	foreach ($properties as $property => $value)
    	{
    		if ( substr($property,-2) !== '_c' )
    		{
    			unset($properties[$property]);
    		}
    	}
    	
    	$this->_save( $properties );
	}
	
	/**
     * Save Relationship
     * 
     * Method is designed to locate the relationship and save the bean
     * 
     * @param $child
     * @param $options
     * @return boolean
     */
    function saveRelationship( $child, $options = null )
    {
    	//reasons to fail
    	if ( strlen(trim($this->id)) <1 ) return false;
    	
    	
    	//intialiazing variables
    	$date =& JFactory::getDate();
    	$date_modified = $date->toMysql();
    	$id = create_guid();
    	
	 	//making sure that the relationship id property exists for this object
    	if (!($child_id = $this->_getChildIdProperty( $child ))) return false;
    	
    	//reasons to fail
    	if ( strlen(trim($this->$child_id)) <1 ) return false;
    	
    	
    	$this->getRelationship( $child, &$joinTable, &$parentColumnName, &$childColumnName );
	 	if ( strlen(trim($child_id)) <1 ) return false;
	 	
    	//building the query
    	$query = "INSERT INTO `".$joinTable."`"
	 			." (`id`,`".$parentColumnName."`,`".$childColumnName."`) VALUES "
	 			." ('".$id."','".$this->id."','".$this->$child_id."');";
	 	
	 	$this->purgeRelationships( $child );
    	$this->query( $query );
    	
    	return $id;
    }
    
    /**
	 * Modifies a property of the object, creating it if it does not already exist.
	 *
	 * @access	public
	 * @param	string $property The name of the property
	 * @param	mixed  $value The value of the property to set
	 * @return	mixed Previous value of the property
	 * @see		setProperties()
	 * @since	1.5
	 */
	function set( $property, $value = null )
	{
		$previous = isset($this->$property) ? $this->$property : null;
		$this->$property = $value;
		return $previous;
	}
	
	/**
	 * Set the object properties based on a named array/hash
	 *
	 * @access	protected
	 * @param	$array  mixed Either and associative array or another object
	 * @return	boolean
	 * @see		set()
	 * @since	1.5
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
	
	/**
	 * Set the internal database object
	 *
	 * @param	object	$db	A JDatabase based object
	 * @return	void
	 */
	function setDBO(&$db)
	{
		$this->_db =& $db;
	}
	
	/**
	 * Export item list to xml
	 *
	 * @access public
	 * @param boolean Map foreign keys to text values
	 */
	function toXML( $mapKeysToText=false )
	{
		$xml = '<record table="' . $this->_tbl . '"';

		if ($mapKeysToText)
		{
			$xml .= ' mapkeystotext="true"';
		}
		$xml .= '>';
		foreach (get_object_vars( $this ) as $k => $v)
		{
			if (is_array($v) or is_object($v) or $v === NULL)
			{
				continue;
			}
			if ($k[0] == '_')
			{ // internal field
				continue;
			}
			$xml .= '<' . $k . '><![CDATA[' . $v . ']]></' . $k . '>';
		}
		$xml .= '</record>';

		return $xml;
	}
	
	/**
     * Update
     * 
     * Method is the base update function for this object class
     * 
     * @return string
     */
    function _update( $properties = null )
    {
    	//reasons to return
    	if ( is_null($properties) ) return false;
    	
    	//building the query
    	$query = "UPDATE `".$this->_tbl."`"
    			." SET ";
    	
    	//Updating the class property values
	 	foreach ($properties as $count => $property)
    	{
    		if ($property == 'id') continue;
    		
    		//Making sure that system properties are also set
    		switch($property)
    		{
    			case 'date_created': break;
    			case 'date_modified': 
    				$date =& eFactory::getDate( time() );
    				$query .=" `date_modified` = '".$date->toMySQL()."'";
    				break;
    			default: $query .=" `".$property."` = '".$this->$property."'"; break;
    		}
    		
    		if ($count+1 < count($properties)) $query .=",";
    		
    	}
	 	$query .=" WHERE `id_c` = '".$this->id."';";
	 	
	 	if ($this->query( $query ))
	 	{
	 		return $this->id;
	 	}
	 	return false;
    }
    
    /**
	 * Overriding method
	 */
	function __call( $property, $args )
	{
		return $this->get( $property );
	}
	
}





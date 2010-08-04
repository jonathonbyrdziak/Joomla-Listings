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
class SugarTable extends JTable
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
	 * Overriding method
	 */
	function __call( $property, $args )
	{
		return $this->get( $property );
	}
	
	/**
     * Method loads the table values into the object properties
     * 
     * @param $id
     * @param $options
     */
    function __construct( $table, $key, &$db )
    {
    	$this->_tbl		= $table;
		$this->_tbl_key	= $key;
		$this->_db		=& $db;
    }
    
    /**
     * Check that this record is valid
     * 
     * @return boolean
     */
    function check()
    {
    	return ($this->id)? true : false;
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
	function bind( $from, $ignore=array() )
	{
		$fromArray	= is_array( $from );
		$fromObject	= is_object( $from );

		if (!$fromArray && !$fromObject)
		{
			trigger_error( get_class( $this ).'::bind failed. Invalid from argument' );
			return false;
		}
		
		if (!is_array( $ignore )) {
			$ignore = explode( ' ', $ignore );
		}
		
		if ($fromArray) $from = array_change_key_case($from, CASE_LOWER);
		
		foreach ($this->getProperties() as $k => $v)
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
	 * Delete all addresses
	 * 
	 * Method will load all of the addresses and then loop through each
	 * of them, deleting all.
	 * 
	 * @return boolean
	 */
	function deleteAddresses()
	{
		$addresses =& $this->getOneToMany('ven_Addresses');
		
		if (empty($addresses)) return false;
		
		foreach ($addresses as $address)
		{
			$address->delete();
		}
		
		return true;
	}
	
	/**
     * Delete relationship links
     * 
     * Method is designed to delete the relationship link records
     * 
     * @return boolean
     */
    function delete_linked()
    {
    	$results = parent::delete_linked( $this->id );
    	return $results;
    }
    
    /**
     * Delete Record
     * 
     * Method is designed to delete the mark the record as deleted unless 
     * the param is set to true then this method will completely delete 
     * this record.
     * 
     * @param $complete
     * @return boolean
     */
    function delete( $complete = false )
    {
    	if (!$this->id) return false;
    	
    	if ($complete)
    	{
    		//not a complete delete, just marking them as deleted
    		$this->deleteChildren();
    		return $this->mark_deleted();
    	}
    	else
    	{
    		$this->deleteChildren( true );
    		$this->deleteRelationships();
    		
    		//query to delete THIS record
	    	$query = "DELETE FROM `".$this->_tbl."` "
	    			." WHERE id = '".$this->id."'"
	    			." ";
	    			
	    	return $this->_db->query( $query, false, '' );
    	}
    	
    }
    
    /**
     * Delete Child Objects
     * 
     * Method will loop through the child objects deleting associated 
     * records
     * 
     * @return boolean
     */
    function deleteChildren( $complete = false )
    {
    	//fail if there are no child objects
    	if (empty($this->childObjects)) return false;
    	
    	foreach ($this->childObjects as $child)
    	{
    		//load the child object references
    		$objects =& $this->getOneToMany($child);
    		
    		//fail if there are no child object references
    		if (empty($objects)) continue;
    		
    		foreach($objects as $object)
    		{
    			//delete child record completely
    			$object->delete( $complete );
    		}
    	}
    	
    	return true;
    }
    
    /**
     * Delete Relationships
     * 
     * Method is designed to delete any relationship that contains the UUID
     * 
     * @return integer
     */
    function deleteRelationships()
    {
    	if (!chk($this->id)) return false;
    	
    	//initializing variables
    	$relationships = $this->getRelationships();
    	$count = 0;
    	
    	foreach ($relationships as $rel)
    	{
    		$table = false;
    		
    		if ($rel['lhs_table'] == $this->_tbl)
    		{
    			$key = $rel['join_key_lhs'];
    			$table = $rel['join_table'];
    		}
    		if ($rel['rhs_table'] == $this->_tbl)
    		{
    			$key = $rel['join_key_rhs'];
    			$table = $rel['join_table'];
    		}
    		
    		if ($table)
    		{
    			//query to delete THIS record
		    	$query = "DELETE FROM `".$table."` "
		    			." WHERE `".$key."` = '".$this->id."';";
		    			
		    	if ($this->_db->query( $query, false, '' ))
		    	{
		    		$count++;
		    	}
		    	
    		}
    		
    	}
    	
    	return $count;
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
	 * Returns a property of the object or the default value if the property is not set.
	 *
	 * @access	public
	 * @param	string $property The name of the property
	 * @param	mixed  $default The default value
	 * @return	mixed The value of the property
	 * @see		getProperties()
	 * @since	1.5
 	 */
	function get($property, $default=null)
	{
		if(isset($this->$property)) {
			return $this->$property;
		}
		return $default;
	}
	
	/**
     * Get the Database name
     * 
     * Method will return the name of the database to use.
     * 
     * @return string
     */
    function _getDBN()
    {
    	//cake uses DB_CONNECTION_CONFIG
    	if (defined('DB_CONNECTION_CONFIG'))
    	{
    		$config = new DB_CONNECTION_CONFIG('default');
			return $config->database;
    	}
    	elseif (strlen(trim($this->_db->_db_name))>0)
    	{
    		return $this->_db->_db_name;
    	}
    	else
    	{
    		return $GLOBALS['sugar_config']['dbconfig']['db_name'];
    	}
    }
    
    /**
     * Get the Childs Method name
     * 
     * Method will determine the childs method name and return it
     * 
     * @param string $child
     * @return boolean
     */
    function _getChildMethod( $child = null )
    {
    	//initializing variables
    	static $methods;
    	$child = strtolower(str_replace('ven_', '', trim($child) ));
    	$length = strlen($child);
    	
    	if (!isset($methods))
    	{
    		$methods = array();
    		foreach (get_class_methods('eFactory') as $method)
    		{
    			if (strlen(trim($method))< 1) continue;
    			$methods[strtolower($method)] = (string)trim($method);
    		}
    	}
    	
    	//check it straight
    	$method = 'get'.$child;
    	if (isset($methods[$method])) return $methods[$method];
    	
    	//check without the S
    	$method = 'get'.substr($child, 0, $length-1 );
    	if (isset($methods[$method])) return $methods[$method];
    	
    	//check with the S
    	$method = 'get'.$child.'s';
    	if (isset($methods[$method])) return $methods[$method];
    	
    	return false;
    }
    
    /**
     * Get the childs class name
     * 
     * Method will determine the name of the childs class and return it
     * 
     * @param string $child
     * @return string
     */
    private function _getChildClass( $child = null )
    {
    	//initiailizing variables
    	static $classes;
	 	$method = $this->_getChildMethod( $child );
    	$child = strtolower($child);
	 	$length = strlen($child);
    	
	 	if (!isset($classes))
    	{
    		//loading resources
    		eFactory::$method();
    		
    		$classes = array();
    		foreach (get_declared_classes() as $class)
    		{
    			$lower = strtolower($class);
    			if (substr($lower,-5) != 'model') continue;
    			
    			$classes[$lower] = $class;
    		}
    		
    	}
    	
    	//check it straight
    	$class = $child.'model';
    	if (isset($classes[$class])) return $classes[$class];
    	
    	//check without the S
    	$class = substr($child, 0, $length-1 ).'model';
    	if (isset($classes[$class])) return $classes[$class];
    	
    	//check with the S
    	$class = $child.'smodel';
    	if (isset($classes[$class])) return $classes[$class];
    	
    	return false;
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
    	$child = strtolower(trim($child));
    	$length = strlen($child);
    	
    	if (is_null($model))
    	{
    		$model = $this;
    	}
    	
    	$properties = array();
    	foreach($model->getProperties() as $property => $null)
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
	 * Get Billing Address
	 * 
	 * Method will return the billing address of the order
	 * 
	 * @return object
	 */
	function getBillingAddress()
	{
		//loading resources
		$addresses =& $this->getOneToMany('ven_Addresses');
		$empty =& eFactory::getAddress();
		
		//reasons to fail
		if (empty($addresses)) return $empty;
		
		//initializing variables
		$billing_addresses = array();
		
		
		//getting all the billing addresses
		foreach ($addresses as $id => $address)
		{
			if (!$address->isBilling()) continue;
			$billing_addresses[$id] = $address;
		}
		if (empty($billing_addresses)) return $address;
		
		//seeing if one is the primary
		foreach ($billing_addresses as $address)
		{
			if (!$address->isPrimary()) continue;
			return $address;
		}
		
		//return one if all else failed
		$address = $this->getPrimaryAddress();
		return $address;
	}
	
	/**
     * Get Records Emails
     * 
     * Method will locate all of the emails associated with this record and return 
     * then as an array
     * 
     * @return array
     */
    function getEmails()
    {
    	//building the query
    	$query = "SELECT *, `bean`.`id` AS `rel_id` FROM `email_addr_bean_rel` AS `bean`"
    			." LEFT JOIN `email_addresses` AS `addr` "
    			." ON `addr`.`id` = `bean`.`email_address_id`"
    			." WHERE `bean_id` = '".$this->id."';";
	 	
    	$results = $this->query($query);
	   	
	 	//failed to locate any records
	 	if (empty($results)) return false;
	 	
	 	return $results;
    }
    
    /**
     * Get Primary Email
     * 
     * Method will try and locate the primary email for this record,
     * if unsuccessful, then the method will return the first email 
     * in the array
     * 
     * @return string
     */
    function getEmail()
    {
    	//loading resources
    	$emails = $this->getEmails();
    	
    	//failed to locate anything
    	if (empty($emails)) return false;
    	
    	foreach ($emails as $email)
    	{
    		if ($email['primary_address'])
    		{
    			$return = $email['email_address'];
    			break;
    		}
    	}
    	
    	
    	return $return;
    }
    
    /**
     * Get Model Errors
     * 
     * Method will return a false if the error array is empty or will return 
     * the error messages.
     * 
     * @return string
     */
    function getErrors()
    {
    	//reasons to fail
    	if (!isset($this->_errorMsgs)) return false;
    	if (empty($this->_errorMsgs)) return false;
    	
    	return $this->_errorMsgs;
    }
    
    /**
	 * returns a list of all the items
	 * 
	 * @access public
	 * @return array
	 */
	function getList() 
	{
		//initializing variables
		$results = array();
		$query 	= "SELECT * FROM ".$this->_tbl;
		$class = strtolower(str_replace('Table','', get_class($this)));
		
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
	 * Get One Column 
	 * 
	 * Method returns a single db table column
	 * 
	 * @param $query
	 * @return string
	 */
	function getOne( $query )
	{
		return $this->_db->getOne( $query );
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
    	
    	//which reports to collect
    	$deleted = "AND deleted = 0";
    	if (isset($options['deleted']) && $options['deleted'] === true)
    	{
    		$deleted = "";
    	}
    	
    	//getting the relationship fields
    	$this->getRelationship( $child, &$joinTable, &$parentColumnName, &$childColumnName );
    	
    	//getting the package bean
	 	$query = " SELECT `".$childColumnName."` AS `child_id` "
	 			." FROM `".$joinTable."`"
	 			." WHERE `".$parentColumnName."` = '".$this->id."' ".$deleted
	 			." ORDER BY `date_modified` DESC;";
	 	
	 	$this->_db->setQuery($query);
		$child_id = $this->_db->loadAssocList();
	 	
	 	
	 	//reasons to return
	 	if (!$child_id) return false;
	 	
	 	foreach ($child_id as $id)
	 	{
	 		$instance = JTable::getInstance( $child, 'Table' );
	 		
	 		//check to make sure the object is legit
	 		if (!method_exists($instance, 'check') || !$instance->check()) continue;
	 		
	 		$instance->load($id['child_id']);
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
	    
	    return $instance;
    }
	
    /**
	 * Get Primary Address
	 * 
	 * Method will return the billing address of the order
	 * 
	 * @return object
	 */
	function getPrimaryAddress()
	{
		//loading resources
		$addresses =& $this->getOneToMany('ven_Addresses');
		$empty =& eFactory::getAddress();
		
		//reasons to fail
		if (empty($addresses)) return $empty;
		
		//initializing variables
		$primary_addresses = array();
		
		
		//getting all the billing addresses
		foreach ($addresses as $id => $address)
		{
			if (!$address->isPrimary()) continue;
			$primary_addresses[$id] = $address;
		}
		if (empty($primary_addresses)) return $empty;
		
		//return one if all else failed
		$address = current($primary_addresses);
		return $address;
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
	function getProperties( $public = true )
	{
		//initializing variables
		$ignore = array('processed_dates_times','fetched_row','list_fields','field_defs'
		,'field_name_map','db','column_fields','new_schema','_errorMsgs','dbManager'
		,'custom_fields');
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
    	$parent = $this->_tbl;
    	
    	if (!isset($relationships))
    	{
    		$relationships = array();
    		foreach($this->getRelationships() as $name => $link)
    		{
    			$relationships[$link['lhs_table']][$link['rhs_table']] = $name;
    			$relationships[$link['rhs_table']][$link['lhs_table']] = $name;
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
    	//initializing variables
    	static $relationships;
    	
    	if (!isset($relationships))
    	{
    		//initializing variables
    		$path = EBOOK_JOOMLA.DS.'database'.DS.'relationships.php';
    		
    		if (is_file($path)) require_once $path;
    		
    		//initializing variables
    		global $relationships;
	    	
    		//reasons to return
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
     * Get Siblings
     * 
     * Method is designed to search through all of the past reports and remove any reports
     * that are associate with the same order and same product.
     * 
     * @return boolean
     */
    function getSiblings( $options = null )
    {
    	//make sure that the required porperties exist
    	if (!$this->parentObject) return false;
    	if (!$this->object_name) return false;
    	
    	//load the parent and then the siblings
    	$parent =& $this->getOneToOne( $this->parentObject, $options );
    	if (!is_object($parent)) return false;
    	$siblings =& $parent->getOnetoMany( $this->object_name, $options );
    	
    	//unset the current record
    	unset($siblings[$this->id]);
    	
    	//fail if there are no reports
    	if (empty($siblings)) return false;
    	
    	return $siblings;
    }
    
    /**
	 * Is this property set?
	 * 
	 * Method will check the value for 
	 * 
	 * @param $property
	 * @return boolean
	 */
	function _isset( $property = null )
	{
		if (strlen(trim($this->$property)) > 0)
			return true;
		return false;
	}
    
    /**
     * Method builds this model based on a contact's id
     * 
     * @param integer $user_id
     * @return boolean
     */
    function load( $id = null )
    {
    	//reasons to fail
    	if (is_null($id) || !$id) return false;
    	if (!is_string($id)) return false;
    	
    	//initializing variables
		$id = addslashes($id);
		
	 	//Get the Contacts information
		$query = "SELECT * "
				." FROM `".$this->_tbl."`"
				." WHERE `id` = '$id'";
		
		$this->_db->setQuery( $query );
		$result = $this->_db->loadAssoc( );
		
		if (!$result) return false;
		
		$this->bind( $result );
		
		//loading any custom properties
		$this->loadCustomProperties();
		return true;
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
     * Load the custom properties
     * 
     * Method will load all of the custom properties from the sugar db table
     * and append them to the current object
     * 
     * @return boolean
     */
    function loadCustomProperties()
    {
    	//initializing variables
    	$properties = array();
    	$query = "SELECT * FROM `".$this->_tbl."_cstm`"
    			." WHERE `id_c` = '".$this->id."'";
		
    	$results = $this->query( $query );
		
		//reasons to return
		if (!$results) return false;
		
		foreach ($results[0] as $property => $value)
		{
			$properties['_'.$property] = $value;
		}
		//binds these properties to the current object
		$this->setProperties($properties);
		return true;
    }
    
    /**
     * Mark as deleted
     * 
     * Method will mark this record as deleted, not deleting it permanently.
     * 
     * @return boolean
     */
    function mark_deleted()
    {
    	if ($result = parent::mark_deleted( $this->id ))
    	{
    		$this->delete_linked();
    	}
    	return $result;
    }
    
    /**
     * Mark as un-deleted
     * 
     * Method will mark this record as not deleted, restoring it to view.
     * 
     * @return boolean
     */
    function mark_undeleted()
    {
    	$result = parent::mark_undeleted( $this->id );
    	return $result;
    }
    
    /**
     * Get the Name
     * 
     * Making this the standard method to get the name of the current record
     * 
     * @return string
     */
    function name()
    {
    	return $this->name;
    }
    
    /**
     * Purge Relationships
     * 
     * Method deletes duplicate relationships 
     * 
     * @param $child
     * @return boolean
     */
    function purgeRelationships($child)
    {
    	//loading resources
    	$this->getRelationship( $child, &$joinTable, &$parentColumnName, &$childColumnName, &$link );
    	
    	//Delete any exact duplicate link entries
    	$query = "DELETE FROM `".$joinTable."` "
    			." WHERE `".$parentColumnName."` = '".$this->id."';";
    	
		if ($this->query( $query ))
			return true;
		return false;
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
				$result =  $this->_db->query( );
				return $result;
				break;
		}
		return false;
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
    	if ( !$this->isNew() ) return $this->_update( $properties );
    	
    	//initializing variables
    	$id = create_guid();
    	
    	//building the query
    	$query = "INSERT INTO `".$this->_tbl."_cstm`"
    			." (`".implode( "`,`", $properties )."`) VALUES (";
		
    	//Saving the class property values
    	foreach ($properties as $property => $value)
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
    			default: $query .= "'".$value."'"; break;
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
     * Saves the properties to the database
     * 
     */
    function save( $force = false )
    {
    	//Build the query ourselves
    	if ($force)
    	{
    		$this->id = $this->_save();
    		return $this->id;
    	}
    	if (!$this->store()) 
    	{
    		return false;
		}
		
		//saving custom proeprties
		$this->saveCustomProperties();
		
    	return $this->id;
    }
    
    /**
	 * Save the Custom Properties
	 * 
	 */
	function saveCustomProperties()
	{
		//initializing variables
		$properties = $this->getProperties( false );
		$custom = array();
		
		foreach ($properties as $property => $value)
    	{
    		//initializing variables
    		$last = substr($property,-2);
    		$new = substr($property,1);
    		
    		if ( $last == '_c' )
    		{
    			$custom[$new] = $value;
    		}
    	}
    	
    	$this->_save( $custom );
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
    	if ( $this->isNew() ) return false;
    	
    	//intialiazing variables
    	$date =& JFactory::getDate();
    	$date_modified = $date->toMysql();
    	$id = create_guid();
    	
	 	//making sure that the relationship id property exists for this object
    	if (!($child_id = $this->_getChildIdProperty( $child ))) return false;
    	
    	$this->getRelationship( $child, &$joinTable, &$parentColumnName, &$childColumnName );
	 	if ( strlen(trim($child_id)) <1 ) return false;
	 	
    	//building the query
    	$query = "INSERT INTO `".$joinTable."`"
	 			." (`id`,`date_modified`,`deleted`,`".$parentColumnName."`,`".$childColumnName."`) VALUES "
	 			." ('".$id."','".$date_modified."','0','".$this->id."','".$this->$child_id."');";
	 	
	 	$this->purgeRelationships( $child );
    	$this->query( $query );
    	
    	return $id;
    }
    
    /**
     * Save This Physical Address
     * 
     * Method will save this address as an association to the parent record
     * 
     * @param $address
     * @return boolean
     */
    function saveAddress( $address = null )
    {
    	//reasons to fail
    	if (is_null($this->id)) return false;
    	if (is_null($address)) return false;
    	
    	//loading resources
    	$object =& eFactory::getAddress( $address );
    	
    	//making sure that the relationship id property exists for this object
    	if ($child_id = $object->_getChildIdProperty( $this->object_name ))
    	{
    		$object->$child_id = $this->id;
    	}
    	
    	$object->setName();
    	
    	if ($object->isValid())
    	{
    		$id = $object->save();
    		return $id;
    	}
    	
		return false;
    }
    
    /**
     * Save This Email Address
     * 
     * Method will save this email address as an association to the parent record
     * 
     * @param $email
     * @return boolean
     */
    function saveEmail( $email = null )
    {
    	//reasons to fail
    	if (is_null($email)) return false;
    	if (is_null($this->id)) return false;
    	
    	//loading resources
    	$object =& eFactory::getEmailAddress( (string)$email );
    	
    	//setting class properties
    	$object->parent_id = $this->id;
		$object->parent_type = $this->module_dir;
		$object->setEmail( $email );
		
		$email_id = $object->save();
    	
		return $email_id;
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
     * Set Error
     * 
     * Method records all of the errors that this table model has encoutered.
     * 
     * @param $error
     */
    function setError( $error = "" )
    {
    	//reasons to fail
    	if (trim($error) == "") return false;
    	
    	//initializing variables
    	if (!isset($this->_errorMsgs))
    	{
    		$this->_errorMsgs = array();
    	}
    	
    	$this->_errorMsgs[] = $error;
    	
    	return true;
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
	 * Set the status property and save it
	 * 
	 * Method sets the status property and then saves it immediately
	 * 
	 * @param string $status
	 * @return boolean
	 */
	function setStatus( $status )
    {
    	//status_id :special status property for documents
    	//status :standard status property for all other objects
    	if (!isset($this->status_id) && !isset($this->status)) return false;
    	
    	if (isset($this->status))
    	{
    		$property = 'status';
    	}
    	else
    	{
    		$property = 'status_id';
    	}
    	
    	$this->$property = $status;
    	
    	//building the query
    	$query = "UPDATE `".$this->_tbl."`"
	 			." SET `".$property."` = '".$this->$property."'"
	 			." WHERE `id` = '".$this->id."'";
	 	
	 	return $this->_db->query( $query );
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
    	$query = "UPDATE `".$this->_tbl."_cstm`"
    			." SET ";
    	
    	//Updating the class property values
	 	foreach ($properties as $property => $value)
    	{
    		if ($property == 'id') continue;
    		
    		//Making sure that system properties are also set
    		switch($property)
    		{
    			case 'id_c': break;
    			case 'date_created': break;
    			case 'date_modified': 
    				$date =& eFactory::getDate( time() );
    				$query .=" `date_modified` = '".$date->toMySQL()."',";
    				break;
    			default: $query .=" `".$property."` = '".$value."',"; break;
    		}
    		
    	}
    	$query = substr($query,0,strlen($query)-1);
	 	$query .=" WHERE `id_c` = '".$this->id."';";
	 	
	 	
	 	if ($this->query( $query ))
	 	{
	 		return $this->id;
	 	}
	 	return false;
    }
	
	
}

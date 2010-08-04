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
class TableByrdlist_categories extends ResTable
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
	 * @var int
	 */
	var $parent_id		= null;

	/**
	 * 
	 *
	 * @var string
	 */
	var $name			= null;

	/**
	 * 
	 *
	 * @var string
	 */
	var $slug			= null;

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
	var $published		= null;
	
	/**
	 * 
	 *
	 * @var string
	 */
	var $_images_id		= null;
	
	
	/**
	 * @param database A database connector object
	 */
	function __construct( &$db )
	{
		parent::__construct( '#__byrdlist_categories', 'id', $db );
	}

	/**
	 * 
	 */
	function Check()
	{
		return true;
	}

	/**
	 * Return the parent name
	 * 
	 */
	function setSlug()
	{
		//reasons to return
		if ( strlen(trim($this->slug)) >0 ) return false;
		
		//loading libraries
		require_once EBOOK_EVERY.DS.'utilities'.DS.'slug.php';
		
		$this->slug = create_slug( $this->name() );
		
    	return $this->slug();
	}

	/**
	 * Return the parent name
	 * 
	 */
	function parent_name()
	{
		//loading resources
		$record =& JTable::getInstance('byrdlist_categories', 'Table');
    	$record->load( $this->parent_id );
		
    	return $record->name();
	}

	/**
	 * 
	 */
	function store()
	{
		//initializing object properties
		$this->setSlug();
		
		if ($id = parent::store())
		{
			$this->saveRelationship('byrdlist_images');
			return $id;
		}
		return false;
	}
}

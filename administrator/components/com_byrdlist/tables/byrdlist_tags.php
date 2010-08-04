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
class TableByrdlist_tags extends ResTable
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
	 * @var string
	 */
	var $published		= null;

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
	var $_listings_id		= null;

	
	/**
	 * @param database A database connector object
	 */
	function __construct( &$db )
	{
		parent::__construct( '#__byrdlist_tags', 'id', $db );
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

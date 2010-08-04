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
class TableByrdlist_websites extends ResTable
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
	var $description	= null;

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
	var $type			= null;

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
	var $homepage		= null;

	/**
	 * 
	 *
	 * @var string
	 */
	var $_jusers_id		= null;



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
			$class = ucfirst($type).'Webpage';
			$path = EBOOK_EVERY.DS.'webpage_types'.DS.$type.'.php';
			
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
	 * @param database A database connector object
	 */
	function __construct( &$db )
	{
		parent::__construct( '#__byrdlist_websites', 'id', $db );
	}

	/**
	 * 
	 */
	function Check()
	{
		return true;
	}
	
	/**
	 * Name.
	 * 
	 */
	public function name()
	{
		return ucwords(strtolower($this->name));
	}
	
	/**
	 * Description
	 * 
	 */
	public function description( $substr = false )
	{
		//initializing variables
		$desc = $this->description;
		
		if ($substr) $desc = substr($desc, 0, $substr);
		
		return $desc;
	}
	
	/**
	 * Return an html thumbnail
	 * 
	 */
	public function getHtmlThumbnail( $width = 100 )
	{
		$src = '';
		
		//initializing variables
		$html = '<img border="0" src="'.$src.'" width="'.$width.'" class="image-left" />';
		
		return "";
	}
	
	/**
	 * 
	 */
	public function getWebpages()
	{
		//loading resources
		$user =& $this->getOneToOne('juser');
		$records = $user->getWebpages();
		
		//reasons to fail
		if (!$records) return false;
		
		return $records;
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

	/**
	 * 
	 */
	function store()
	{
		if ($id = parent::store())
		{
			//$this->saveRelationship('byrdlist_listings');
			return $id;
		}
		return false;
	}
}

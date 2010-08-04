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
class TableByrdlist_images extends ResTable
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
	var $ext			= null;

	/**
	 * 
	 *
	 * @var string
	 */
	var $file_name		= null;

	/**
	 * 
	 *
	 * @var bool
	 */
	var $thumbnail		= null;

	/**
	 * 
	 *
	 * @var string
	 */
	var $_categories_id	= null;

	/**
	 * 
	 *
	 * @var string
	 */
	var $_listings_id	= null;

	/**
	 * 
	 *
	 * @var string
	 */
	var $_websites_id	= null;

	
	/**
	 * @param database A database connector object
	 */
	function __construct( &$db )
	{
		parent::__construct( '#__byrdlist_images', 'id', $db );
	}

	/**
	 * 
	 */
	function Check()
	{
		return true;
	}
	
	/**
	 * Delete the file too
	 */
	public function delete()
	{
		//initializing variables
		$path = $this->file( false );
		
		//reasons to fail
		if ( file_exists($path) )
		{
			unlink($path);
		}
		
		return parent::delete();
	}

	/**
	 * 
	 */
	function file( $http = true )
	{
		//initializing variables
		$path = EBOOK_IMAGES.DS.$this->id().'.'.$this->ext();;
		
		//reasons to return
		if (!file_exists($path)) return false;
		
		if ($http) $path = str_replace(JPATH_BASE, '', $path);
		
		return $path;
	}
	
	/**
	 * Get the parent of this image
	 * 
	 */
	public function &getParent()
	{
		//loading resources
		$listing =& $this->getOneToOne('byrdlist_listings');
		$webpage =& $this->getOneToOne('byrdlist_websites');
		$category =& $this->getOneToOne('byrdlist_categories');
		
		if (!$listing->isNew()) return $listing;
		if (!$webpage->isNew()) return $webpage;
		if (!$category->isNew()) return $category;
		
		return false;
	}

	/**
	 * 
	 */
	function listing_id()
	{
		//loading resources
		$listing =& $this->getOneToOne('byrdlist_listings');
		
		return $listing->id();
	}

	/**
	 * 
	 */
	function listing_name()
	{
		//loading resources
		$listing =& $this->getOneToOne('byrdlist_listings');
		
		return $listing->name();
	}
	
	/**
	 * 
	 */
	public function isThumbnail()
	{
		//loading resources
		$listing =& $this->getParent();
		$image = $listing->thumbnail();
		
		//reasosn to fail
		if (!$image) return false;
		
		if ($this->id() == $image->id())
		{
			$this->thumbnail = 1;
			$this->store();
			return true;
		}
		return false;
	}
	
	/**
	 * Save the Posted File
	 * 
	 */
	protected function saveFile()
	{
		//initializing variables
		$allowed_ext = array('jpg','jpeg','gif','png','bmp');
		$maxlimit = 9999999999;
		
		//loading resources
		$data = JRequest::getVar('file_name', null, 'files');
		$parts = pathinfo($data['name']);
		
		//initializing file variables
		$new_name = $this->id();
		$filesize = $data['size'];
		$file_ext = $parts['extension'];
		
		$file_path = JPath::clean( EBOOK_IMAGES.DS.$new_name.'.'.$file_ext );
		
		
		//reasons to fail
		if ( empty($_FILES) ) return false;
		if ( !in_array($file_ext, $allowed_ext) ) return false;
		if ( $filesize < 1 ) return false;
		if ( $filesize > $maxlimit ) return false;
		
		if(move_uploaded_file($data['tmp_name'], $file_path)) 
		{
			return true;
		}
		return false;
	}
	
	/**
	 * Set the extension
	 * 
	 */
	protected function setExt()
	{
		//initializing variables
		$data = JRequest::getVar('file_name', null, 'files');
		
		//reasons to fail
		if (empty($_FILES)) return false;
		
		$parts = pathinfo($data['name']);
		$this->ext = $parts['extension'];
		return true;
	}
	
	/**
	 * Set this as the thumnail
	 * 
	 * Unsets the other thumbnail and then sets this one as the thumbnail
	 * 
	 */
	public function setThumbnail()
	{
		//loading resources
		$listing =& $this->getOneToOne('byrdlist_listings');
		$image = $listing->thumbnail();
		
		$image->thumbnail = 0;
		$image->store();
		
		$this->thumbnail = 1;
		$this->store();
		return true;
	}
	
	public function isPdfValid()
	{
		//reasons to fail
		if ($this->ext == 'bmp') return false;
		
		return true;
	}

	/**
	 * 
	 */
	function store()
	{
		//initializing object properties
		$this->setExt();
		
		if ($id = parent::store())
		{
			$this->saveRelationship('byrdlist_listings');
			$this->saveRelationship('byrdlist_categories');
			$this->saveRelationship('byrdlist_websites');
			$this->saveFile();
			
			if (!$this->valid())
			{
				$this->delete();
				$this->setError("ERROR: Could not save image.");
				return false;
			}
			
			return $id;
		}
		return false;
	}
	
	
	public function valid()
	{
		//initializing variables
		$path = $this->file( false );
		
		//reasons to fail
		if ( !file_exists($path) ) return false;
		if ( !($contents = @file_get_contents($path)) ) return false;
		if ( strlen(trim($contents)) <1 ) return false;
		
		return true;
	}
	
}

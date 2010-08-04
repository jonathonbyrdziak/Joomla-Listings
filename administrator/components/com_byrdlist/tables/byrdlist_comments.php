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
class TableByrdlist_comments extends ResTable
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
	 * @var blob
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
	var $parent_id		= null;

	/**
	 * 
	 *
	 * @var string
	 */
	var $awarded		= null;

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
	var $_ratings_id	= null;

	/**
	 * 
	 *
	 * @var string
	 */
	var $_helpful_id		= null;

	
	/**
	 * @param database A database connector object
	 */
	function __construct( &$db )
	{
		parent::__construct( '#__byrdlist_comments', 'id', $db );
	}

	/**
	 * 
	 */
	function Check()
	{
		return true;
	}
	
	/**
	 * Get the child comments
	 * 
	 * This method should return the comments in proper order
	 * 
	 * @return array of objects
	 */
	public function getChildComments()
	{
		//loading resources
		$listing =& $this->getOneToOne('byrdlist_listings');
		$comments = $listing->getOneToMany('byrdlist_comments');
		$comments = ByrdHelper::sort_object($comments, 'created_on', false);
		
		//reasons to return
		if (empty($comments)) return false;
		
		//initializing variables
		$new = array();
		
		foreach ($comments as $id => $instance)
		{
			//skip if its a child of something else
			if ($instance->parent_id() != $this->id()) continue;
			if (!$instance->published()) continue;
			
			//initializing variables
			$instance->_comments_children = $this->_comments_children + 1;
			$new[$id] = $instance;
			$children = $instance->getChildComments();
			
			//reasons to continue
			if (!$children) continue;
			
			foreach ($children as $id => $instance)
			{
				//initializing variables
				$new[$id] = $instance;
			}
		}
		
		return $new;
	}

	/**
	 * Helpful count
	 * 
	 */
	function helpful()
	{
		//loading resources
		$count = $this->countRelationships('helpful');
		
		return $count;
	}

	/**
	 * 
	 */
	function helpful_no()
	{
		//loading resources
		$count = $this->countRelationships('helpful_no');
		
		return $count;
	}

	/**
	 * 
	 */
	function helpful_total()
	{
		//loading resources
		$total = $this->helpful() + $this->helpful_no();
		
		return $total;
	}
	
	/**
	 * Determines if this is awarded
	 * 
	 */
	public function isAwarded()
	{
		if ($this->awarded)
			return true;
		return false;
	}

	/**
	 * 
	 */
	function load( $id = null, $options = null )
	{
		$result = parent::load( $id, $options );
		
		//initializing object properties
		$this->markHelpful();
		
		return $result;
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
	 * Mark this comment as helpful or otherwise
	 * 
	 * @return boolean
	 */
	function markHelpful()
	{
		//initializing variables
		$helpful = JRequest::getVar('helpful', false);
		$helpful_no = JRequest::getVar('helpful_no', false);
		
		//loading resources
		$user =& eFactory::getUser();
		
		//reasons to return
		if (!$helpful && !$helpful_no) return false;
		if ($helpful != $this->id() && $helpful_no != $this->id()) return false;
		
		//reasons to return
		$this->countRelationships('helpful', $ids);
		if (in_array($user->id(), $ids)) return false;
		
		//reasons to return
		$this->countRelationships('helpful_no', $ids);
		if (in_array($user->id(), $ids)) return false;
		
		//populating object properties
		$this->_helpful_id = $user->id();
		$this->_helpful_no_id = $user->id();
		
		if ($helpful) $this->saveRelationship('helpful');
		if ($helpful_no) $this->saveRelationship('helpful_no');
		
		return true;
	}
	
	/**
	 * The name of the parent comment
	 * 
	 */
	public function parent_name()
	{
		//reasons to return
		if ( strlen(trim($this->parent_id())) <1 ) return false;
		
		//loading resources
		$instance = JTable::getInstance('byrdlist_comments', 'Table' );
		$instance->load($this->parent_id);
		
		return $instance->name();
	}

	/**
	 * The rating Number
	 */
	function rating()
	{
		//loading resources
		$listing =& $this->getOneToOne('byrdlist_ratings');
		
		return $listing->rating();
	}
	
	/**
	 * Set this as awarded
	 * 
	 * Unsets any others and then sets itself
	 * 
	 */
	public function setAwarded()
	{
		//loading resources
		$listing =& $this->getOneToOne('byrdlist_listings');
		$awarded =& $listing->getAwarded();
		$owner = eFactory::getUser( $listing->author_id()  );
		
		$author = eFactory::getUser( $this->author_id() );
		
		if ($awarded && !$awarded->isNew())
		{
			$awarded->awarded = 0;
			$awarded->store();
		}
		
		$this->awarded =1;
		$this->store();
		
		require_once EBOOK_HELPERS.DS.'mailer.php';
		
		if ($listing->type() == 'donation')
		{
			BMailer::donationAwarded_Owner( $owner, $listing, $author );
			BMailer::donationAwarded_Requester( $author, $listing );
		}
		else
		{
			BMailer::needAwarded_Owner( $owner, $listing, $author );
			BMailer::needAwarded_Requester( $author, $listing );
		}
		
		return true;
	}

	/**
	 * Save this record
	 * 
	 */
	function store()
	{
		
		if ($id = parent::store())
		{
			$this->saveRelationship('byrdlist_listings');
			$this->saveRelationship('byrdlist_ratings');
			return $id;
		}
		return false;
	}
	
}

<?php
/**
 * Joomla! 1.5 component Every Booking
 *
 * @author Jonathon Byrd
 * @package Joomla
 * @subpackage everybooking
 * @license Proprietary software, closed source, All rights reserved November 2009 Every Booking Inc.
 * For more information please see http://www.everybooking.com
 * 
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
 * everybooking Helper
 *
 * @package Joomla
 * @subpackage everybooking
 * @since 1.5
 */
class eHelper 
{
	/**
	 * Loops through the authorization array
	 * 
	 */
	public function loop( $array = null )
	{
		//reasons to fail
		if (is_null($array)) return false;
		if (!is_array($array)) return false;
		
		//Populating class properties
		$user =& JFactory::getUser();
		if($user->guest) $user->usertype = 'Public';
			
		
		foreach ($array as $group => $pages)
		{
			foreach ($pages as $page)
			{
				//reasons to continue
				if ( strlen(trim($group)) <1 ) continue;
				if ( strlen(trim($page)) <1 ) continue;
				
				eHelper::eb_acl( $page, $group );
			}
			
		}
		
		return true;
	}
	
	/**
	 * Sets the parent groups with the same acl
	 * 
	 * @param $location
	 * @param $toplevel
	 * @return true
	 */
	function eb_acl( $location, $lowerlevel ){
		
		// set it once so that we dont have to keep doing this
		static $acl = null;
		if (is_null($acl))
		{ 
			$acl =& JFactory::getACL(); 
		}
		
		//set acl for public access
		if($lowerlevel == 'Public')
		{
			$acl->_mos_add_acl( EBOOK_COMPONENT, $location, 'users', 'Public' );
		}
		
		//we set all of the parent groups to this same value
		$AROs = array_reverse($acl->get_group_children_tree());
		
		//looping through all of the group types
		foreach($AROs as $ARO){
			
			//getting the group names
			$gname = $acl->get_group_name($ARO->value);
			
			//some groups dont count
			if($gname == 'ROOT' || $gname == 'USERS' 
			|| $gname == 'Public Frontend' 
			|| $gname == 'Public Backend') continue;
			
			//setting it as an acl
			$acl->_mos_add_acl( EBOOK_COMPONENT, $location, 'users', $gname );
			
			//quit if we're at the highest that we want to go
			if ($lowerlevel == $gname) break;
			
		}
		
		return true;
	}
	
	
}
?>
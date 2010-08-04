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

class eFactory extends JObject
{
	
	/**
	 * Returns the resdesk session object
	 * 
	 * @param $config
	 * @return Object
	 */
	public static function &getResSession()
	{
		static $instance =null;
		
		if (is_null($instance))
		{
			//requiring the class file
			require_once EBOOK_EVERY.DS.'inputs'.DS.'resdesk_session.php';
			
			//request the instance
			$instance = new bookingSession();
		}

		return $instance;
	}
	
	/**
	 * Get an user object
	 * 
	 * The Reservation system is highjacking the joomla user object in order to enhance and
	 * customize it.
	 * 
	 * Returns a reference to the global {@link JUser} object, only creating it
	 * if it doesn't already exist.
	 *
	 * @param 	int 	$id 	The user to load - Can be an integer or string - If string, it is converted to ID automatically.
	 *
	 * @access public
	 * @return object JUser
	 */
	public static function &getUser( $id = null )
	{
		//loading libraries
		jimport('joomla.user.user');
		require_once EBOOK_JOOMLA.DS.'user'.DS.'user.php';

		if(is_null($id))
		{
			$session  =& JFactory::getSession();
			$instance =& $session->get('user');
			
			if (is_a($instance, 'JUser')) 
			{
				$instance =& ResUser::getInstance( $instance->id );
			}
			elseif (!is_a($instance, 'ResUser')) 
			{
				$instance =& ResUser::getInstance();
			}
		}
		else
		{
			$instance =& ResUser::getInstance($id);
		}

		return $instance;
	}
}
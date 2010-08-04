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

class ResUser extends JUser
{
	/**
	 * Unique id
	 * @var int
	 */
	var $id				= null;

	/**
	 * The users real name (or nickname)
	 * @var string
	 */
	var $name			= null;

	/**
	 * The login name
	 * @var string
	 */
	var $username		= null;

	/**
	 * The email
	 * @var string
	 */
	var $email			= null;

	/**
	 * MD5 encrypted password
	 * @var string
	 */
	var $password		= null;

	/**
	 * Description
	 * @var string
	 */
	var $usertype		= null;

	/**
	 * Description
	 * @var int
	 */
	var $block			= null;

	/**
	 * Description
	 * @var datetime
	 */
	var $lastvisitDate	= null;

	/**
	 * Description
	 * @var boolean
	 */
	var $guest     = null;

	/**
	 * 
	 *
	 * @var int
	 */
	var $description = null;
	
	/**
	 * 
	 *
	 * @var int
	 */
	var $deleted = null;
	
	/**
	 * 
	 *
	 * @var int
	 */
	var $salutation = null;
	
	/**
	 * 
	 *
	 * @var int
	 */
	var $first_name = null;
	
	/**
	 * 
	 *
	 * @var int
	 */
	var $last_name = null;
	
	/**
	 * 
	 *
	 * @var int
	 */
	var $title = null;
	
	/**
	 * 
	 *
	 * @var int
	 */
	var $do_not_call = null;
	
	/**
	 * 
	 *
	 * @var int
	 */
	var $phone_home = null;
	
	/**
	 * 
	 *
	 * @var int
	 */
	var $phone_mobile = null;
	
	/**
	 * 
	 *
	 * @var int
	 */
	var $phone_work = null;
	
	/**
	 * 
	 *
	 * @var int
	 */
	var $phone_other = null;
	
	/**
	 * 
	 *
	 * @var int
	 */
	var $phone_fax = null;
	
	/**
	 * 
	 *
	 * @var int
	 */
	var $primary_address_street = null;
	
	/**
	 * 
	 *
	 * @var int
	 */
	var $primary_address_city = null;
	
	/**
	 * 
	 *
	 * @var int
	 */
	var $primary_address_state = null;
	
	/**
	 * 
	 *
	 * @var int
	 */
	var $primary_address_postalcode = null;
	
	/**
	 * 
	 *
	 * @var int
	 */
	var $primary_address_country = null;
	
	/**
	 * 
	 *
	 * @var int
	 */
	var $alt_address_street = null;
	
	/**
	 * 
	 *
	 * @var int
	 */
	var $alt_address_city = null;
	
	/**
	 * 
	 *
	 * @var int
	 */
	var $alt_address_state = null;
	
	/**
	 * 
	 *
	 * @var int
	 */
	var $alt_address_postalcode = null;
	
	/**
	 * 
	 *
	 * @var int
	 */
	var $alt_address_country = null;
	
	/**
	 * 
	 *
	 * @var int
	 */
	var $birthdate = null;
	
	/**
	 * ContactTable Object
	 * @var object
	 */
	var $_contact 	= null;

	
	/**
	 * Overriding method
	 */
	function __call( $property, $args )
	{
		return $this->get( $property );
	}
	
	/**
	* Constructor activating the default information of the language
	*
	* @access 	protected
	*/
	function __construct( $identifier = 0 )
	{
		parent::__construct($identifier);
	}

	/**
	 * Returns a reference to the global User object, only creating it if it
	 * doesn't already exist.
	 *
	 * This method must be invoked as:
	 * 		<pre>  $user =& JUser::getInstance($id);</pre>
	 *
	 * @access 	public
	 * @param 	int 	$id 	The user to load - Can be an integer or string - If string, it is converted to ID automatically.
	 * @return 	JUser  			The User object.
	 * @since 	1.5
	 */
	function &getInstance($id = 0)
	{
		static $instances;

		if (!isset ($instances)) {
			$instances = array ();
		}

		// Find the user id
		if(!is_numeric($id))
		{
			jimport('joomla.user.helper');
			if (!$id = JUserHelper::getUserId($id)) {
				JError::raiseWarning( 'SOME_ERROR_CODE', 'JUser::_load: User '.$id.' does not exist' );
				$retval = false;
				return $retval;
			}
		}

		if (empty($instances[$id])) {
			$user = new ResUser($id);
			$instances[$id] = $user;
		}

		return $instances[$id];
	}
	
	/**
	 * Is this a guest?
	 * 
	 */
	public function isGuest()
	{
		if ($this->guest == 1)
			return true;
		return false;
	}
	
	/**
	 * Is this a guest?
	 * 
	 */
	public function isNonProfit()
	{
		if ($this->gid == 31 || $this->gid == 32)
			return true;
		return false;
	}
	
	/**
	 * Is this a guest?
	 * 
	 */
	public function isVerified()
	{
		if ($this->gid == 32)
			return true;
		return false;
	}
	
	/**
	 * Is this a guest?
	 * 
	 */
	public function isDonor()
	{
		if ($this->gid == 33 || $this->gid == 34)
			return true;
		return false;
	}
	
	/**
	 * Is this a guest?
	 * 
	 */
	public function isBusiness()
	{
		if ($this->gid == 34)
			return true;
		return false;
	}
	
	/**
	 * Method to load a ResUser object by user id number
	 *
	 * @access 	public
	 * @param 	mixed 	$identifier The user id of the user to load
	 * @param 	string 	$path 		Path to a parameters xml file
	 * @return 	boolean 			True on success
	 * @since 1.5
	 */
	function load($id)
	{
		if (!parent::load( $id )) return false;
		
		//initializing variables
		$array =array(
			31 => 'NonProfit',
			32 => 'Verified',
			33 => 'Individual Donor',
			34 => 'Business Donor',
		);
		
		if (!$this->usertype)
		{
			$this->usertype = $array[$this->gid];
		}
		
		return true;
	}

	/**
	 * Name of the User
	 */
	function name()
	{
		return $this->name;
	}
	
	
}
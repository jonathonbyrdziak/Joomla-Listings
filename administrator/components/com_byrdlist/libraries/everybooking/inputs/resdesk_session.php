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

class bookingSession extends JObject 
{
	
	/**
	 * 
	 * @var: varchar(25)
	 */
	var $booking_type = null;
	
	/**
	 * 
	 * @var: varchar(25)
	 */
	var $addressid = false;
	
	/**
	 * 
	 * @var: int
	 */
	var $userid = null;
	
	/**
	 * 
	 * @var: date
	 */
	var $couponType = null;
	
	/**
	 * 
	 * @var: date
	 */
	var $couponSavings = null;
	
	/**
	 * 
	 * @var: date
	 */
	var $startdate = null;
	
	/**
	 * 
	 * @var: time
	 */
	var $starttime = null;
	
	/**
	 * 
	 * @var: date
	 */
	var $enddate = null;
	
	/**
	 * 
	 * @var: time
	 */
	var $endtime = null;
	
	/**
	 * 
	 * @var: int
	 */
	var $nights = null;
	
	/**
	 * 
	 * @var: int
	 */
	var $occ_adult = null;
	
	/**
	 * 
	 * @var: int
	 */
	var $occ_children = null;
	
	/**
	 * 
	 * @var: int
	 */
	var $RoomQty = null;
	
	/**
	 * 
	 * @var: varchar
	 */
	var $roomnumber = null;
	
	/**
	 * 
	 * @var: string
	 */
	var $RoomType = null;
	
	/**
	 * 
	 * @var: float
	 */
	var $RoomCost = null;
	
	/**
	 * 
	 * @var: float
	 */
	var $SubTotal = null;
	
	/**
	 * 
	 * @var: float
	 */
	var $GST = null;
	
	/**
	 * 
	 * @var: float
	 */
	var $PST = null;
	
	/**
	 * 
	 * @var: float
	 */
	var $amount = null;
	
	/**
	 * 
	 * @var: float
	 */
	var $Deposit = null;
	
	/**
	 * 
	 * @var: varchar
	 */
	var $name = null;
	
	/**
	 * 
	 * @var: float
	 */
	var $email = null;
	
	/**
	 * 
	 * @var: float
	 */
	var $phone = null;
	
	/**
	 * 
	 * @var: float
	 */
	var $street = null;
	
	/**
	 * 
	 * @var: float
	 */
	var $city = null;
	
	/**
	 * 
	 * @var: float
	 */
	var $state = null;
	
	/**
	 * 
	 * @var: float
	 */
	var $zip = null;
	
	/**
	 * 
	 * @var: float
	 */
	var $nameoncard = null;
	
	/**
	 * 
	 * @var: str
	 */
	var $cc_type = null;
	
	/**
	 * 
	 * @var: float
	 */
	var $number = null;
	
	/**
	 * 
	 * @var: float
	 */
	var $expire_month = null;
	
	/**
	 * 
	 * @var: float
	 */
	var $expire_year = null;
	
	/**
	 * 
	 * @var: float
	 */
	var $comment = null;
	
	/**
	 * 
	 * @var: float
	 */
	var $Terms = null;
	
	/**
	 * 
	 * @var: bool
	 */
	var $specialoffers = null;
	
	/**
	 * 
	 * @var: float
	 */
	var $GiftCard = null;
	
	
	/**
	 * Gets the resdesk session out of the Session and binds the post
	 * 
	 * @return unknown_type
	 */
	function __construct(){
		
		// loading the session
		$session =& JFactory::getSession();
		$this->setProperties( unserialize(base64_decode( $session->get('bookingSession') )) );
		$this->setProperties( JRequest::get('get') );
		$this->setProperties( JRequest::get('post') );
		
		//user info
		$user =& JFactory::getUser();
		$this->userid	 	= $user->get('id');
		
		
		//loading the defaults
		//$config =& JTable::getInstance('config', 'Table');
		if (!$this->startdate) $this->startdate 	= date('d-m-Y');
		//if (!$this->starttime) $this->starttime 	= $config->get('INDIVIDUAL_CHECKIN_TIME');
		if (!$this->enddate) $this->enddate 		= date('d-m-Y',strtotime(date('d-m-Y').' +1 day'));
		//if (!$this->endtime) $this->endtime 		= $config->get('INDIVIDUAL_CHECKOUT_TIME');
		
		//$this->GST	 		= $config->get('GST');
		//$this->PST	 		= $config->get('PST');
		
		register_shutdown_function(array($this,"destruct"));
	}
	
	/**
	 * Stores the resdesk session into the Session
	 * 
	 * @return unknown_type
	 */
	function destruct() {
		$session =& JFactory::getSession();
		$session->set( 'bookingSession', base64_encode (serialize ($this)) );
	}
	
	/**
	 * 
	 * @param $properties
	 * @param $back
	 * @return unknown_type
	 */
	function validate($properties, $layout){
		if (is_array($properties)){
			foreach ($properties as $property){
				if (is_null($this->$property)) $this->redirect($layout, $property.' was not been provided.');
			}
		}
	}
	
	/**
	 * 
	 * @param $properties
	 * @param $back
	 * @return unknown_type
	 */
	function clean(){
		$session =& JFactory::getSession();
		
		foreach ($session->getProperties() as $property){
			if (!is_null($this->$property)) $this->$property = null;
			
		}
	}
	
	/**
	 * used to go backwords in the checkout if session is missing values
	 * @param $layout
	 * @param $error
	 * @return unknown_type
	 */
	function redirect($layout, $error = ''){
		if ($error != '') $error = '&error='.$error;
		header('Location: '.DOTCOM.'index.php?option=com_everybooking&view=booking&layout='.$layout.$error);
	}
	
}
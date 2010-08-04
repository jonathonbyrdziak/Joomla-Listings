<?php
/**
 * Joomla! 1.5 component byrdlist
 *
 * @version $Id: byrdlist.php 2010-06-07 11:32:44 svn $
 * @author Jonathon Byrd
 * @package Joomla
 * @subpackage byrdlist
 * @license Copyright (c) 2010 - All Rights Reserved
 *
 * 
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

require_once EBOOK_JOOMLA.DS.'application'.DS.'component'.DS.'model.php';

/**
 * byrdlist Component byrdlist Model
 *
 * @author      notwebdesign
 * @package		Joomla
 * @subpackage	byrdlist
 * @since 1.5
 */
class ByrdlistModelMyaccount extends ResModel 
{
    /**
	 * Constructor.
	 * 
	 */
	function __construct() 
	{
		parent::__construct();
    }
    
    /**
	 * Get the Ipn Script
	 * 
	 */
	public function getIpnScript()
    {
    	//initializing variables
    	$path = dirname(__file__).DS."ipn.php";
    	
    	//reasons to fail
    	if (!file_exists($path)) return false;
    	require_once $path;
    	
    	//reasons to fail
    	if (!class_exists("ByrdIpn")) return false;
    	
    	$instance = new ByrdIpn();
    	
    	return $instance;
    }
    
    /**
     * Expired Auctions Cron Job
     * 
     */
    public function checkForExpiredAuctions()
    {
    	//loading resources
    	$instance =& JTable::getInstance('byrdlist_listings', 'Table');
    	
    	$instances = $instance->getList();
    	
    	//reasons to fail
    	if (empty($instances)) return false;
    	
    	foreach ($instances as $id => $instance)
    	{
    		//reasons to continue
    		$instance->finalizeListing();
    	}
    	
    }
    
}

<?php
/**
 * Joomla! 1.5 component reservation
 *
 * @version $Id: view.html.php 2010-06-02 12:34:25 svn $
 * @author 
 * @package Joomla
 * @subpackage reservation
 * @license Copyright (c) 2010 - All Rights Reserved
 *
 * 
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');


/**
 * HTML View class for the reservation component
 * 
 * 
 */
class ByrdlistViewMyaccount extends ResView 
{
	/**
	 * Display
	 *
	 */
	function display($tpl = null) 
	{
		parent::display($tpl);
    }
    
    /**
	 * Display
	 *
	 */
	protected function ipn_default()
    {
    	//loading resources
    	$model = $this->getModel();
    	$ipn = $model->getIpnScript();
    }
    
    /**
	 * Display
	 *
	 */
	protected function cron_default()
    {
    	//loading resources
    	$model = $this->getModel();
    	$model->checkForExpiredAuctions();
    }
}
?>
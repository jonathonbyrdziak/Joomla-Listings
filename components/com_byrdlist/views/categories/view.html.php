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

jimport( 'joomla.application.component.view');

/**
 * HTML View class for the reservation component
 */
class ByrdlistViewCategories extends ResView 
{
	
	/**
	 * Contains the table model to use
	 * 
	 * @var string
	 */
	var $_table = 'byrdlist_categories';
	
	/**
	 * Display
	 *
	 */
	function display($tpl = null) 
	{
		parent::display($tpl);
    }
    
    /**
     * Category Item
     * 
     */
    protected function li( $path = null )
    {
    	//loading resources
    	$records = $this->getList();
    	
    	
    	foreach ($records as $record)
    	{
    		require $path;
    	}
    	
    }
}
?>
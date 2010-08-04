<?php
/**
 * Joomla! 1.5 component reservation
 *
 * @version $Id: view.pdf.php 2010-06-02 12:34:25 svn $
 * @author 
 * @package Joomla
 * @subpackage reservation
 * @license Copyright (c) 2010 - All Rights Reserved
 *
 * 
 *
 * This component file was created using the Joomla Component Creator by Not Web Design
 * http://www.notwebdesign.com/joomla_component_creator/
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.view');

/**
 * PDF View class for the reservation component
 */
class ByrdlistViewListings extends JView 
{
	/**
	 * Contains the table model to use
	 * 
	 * @var string
	 */
	var $_table = 'byrdlist_listings';
    
    /**
     * Comments
     * 
     */
    protected function comments( $path = null )
    {
    	
    }
	
	/**
	 * Display
	 *
	 */
	function display($tpl = null) 
	{
		//loading resources
		$this->getRecord();
		
		
		
    	$tpl = 'pdf';
		parent::display($tpl);
    }
	
	/**
     * Get the Records information
     *
     */
    protected function getRecord()
    {
    	//reasons to return
    	if ( is_null($this->_table) ) return false;
    	if ( strlen(trim($this->_table)) <1 ) return false;
    	
    	$this->id = JRequest::getVar('record', JRequest::getVar('id'));
    	
    	//loading resources
    	$record =& JTable::getInstance($this->_table, 'Table');
    	
    	//reasons to return
    	if (!is_object($record)) return false;
    	
    	$record->load( $this->id );
    	
    	//initializing object properties
    	$this->_record = $record;
    	
    	return true;
    }
    
}

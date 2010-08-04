<?php
/**
 * Joomla! 1.5 component byrdlist
 *
 * @version $Id: view.html.php 2010-06-07 11:32:44 svn $
 * @author Jonathon Byrd
 * @package Joomla
 * @subpackage byrdlist
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

// Import Joomla! libraries
require_once EBOOK_JOOMLA.DS.'application'.DS.'component'.DS.'admin_view.php';


class ByrdlistViewReported extends AdminView 
{
	/**
	 * 
	 * 
	 * @var object
	 */
	var $_table = 'byrdlist_reported';
	
	/**
	 * Display.
	 * 
	 */
    function display($tpl = null) 
    {
    	parent::display($tpl);
    }
}





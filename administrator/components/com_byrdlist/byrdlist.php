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
 * This component file was created using the Joomla Component Creator by Not Web Design
 * http://www.notwebdesign.com/joomla_component_creator/
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

/*
 * Define constants for all pages
 */
define( 'COM_BYRDLIST_DIR', 'images'.DS.'byrdlist'.DS );
define( 'COM_BYRDLIST_BASE', JPATH_ROOT.DS.COM_BYRDLIST_DIR );
define( 'COM_BYRDLIST_BASEURL', JURI::root().str_replace( DS, '/', COM_BYRDLIST_DIR ));

// Require the base controller
require_once JPATH_COMPONENT.DS.'controller.php';

// Require the base controller
require_once( JPATH_COMPONENT.DS.'includes'.DS.'framework.php' );

// Initialize the controller
$controller = new ByrdlistController( );

// Perform the Request task
$controller->execute( JRequest::getCmd('task'));
$controller->redirect();
?>
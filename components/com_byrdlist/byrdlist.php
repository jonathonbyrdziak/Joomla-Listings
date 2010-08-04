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

// Require the base controller
require_once JPATH_COMPONENT.DS.'controller.php';
require_once( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_byrdlist'.DS.'includes'.DS.'framework.php' );

// Initialize the controller
$controller = new ByrdlistController();
$controller->execute( null );

// Redirect if set by the controller
$controller->redirect();
?>
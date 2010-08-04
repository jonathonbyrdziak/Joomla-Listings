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

//loading libraries
require_once( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_byrdlist'.DS.'includes'.DS.'framework.php' );


//loading resources
$record =& JTable::getInstance('byrdlist_categories', 'Table');
$records = $record->getList();

//initializing variables
$path = EBOOK_SITE.DS.'views'.DS.'categories'.DS.'elements'.DS.'li.php';

//loading media
JHTML::stylesheet('categories.css', 'components/'.EBOOK_COMPONENT.'/media/css/');


foreach ($records as $record)
{
	require $path;
}
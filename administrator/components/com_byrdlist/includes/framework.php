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


//setting special ini
ini_set('memory_limit', '128M');
date_default_timezone_set('America/Los_Angeles');


//loading library objects
require_once dirname(__file__).DS.'defines.php';
require_once dirname(__file__).DS.'factory.php';
require_once EBOOK_JOOMLA.DS.'database'.DS.'sugar_table.php';
require_once EBOOK_JOOMLA.DS.'database'.DS.'table.php';
require_once EBOOK_JOOMLA.DS.'application'.DS.'component'.DS.'model.php';
require_once EBOOK_JOOMLA.DS.'application'.DS.'component'.DS.'view.php';
require_once EBOOK_JOOMLA.DS.'user'.DS.'authorization.php';

//loading libraries
require_once EBOOK_HELPERS.DS.'helper.php';

//initializing library objects
JTable::addIncludePath( EBOOK_TABLES );





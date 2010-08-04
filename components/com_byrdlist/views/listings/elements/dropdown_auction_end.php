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

require_once EBOOK_EVERY.DS.'dom'.DS.'create_html_dom.php';

//initializing variables
$list = $GLOBALS['dropdowns']['auction_end'];

echo CreateHtmlDom::build( $list, 'auction_end', $this->_record->auction_end() );
?>

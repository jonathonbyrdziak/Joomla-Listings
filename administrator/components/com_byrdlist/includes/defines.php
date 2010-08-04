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


//components name
define( 'EBOOK_COMPONENT', 		'com_byrdlist' );

//this url
$parts = parse_url(JURI::base());
define( 'DOTCOM',				$parts['scheme'].'://'.$parts['host'].'/' );


//setting the directory constants
define( 'EBOOK_ADMINISTRATOR', 	JPATH_ADMINISTRATOR.DS.'components'.DS.EBOOK_COMPONENT );
define( 'EBOOK_SITE', 			JPATH_SITE.DS.'components'.DS.EBOOK_COMPONENT );


define( 'EBOOK_HELPERS', 		EBOOK_ADMINISTRATOR.DS.'helpers' );
define( 'EBOOK_INCLUDES', 		EBOOK_ADMINISTRATOR.DS.'includes' );
define( 'EBOOK_TABLES', 		EBOOK_ADMINISTRATOR.DS.'tables' );
define( 'EBOOK_LIB', 			EBOOK_ADMINISTRATOR.DS.'libraries' );
define( 'EBOOK_IMAGES',			EBOOK_ADMINISTRATOR.DS.'libraries'.DS.'uploads' );
define( 'EBOOK_TEMP',			EBOOK_ADMINISTRATOR.DS.'temp' );

define( 'EBOOK_JOOMLA', 		EBOOK_LIB.DS.'joomla' );
define( 'EBOOK_EVERY', 			EBOOK_LIB.DS.'everybooking' );

define( 'EBOOK_UPLOADS', 		EBOOK_LIB.DS.'uploads' );
define( 'DOTCOM_UPLOADS', 		DOTCOM.'administrator/components/'.EBOOK_COMPONENT.'/libraries/uploads/' );






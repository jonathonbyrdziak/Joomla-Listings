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


/**
 * Create a Slug
 * 
 * @param $string
 * @return string
 */
if (!function_exists('create_slug')):
	function create_slug( $str = null )
	{
		$str = strtolower(trim($str));
		$str = preg_replace('/[^a-zA-Z]/', '', $str);
		$str = preg_replace('/-+/', "", $str);
		return strtolower($str);
	}
endif;
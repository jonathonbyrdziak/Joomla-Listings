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
 * Create Global Unique Identifier
 * 
 * Method will activate only if sugar has not already activated this
 * same method. This method has been copied from the sugar files and
 * is used for cakphp database saving methods.
 * 
 * There is no format to these unique ID's other then that they are
 * globally unique and based on a microtime value
 * 
 * @return string //aaaaaaaa-bbbb-cccc-dddd-eeeeeeeeeeee
 */
if (!function_exists('create_guid')):
	function create_guid()
	{
		$microTime = microtime();
		list($a_dec, $a_sec) = explode(" ", $microTime);
		
		$dec_hex = sprintf("%x", $a_dec* 1000000);
		$sec_hex = sprintf("%x", $a_sec);
		
		ensure_length($dec_hex, 5);
		ensure_length($sec_hex, 6);
		
		$guid = "";
		$guid .= $dec_hex;
		$guid .= create_guid_section(3);
		$guid .= '-';
		$guid .= create_guid_section(4);
		$guid .= '-';
		$guid .= create_guid_section(4);
		$guid .= '-';
		$guid .= create_guid_section(4);
		$guid .= '-';
		$guid .= $sec_hex;
		$guid .= create_guid_section(6);
		
		return $guid;
	}
	function create_guid_section($characters)
	{
		$return = "";
		for($i=0; $i<$characters; $i++)
		{
			$return .= sprintf("%x", mt_rand(0,15));
		}
		return $return;
	}
	function ensure_length(&$string, $length)
	{
		$strlen = strlen($string);
		if($strlen < $length)
		{
			$string = str_pad($string,$length,"0");
		}
		else if($strlen > $length)
		{
			$string = substr($string, 0, $length);
		}
	}
endif;
<?php
/**
 * Joomla! 1.5 component reservation
 *
 * @version $Id: view.html.php 2010-06-02 12:34:25 svn $
 * @author 
 * @package Joomla
 * @subpackage Listings
 * @license Copyright (c) 2010 - All Rights Reserved
 *
 * 
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');


//loading resources
$author = eFactory::getUser( $this->_record->author_id() );
$winner = $this->_record->getWinner();
$document	=& JFactory::getDocument();
$pdf =& $document->_engine;


// set font
$pdf->SetFont('freesans', '', 12);
$pdf->SetFillColor(255, 255, 255);
$pdf->SetTextColor(0, 0, 0);
$pdf->setLanguageArray($l);

// add a page
$pdf->AddPage();
$pdf->Ln(5);


// create columns content
$left_column = $author->name()."\r\n"
			.ucwords(strtolower($this->_record->primary_street()))."\r\n"
			.ucwords(strtolower($this->_record->primary_city())).", "
			.$this->_record->primary_state()
			.$this->_record->primary_postal_code();

$right_column = $winner->name()."\r\n"
			.ucwords(strtolower($winner->primary_street()))."\r\n"
			.ucwords(strtolower($winner->primary_city())).", "
			.$winner->primary_state()
			.$winner->primary_postal_code();

$desc = "<br/><br/><br/><br/><b>".$this->_record->name()."</b><br/><br/>"
			.$this->_record->description( 500 )."<br/><br/>";

foreach ($this->_record->listing_details() as $caption => $value)
{
	$desc .= "<br/>".$caption." :     ".$value;
}


// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)
$pdf->MultiCell(80, 0, $left_column, 0, 'L', 0, 0, '', '', true, 0, true, true, 0);
$pdf->MultiCell(80, 0, $right_column, 0, 'L', 0, 1, '80', '50', true, 0, true, true, 0);

$pdf->writeHTML($desc, true, false, true, false, '');

// reset pointer to the last page
//$pdf->lastPage();


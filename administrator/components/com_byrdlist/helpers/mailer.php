<?php
/**
 * Joomla! 1.5 component reservation
 *
 * @version $Id: helper.php 2010-06-02 12:34:25 svn $
 * @author 
 * @package Joomla
 * @subpackage reservation
 * @license Copyright (c) 2010 - All Rights Reserved
 *
 * 
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
 * reservation Helper
 *
 * @package Joomla
 * @subpackage reservation
 * @since 1.5
 */
class BMailer
{
	/**
	 * Listing Expired
	 * 
	 * WITH NO WINNER
	 * 
	 */
	public static function listingExpiredEmpty( $author, $listing )
	{
		//mail to the USER
		$mailSender =& JFactory::getMailer();
		$mailSender->addRecipient( $author->email() );
		$mailSender->setSender( array( 'info@idozo.org', 'idozo.org') );
		$mailSender->setSubject( 'Your Listing has expired without any bids :: '.$listing->name() );
		$mailSender->setBody( "Hi ".$author->name().",

We at idozo.org are sorry to inform you that your auction has expired without accepting any bids from our users. The listing was named ".
$listing->name().", you can locate the listing by following the link below.

".DOTCOM."?option=com_byrdlist&view=listings&layout=details&record=".$listing->id()."

You can also find your listing be accessing your account area and opening the 'closed listings' tab. 

We thank you for your participation!
Good luck next time.
-idozo staff" );
			
		if (!$mailSender->Send()) return false;
		return true;
	}
	
	/**
	 * Listing Expired
	 * 
	 * WITH NO WINNER
	 * 
	 */
	public static function donationExpiredEmpty( $author, $listing )
	{
		//mail to the USER
		$mailSender =& JFactory::getMailer();
		$mailSender->addRecipient( $author->email() );
		$mailSender->setSender( array( 'info@idozo.org', 'idozo.org') );
		$mailSender->setSubject( 'Your Donation has expired without any requests :: '.$listing->name() );
		$mailSender->setBody( "Hi ".$author->name().",

We at idozo.org are sorry to inform you that your donation has expired without accepting any requests from our users. The donation was named ".
$listing->name().", you can locate the donation listing by following the link below.

".DOTCOM."?option=com_byrdlist&view=listings&layout=details&record=".$listing->id()."

You can also find your donation listing be accessing your account area and opening the 'closed listings' tab. 

We thank you for your participation!
Good luck next time.
-idozo staff" );
			
		if (!$mailSender->Send()) return false;
		return true;
	}
	
	/**
	 * Listing Expired
	 * 
	 * WITH NO WINNER
	 * 
	 */
	public static function needExpiredEmpty( $author, $listing )
	{
		//mail to the USER
		$mailSender =& JFactory::getMailer();
		$mailSender->addRecipient( $author->email() );
		$mailSender->setSender( array( 'info@idozo.org', 'idozo.org') );
		$mailSender->setSubject( 'Your Need has expired without any offers :: '.$listing->name() );
		$mailSender->setBody( "Hi ".$author->name().",

We at idozo.org are sorry to inform you that your requested need has expired without accepting any offers from our users. The need listing was named ".
$listing->name().", you can locate the listing by following the link below.

".DOTCOM."?option=com_byrdlist&view=listings&layout=details&record=".$listing->id()."

You can also find your need listing be accessing your account area and opening the 'closed listings' tab. 

We thank you for your participation!
Good luck next time.
-idozo staff" );
			
		if (!$mailSender->Send()) return false;
		return true;
	}
	
	/**
	 * Listing Expired
	 * 
	 * WITH NO WINNER
	 * 
	 */
	public static function financialExpiredEmpty( $author, $listing )
	{
		//mail to the USER
		$mailSender =& JFactory::getMailer();
		$mailSender->addRecipient( $author->email() );
		$mailSender->setSender( array( 'info@idozo.org', 'idozo.org') );
		$mailSender->setSubject( 'Your Financial Campaign has expired without contributions :: '.$listing->name() );
		$mailSender->setBody( "Hi ".$author->name().",

We at idozo.org are sorry to inform you that your Financial Campaign has expired without accepting any contributions from our users. The campaign was named ".
$listing->name().", you can locate the listing by following the link below.

".DOTCOM."?option=com_byrdlist&view=listings&layout=details&record=".$listing->id()."

You can also find your listing be accessing your account area and opening the 'closed listings' tab. 

We thank you for your participation!
Good luck next time.
-idozo staff" );
			
		if (!$mailSender->Send()) return false;
		return true;
	}
	
	/**
	 * Owner of listing has awarded their donation to a user
	 * 
	 * 
	 * 
	 */
	public static function donationAwarded_Owner( $author, $listing, $winner )
	{
		//mail to the USER
		$mailSender =& JFactory::getMailer();
		$mailSender->addRecipient( $author->email() );
		$mailSender->setSender( array( 'info@idozo.org', 'idozo.org') );
		$mailSender->setSubject( 'You have awarded a donation :: '.$listing->name() );
		$mailSender->setBody( "Hi ".$author->name().",

You have awarded your donation to, ".$winner->name().". Congratulations on this victory! Here's a link to your listing so that you can print your shipping label.

".DOTCOM."?option=com_byrdlist&view=listings&layout=details&record=".$listing->id()."

You can also find your listing be accessing your account area and opening the 'closed listings' tab. 

We thank you for your participation!
-idozo staff" );
			
		if (!$mailSender->Send()) return false;
		return true;
	}
	
	/**
	 * Author of Request has been awarded a donation
	 * 
	 * 
	 */
	public static function donationAwarded_Requester( $author, $listing )
	{
		//mail to the USER
		$mailSender =& JFactory::getMailer();
		$mailSender->addRecipient( $author->email() );
		$mailSender->setSender( array( 'info@idozo.org', 'idozo.org') );
		$mailSender->setSubject( 'You have been awarded a Donation :: '.$listing->name() );
		$mailSender->setBody( "Hi ".$author->name().",

The listing owner of, '".$listing->name()."', has just awarded your organization their donation. Here's a link to your reward:

".DOTCOM."?option=com_byrdlist&view=listings&layout=details&record=".$listing->id()."

We thank you for your participation!
-idozo staff" );
			
		if (!$mailSender->Send()) return false;
		return true;
	}
	
	/**
	 * Owner of listing has awarded their donation to a user
	 * 
	 * 
	 * 
	 */
	public static function needAwarded_Owner( $author, $listing, $winner )
	{
		//mail to the USER
		$mailSender =& JFactory::getMailer();
		$mailSender->addRecipient( $author->email() );
		$mailSender->setSender( array( 'info@idozo.org', 'idozo.org') );
		$mailSender->setSubject( 'You have filled your needs :: '.$listing->name() );
		$mailSender->setBody( "Hi ".$author->name().",

You have awarded your need to, '".$winner->name().".' Congratulations on this victory! Here's a link to your listing.

".DOTCOM."?option=com_byrdlist&view=listings&layout=details&record=".$listing->id()."

You can also find your listing be accessing your account area and opening the 'closed listings' tab. 

We thank you for your participation!
-idozo staff" );
			
		if (!$mailSender->Send()) return false;
		return true;
	}
	
	/**
	 * Author of Request has been awarded a donation
	 * 
	 * 
	 */
	public static function needAwarded_Requester( $author, $listing )
	{
		//mail to the USER
		$mailSender =& JFactory::getMailer();
		$mailSender->addRecipient( $author->email() );
		$mailSender->setSender( array( 'info@idozo.org', 'idozo.org') );
		$mailSender->setSubject( 'Your request to fill a need has been granted :: '.$listing->name() );
		$mailSender->setBody( "Hi ".$author->name().",

The listing owner of, '".$listing->name()."', has just awarded you the opportunity to fulfill their needs. Here's a link to their need, so that you can print a shipping label:

".DOTCOM."?option=com_byrdlist&view=listings&layout=details&record=".$listing->id()."

We thank you for your participation!
-idozo staff" );
			
		if (!$mailSender->Send()) return false;
		return true;
	}
	
	/**
	 * Listing Expired 
	 * 
	 * WITH A WINNER
	 * 
	 */
	public static function listingExpiredWinner( $author, $listing )
	{
		//mail to the AUTHOR
		$mailSender =& JFactory::getMailer();
		$mailSender->addRecipient( $author->email() );
		$mailSender->setSender( array( 'info@idozo.org', 'idozo.org') );
		$mailSender->setSubject( 'Your Listing has a Winner :: '.$listing->name() );
		$mailSender->setBody( "Hi ".$author->name().",

Your listing '".$listing->name()."' has been accepting bids and has expired with a winner, you can locate the listing by following the link below.

".DOTCOM."?option=com_byrdlist&view=listings&layout=details&record=".$listing->id()."

At this time we will email the auction winner and attempt to collect a payment. You may also contact the auction winner at any time to arrange shipping. However, we encourage you to not ship your item until the auction has been paid for.

We thank you for your participation!
-idozo staff" );
			
		if (!$mailSender->Send()) return false;
		return true;
	}
	
	/**
	 * Listing Expired 
	 * 
	 * WITH A WINNER
	 * 
	 */
	public static function listingWinner( $author, $listing )
	{
		//mail to the user
		$mailSender =& JFactory::getMailer();
		$mailSender->addRecipient( $author->email() );
		$mailSender->setSender( array( 'info@idozo.org', 'idozo.org') );
		$mailSender->setSubject( "You've won an auction :: ".$listing->name() );
		$mailSender->setBody( "Hi ".$author->name().",

Congratulations on winning the auction, '{$listing->name()}' at idozo.org. At this time you will need to complete the payment process by following the link below in order for the owner to ship the item to you. 

".DOTCOM."?option=com_byrdlist&view=listings&layout=payment&_listings_id=".$listing->id()."

We thank you for your participation!
-idozo staff" );
			
		if (!$mailSender->Send()) return false;
		return true;
	}
	
	/**
	 * Listing Expired 
	 * 
	 * WITH A WINNER
	 * 
	 */
	public static function needExpiredWinner( $author, $listing )
	{
		//mail to the AUTHOR
		$mailSender =& JFactory::getMailer();
		$mailSender->addRecipient( $author->email() );
		$mailSender->setSender( array( 'info@idozo.org', 'idozo.org') );
		$mailSender->setSubject( 'Your Need has an Offer :: '.$listing->name() );
		$mailSender->setBody( "Hi ".$author->name().",

Your requested need '".$listing->name()."' has been accepting offers but it has expired and you have not selected a winner. You can locate the listing by following the link below.

".DOTCOM."?option=com_byrdlist&view=listings&layout=details&record=".$listing->id()."

You still have an opportunity to select an offer.

We thank you for your participation!
-idozo staff" );
			
		if (!$mailSender->Send()) return false;
		return true;
	}
	
	/**
	 * Listing Expired 
	 * 
	 * WITH A WINNER
	 * 
	 */
	public static function donationExpiredWinner( $author, $listing )
	{
		//mail to the AUTHOR
		$mailSender =& JFactory::getMailer();
		$mailSender->addRecipient( $author->email() );
		$mailSender->setSender( array( 'info@idozo.org', 'idozo.org') );
		$mailSender->setSubject( 'Your Donation has requests :: '.$listing->name() );
		$mailSender->setBody( "Hi ".$author->name().",

Your Donation listing '".$listing->name()."' has been accepting requests but it has expired without you awarding the donation. You can locate the listing by following the link below.

".DOTCOM."?option=com_byrdlist&view=listings&layout=details&record=".$listing->id()."

You still have an opportunity to award the donation to a requestor.

We thank you for your participation!
-idozo staff" );
			
		if (!$mailSender->Send()) return false;
		return true;
	}
	
	/**
	 * Listing Expired 
	 * 
	 * WITH A WINNER
	 * 
	 */
	public static function financialExpiredWinner( $author, $listing )
	{
		//mail to the AUTHOR
		$mailSender =& JFactory::getMailer();
		$mailSender->addRecipient( $author->email() );
		$mailSender->setSender( array( 'info@idozo.org', 'idozo.org') );
		$mailSender->setSubject( 'Your Financial Campaign has expired :: '.$listing->name() );
		$mailSender->setBody( "Hi ".$author->name().",

Your listing '".$listing->name()."' has been accepting contribution but it has expired, you can locate the listing by following the link below.

".DOTCOM."?option=com_byrdlist&view=listings&layout=details&record=".$listing->id()."

We thank you for your participation!
-idozo staff" );
			
		if (!$mailSender->Send()) return false;
		return true;
	}
	
	/**
	 * Listing was just paid in full
	 * 
	 * BY THE WINNER
	 * 
	 */
	public static function auctionPaidInFull( $author, $listing )
	{
		//mail to the AUTHOR
		$mailSender =& JFactory::getMailer();
		$mailSender->addRecipient( $author->email() );
		$mailSender->setSender( array( 'info@idozo.org', 'idozo.org') );
		$mailSender->setSubject( 'Thank you for your payment :: '.$listing->name() );
		$mailSender->setBody( "Hi ".$author->name().",

You've completed the auction process for '".$listing->name()."'. We have contacted the listing owner, you should be expected them to contact you with shipping information shortly. Here is the link to your purchase, we will leave it online for a week.

".DOTCOM."?option=com_byrdlist&view=listings&layout=details&record=".$listing->id()."

We thank you for your participation!
-idozo staff" );
			
		if (!$mailSender->Send()) return false;
		return true;
	}
	
	/**
	 * Listing was just paid in full
	 * 
	 * BY THE WINNER
	 * 
	 */
	public static function notifyListingOwnerAuctionPaidInFull( $author, $listing )
	{
		//mail to the AUTHOR
		$mailSender =& JFactory::getMailer();
		$mailSender->addRecipient( $author->email() );
		$mailSender->setSender( array( 'info@idozo.org', 'idozo.org') );
		$mailSender->setSubject( 'Your Listing has been Paid for :: '.$listing->name() );
		$mailSender->setBody( "Hi ".$author->name().",

Your listing '".$listing->name()."' has been paid for. It's now a good idea to contact the auction winner and communicate your shipping procedures with them. Your listing link is here:

".DOTCOM."?option=com_byrdlist&view=listings&layout=details&record=".$listing->id()."

We thank you for your participation!
-idozo staff" );
			
		if (!$mailSender->Send()) return false;
		return true;
	}
	
}

?>
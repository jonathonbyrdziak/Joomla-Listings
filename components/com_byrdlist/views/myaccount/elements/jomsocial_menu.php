<?php
/**
 * Joomla! 1.5 component reservation
 *
 * @version $Id: view.html.php 2010-06-02 12:34:25 svn $
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

//loading resources
$user =& eFactory::getUser();

?>

<script type="text/javascript" src="components/com_community/assets/jquery-1.2.6.pack.js"></script> 
<script type="text/javascript" src="components/com_community/assets/window-1.0.js"></script> 
<script type="text/javascript" src="components/com_community/assets/script-1.2.js"></script> 

<div id="componentarea"><div id="community-wrap"><div id="cToolbarNav"> 
	<div id="cToolbarNavInner"> 
		<ul id="cToolbarNavList"> 
			<li id="toolbar-item-frontpage"> 
				<a href="/index.php?option=com_community&amp;view=profile&amp;Itemid=14"> 
					Home</a> 
			</li> 
			 <li id="toolbar-item-profile" class=""> 
				<a href="/index.php?option=com_community&amp;Itemid=14&amp;view=profile&amp;userid=62&amp;Itemid=14" onmouseover="joms.toolbar.open('m1')" onmouseout="joms.toolbar.closetime()">Profile</a> 
		        <div id="m1" onmouseover="joms.toolbar.cancelclosetime()" onmouseout="joms.toolbar.closetime()"> 
			        
                                      
                   <a href="/index.php?option=com_community&amp;view=profile&amp;task=uploadAvatar&amp;Itemid=14&amp;Itemid=14"> 
						Change profile picture					</a> 
					<a href="/index.php?option=com_community&amp;view=profile&amp;task=edit&amp;Itemid=14&amp;Itemid=14"> 
						Edit profile					</a> 
					<a href="/index.php?option=com_community&amp;view=profile&amp;task=editDetails&amp;Itemid=14&amp;Itemid=14"> 
						Edit details					</a> 
				    <a href="/index.php?option=com_community&amp;view=profile&amp;task=privacy&amp;Itemid=14&amp;Itemid=14"> 
						Privacy					</a> 
		        </div> 
		    </li> 
		    <li id="toolbar-item-friends" class=""> 
				<a href="/index.php?option=com_community&amp;view=friends&amp;Itemid=14&amp;userid=62" onmouseover="joms.toolbar.open('m2')" onmouseout="joms.toolbar.closetime()">Friends</a> 
		        <div id="m2" onmouseover="joms.toolbar.cancelclosetime()" onmouseout="joms.toolbar.closetime()" style="visibility: hidden;"> 
					<a href="/index.php?option=com_community&amp;view=friends&amp;Itemid=14" class="has-separator">Show all</a> 
					<a href="/index.php?option=com_community&amp;view=search&amp;Itemid=14">Search</a> 
					<a href="/index.php?option=com_community&amp;view=friends&amp;task=invite&amp;Itemid=14">Invite Friends</a> 
					<a href="/index.php?option=com_community&amp;view=friends&amp;task=sent&amp;Itemid=14">Request sent</a> 
					<a href="/index.php?option=com_community&amp;view=friends&amp;task=pending&amp;Itemid=14">Pending my approval</a> 
		        </div> 
		    </li> 
      		<li id="toolbar-item-apps" class=""> 
				<a href="/index.php?option=com_community&amp;view=apps&amp;Itemid=14" onmouseover="joms.toolbar.open('m3')" onmouseout="joms.toolbar.closetime()">Applications</a> 
		        <div id="m3" onmouseover="joms.toolbar.cancelclosetime()" onmouseout="joms.toolbar.closetime()" style="visibility: hidden; overflow: hidden;"> 
			        <a href="/index.php?option=com_community&amp;view=apps&amp;Itemid=14"> 
						My Applications					</a> 
				    <a href="/index.php?option=com_community&amp;view=apps&amp;task=browse&amp;Itemid=14" class="has-separator"> 
						Browse					</a> 
									    <a href="/index.php?option=com_community&amp;view=groups&amp;Itemid=14&amp;task=mygroups&amp;userid=62"> 
						Groups					</a> 
				    											<a href="/index.php?option=com_community&amp;view=photos&amp;task=myphotos&amp;Itemid=14&amp;userid=62"> 
							Photos						</a> 
							        </div> 
			</li> 
      		<li id="toolbar-item-inbox" class=""> 
				<a href="/index.php?option=com_community&amp;view=inbox&amp;Itemid=14" onmouseover="joms.toolbar.open('m4')" onmouseout="joms.toolbar.closetime()">Inbox</a> 
		        <div id="m4" onmouseover="joms.toolbar.cancelclosetime()" onmouseout="joms.toolbar.closetime()" style="visibility: hidden;"> 
				    <a href="/index.php?option=com_community&amp;view=inbox&amp;Itemid=14">Inbox</a> 
				    <a href="/index.php?option=com_community&amp;view=inbox&amp;task=sent&amp;Itemid=14">Sent</a> 
					<a href="/index.php?option=com_community&amp;view=inbox&amp;task=write&amp;Itemid=14">Write</a> 
		        </div> 
			</li> 
			<li id="toolbar-item-mylisting"  class="toolbar-active"> 
				<a href="/index.php?option=com_byrdlist&view=myaccount&Itemid=14">My listings</a> 
			</li> 
					</ul> 
		
		<div class="toolbar-myname try">Hello <?php echo $user->name(); ?></div> 
		<div class="clr"></div> 
	</div> 
</div> 
 
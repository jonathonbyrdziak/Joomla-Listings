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
$usertable =& JTable::getInstance('juser', 'Table');
$usertable->load( $user->id() );

?>

<div id="community-wrap" style="margin:0px;">

	<?php $this->element('menu'); ?>

<div style="clearb:both;width:100%;height:10px;line-height:10px;">&nbsp;</div>
			<div class="profile-main"> 
			<div class="profile-box"> 
	 
			<!-- Avatar --> 
			<div class="profile-avatar"> 
				<?php echo $usertable->getHtmlAvatar( 150 ); ?>
			</div>
	 
			<!-- Short Profile info --> 
			<div class="profile-info"> 
				<div class="contentheading">
					<?php echo $user->name(); ?> 
					<span style="font-size:12px;">[ <?php echo $user->username(); ?> ]</span>
				</div> 
	 
				<!--  Profile Status  --> 
				<div id="profile-status"> 
					<span id="profile-status-message"></span> 
				</div> 
	 
				<!--  Profile Details  --> 
				<ul class="profile-details"> 
					<li class="title">Last Visit</li> 
					<li><?php echo $user->lastvisitDate(); ?></li> 
	  
					<li class="title">Email</li> 
					<li><?php echo $user->email(); ?></li> 
	 				<!-- 
					<li class="title">Home Number</li> 
					<li><?php echo $user->phone_home(); ?></li> 
	 
					<li class="title">Fax Number</li> 
					<li><?php echo $user->phone_fax(); ?></li> 
	 
					<li class="title">&nbsp;</li> 
					<li>&nbsp;</li> 
					
					<li class="title">Address</li> 
					<li><?php echo $user->primary_address_street(); ?><br/>
					<?php echo $user->primary_address_city(); ?> 
					<?php echo $user->primary_address_state(); ?> 
					<?php echo $user->primary_address_postalcode(); ?></li> 
					  -->
				</ul> 
				<div class="clr">&nbsp;</div> 
			</div> 
			<div class="clr">&nbsp;</div> 
		</div> 
	 
		<div class="profile-toolbox-bl"> 
			<div class="profile-toolbox-br"> 
				<div class="profile-toolbox-tl" style="padding:10px;"> 
					<!-- 
					<div style="padding-left: 17px;"> 
						<div class="statustext"> 
							<label for="statustext">Comment</label> 
							<input name="statustext" id="statustext" type="text" class="status" value="" /> 
							<input name="isubmitcode" id="isubmitcode" type="hidden" value="<?php //echo JRequest::getVar('isubmitcode'); ?>" /> 
							<input name="userid" id="userid" type="hidden" value="<?php //echo $userid; ?>" /> 
							<a href="javascript:void(0);" id="save-status" onclick="status._save();return false;">Save</a> 
						</div> 
					</div>
					 -->
					<div id="profile-header" class="js-box-grey" style="margin: 0 0 10px; padding-left: 40px;"> 
						<ul class="actions">
							<!-- 
							<li class="photo"> 
								<a href="?option=com_community&view=myaccount&task=edit"> 
									<span>Edit Profile</span> 
								</a> 
							</li> 
							<li class="privacy"> 
								<a href="?option=com_byrdlist&view=myaccount&layout=shipping"> 
									<span>Edit Shipping Details</span> 
							   </a> 
							</li> 
							<li class="write"> 
								<a href="?option=com_byrdlist&view=myaccount&layout=payment"> 
									<span>Edit Payment Details</span> 
								</a> 
							</li> 
							 -->
						</ul> 
						<ul class="actions"> 
						<!-- 
							<li class="invite"> 
								<a href="?option=com_byrdlist&view=mail&layout=compose"> 
									<span>Compose Email</span> 
								</a> 
							</li> 
							<li class="apps"> 
								<a href="?option=com_byrdlist&view=mail&layout=settings" >
									<span>Email Settings</span> 
								</a>
							</li>
							-->
						</ul> 
						
						<!-- 
						<ul class="actions"> 
							<li class="inbox"> 
								<a href="#"> 
									<span>Daily Checkin Report</span> 
								</a> 
							</li> 
							<li class="inbox"> 
								<a href="#"> 
									<span>Room Tags</span>
								</a> 
							</li> 
						</ul> 
						 -->
						 
					</div> 
					<div class="clr">&nbsp;</div> 
					
				</div> 
			</div> 
		</div>
		
	</div>
	<div style="clearb:both;width:100%;height:10px;line-height:10px;">&nbsp;</div>
</div>


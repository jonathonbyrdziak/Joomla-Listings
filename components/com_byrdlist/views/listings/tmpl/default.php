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

$cat = strlen(trim($this->_category->name()));

?>

<div id="listing"> 
	<h2 style="margin-bottom:10px;height:35px;">
		<?php if ($cat): ?>
			Category :: <?php echo $this->_category->name(); ?>
		<?php endif; ?>
		
		<div style="position:relative;float:right;">
			<div class="mbutton"> 
				<a href="/" rel="nofollow">
				Back to Categories</a>
				
			<?php if ($this->user->isGuest()): ?>
				<a href="?option=com_community" rel="nofollow">
				Log In</a>
				
			<?php else: ?>
				<a href="?option=com_byrdlist&view=myaccount" rel="nofollow">
				My Account</a>
				
				<a href="?option=com_byrdlist&view=listings&layout=new">
				Add your listing here</a>
			<?php endif; ?>
			</div>
		</div>
	</h2> 
</div>

<?php if ($cat): ?>
	<?php $this->element('categories'); ?>
<?php endif; ?>

<?php $this->element('search_bar'); ?>
<?php $this->element('tabs'); ?>
<?php $this->element('listings'); ?>

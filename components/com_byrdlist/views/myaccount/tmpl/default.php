<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php $this->element('jomsocial_menu'); ?>

<?php $this->element('mymenu'); ?>

<p class="mbutton"> 
	<a href="/" rel="nofollow" class="add-listing" style="margin-left:10px;"> Back to Categories</a>
	<a href="?option=com_byrdlist&view=listings&layout=new" class="add-listing">Add a new listing</a>
</p> 

<?php $this->element('tabs'); ?>

<?php $this->element('listings'); ?>
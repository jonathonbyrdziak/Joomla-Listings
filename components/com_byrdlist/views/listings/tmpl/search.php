<?php defined('_JEXEC') or die('Restricted access'); ?>

<div id="cat-header"> 
	<h2 class="contentheading">
		Computers
		<a href="/tree/directory/computers/rss/new.html">
			<img src="/tree/components/com_mtree/img/rss.png" width="14" height="14" hspace="5" alt="RSS" border="0" />
		</a>
	</h2> 
	
	<p class="mbutton"> 
		<a href="/tree/directory/computers/add.html" class="add-listing">Add your listing here</a>
	</p> 
</div> 

<?php $this->element('categories'); ?>

<?php $this->element('tabs'); ?>

<?php $this->element('listings'); ?>

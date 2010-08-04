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

$pagination = $this->getPagination();

?>

<ul class="pagination">
	<?php if ($pagination['page'] > 1): ?>
	<li>
		<strong>
			<a href="?option=com_byrdlist<?php echo $view.$layout.$task.$categories_id.$search; ?>&limitstart=<?php echo $first; ?>" title="Start">
			Start</a>
		</strong>
	</li>
	<?php else: ?>
	<li>Start</li>
	<?php endif; ?>
	
	<?php if ($pagination['page'] > 1): ?>
	<li>
		<strong>
			<a href="?option=com_byrdlist<?php echo $view.$layout.$task.$categories_id; ?>&limitstart=<?php echo $prev; ?>" title="Prev">
			Prev</a>
		</strong>
	</li>
	<?php else: ?>
	<li>Prev</li>
	<?php endif; ?>
	
	<?php $this->element('pagination_li'); ?>
	
	<?php if ($pagination['page'] != $pagination['pages']): ?>
	<li>
		<strong>
			<a href="?option=com_byrdlist<?php echo $view.$layout.$task.$categories_id; ?>&limitstart=<?php echo $next; ?>" title="Next">
			Next</a>
		</strong>
	</li>
	<?php else: ?>
	<li>Next</li>
	<?php endif; ?>
	
	<?php if ($pagination['page'] != $pagination['pages']): ?>
	<li>
		<strong>
			<a href="?option=com_byrdlist<?php echo $view.$layout.$task.$categories_id; ?>&limitstart=<?php echo $last; ?>" title="End">
			End</a>
		</strong>
	</li>
	<?php else: ?>
	<li>End</li>
	<?php endif; ?>
</ul>
<?php defined('_JEXEC') or die('Restricted access'); ?>

<del class="container">
<div class="pagination"> 
	
	<div class="limit">
		Display #
		<select name="limit" id="limit" class="inputbox" size="1" onchange="submitform();">
			<option value="5" <?php echo ($limit == 5)?$select:"";?>>5</option>
			<option value="10" <?php echo ($limit == 10)?$select:"";?>>10</option>
			<option value="15" <?php echo ($limit == 15)?$select:"";?>>15</option>
			<option value="20" <?php echo ($limit == 20)?$select:"";?>>20</option>
			<option value="25" <?php echo ($limit == 25)?$select:"";?>>25</option>
			<option value="30" <?php echo ($limit == 30)?$select:"";?>>30</option>
			<option value="50" <?php echo ($limit == 50)?$select:"";?>>50</option>
			<option value="100" <?php echo ($limit == 100)?$select:"";?>>100</option>
			<option value="0" <?php echo ($limit == 0)?$select:"";?>>all</option>
		</select>
	</div>
	
	<div class="button2-right <?php echo ($page >1 )?"":"off"; ?>">
		<div class="start">
			<?php if ($page >1 ): ?>
			<a href="#" title="Start" onclick="javascript: document.adminForm.limitstart.value=<?php echo $first; ?>; submitform();return false;">Start</a>
			<?php else: ?>
			<span>Start</span>
			<?php endif; ?>
		</div>
	</div>
	
	<div class="button2-right <?php echo ($page >1 )?"":"off"; ?>">
		<div class="prev">
			<?php if ($page >1 ): ?>
			<a href="#" title="Prev" onclick="javascript: document.adminForm.limitstart.value=<?php echo $prev; ?>; submitform();return false;">Prev</a>
			<?php else: ?>
			<span>Prev</span>
			<?php endif; ?>
		</div>
	</div>
	
	<div class="button2-left">
		<div class="page">
			<?php $this->element('pagination_li'); ?>
		</div>
	</div>
	
	<div class="button2-left <?php echo ($page != $pagination['pages'])?"":"off"; ?>">
		<div class="next">
			<?php if ($page != $pagination['pages']): ?>
			<a href="#" title="Next" onclick="javascript: document.adminForm.limitstart.value=<?php echo $next; ?>; submitform();return false;">Next</a>
			<?php else: ?>
			<span>Next</span>
			<?php endif; ?>
		</div>
	</div>
	
	<div class="button2-left <?php echo ($page != $pagination['pages'])?"":"off"; ?>">
		<div class="end">
			<?php if ($page != $pagination['pages']): ?>
			<a href="#" title="End" onclick="javascript: document.adminForm.limitstart.value=<?php echo $last; ?>; submitform();return false;">End</a>
			<?php else: ?>
			<span>End</span>
			<?php endif; ?>
		</div>
	</div> 
	
	<div class="limit">Page 1 of <?php echo $pagination['pages']; ?></div> 
	<input type="hidden" name="limitstart" value="0" />
	
</div>
</del>				

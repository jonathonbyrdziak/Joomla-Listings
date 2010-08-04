<tr class="row<?php echo $row; ?>"> 
	<td> 
		<?php echo $count; ?>
	</td> 
	<td align="center"> 
		<input type="checkbox" id="cb<?php echo $count; ?>" name="cid[]" value="<?php echo $record->id(); ?>" 
		onclick="isChecked(this.checked);" />
	</td> 
	<td> 
		<span class="editlinktip hasTip" 
		title="<?php echo $record->subject(); ?>::<?php echo $record->description(); ?>" >
			<a href="index.php?option=com_byrdlist&view=reported&layout=edit&record=<?php echo $record->id(); ?>"> 
				<?php echo $record->subject(); ?>
			</a> 
		</span>
	</td> 
	<td>
	<a href="index.php?option=com_byrdlist&view=reported&layout=edit&task=edit&record=<?php echo $record->id(); ?>" 
		title="Edit Parent Category"> 
		<?php echo @$GLOBALS['dropdowns']['violation_type'][$record->type()]; ?>
	</a>
	</td>
	<td align="center">
		<?php if ($record->published()): ?>
		<span class="editlinktip hasTip" title="Publish Information::Start: 2009-02-12 18:56:41">
			<a href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $count; ?>','unpublish')"> 
			<img src="images/publish_g.png" width="16" height="16" border="0" alt="Published" />
			</a>
		</span>
		<?php else: ?>
		<span class="editlinktip hasTip" title="Publish Information::Start: 2009-02-10 01:58:00">
			<a href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $count; ?>','publish')"> 
			<img src="images/publish_x.png" width="16" height="16" border="0" alt="Unpublished" />
			</a>
		</span> 
		<?php endif; ?>
	</td>
	<td>
		<a href="index.php?option=com_users&amp;task=edit&amp;cid[]=<?php echo $record->author_id(); ?>" 
		title="Edit User">
		<?php echo $record->author_name(); ?></a>
	</td>
	<td nowrap="nowrap">
		<?php echo $record->created_on(); ?>
	</td>
	<td>
		<?php echo $record->id(); ?>
	</td>
</tr>	
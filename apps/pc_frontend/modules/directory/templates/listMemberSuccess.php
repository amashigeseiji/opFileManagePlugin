<div class="partsHeading">
<?php echo __('Directory list of %1%', array('%1%' => $member->getName())) ?>
</div>

<?php if ($pager->getNbResults()): ?>

<?php include_partial('directory/listTable', array('pager' => $pager)) ?>

<?php op_include_pager_navigation($pager, '@directory_list?id='.$member->getId().'&page=%d'); ?>
<?php else: ?>
<?php op_include_box('DirectoryList', __('There is no directory.')) ?>
<?php endif; ?>

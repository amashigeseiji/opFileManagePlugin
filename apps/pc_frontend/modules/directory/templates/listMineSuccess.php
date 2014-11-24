<div class="partsHeading">
<?php echo __('Directory list of %1%', array('%1%' => $member->getName())) ?>
</div>
<span style="float: right;font-weight: normal; color: #333">
<?php include_component('directory', 'directoryCreateModal') ?>
</span>

<?php if ($pager->getNbResults()): ?>

<?php include_partial('directory/listTable', array('pager' => $pager, 'isPublic' => true)) ?>

<?php op_include_pager_navigation($pager, '@directory_list?page=%d'); ?>
<?php else: ?>
<?php op_include_box('DirectoryList', __('There is no directory.')) ?>
<?php endif; ?>

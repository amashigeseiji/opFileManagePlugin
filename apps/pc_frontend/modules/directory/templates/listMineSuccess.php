<div class="partsHeading">
<?php echo __('Directory list of %1%', array('%1%' => $member->getName())) ?>
</div>
<span style="float: right;font-weight: normal; color: #333">
<?php include_component('directory', 'directoryCreateModal') ?>
</span>

<table class="table table-striped">
<thead>
<?php if ($pager->getNbResults()): ?>
<th><?php echo __('Operation') ?></th>
<th><?php echo __('Directory name') ?></th>
<th><?php echo __('note') ?></th>
<?php if (opFileManageConfig::isUsePrivate() && opFileManageConfig::isUsePublic()): ?>
<th><?php echo __('Is Public') ?></th>
<?php endif; ?>
<?php endif; ?>
</thead>

<tbody>
<?php if ($pager->getNbResults()): ?>
<?php foreach ($pager as $directory): ?>
<?php include_partial('directory/listRow', array('directory' => $directory)) ?>
<?php endforeach; ?>
<?php endif; ?>
</tbody>
</table>

<?php if ($pager->getNbResults()): ?>
<?php op_include_pager_navigation($pager, '@directory_list?page=%d'); ?>
<?php else: ?>
<?php op_include_box('DirectoryList', __('There is no directory.')) ?>
<?php endif; ?>

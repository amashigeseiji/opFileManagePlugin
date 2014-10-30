<div class="partsHeading">
  <?php echo __('File list of %1%', array('%1%' => $community->name)) ?>
</div>
<div class="pull-right">
  <?php include_component('file', 'communityFileUploadModal') ?>
</div>

<table class="table table-striped">
<thead>
  <th><?php echo __('Operation') ?></th>
  <th><?php echo __('File name') ?>(<?php echo __('Directory name') ?>)</th>
  <th><?php echo __('note') ?></th>
</thead>

<tbody>
<?php foreach ($pager as $file): ?>
<?php include_partial('file/fileListRow', array('file' => $file, 'dirname' => true)) ?>
<?php endforeach; ?>
</tbody>
</table>

<?php if ($pager->getNbResults()): ?>
  <?php op_include_pager_navigation($pager, '@file_list_community?id='.$community->id.'&page=%d'); ?>
<?php else: ?>
  <?php op_include_box('directoryShow', __('There is no file.')) ?>
<?php endif; ?>

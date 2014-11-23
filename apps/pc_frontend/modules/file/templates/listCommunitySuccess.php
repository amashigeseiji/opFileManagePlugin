<div class="partsHeading">
  <?php echo __('File list of %1%', array('%1%' => $community->name)) ?>
</div>
<div class="pull-right">
  <?php include_component('file', 'communityFileUploadModal') ?>
</div>

<?php include_partial('file/fileListTable', array('pager' => $pager, 'dirname' => true, 'member' => true)) ?>

<?php if ($pager->getNbResults()): ?>
  <?php op_include_pager_navigation($pager, '@file_list_community?id='.$community->id.'&page=%d'); ?>
<?php else: ?>
  <?php op_include_box('directoryShow', __('There is no file.')) ?>
<?php endif; ?>

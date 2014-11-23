<div class="partsHeading">
  <?php if ($sf_request->getParameter('search')): ?>
    <?php echo __('Search result') ?>
  <?php else: ?>
    <?php echo __('Public file list') ?>
  <?php endif; ?>
</div>

<?php include_partial('file/fileListTable', array('pager' => $pager, 'member' => true, 'dirname' => true)) ?>

<?php if ($pager->getNbResults()): ?>
  <?php op_include_pager_navigation($pager, '@file_index?page=%d'); ?>
<?php else: ?>
  <?php op_include_box('fileIndex', __('There is no file.')) ?>
<?php endif; ?>

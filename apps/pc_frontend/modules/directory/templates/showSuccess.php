<div class="dpart">
<div class="partsHeading">
  <?php echo __('File list of %1%', array(
    '%1%' => '<span class="dirname_'.$directory->id.'">'.$directory->getName().'</span>'
  )) ?>
  <?php if ($directory->isEditable(sfContext::getInstance()->getUser()->getMember())): ?>
    <span class="normal">
    (<?php echo ('community' === $directory->type) ?
      $directory->getConfig()->getCommunity()->name : __($directory->getPublicLabel()) ?>)
    </span>
    <?php include_partial('directory/edit', array('directory' => $directory)) ?>
  <?php endif; ?>
</div>
<div class="pull-right">
  <?php if ($directory->isUploadable(sfContext::getInstance()->getUser()->getMember())): ?>
  <?php include_component('file', 'directoryFileUploadModal') ?>
  <?php endif; ?>
</div>
<span class="normal-darker"><?php echo $directory->note ?></span>
</div>

<?php include_partial('file/fileListTable', array('pager' => $pager, 'member' => true)) ?>

<?php if ($pager->getNbResults()): ?>
  <?php op_include_pager_navigation($pager, '@directory_show?id='.$directory->id.'&page=%d'); ?>
<?php else: ?>
  <?php op_include_box('directoryShow', __('There is no file.')) ?>
<?php endif; ?>

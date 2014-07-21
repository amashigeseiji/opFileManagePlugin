<style>
.btn-group a {
  color: #333333
}
</style>
<?php $member = sfContext::getInstance()->getUser()->getMember() ?>
<div class="btn-group operation-button">
  <?php if ($directory->isEditable($member)): ?>
  <a href="javascript:void(0)" id="directory_edit_name_show_link_<?php echo $directory->getId() ?>" class="btn btn-small"><i class="icon-edit"></i></a>
  <?php endif; ?>
  <?php if ($directory->isDeletable($member)): ?>
  <?php echo link_to('<i class="icon-trash"></i>', '@directory_delete?id='.$directory->getId(), array('method' => 'delete', 'confirm' => __('Directory name').': '.$directory->getName().'\n'.__('Files in directory will be deleted.\nIs it OK?'), 'class' => 'btn btn-small')) ?>
  <?php endif; ?>
</div>
<?php if ($directory->isEditable($member)): ?>
<?php include_partial('directory/editDirectoryNameBox', array('directory' => $directory, 'trigger' => '#directory_edit_name_show_link_'.$directory->getId())) ?>
<?php endif; ?>

<style>
<!--
.btn-group a {
  color: #333333
}
-->
</style>
<div class="btn-group operation-button">
  <a href="javascript:void(0)" id="directory_edit_name_show_link_<?php echo $directory->getId() ?>" class="btn btn-small"><i class="icon-edit"></i></a>
  <?php if ($directory->isDeletable(sfContext::getInstance()->getUser()->getMember())): ?>
  <?php echo link_to('<i class="icon-trash"></i>', '@directory_delete?id='.$directory->getId(), array('method' => 'delete', 'confirm' => __('Directory name').': '.$directory->getName().'\n'.__('Files in directory will be deleted.\nIs it OK?'), 'class' => 'btn btn-small')) ?>
  <?php endif; ?>
</div>
<?php include_partial('directory/editDirectoryNameBox', array('directory' => $directory, 'trigger' => '#directory_edit_name_show_link_'.$directory->getId())) ?>

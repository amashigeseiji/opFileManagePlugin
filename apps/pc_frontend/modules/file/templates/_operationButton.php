<?php $member = sfContext::getInstance()->getUser()->getMember() ?>
<span class="span btn-group">
  <?php if ($file->isViewable($member)): ?>
  <?php echo link_to(
    '<i class="icon-download-alt"></i>',
    url_for('file_download', $file),
    array('class' => 'btn btn-small'))
  ?>
  <?php endif; ?>
  <?php if ($file->isDeletable($member)): ?>
    <?php echo link_to(
      '<i class="icon-trash"></i>',
      '@file_delete?id='.$file->getId(),
      array('method' => 'delete',
            'class' => 'btn btn-small',
            'confirm' => __('File name').': '.$file->getName().'\n'.__('Are you sure you want to remove this completely?'))
    ) ?>
  <?php endif; ?>
  <?php if ($file->isEditable($member)): ?>
    <a href="javascript:void(0)" id="file_edit_name_link_<?php echo $file->getId() ?>" class="btn btn-small">
      <i class="icon-edit"></i>
    </a>
    <a href="javascript:void(0)" id="file_move_directory_link_<?php echo $file->getId() ?>" class="btn btn-small">
      <i class="icon-folder-open"></i>
    </a>
  <?php endif; ?>
</span>

<?php if ($file->isEditable($member)): ?>
<?php include_partial('file/editFileNameBox', array('file' => $file, 'trigger' => '#file_edit_name_link_'.$file->getId())) ?>
<?php include_partial('file/moveDirectory', array('file' => $file, 'trigger' => '#file_move_directory_link_'.$file->getId())) ?>
<?php endif; ?>

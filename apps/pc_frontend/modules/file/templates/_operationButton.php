<?php use_javascript('jquery.min.js') ?>
<?php use_javascript('/opFileManagePlugin/js/bootstrap-dropdown') ?>

<?php if ($sf_request->isSmartphone()): ?>
<?php op_smt_use_javascript('jquery.min.js') ?>
<?php op_smt_use_javascript('/opFileManagePlugin/js/bootstrap-dropdown') ?>
<?php endif; ?>

<?php $member = sfContext::getInstance()->getUser()->getMember() ?>
<div class="dropdown operation">

  <button class="btn btn-small dropdwon-toggle" data-toggle="dropdown" id="file_operation_<?php echo $file->id ?>"><span class="caret" style=""></span></button>

  <ul class="dropdown-menu" role="menu" area-labelleby="file_operation_<?php echo $file->id ?>">

  <?php if ($file->isViewable($member)): ?>
    <li>
    <?php echo link_to(
      '<i class="icon-download-alt"></i>&nbsp;'.__('Download'),
      url_for('file_download', $file))
    ?>
    </li>
  <?php endif; ?>

  <?php if ($file->isEditable($member)): ?>
    <li>
      <a href="javascript:void(0)" id="file_edit_name_link_<?php echo $file->getId() ?>">
        <i class="icon-edit"></i>
        <?php echo __('Edit name') ?>
      </a>
    </li>

    <li>
      <a href="javascript:void(0)" id="file_edit_note_link_<?php echo $file->getId() ?>">
        <i class="icon-pencil"></i>
        <?php echo __('Edit note') ?>
      </a>
    </li>
  <?php endif; ?>

  <?php $movable = $file->isMovable($member) ?>
  <?php if ($movable): ?>
    <li>
      <a href="javascript:void(0)" id="file_move_directory_link_<?php echo $file->id ?>">
        <i class="icon-folder-open"></i>
        <?php echo __('Move Folder') ?>
      </a>
    </li>
  <?php endif; ?>

  <?php if ($file->isDeletable($member)): ?>
    <li>
      <?php echo link_to(
        '<i class="icon-trash"></i>&nbsp;'.__('Delete'),
        '@file_delete?id='.$file->getId(),
        array('method' => 'delete',
              'confirm' => __('File name').': '.$file->getName().'\n'.__('Are you sure you want to remove this completely?'))
      ) ?>
    </li>
  <?php endif; ?>

  </ul>

</div>

<?php if ($file->isEditable($member)): ?>
  <?php include_partial('file/editFileNameBox', array('file' => $file, 'trigger' => '#file_edit_name_link_'.$file->getId())) ?>
  <?php include_partial('file/editNote', array('file' => $file, 'trigger' => '#file_edit_note_link_'.$file->id)) ?>
<?php endif; ?>
<?php if ($movable): ?>
  <?php include_partial('file/moveDirectory', array('file' => $file, 'trigger' => '#file_move_directory_link_'.$file->id)) ?>
<?php endif; ?>

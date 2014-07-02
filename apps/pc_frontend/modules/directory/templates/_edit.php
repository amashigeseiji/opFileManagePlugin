<style>
<!--
.btn-group a {
  color: #333333
}
-->
</style>
<div class="btn-group">
  <?php if (opFileManageConfig::get('use_private_directory')): ?>
    <?php if (!$directory->getIsOpen()): ?>
      <?php echo link_to('公開する', '@directory_publish?id='.$directory->getId(), array('method' => 'put', 'class' => 'btn btn-mini')) ?>
    <?php else: ?>
      <?php echo link_to('非公開にする', '@directory_publish?id='.$directory->getId().'&private=true', array('method' => 'put', 'class' => 'btn btn-mini')) ?>
    <?php endif; ?>
  <?php endif; ?>
  <?php echo link_to('<i class="icon icon-trash"></i>', '@directory_delete?id='.$directory->getId(), array('method' => 'delete', 'confirm' => 'フォルダ名: '.$directory->getName().'\nフォルダの中のファイルもすべて削除されます。\nよろしいですか？', 'class' => 'btn btn-mini')) ?>
  <a href="javascript:void(0)" id="directory_edit_name_show_link_<?php echo $directory->getId() ?>" class="btn btn-mini"><i class="icon icon-edit"></i></a>
</div>
<?php include_partial('directory/editDirectoryNameBox', array('directory' => $directory, 'trigger' => '#directory_edit_name_show_link_'.$directory->getId())) ?>

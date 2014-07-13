<style>
<!--
.btn-group a {
  color: #333333
}
-->
</style>
<div class="btn-group">
  <a href="javascript:void(0)" id="directory_edit_name_show_link_<?php echo $directory->getId() ?>" class="btn btn-small"><i class="icon-edit"></i></a>
  <?php echo link_to('<i class="icon-trash"></i>', '@directory_delete?id='.$directory->getId(), array('method' => 'delete', 'confirm' => 'フォルダ名: '.$directory->getName().'\nフォルダの中のファイルもすべて削除されます。\nよろしいですか？', 'class' => 'btn btn-small')) ?>
</div>
<?php include_partial('directory/editDirectoryNameBox', array('directory' => $directory, 'trigger' => '#directory_edit_name_show_link_'.$directory->getId())) ?>

<style>
<!--
.btn-group a {
  color: #333333
}
-->
</style>
<div class="btn-group">
  <a href="javascript:void(0)" id="directory_edit_name_show_link_<?php echo $directory->getId() ?>" class="btn btn-small"><i class="icon icon-edit"></i></a>
  <?php echo link_to('<i class="icon icon-trash"></i>', '@directory_delete?id='.$directory->getId(), array('method' => 'delete', 'confirm' => 'フォルダ名: '.$directory->getName().'\nフォルダの中のファイルもすべて削除されます。\nよろしいですか？', 'class' => 'btn btn-small')) ?>
  <?php if (opFileManageConfig::get('use_private_directory')): ?>
    <?php $word = (!$directory->getIsOpen()) ? '公開する' : '非公開にする' ?>
    <?php $url  = '@directory_publish?id='.$directory->getId().'&redirect='.urlencode($sf_request->getUri()) ?>
    <?php if ($directory->getIsOpen()): ?>
    <?php $url .= '&private=true' ?>
    <?php endif; ?>
    <?php $options = array('method' => 'put', 'class' => 'btn btn-mini', 'style' => 'height: 18px')?>
    <?php echo link_to($word, $url, $options) ?>
  <?php endif; ?>
</div>
<?php include_partial('directory/editDirectoryNameBox', array('directory' => $directory, 'trigger' => '#directory_edit_name_show_link_'.$directory->getId())) ?>

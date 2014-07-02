<?php
  $option = array('name');
  if (opFileManageConfig::get('use_private_directory'))
  {
    $option[] = 'is_open';
  }
?>
<?php include_partial('file/formModal', array(
  'form'    => new FileDirectoryForm(),
  'url'     => url_for('directory_create'),
  'title'   => 'フォルダを追加する',
  'widgets' => $option,
  'id'      => 'directory_create_form',
  'trigger' => $trigger
)) ?>

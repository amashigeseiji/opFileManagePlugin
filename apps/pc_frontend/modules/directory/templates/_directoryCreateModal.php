<?php include_partial('file/formModal', array(
  'form'    => new FileDirectoryForm(),
  'url'     => url_for('directory_create'),
  'title'   => 'フォルダを追加する',
  'widgets' => array('name', 'is_open'),
  'id'      => 'directory_create_form',
  'trigger' => $trigger
)) ?>

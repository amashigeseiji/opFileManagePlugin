<?php include_partial('file/formModal', array(
  'form'    => new ManagedFileForm(array(), array('directory' => $directory)),
  'url'     => url_for('file_upload', $directory),
  'id'      => 'file_upload_form',
  'title'   => 'ファイルをアップロードする',
  'widgets' => array('file'),
  'trigger' => $trigger,
  'submit'  => __('Upload')
)) ?>

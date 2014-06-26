<?php include_partial('file/formModal', array(
  'form'    => $form,
  'url'     => $url,
  'id'      => 'file_upload_form',
  'title'   => 'ファイルをアップロードする',
  'widgets' => array('file'),
  'trigger' => $trigger,
  'submit'  => __('Upload')
)) ?>

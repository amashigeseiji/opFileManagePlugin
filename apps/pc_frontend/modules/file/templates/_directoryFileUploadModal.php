<a href="javascript:void(0)" id="file_upload_show_link" class="btn btn-mini btn-info" style="color: #ffffff">
<?php echo __('Upload') ?>
</a>

<?php include_partial('file/formModal', array(
  'form'    => $form,
  'url'     => url_for($url),
  'id'      => 'file_upload_form',
  'title'   => __('File upload'),
  'widgets' => $widgets,
  'trigger' => '#file_upload_show_link',
  'submit'  => __('Upload')
)) ?>

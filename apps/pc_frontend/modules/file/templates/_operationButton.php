<span class="btn-group">
  <?php echo link_to(
    '<i class="icon-download-alt"></i>',
    url_for('file_download', $file),
    array('class' => 'btn btn-small'))
  ?>
  <?php if ($file->isAuthor()): ?>
    <?php echo link_to(
      '<i class="icon-trash"></i>',
      '@file_delete?id='.$file->getId(),
      array('method' => 'delete',
            'class' => 'btn btn-small',
            'confirm' => 'ファイル名: '.$file->getName().'\n本当に削除してもよろしいですか？')
    ) ?>
  <?php endif; ?>
</span>

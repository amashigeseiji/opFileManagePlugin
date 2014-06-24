<h3>
  <?php echo $directory->getName() ?>
  <?php if ($directory->isAuthor()): ?>
    <small>(<?php echo $directory->getPublicLabel() ?>)</small>
  <?php endif; ?>
  <?php if ($directory->isAuthor()): ?>
    <small>
      <?php include_partial('directory/edit', array('directory' => $directory)) ?>
    </small>
  <?php endif; ?>
</h3>


<h4>
ファイル一覧
<?php if ($directory->getisOpen() || $directory->isAuthor()): ?>
  <small>
    <a href="javascript:void(0)" id="file_upload_show_link" class="btn btn-mini btn-info" style="color: #ffffff">
      <?php echo __('Upload') ?>
    </a>
  </small>
  <?php include_partial('file/fileUploadModal', array(
    'form' => $fileForm,
    'url' => url_for('file_upload', $directory),
    'trigger' => '#file_upload_show_link')
  ) ?>
<?php endif; ?>
</h4>

<table class="table table-striped">
<?php foreach ($files as $file): ?>
  <tr>
    <td>
      <?php echo link_to($file->getName(), 'file_show', $file) ?>
    </td>
    <td>
      <span class="btn-group">
        <a href="<?php echo url_for('file_download', $file) ?>" class="btn btn-small">
          <i class="icon-download-alt"></i>
        </a>
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
    </td>
  </tr>
<?php endforeach; ?>
</table>

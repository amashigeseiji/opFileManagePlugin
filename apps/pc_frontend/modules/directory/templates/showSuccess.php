<style>
.normal {
  font-weight: normal;
  color: #999999;
}
</style>

<table class="table table-striped">
<thead>
<tr>
  <th>
    <?php echo $directory->getName() ?>のファイル
    <?php if ($directory->isAuthor()): ?>
      <span class="normal">
      (<?php echo $directory->getPublicLabel() ?>)
      <?php include_partial('directory/edit', array('directory' => $directory)) ?>
      </span>
    <?php endif; ?>
  </th>
  <td>
    <?php if ($directory->getisOpen() || $directory->isAuthor()): ?>
      <a href="javascript:void(0)" id="file_upload_show_link" class="btn btn-mini btn-info" style="color: #ffffff">
        <?php echo 'アップロード' ?>
      </a>
    <?php endif; ?>
  </td>
</tr>
</thead>
<tbody>
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
</tbody>
</table>
  <?php if ($directory->getisOpen() || $directory->isAuthor()): ?>
    <?php include_partial('file/fileUploadModal', array(
      'form' => $fileForm,
      'url' => url_for('file_upload', $directory),
      'trigger' => '#file_upload_show_link')
    ) ?>
  <?php endif; ?>

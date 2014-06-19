<h3>ファイル情報</h3>
<table>
<tr>
  <th>ファイル名 &nbsp;</th>
  <td>
    <?php echo $file->getFileNameWithExtension() ?> ( <?php echo $file->getFile()->getType() ?> )
    <?php echo link_to('<i class="icon-download-alt"></i>', '@file_download?id='.$file->id, array('class' => 'btn btn-default')) ?>
  </td>
</tr>
<tr>
  <th>サイズ</th>
  <td><?php echo $file->getFilesize() ?></td>
</tr>
<tr>
  <th>フォルダ &nbsp;</th>
  <td><?php echo link_to($directory->getName(), 'directory_show', $directory) ?> ( <?php echo $directory->getPublicLabel() ?> )</td>
</tr>
<tr>
  <th>メンバー &nbsp;</th>
  <td><?php echo $file->getMember()->getName() ?></td>
</tr>
<tr>
  <th>アップロード日時 &nbsp;</th>
  <td><?php echo $file->getDateTimeObject('created_at')->format('Y年m月d日') ?></td>
</tr>
</table>

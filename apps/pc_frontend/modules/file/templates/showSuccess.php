<h3>ファイル情報</h3>
<table>
<tr>
  <th>ファイル名 &nbsp;</th>
  <td><?php echo $file->getFileNameWithExtension() ?></td>
</tr>
<tr>
  <th>ディレクトリ &nbsp;</th>
  <td><?php echo $file->getFileDirectory()->getName() ?></td>
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
<br />
<?php echo link_to('ダウンロード', '@file_download?id='.$file->getId()) ?>

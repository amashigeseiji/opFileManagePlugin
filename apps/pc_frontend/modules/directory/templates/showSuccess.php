<h2><?php echo $directory->getName() ?></h2>
<h3>ファイル</h3>
<ul>
<?php foreach ($files as $file): ?>
  <li>
  <a href="<?php echo url_for('file_download', $file) ?>" class="btn-small"><i class="icon-arrow-down"></i></a>
  <?php echo link_to($file->getFileNameWithExtension(), 'file_show', $file) ?>
  &nbsp;
  </li>
<?php endforeach; ?>
</ul>

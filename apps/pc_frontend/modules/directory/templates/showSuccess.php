<h2><?php echo $directory->getName() ?></h2>
<?php echo link_to('設定', 'directory/edit?id='.$directory->id) ?>
<ul>
<?php foreach ($files as $file): ?>
  <li>
    <a href="<?php echo url_for('file_download', $file) ?>" class="btn-small btn-default">
      <i class="icon-download-alt"></i>
    </a>
    <?php echo link_to($file->getFileNameWithExtension(), 'file_show', $file) ?>
  </li>
<?php endforeach; ?>
</ul>

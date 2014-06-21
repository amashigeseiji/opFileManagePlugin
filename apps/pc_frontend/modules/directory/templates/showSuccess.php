<h3>
  <?php echo $directory->getName() ?>
  <?php if ($directory->isAuthor()): ?>
  <small>(<?php echo $directory->getPublicLabel() ?>)</small>
  <?php endif; ?>
</h3>
<?php if ($directory->isAuthor()): ?>
  <?php include_partial('directory/edit', array('directory' => $directory, 'fileForm' => $fileForm)) ?>
<?php endif; ?>
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

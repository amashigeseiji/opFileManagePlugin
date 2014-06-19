<h3>
  <?php echo $directory->getName() ?>
  <?php if ($directory->isAuthor()): ?>
  <small>(<?php echo $directory->getPublicLabel() ?>)</small>
  <?php endif; ?>
</h3>
<?php if ($directory->isAuthor()): ?>
  <?php if (!$directory->getIsOpen()): ?>
    <?php echo link_to('公開', '@directory_publish?id='.$directory->getId(), array('method' => 'put')) ?>
  <?php else: ?>
    <?php echo link_to('非公開', '@directory_publish?id='.$directory->getId().'&private=true', array('method' => 'put')) ?>
  <?php endif; ?>
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

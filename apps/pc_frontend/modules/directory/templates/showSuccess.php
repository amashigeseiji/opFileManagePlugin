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
    <?php echo __('File list of %1%', array(
      '%1%' => '<span class="dirname_'.$directory->id.'">'.$directory->getName().'</span>'
    )) ?>
    <?php if ('community' === $directory->type): ?>
      <span class="normal">
      (<?php echo $directory->getConfig()->getCommunity()->name ?>)
      <?php include_partial('directory/edit', array('directory' => $directory)) ?>
      </span>
    <?php elseif ($directory->isAuthor()): ?>
      <span class="normal">
      (<?php echo __($directory->getPublicLabel()) ?>)
      <?php include_partial('directory/edit', array('directory' => $directory)) ?>
      </span>
    <?php endif; ?>
  </th>
  <td>
    <?php if ($directory->isUploadable(sfContext::getInstance()->getUser()->getMember())): ?>
      <a href="javascript:void(0)" id="file_upload_show_link" class="btn btn-mini btn-info" style="color: #ffffff">
      <?php echo __('Upload') ?>
      </a>
    <?php endif; ?>
  </td>
</tr>
</thead>
<tbody>
<?php foreach ($pager as $file): ?>
  <tr>
    <td class="filename_<?php echo $file->getId() ?>">
      <?php echo link_to($file->getName(), 'file_show', $file) ?>
    </td>
    <td>
      <?php include_partial('file/operationButton', array('file' => $file)) ?>
    </td>
  </tr>
<?php endforeach; ?>
</tbody>
</table>

<?php if ($pager->getNbResults()): ?>
  <?php op_include_pager_navigation($pager, '@directory_show?id='.$directory->id.'&page=%d'); ?>
<?php else: ?>
  <?php op_include_box('directoryShow', __('There is no file.')) ?>
<?php endif; ?>

<?php if ($directory->isUploadable(sfContext::getInstance()->getUser()->getMember())): ?>
  <?php include_partial('file/fileUploadModal', array(
    'directory' => $directory,
    'trigger'   => '#file_upload_show_link')
  ) ?>
<?php endif; ?>

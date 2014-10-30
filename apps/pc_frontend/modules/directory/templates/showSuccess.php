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
    <?php if ($directory->isEditable(sfContext::getInstance()->getUser()->getMember())): ?>
      <span class="normal">
      (<?php echo ('community' === $directory->type) ?
        $directory->getConfig()->getCommunity()->name : __($directory->getPublicLabel()) ?>)
      </span>
      <?php include_partial('directory/edit', array('directory' => $directory)) ?>
    <?php endif; ?>
    <br />
    <span style="font-weight: normal;color: #666"><?php echo $directory->note ?></span>
  </th>
  <td>
    <?php if ($directory->isUploadable(sfContext::getInstance()->getUser()->getMember())): ?>
    <?php include_component('file', 'directoryFileUploadModal') ?>
    <?php endif; ?>
  </td>
</tr>
</thead>
<tbody>
<?php foreach ($pager as $file): ?>
<?php include_partial('file/fileListRow', array('file' => $file)) ?>
<?php endforeach; ?>
</tbody>
</table>

<?php if ($pager->getNbResults()): ?>
  <?php op_include_pager_navigation($pager, '@directory_show?id='.$directory->id.'&page=%d'); ?>
<?php else: ?>
  <?php op_include_box('directoryShow', __('There is no file.')) ?>
<?php endif; ?>

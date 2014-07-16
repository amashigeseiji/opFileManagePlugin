<?php if ($sf_request->isSmartphone()): ?>
<?php op_smt_use_stylesheet('/opFileManagePlugin/css/smt', 'last') ?>
<?php endif; ?>

<table class="table table-striped">
<thead>
<tr>
  <th><?php echo __('File information') ?></th>
  <td>
    <?php include_partial('file/operationButton', array('file' => $file)) ?>
  </td>
</tr>
</thead>

<tbody>
<tr>
  <th><?php echo __('File name') ?></th>
  <td class="filename_<?php echo $file->getId() ?>" style="width: 50%">
    <?php echo $file->getName() ?>
  </td>
</tr>
<tr>
  <th><?php echo __('File type') ?></th>
  <td><?php echo $file->getFile()->getType() ?></td>
</tr>
<tr>
  <th><?php echo __('File size') ?></th>
  <td><?php echo $file->getFilesize() ?></td>
</tr>
<tr>
  <th><?php echo __('Directory') ?></th>
  <td><?php echo link_to($directory->getName(), 'directory_show', $directory) ?> ( <?php echo $directory->getPublicLabel() ?> )</td>
</tr>
<tr>
  <th><?php echo __('Member') ?></th>
  <td><?php echo $file->getMember()->getName() ?></td>
</tr>
<tr>
  <th><?php echo __('Uploaded at') ?></th>
  <td><?php echo $file->getDateTimeObject('created_at')->format('Y年m月d日') ?></td>
</tr>
</tbody>
</table>

<div class="thumbnail" style="text-align: center">
<?php include_partial('file/thumbnail', array('file' => $file)) ?>
</div>

<table class="table table-striped">

<thead>
<tr>
  <th><?php echo __('File list of %1%', array('%1%' => $member->name)) ?></th>
  <td><?php //include_component('file', 'communityFileUploadModal') ?></td>
</tr>
</thead>

<tbody>
<?php foreach ($pager as $file): ?>
<?php include_partial('file/fileListRow', array('file' => $file, 'dirname' => true)) ?>
<?php endforeach; ?>
</tbody>
</table>

<?php if ($pager->getNbResults()): ?>
  <?php op_include_pager_navigation($pager, '@file_list_member?id='.$member->id.'&page=%d'); ?>
<?php else: ?>
  <?php op_include_box('directoryShow', __('There is no file.')) ?>
<?php endif; ?>

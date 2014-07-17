<table class="table table-striped">

<thead>
<tr>
  <th column=2><?php echo __('File list of %1%', array('%1%' => $community->name)) ?></th>
</tr>
</thead>

<tbody>
<?php foreach ($pager as $file): ?>
<?php include_partial('file/fileListRow', array('file' => $file)) ?>
<?php endforeach; ?>
</tbody>
</table>

<?php if ($pager->getNbResults()): ?>
  <?php op_include_pager_navigation($pager, '@file_list_community?id='.$community->id.'&page=%d'); ?>
<?php else: ?>
  <?php op_include_box('directoryShow', __('There is no file.')) ?>
<?php endif; ?>

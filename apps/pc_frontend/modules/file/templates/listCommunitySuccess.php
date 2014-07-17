<table class="table table-striped">

<thead>
<tr>
  <th><?php echo $community->name ?>のファイル一覧</th>
  <td>
    <a href="javascript:void(0)" id="file_upload_show_link" class="btn btn-mini btn-info" style="color: #ffffff">
    <?php echo __('Upload') ?>
    </a>
  </td>
</tr>
</thead>

<tbody>
<?php foreach ($pager as $file): ?>
<?php include_partial('file/fileListRow', array('file' => $file)) ?>
<?php endforeach; ?>
</tbody>
</table>

<table class="table table-striped">
<thead>
<th>
<?php echo $member->getName() ?>のフォルダ一覧
</th>
<?php if ($sf_user->getMemberId() === $member->getId()): ?>
<td>
<a href="javascript:void(0)" id="directory_create_link">フォルダを追加する</a>
</td>
<?php endif; ?>
</thead>

<tbody>
<?php if ($pager->getNbResults()): ?>
<?php foreach ($pager as $directory): ?>
<tr>
<td>
<?php if ($directory->isAuthor()): ?>
<a href="javascript:void(0)" id="edit_directory_name_show_link_<?php echo $directory->getId() ?>" class="btn btn-mini"><i class="icon-edit"></i></a>
  <?php include_partial('directory/editDirectoryNameBox', array('directory' => $directory, 'trigger' => '#edit_directory_name_show_link_'.$directory->getId())) ?>
<?php endif; ?>
<span class="dirname_<?php echo $directory->id ?>">
<?php echo link_to($directory->getName(), '@directory_show?id='.$directory->getId()) ?>
</span>
</td>
<?php if ($directory->isAuthor()): ?>
<td style="width: 40%">
<?php echo $directory->getPublicLabel() ?>
</td>
<?php endif; ?>
</tr>
<?php endforeach; ?>
<?php endif; ?>
</tbody>
</table>

<?php if ($pager->getNbResults()): ?>
<?php $uri = $sf_request->getParameter('id') ?
  '@directory_list_member?id='.$member->getId().'&page=%d' : '@directory_list?page=%d' ?>
<?php op_include_pager_navigation($pager, $uri); ?>
<?php else: ?>
<?php op_include_box('DirectoryList', 'フォルダがありません。') ?>
<?php endif; ?>

<?php include_partial('directory/directoryCreateModal', array('trigger' => '#directory_create_link')) ?>

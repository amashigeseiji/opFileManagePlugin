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
<?php echo link_to($directory->getName(), '@directory_show?id='.$directory->getId()) ?>
</td>
<?php if ($directory->isAuthor()): ?>
<td>
<?php echo $directory->getPublicLabel() ?>
</td>
<?php endif; ?>
</tr>
<?php endforeach; ?>
<?php endif; ?>
</tbody>
</table>

<?php if ($pager->getNbResults()): ?>
<?php op_include_pager_navigation($pager, '@directory_list?page=%d'); ?>
<?php else: ?>
<?php op_include_box('DirectoryList', 'フォルダがありません。') ?>
<?php endif; ?>

<?php include_partial('directory/directoryCreateModal', array('trigger' => '#directory_create_link')) ?>

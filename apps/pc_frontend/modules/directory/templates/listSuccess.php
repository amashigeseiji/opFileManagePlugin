<?php if ($sf_request->isSmartphone()): ?>
<?php op_smt_use_stylesheet('/opFileManagePlugin/css/smt') ?>
<?php endif; ?>

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
<?php include_partial('directory/listRow', array('directory' => $directory)) ?>
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

<?php include_component('directory', 'directoryCreateModal', array('trigger' => '#directory_create_link')) ?>

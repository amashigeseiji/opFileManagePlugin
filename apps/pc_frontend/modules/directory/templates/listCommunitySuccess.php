<?php if ($sf_request->isSmartphone()): ?>
<?php op_smt_use_stylesheet('/opFileManagePlugin/css/smt') ?>
<?php endif; ?>

<table class="table table-striped">
<thead>
<th>
<?php echo $community->getName() ?>のフォルダ一覧
</th>
<td>
<a href="javascript:void(0)" id="directory_create_link">フォルダを追加する</a>
</td>
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
  '@directory_list_community?id='.$community->getId().'&page=%d' : '@directory_list?page=%d' ?>
<?php op_include_pager_navigation($pager, $uri); ?>
<?php else: ?>
<?php op_include_box('DirectoryList', 'フォルダがありません。') ?>
<?php endif; ?>

<?php include_component('directory', 'communityDirectoryCreateModal', array('trigger' => '#directory_create_link')) ?>

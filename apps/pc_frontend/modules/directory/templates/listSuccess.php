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
<tr>
<td class="dirname-list">
<?php if ($directory->isAuthor()): ?>
<?php include_partial('directory/edit', array('directory' => $directory)) ?>
<?php endif; ?>
<span class="dirname_<?php echo $directory->id ?> dirname">
<?php echo link_to($directory->getName(), '@directory_show?id='.$directory->getId()) ?>
</span>
</td>
<?php if ($directory->isAuthor()): ?>
<td style="width: 30%">
<?php echo $directory->getPublicLabel() ?>
<?php if ('private' === $directory->getType() || 'public' === $directory->getType()): ?>
<?php $word = ($directory->isPrivate()) ? '公開する' : '非公開にする' ?>
<?php $url  = '@directory_publish?id='.$directory->getId().'&redirect='.urlencode($sf_request->getUri()) ?>
<?php $url .= ($directory->isPrivate()) ? '&publish=public' : '&publish=private'?>
&nbsp;<small>(<?php echo link_to($word, $url, array('method' => 'put')) ?>)</small>
<?php endif; ?>
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

<?php include_component('directory', 'directoryCreateModal', array('trigger' => '#directory_create_link')) ?>

<table class="table table-striped">
<thead>
<th>
<?php echo __('Directory list of %1%', array('%1%' => $member->getName())) ?>
</th>
<?php if ($sf_user->getMemberId() === $member->getId()): ?>
<td>
<?php include_component('directory', 'directoryCreateModal') ?>
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
<?php op_include_box('DirectoryList', __('There is no directory.')) ?>
<?php endif; ?>


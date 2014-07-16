<table class="table table-striped">
<thead>
<th>
<?php echo __('Directory list of %1%', array('%1%' => $community->getName())) ?>
</th>
<td>
<a href="javascript:void(0)" id="directory_create_link"><?php echo __('Create directory') ?></a>
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
<?php op_include_box('DirectoryList', __('There is no directory.')) ?>
<?php endif; ?>

<?php include_component('directory', 'communityDirectoryCreateModal', array('trigger' => '#directory_create_link')) ?>

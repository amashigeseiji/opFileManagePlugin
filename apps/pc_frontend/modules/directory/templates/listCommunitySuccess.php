<div class="partsHeading">
<?php echo __('Directory list of %1%', array('%1%' => $community->getName())) ?>
</div>
<div class="pull-right">
<?php include_component('directory', 'communityDirectoryCreateModal', array('community' => $community)) ?>
</div>

<?php if ($pager->getNbResults()): ?>

<?php include_partial('directory/listTable', array('pager' => $pager, 'member' => true)) ?>

<?php $uri = $sf_request->getParameter('id') ?
  '@directory_list_community?id='.$community->getId().'&page=%d' : '@directory_list?page=%d' ?>
<?php op_include_pager_navigation($pager, $uri); ?>
<?php else: ?>
<?php op_include_box('DirectoryList', __('There is no directory.')) ?>
<?php endif; ?>

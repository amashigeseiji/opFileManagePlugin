<?php
  $isPublic = isset($isPublic) ? $isPublic : false;
  $member = isset($member) ? $member : false;
?>
<table class="table table-striped">

<thead>
<?php if ($pager->getNbResults()): ?>
<th><?php echo __('Operation') ?></th>
<th><?php echo __('Directory name') ?></th>
<?php if ($member): ?>
<th><?php echo __('Member') ?></th>
<?php endif; ?>
<th><?php echo __('Note') ?></th>
<?php if ($isPublic): ?>
<th><?php echo __('Is Public') ?></th>
<?php endif; ?>
<?php endif; ?>
</thead>

<tbody>
<?php if ($pager->getNbResults()): ?>
<?php foreach ($pager as $directory): ?>
<?php include_partial('directory/listRow', array('directory' => $directory, 'isPublic' => $isPublic, 'member' => $member)) ?>
<?php endforeach; ?>
<?php endif; ?>
</tbody>

</table>

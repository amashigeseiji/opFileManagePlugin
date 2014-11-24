<?php if($pager->getNbResults()): ?>
<table class="table table-striped">

<thead>
  <th><?php echo __('Operation') ?></th>
  <th><?php echo __('File name') ?></th>
  <?php if (isset($dirname) && $dirname): ?>
  <th><?php echo __('Directory') ?></th>
  <?php endif; ?>
  <?php if (isset($member) && $member): ?>
  <th><?php echo __('Member') ?></th>
  <?php endif; ?>
  <th><?php echo __('Note') ?></th>
</thead>

<tbody>
<?php
$options = array();
if (isset($member) && $member)
{
  $options['member'] = true;
}
if (isset($dirname) && $dirname)
{
  $options['dirname'] = true;
}
?>

<?php foreach ($pager->getResults() as $file): ?>
<?php $options['file'] = $file ?>
<?php include_partial('file/fileListRow', $options) ?>
<?php endforeach; ?>
</tbody>

</table>
<?php endif; ?>

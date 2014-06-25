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
<?php foreach ($directories as $key => $directory): ?>
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
</tbody>
</table>

<?php include_component('directory', 'formModal', array('trigger' => '#directory_create_link')) ?>

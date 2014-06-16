<h3>Directory list</h3>
<table>
<?php foreach ($directories as $key => $directory): ?>
<tr>
<td>
<?php echo link_to($directory->getName(), 'directory/show?id='.$directory->getId(), $directory) ?>
</td>
</tr>
<?php endforeach; ?>
</table>

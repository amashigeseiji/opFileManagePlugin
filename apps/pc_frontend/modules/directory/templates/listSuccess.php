<h4>
フォルダ一覧
<small><a href="javascript:void(0)" id="directory_create_link">フォルダを追加する</a></small>
</h4>

<ul>
<?php foreach ($directories as $key => $directory): ?>
<li>
<?php echo link_to($directory->getName(), '@directory_show?id='.$directory->getId()) ?>
<?php if ($directory->isAuthor()): ?>
 ( <?php echo $directory->getPublicLabel() ?> )
<?php endif; ?>
</li>
<?php endforeach; ?>
</ul>

<?php include_component('directory', 'formModal', array('trigger' => '#directory_create_link')) ?>

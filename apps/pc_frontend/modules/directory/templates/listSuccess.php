<h3>ディレクトリ一覧</h3>
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

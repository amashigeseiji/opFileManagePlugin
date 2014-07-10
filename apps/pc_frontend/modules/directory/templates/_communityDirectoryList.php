<?php if ($isCommunityMember): ?>
<tr>
<th>
共有フォルダ
</th>
<td>
<?php if ($pager->getNbResults()): ?>
<ul>
<?php foreach ($pager as $directory): ?>
<?php if ($directory->isViewable(sfContext::getInstance()->getUser()->getMember())): ?>
<li>
<?php echo link_to($directory->name, '@directory_show?id='.$directory->id) ?>
</li>
<?php endif; ?>
<?php endforeach; ?>
</ul>
<?php endif; ?>
</td>
</tr>
<?php endif; ?>

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
<ul class="moreInfo" style="float: right;">
<li>
<a href="javascript:void(0)" id="directory_create_link">フォルダを追加する</a>
</li>
<li>
<?php echo link_to(__('More'), '@directory_list_community?id='.$community->id) ?>
</li>
</ul>
<?php include_component('directory', 'communityDirectoryCreateModal', array('trigger' => '#directory_create_link', 'community' => $community)) ?>
</td>
</tr>

<tr>
<th>
<?php echo __('Shared directory') ?>
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
<a href="javascript:void(0)" id="directory_create_link"><?php echo __('Create directory') ?></a>
</li>
<li>
<?php echo link_to(__('Directory list of %1%', array('%1%' => $community->name)), '@directory_list_community?id='.$community->id) ?>
</li>
<li>
<?php echo link_to(__('File list of %1%', array('%1%' => $community->name)), '@file_list_community?id='.$community->id) ?>
</li>
</ul>
<?php include_component('directory', 'communityDirectoryCreateModal', array('trigger' => '#directory_create_link', 'community' => $community)) ?>
</td>
</tr>

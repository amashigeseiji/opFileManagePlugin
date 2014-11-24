<tr>
<td class="operation">
<?php include_partial('directory/edit', array('directory' => $directory)) ?>
</td>
<td class="dirname-list">
<span class="dirname_<?php echo $directory->id ?> dirname">
<?php echo link_to($directory->getName(), '@directory_show?id='.$directory->getId()) ?>
</span>
</td>
<td>
<?php echo $directory->note ?>
</td>
<?php if (opFileManageConfig::isUsePrivate() && opFileManageConfig::isUsePublic() && 'community' !== $directory->type && $directory->isAuthor()): ?>
<td style="width: 30%">
<?php echo __($directory->getPublicLabel()) ?>
<?php if (opFileManageConfig::isUsePrivate() && opFileManageConfig::isUsePublic()): ?>
<?php $word = ($directory->isPrivate()) ? __('Publish') : __('Take private') ?>
<?php $url  = '@directory_publish?id='.$directory->getId().'&redirect='.urlencode($sf_request->getUri()) ?>
<?php $url .= ($directory->isPrivate()) ? '&publish=public' : '&publish=private'?>
&nbsp;<small>(<?php echo link_to($word, $url, array('method' => 'put')) ?>)</small>
<?php endif; ?>
</td>
<?php endif; ?>
</tr>

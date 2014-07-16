<tr>
<td class="dirname-list"<?php if ('community' === $directory->type || !$directory->isAuthor()): ?> colspan=2<?php endif; ?>>
<?php if ($directory->isAuthor()): ?>
<?php include_partial('directory/edit', array('directory' => $directory)) ?>
<?php endif; ?>
<span class="dirname_<?php echo $directory->id ?> dirname">
<?php echo link_to($directory->getName(), '@directory_show?id='.$directory->getId()) ?>
</span>
</td>
<?php if ($directory->isAuthor() && 'community' !== $directory->type): ?>
<td style="width: 30%">
<?php echo __($directory->getPublicLabel()) ?>
<?php if ('private' === $directory->getType() || 'public' === $directory->getType()): ?>
<?php $word = ($directory->isPrivate()) ? __('Publish') : __('Take private') ?>
<?php $url  = '@directory_publish?id='.$directory->getId().'&redirect='.urlencode($sf_request->getUri()) ?>
<?php $url .= ($directory->isPrivate()) ? '&publish=public' : '&publish=private'?>
&nbsp;<small>(<?php echo link_to($word, $url, array('method' => 'put')) ?>)</small>
<?php endif; ?>
</td>
<?php endif; ?>
</tr>

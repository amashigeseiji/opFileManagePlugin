<table class="table table-striped">
<thead>
<tr>
  <th><?php echo __('File information') ?></th>
  <td>
    <?php include_partial('file/operationButton', array('file' => $file)) ?>
  </td>
</tr>
</thead>

<tbody>
<tr>
  <th><?php echo __('File name') ?></th>
  <td class="filename_<?php echo $file->getId() ?>" style="width: 50%">
    <?php echo $file->getName() ?>
  </td>
</tr>
<tr>
  <th><?php echo __('File type') ?></th>
  <td><?php echo $file->getFile()->getType() ?></td>
</tr>
<tr>
  <th><?php echo __('File size') ?></th>
  <td><?php echo $file->getFilesize() ?></td>
</tr>
<tr>
  <th><?php echo __('Directory') ?></th>
  <td>
    <?php echo link_to($directory->getName(), 'directory_show', $directory) ?>
    ( <?php echo 'community' === $directory->type ?
      link_to($directory->getConfig()->getCommunity()->name, '@community_home?id='.$directory->getConfig()->getCommunityid()) :
      __($directory->getPublicLabel()) ?> )
  </td>
</tr>
<tr>
  <th><?php echo __('Member') ?></th>
  <td><?php echo $file->getMember()->getName() ?></td>
</tr>
<tr>
  <th><?php echo __('Uploaded at') ?></th>
  <td><?php echo $file->getDateTimeObject('created_at')->format('Y年m月d日') ?></td>
</tr>
<tr>
  <th><?php echo __('Download link') ?></th>
  <td>
    <div class="input-append">
      <input type="text" id="download-link" readonly="readonly" value="<?php echo url_for('@file_download?id='.$file->id, true) ?>" style="background-color: white;cursor:auto" onclick="$(this).select()" />
      <span class="add-on" onclick="$('#download-link').select()"><i class="icon-list-alt"></i></span>
    </div>
  </td>
</tr>
</tbody>
</table>

<?php include_partial('file/thumbnail', array('file' => $file)) ?>

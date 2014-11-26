<tr>
  <td class="operation">
    <?php include_partial('file/operationButton', array('file' => $file)) ?>
  </td>
  <td class="filename_<?php echo $file->getId() ?>">
    <?php echo link_to($file->getName(), 'file_show', $file) ?>
  </td>
  <?php if (isset($dirname) && $dirname): ?>
  <td>
    <?php echo link_to($file->directory->name, '@directory_show?id='.$file->directory->id) ?>
  </td>
  <?php endif; ?>
  <?php if (isset($member) && $member): ?>
  <td>
    <?php echo link_to($file->Member, '@member_profile?id='.$file->Member->id) ?>
  </td>
  <?php endif; ?>
  <td>
    <?php echo $file->note ?>
  </td>
</tr>

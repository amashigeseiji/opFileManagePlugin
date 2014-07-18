<tr>
  <td class="filename_<?php echo $file->getId() ?>">
    <?php echo link_to($file->getName(), 'file_show', $file) ?>
    <?php if (isset($dirname) && $dirname): ?>
    &nbsp;(<?php echo link_to($file->FileDirectory->name, '@directory_show?id='.$file->FileDirectory->id) ?>)
    <?php endif; ?>
  </td>
  <td>
    <?php include_partial('file/operationButton', array('file' => $file)) ?>
  </td>
</tr>

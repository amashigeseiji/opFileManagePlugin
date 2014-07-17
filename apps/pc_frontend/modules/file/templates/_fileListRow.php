<tr>
  <td class="filename_<?php echo $file->getId() ?>">
    <?php echo link_to($file->getName(), 'file_show', $file) ?>
  </td>
  <td>
    <?php include_partial('file/operationButton', array('file' => $file)) ?>
  </td>
</tr>

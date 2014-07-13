<?php use_javascript('/opFileManagePlugin/js/lib/vendor/bootstrap-modal', 'last') ?>
<?php if ($sf_request->isSmartphone()): ?>
<?php use_helper('opAsset') ?>
<?php op_smt_use_javascript('/opFileManagePlugin/js/lib/vendor/bootstrap-modal', 'last') ?>
<?php endif; ?>

<script type="text/javascript">
$(document).ready(function() {
  $('<?php echo $trigger ?>').on('click', function() {
    $('#<?php echo $id ?>').modal('show');
  });
});
</script>

<?php echo $form->renderFormTag($url, array('class' => 'modal hide', 'id' => $id)) ?>
  <div class="modal-header text-center">
    <strong><?php echo $title ?></strong>
  </div>

  <div class="modal-body">
    <table style="width: 80%; margin: 0 auto;">
    <?php foreach ($widgets as $widget): ?>
      <tr>
        <th><?php echo $form[$widget]->renderLabel() ?></th>
        <td><?php echo $form[$widget] ?></td>
      </tr>
    <?php endforeach; ?>
    </table>
  </div>

  <div class="modal-footer" style="text-align:center;">
    <?php echo $form->renderHiddenFields() ?>
    <input type="submit" class="btn btn-primary" <?php if (isset($submit)): ?>value="<?php echo __($submit) ?>"<?php endif; ?> />
  </div>

</form>

<?php use_javascript('/opFileManagePlugin/js/bootstrap-modal', 'last') ?>

<script type="text/javascript">
$(document).ready(function() {
  $('<?php echo $trigger ?>').on('click', function() {
    $('#<?php echo $id ?>').modal('show');
  });
});
</script>

<?php echo $form->renderFormTag($url, array('class' => 'modal hide', 'id' => $id)) ?>
  <div class="modal-header">
    <strong><?php echo $title ?></strong>
  </div>

  <div class="modal-body">
    <?php echo $form ?>
  </div>

  <div class="modal-footer" style="text-align:center;">
    <input type="submit" class="btn btn-primary" <?php if ($submit): ?>value="<?php echo __($submit) ?>"<?php endif; ?> />
  </div>

</form>

<?php use_javascript('/opFileManagePlugin/js/lib/vendor/bootstrap-modal', 'last') ?>
<?php use_stylesheet('/opFileManagePlugin/css/modal') ?>
<?php if ($sf_request->isSmartphone()): ?>
<?php use_helper('opAsset') ?>
<?php op_smt_use_javascript('/opFileManagePlugin/js/lib/vendor/bootstrap-modal', 'last') ?>
<?php op_smt_use_stylesheet('/opFileManagePlugin/css/modal') ?>
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
    <ul>
    <?php foreach ($widgets as $widget): ?>
      <li>
        <span class="form-label"><?php echo $form[$widget]->renderLabel() ?></span>
        <span><?php echo $form[$widget] ?></span>
      </li>
    <?php endforeach; ?>
    </ul>
  </div>

  <div class="modal-footer" style="text-align:center;">
    <?php echo $form->renderHiddenFields() ?>
    <input type="submit" class="btn btn-primary" value=<?php echo (isset($submit)) ? __($submit) : __('Send') ?> />
  </div>

</form>

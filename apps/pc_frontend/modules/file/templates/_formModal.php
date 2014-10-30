<?php use_javascript('/opFileManagePlugin/js/lib/vendor/bootstrap-modal', 'last') ?>
<?php if ($sf_request->isSmartphone()): ?>
<?php use_helper('opAsset') ?>
<?php op_smt_use_javascript('/opFileManagePlugin/js/lib/vendor/bootstrap-modal', 'last') ?>
<?php endif; ?>

<style>
.modal {
  margin-top: 0;
}
.modal-body li {
  display: table;
  margin: 10px 0;
}
.modal-body li>span {
  display: table-cell;
}
.modal-body li>span.form-label {
  width: 80px;
}
.modal-body li>span select {
  vertical-align: baseline;
}
</style>

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

<?php use_javascript('/opFileManagePlugin/js/bootstrap-modal', 'last') ?>
<script type="text/javascript">
$(document).ready(function() {
  $('<?php echo $trigger ?>').on('click', function() {
    $('#directory_create_form').modal('show');
  });
});
</script>

<?php echo $form->renderFormTag(url_for('directory_create'), array('class' => 'modal hide', 'id' => 'directory_create_form')) ?>

  <div class="modal-header">
    <strong>フォルダを追加する</strong>
  </div>

  <div class="modal-body">
    <table style="width: 80%">
      <tr>
        <th>フォルダ名</th>
        <td><?php echo $form['name'] ?></td>
      </tr>
      <tr>
        <th>公開する</th>
        <td><?php echo $form['is_open'] ?></td>
      </tr>
    </table>
  </div>

  <div class="modal-footer" style="text-align: center">
    <?php echo $form->renderHiddenFields() ?>
    <input type="submit" class="btn btn-primary" value='送信' />
  </div>

</form>

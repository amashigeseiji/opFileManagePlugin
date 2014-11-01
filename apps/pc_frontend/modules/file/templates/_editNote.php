<?php
$options = array(
  'method'  => 'put',
  'class'   => 'btn btn-small btn-primary',
  'style'   => 'color: #ffffff'
);
$root = 'file_edit_note_'.$file->id;
?>
<div id="<?php echo $root ?>" class="hide">
  <span class="form form-inline">
    <input type="text" placeholder="<?php echo __('Update note') ?>" />
    <?php echo link_to(__('Modify'), '@file_edit?id='.$file->getId(), $options) ?>
  </span>
</div>

<script type="text/javascript">
$(document).ready(function() {
  var root = $('#<?php echo $root ?>');

  var toggle = function() {
    if (root.hasClass('hide')) {
      root.removeClass('hide');
    } else {
      root.addClass('hide');
    }
  }

  $("<?php echo $trigger ?>").on('click', toggle);

  root.find('input').on('keyup', function() {
    root.find('a').attr('href', "<?php echo url_for('@file_edit?id='.$file->id) ?>" + '?note=' + this.value);
  });
});
</script>

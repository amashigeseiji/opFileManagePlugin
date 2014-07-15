<?php use_javascript('/opFileManagePlugin/js/lib/vendor/require.js', 'first', array('data-main' => '/opFileManagePlugin/js/app.js')) ?>

<script type="text/javascript">
if (typeof(selector) === 'undefined') {
  var selector = [];
}
selector.push({
    root:'.filename_<?php echo $file->id ?>',
    activeContents:'#file_edit_name_<?php echo $file->id ?>',
    trigger: '<?php echo $trigger ?>'
});
</script>

<?php
$options = array(
  'method'  => 'put',
  'class'   => 'btn btn-small btn-primary',
  'style'   => 'color: #ffffff'
);
?>
<div id="file_edit_name_<?php echo $file->getId() ?>" class="hide">
  <span class="form form-inline">
    <input type="text" placeholder="<?php echo $file->getName() ?>" />
    <?php echo link_to('確定', '@file_edit_name?id='.$file->getId().'&redirect='.$sf_request->getUri(), $options) ?>
  </span>
</div>

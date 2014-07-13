<?php use_javascript('/opFileManagePlugin/js/lib/vendor/require.js', 'first', array('data-main' => '/opFileManagePlugin/js/app.js')) ?>
<?php if ($sf_request->isSmartphone()): ?>
<?php use_helper('opAsset') ?>
<?php op_smt_use_javascript('/opFileManagePlugin/js/lib/vendor/require.js', 'first', array('data-main' => '/opFileManagePlugin/js/app.js')) ?>
<?php endif; ?>

<script type="text/javascript">
if (typeof(selector) === 'undefined') {
  var selector = [];
}
selector.push({
    root:'.dirname_<?php echo $directory->id ?>',
    activeContents:'#directory_edit_name_<?php echo $directory->id ?>',
    trigger: '<?php echo $trigger ?>'
});
</script>

<?php
$options = array(
  'method'  => 'put',
  'class'   => 'btn btn-mini btn-primary',
  'style'   => 'color: #ffffff'
);
?>
<div id="directory_edit_name_<?php echo $directory->id ?>" class="hide">
<span class="form form-horizontal">
  <input type="text" placeholder="<?php echo $directory->getName() ?>" class="font-size: small; height: 15px" />
  <?php echo link_to('変更', '@directory_edit_name?id='.$directory->getId().'&redirect='.$sf_request->getUri(), $options) ?>
  </span>
</div>

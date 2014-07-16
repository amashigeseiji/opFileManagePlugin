<style>
.hide {
  display: none !important;
}
</style>

<script type="text/javascript">
$(document).ready( function() {
  var toggle = function(dom, link, word) {
    if (!dom.hasClass('hide')) {
      dom.addClass('hide');
      link.html(word.to_open);
    } else {
      dom.removeClass('hide');
      link.html(word.to_close);
    }
  }

  $('.toggle-text').on('click', function () {
    toggle($('.text'), $(this), { to_open: "<?php echo __('Preview') ?>", to_close: "<?php echo __('Hide') ?>" });
  });

  $('.toggle-image').on('click', function() {
    toggle($('.preview-image'), $(this), { to_open: "<?php echo __('Preview') ?>", to_close: "<?php echo __('Hide') ?>" });
  });
});
</script>

<?php if ($file->isImage()): ?>
  <a href="javascript:void(0)" class="toggle-image"><?php echo __('Preview') ?></a>
  <?php echo op_image_tag_sf_image($file->getFile()->getName(), array('size' => '320x320', 'class' => 'hide preview-image')) ?>
<?php elseif ($file->isText()): ?>
<a href="javascript:void(0)" class="toggle-text"><?php echo __('Preview') ?></a>
<div class="text hide">
<pre class="prettyprint linenums">
<?php echo $file->getBin() ?>
</pre>
</div>
<?php endif; ?>

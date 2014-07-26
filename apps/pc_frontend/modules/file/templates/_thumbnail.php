<?php if ($file->isText() || $file->isImage()): ?>
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

  $('.toggle').on('click', function() {
    toggle($('.preview'), $(this), { to_open: "<?php echo __('Preview') ?>", to_close: "<?php echo __('Hide') ?>" });
  });
});
</script>

<div class="thumbnail" style="text-align: center">
  <a href="javascript:void(0)" class="toggle" style="display: block; width: 100%"><?php echo __('Preview') ?></a>
  <?php if ($file->isImage()): ?>
    <?php echo op_image_tag_sf_image($file->getFile()->getName(), array('size' => '320x320', 'class' => 'hide preview')) ?>
  <?php elseif ($file->isText()): ?>
    <div class="hide preview">
      <pre class="prettyprint linenums">
      <?php echo $file->getText() ?>
      </pre>
    </div>
  <?php endif; ?>
</div>
<?php endif; ?>

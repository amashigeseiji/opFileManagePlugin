<script type="text/javascript">
$(document).ready( function() {
  var toggle = function() {
    var t = $('.text');
    if (t.hasClass('active')) {
      t.removeClass('active');
      t.hide();
      $(this).html('テキストを表示する');
    } else {
      t.addClass('active');
      t.show();
      $(this).html('テキストを隠す');
    }
  }
  $('.toggle-text').on('click', toggle);
});
</script>

<?php if ($file->isImage()): ?>
<div class="thumnail">
  <?php echo op_image_tag_sf_image($file->getFile()->getName()) ?>
</div>
<?php elseif ($file->isText()): ?>
<a href="javascript:void(0)" class="toggle-text">テキストを表示する</a>
<div class="text hide">
<pre class="prettyprint linenums">
<?php echo $file->getBin() ?>
</pre>
</div>
<?php endif; ?>

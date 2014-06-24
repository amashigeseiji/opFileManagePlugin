<style>
.hide {
  display: none !important;
}
</style>

<script type="text/javascript">
$(document).ready( function() {
  var toggle = function(dom, word) {
    if (dom.hasClass('active')) {
      dom.removeClass('active');
      dom.addClass('hide');
      $(this).html(word.to_open);
    } else {
      dom.addClass('active');
      dom.removeClass('hide');
      $(this).html(word.to_open);
    }
  }

  $('.toggle-text').on('click', function () {
    toggle($('.text'), { to_open: 'テキストを表示する', to_close: 'テキストを隠す' });
  });

  $('.toggle-image').on('click', function() {
    toggle($('.preview-image'), { to_open: '画像を表示する', to_close: '画像を隠す' });
  });
});
</script>

<?php if ($file->isImage()): ?>
  <a href="javascript:void(0)" class="toggle-image">画像を表示する</a>
  <?php echo op_image_tag_sf_image($file->getFile()->getName(), array('size' => '240x320', 'class' => 'hide preview-image')) ?>
<?php elseif ($file->isText()): ?>
<a href="javascript:void(0)" class="toggle-text">テキストを表示する</a>
<div class="text hide">
<pre class="prettyprint linenums">
<?php echo $file->getBin() ?>
</pre>
</div>
<?php endif; ?>

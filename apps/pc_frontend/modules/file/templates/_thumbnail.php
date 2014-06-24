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
    toggle($('.text'), $(this), { to_open: 'テキストを表示する', to_close: 'テキストを隠す' });
  });

  $('.toggle-image').on('click', function() {
    toggle($('.preview-image'), $(this), { to_open: '画像を表示する', to_close: '画像を隠す' });
  });
});
</script>

<?php if ($file->isImage()): ?>
  <a href="javascript:void(0)" class="toggle-image">画像を表示する</a>
  <?php echo op_image_tag_sf_image($file->getFile()->getName(), array('size' => '320x320', 'class' => 'hide preview-image')) ?>
<?php elseif ($file->isText()): ?>
<a href="javascript:void(0)" class="toggle-text">テキストを表示する</a>
<div class="text hide">
<pre class="prettyprint linenums">
<?php echo $file->getBin() ?>
</pre>
</div>
<?php endif; ?>

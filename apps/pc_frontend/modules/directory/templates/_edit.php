<script type="text/javascript">
$(document).ready(function() {
  $('#directory_edit_name_show_link').on('click', function() {
    var
      _self = $(this),
      to_open = '名前を変更する',
      to_close = '中止',
      link = $('.directory_edit_name_form'),
      href = link.attr('href'),
      div = $('#directory_edit_name');

    $('.directory_edit_name_input').on('keyup', function () {
      link.attr('href', href + '?name=' + this.value);
    });

    if (!div.hasClass('active')) {
      div.addClass('active');
      div.show();
      _self.html(to_close);
    } else {
      div.removeClass('active');
      div.hide();
      _self.html(to_open);
    }
  });
});
</script>

<?php if (!$directory->getIsOpen()): ?>
  <?php echo link_to('公開', '@directory_publish?id='.$directory->getId(), array('method' => 'put')) ?>
<?php else: ?>
  <?php echo link_to('非公開', '@directory_publish?id='.$directory->getId().'&private=true', array('method' => 'put')) ?>
<?php endif; ?>

<a href="javascript:void(0)" id="directory_edit_name_show_link">名前を変更する</a>
<div id="directory_edit_name" class="hide">
  <input type="text" class="directory_edit_name_input" />
  <?php echo link_to('確定', '@directory_edit_name?id='.$directory->getId(), array('method' => 'put', 'class' => 'directory_edit_name_form btn btn-default')) ?>
</div>

<?php echo link_to('削除', '@directory_delete?id='.$directory->getId(), array('method' => 'delete', 'confirm' => 'ディレクトリ配下のファイルもすべて削除されます。\nよろしいですか？')) ?>

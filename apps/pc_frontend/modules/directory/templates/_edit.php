<script type="text/javascript">
$(document).ready(function() {
  var toggle = function(div, link, word) {
    if (!div.hasClass('active')) {
      div.addClass('active');
      div.show();
      link.html(word.to_close);
    } else {
      div.removeClass('active');
      div.hide();
      link.html(word.to_open);
    }
  };

  $('#directory_edit_name_show_link').on('click', function() {
    var
      div = $('#directory_edit_name'),
      link = div.find('a'),
      href = link.attr('href');

    div.find('input[type=text]').on('keyup', function () {
      link.attr('href', href + '?name=' + this.value);
    });

    toggle(div, $(this), { to_open : '名前を変更する', to_close: '中止' });
  });
});
</script>

<style>
<!--
.btn-group a {
  color: #333333
}
-->
</style>
<div class="btn-group">
  <?php if (!$directory->getIsOpen()): ?>
    <?php echo link_to('公開する', '@directory_publish?id='.$directory->getId(), array('method' => 'put', 'class' => 'btn btn-mini')) ?>
  <?php else: ?>
    <?php echo link_to('非公開にする', '@directory_publish?id='.$directory->getId().'&private=true', array('method' => 'put', 'class' => 'btn btn-mini')) ?>
  <?php endif; ?>
  <?php echo link_to(__('Delete'), '@directory_delete?id='.$directory->getId(), array('method' => 'delete', 'confirm' => 'フォルダの中のファイルもすべて削除されます。\nよろしいですか？', 'class' => 'btn btn-mini')) ?>
  <a href="javascript:void(0)" id="directory_edit_name_show_link" class="btn btn-mini">名前を変更する</a>
</div>

<div id="directory_edit_name" class="hide form form-inline">
  <input type="text" placeholder="フォルダ名を入力してください" />
  <?php echo link_to('確定', '@directory_edit_name?id='.$directory->getId(), array('method' => 'put', 'class' => 'btn btn-small btn-primary', 'style' => 'color: #ffffff')) ?>
</div>

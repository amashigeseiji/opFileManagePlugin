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
<ul class="inline">
  <li>
    <?php if (!$directory->getIsOpen()): ?>
      <?php echo link_to('公開', '@directory_publish?id='.$directory->getId(), array('method' => 'put')) ?>
    <?php else: ?>
      <?php echo link_to('非公開', '@directory_publish?id='.$directory->getId().'&private=true', array('method' => 'put')) ?>
    <?php endif; ?>
  </li>

  <li>
    <?php echo link_to('削除', '@directory_delete?id='.$directory->getId(), array('method' => 'delete', 'confirm' => 'フォルダの中のファイルもすべて削除されます。\nよろしいですか？')) ?>
  </li>

  <li>
    <a href="javascript:void(0)" id="directory_edit_name_show_link">名前を変更する</a>
  </li>
</ul>

<div id="directory_edit_name" class="hide">
  <input type="text" placeholder="フォルダ名を入力してください" />
  <?php echo link_to('確定', '@directory_edit_name?id='.$directory->getId(), array('method' => 'put', 'class' => 'btn btn-small')) ?>
</div>

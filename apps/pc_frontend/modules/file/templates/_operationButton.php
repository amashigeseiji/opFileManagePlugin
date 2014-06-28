<script type="text/javascript">
$(document).ready(function() {
  var toggle = function(div, link, word) {
    if (div.hasClass('hide')) {
      div.removeClass('hide');
    } else {
      div.addClass('hide');
    }
  }
  $('#file_edit_name_link').on('click', function() {
    var
      div = $('#file_edit_name'),
      link = div.find('a'),
      href = link.attr('href');

    div.find('input[type=text]').on('keyup', function() {
      link.attr('href', href + '?name=' + this.value);
    });

    toggle(div, $(this), { to_open : '名前を変更する', to_close: '中止' });
  });
});
</script>

<span class="btn-group">
  <?php echo link_to(
    '<i class="icon-download-alt"></i>',
    url_for('file_download', $file),
    array('class' => 'btn btn-small'))
  ?>
  <?php if ($file->isAuthor()): ?>
    <?php echo link_to(
      '<i class="icon-trash"></i>',
      '@file_delete?id='.$file->getId(),
      array('method' => 'delete',
            'class' => 'btn btn-small',
            'confirm' => 'ファイル名: '.$file->getName().'\n本当に削除してもよろしいですか？')
    ) ?>
    <a href="javascript:void(0)" id="file_edit_name_link" class="btn btn-small">
      <i class="icon-edit"></i>
    </a>
  <?php endif; ?>
</span>

<?php if ($file->isAuthor()): ?>
<div id="file_edit_name" class="hide form form-inline" placeholder="ファイル名を入力してください。">
<input type="text" />
<?php echo link_to(
  '確定',
  '@file_edit_name?id='.$file->getId(),
  array(
    'method' => 'put',
    'class' => 'btn btn-small btn-primary',
    'style' => 'color: #ffffff'
  )
) ?>
</div>
<?php endif; ?>

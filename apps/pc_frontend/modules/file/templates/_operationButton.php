<script type="text/javascript">
$(document).ready(function() {
  var fileId = "<?php echo $file->getId() ?>";

  var toggle = function(td, div, filename) {
    if (!div.hasClass('active')) {
      div.addClass('active');
      td.html(div.html());
    } else {
      div.removeClass('active');
      td.html(filename)
    }
  }

  var
    td = $('.filename_' + fileId),
    filename = td.html();

  $('#file_edit_name_link_' + fileId).on('click', function() {
    toggle(td, $('#file_edit_name_' + fileId), filename);

    var
      editlink = td.find('a'),
      href = editlink.attr('href');

    td.find('input[type=text]').on('keyup', function() {
      editlink.attr('href', href + '?name=' + this.value);
    });
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
    <a href="javascript:void(0)" id="file_edit_name_link_<?php echo $file->getId() ?>" class="btn btn-small">
      <i class="icon-edit"></i>
    </a>
  <?php endif; ?>
</span>

<?php if ($file->isAuthor()): ?>
<div id="file_edit_name_<?php echo $file->getId() ?>" class="hide">
  <span class="form form-inline">
    <input type="text" placeholder="<?php echo $file->getName() ?>" />
    <?php echo link_to(
      '確定',
      '@file_edit_name?id='.$file->getId(),
      array(
        'method'  => 'put',
        'class'   => 'btn btn-small btn-primary',
        'style'   => 'color: #ffffff'
      )
    ) ?>
  </span>
</div>
<?php endif; ?>

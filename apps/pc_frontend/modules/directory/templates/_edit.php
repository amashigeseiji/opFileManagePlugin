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

  $('#file_upload_show_link').on('click', function() {
    var
      _self = $(this),
      div = $('.file_upload_input'),
      to_open = '<?php echo __('Upload') ?>',
      to_close = '中止';

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

<a href="javascript:void(0)" id="file_upload_show_link"><?php echo __('Upload') ?></a>

<?php if (!$directory->getIsOpen()): ?>
  <?php echo link_to('公開', '@directory_publish?id='.$directory->getId(), array('method' => 'put')) ?>
<?php else: ?>
  <?php echo link_to('非公開', '@directory_publish?id='.$directory->getId().'&private=true', array('method' => 'put')) ?>
<?php endif; ?>

<?php echo link_to('削除', '@directory_delete?id='.$directory->getId(), array('method' => 'delete', 'confirm' => 'フォルダの中のファイルもすべて削除されます。\nよろしいですか？')) ?>

<a href="javascript:void(0)" id="directory_edit_name_show_link">名前を変更する</a>

<div id="directory_edit_name" class="hide">
  <input type="text" class="directory_edit_name_input" placeholder="フォルダ名を入力してください" />
  <?php echo link_to('確定', '@directory_edit_name?id='.$directory->getId(), array('method' => 'put', 'class' => 'directory_edit_name_form btn btn-default')) ?>
</div>

<div class="file_upload_input hide">
  <?php echo $fileForm->renderFormTag(url_for('file_upload', $directory), array('method' => 'post')) ?>
  <?php echo $fileForm ?>
  <input type="submit" class="btn btn-mini" value="<?php echo __('Upload') ?>" />
  </form>
</div>
